<?php

/*
<?php
    define ('HOSTNAME','127.0.0.1');
    define ('USER','myuser');
    define ('PASSWD','mypass');
    define ('DB','toolbox');
?>
 */
include_once('../auth-toolbox.php');

class Tool
{
    private $servername;
    private $username;
    private $password;
    private $dbname;

    public function __construct() {
        $this->servername = HOSTNAME;
        $this->username   = USER;
        $this->password   = PASSWD;
        $this->dbname     = DB;
    }

    private $toolname   = "";
    private $shrtdesc   = "";
    private $longdesc   = "";
    private $seealso    = "";
    private $risks      = "";
    private $tusage     = "";
    private $labels     = "";
    private $codesid    = "";
    private $sources    = "";
    private $maintainer = "";
    private $isfinished = false;

    // id of toolname in db
    private $id         = "";

    /**
     * @return bool db connection status 
     */
    private $dbstatus;

    // cnx obj
    private $conn;

    // setters and getters

    public function getFinished(){
        return $this->isfinished;
    }
    public function setFinished($isfinished){
        $this->isfinished = $isfinished;
    }

    public function getId(){
        return $this->id;
    }

    public function setId($id){
        $this->id = $id;
    }

    public function getCodesid(){
        return $this->codesid;
    }

    public function setCodesid($codesid){
        $this->codesid = $codesid;
    }

    public function getToolname(){
        return $this->toolname;
    }

    /**
     * @param str $toolname
     * check if already exists
     */
    public function setToolname($toolname){
        if(empty($toolname)){
            die("Empty tool name");
        }

        $existing_tool = $this->search_toolname($toolname);

        // If toolname exists in DB
        if(! empty($existing_tool) ){
            if(empty($this->id)) {
                die("Toolname already in DB");
            } else {
                foreach($existing_tool as $key => $val) {
                    if ( $val != $this->id ) {
                        die("Toolname already in DB and it is not me");
                        return false; // If existing toolname is not me
                    }
                }
            }
        }
        $this->toolname = $toolname;
    }

    public function getShrtdesc(){
        return $this->shrtdesc;
    }

    public function setShrtdesc($shrtdesc){
        $this->shrtdesc = $shrtdesc;
    }

    public function getLongdesc(){
        return $this->longdesc;
    }

    public function setLongdesc($longdesc){
        $this->longdesc = $longdesc;
    }

    public function getSeealso(){
        return $this->seealso;
    }

    public function setSeealso($seealso){
        $this->seealso = $seealso;
    }

    public function getRisks(){
        return $this->risks;
    }

    public function setRisks($risks){
        $this->risks = $risks;
    }

    public function getTUsage(){
        return $this->tusage;
    }

    public function setTusage($tusage){
        $this->tusage = $tusage;
    }

    public function getLabels(){
        return $this->labels;
    }

    /**
     * @param str comma separated list of labels
     */
    public function setLabels($labels){
        if(empty($labels)){
            return false;
        }
        $mylabel = Array();
        $arr_labels = explode(',', $labels);
        if(empty($arr_labels)) {
            return True;
        }

        $this->Dbstatus() or die("cnx error");

        foreach( $arr_labels as $str  ){
            $l = $this->search_labels($str);
            if( empty($l) ){
                $sql = "INSERT INTO labels (label) VALUES (?)";
                $stmt = $this->conn->prepare($sql) or die('Error with prepare: ' . htmlspecialchars($stmt->error));
                $a = trim($str);
                $stmt->bind_param("s", $a) or die('Error with bind_param: ' . htmlspecialchars($stmt->error));
                $stmt->execute() or die('Error with execute: ' . htmlspecialchars($stmt->error));
                $mylabel[$str] = $stmt->insert_id;
            } else {
                $mylabel[$str] = $l[$str];
            }
        }
        $this->labels = implode(',', $mylabel);
    }

    public function getSources(){
        return $this->sources;
    }

    public function setSources($sources){
        $this->Dbstatus() or die("cnx error");
        $this->sources = $sources;

        $srcs = $this->list_sources();
        foreach( $srcs as $k => $v ){
            if( $v["url"] == $sources ){
                $this->sources = $v;
                return true;
            }
        }

        // if not exists, create
        $sql = "INSERT INTO sources ( url ) VALUES ( ? )";
        $stmt = $this->conn->prepare($sql) or die('Error with prepare: ' . htmlspecialchars($stmt->error));
        $a = trim($sources);
        $stmt->bind_param("s", $a) or die('Error with bind_param: ' . htmlspecialchars($stmt->error));
        $stmt->execute() or die('Error with execute: ' . htmlspecialchars($stmt->error));

        $this->sources = array("id" => $stmt->insert_id, "url" => $sources);
        $stmt->close();
    }

    /**
     * @return Array id=>int, name=>string
     */
    public function getMaintainer(){
        return $this->maintainer;
    }

    /**
     * @param string maintainer name
     * set Array id=>int, name=>string
     */
    public function setMaintainer($maintainer){
        $this->Dbstatus() or die("cnx error");
        $this->maintainer = $maintainer;

        $maints = $this->list_maintainers();
        foreach( $maints as $k => $v ){
            if( $v["name"] == $maintainer ){
                $this->maintainer = $v;
                return true;
            }
        }

        // if not exists, create
        $sql = "INSERT INTO maintainer ( name ) VALUES ( ? )";
        $stmt = $this->conn->prepare($sql) or die('Error with prepare: ' . htmlspecialchars($stmt->error));
        $a = trim($maintainer);
        $stmt->bind_param("s", $a) or die('Error with bind_param: ' . htmlspecialchars($stmt->error));
        $stmt->execute() or die('Error with execute: ' . htmlspecialchars($stmt->error));

        $this->maintainer = array("id" => $stmt->insert_id, "name" => $maintainer);
    }

    /**
     * @param string source name
     * set Array id=>int, name=>string
     */
    public function setSource($source){
        $this->Dbstatus() or die("cnx error");
        $this->source = $source;

        $sources = $this->list_sources();
        foreach( $sources as $k => $v ){
            if( $v["url"] == $source ){
                $this->source = $v;
                return true;
            }
        }

        // if not exists, create
        $sql = "INSERT INTO sources (url) VALUES ( ? )";
        $stmt = $this->conn->prepare($sql) or die('Error with prepare: ' . htmlspecialchars($stmt->error));
        $a = trim($source);
        $stmt->bind_param("s", $a) or die('Error with bind_param: ' . htmlspecialchars($stmt->error));
        $stmt->execute() or die('Error with execute: ' . htmlspecialchars($stmt->error));

        $this->source = array("id" => $stmt->insert_id, "url" => $source);
    }

    /**
     * @param optional id
     * return Array
     */
    public function list_maintainers($id=""){
        $list = Array();
        $this->Dbstatus() or die("cnx error");

        if(empty($id)){
            $sql = "SELECT id, name from maintainer";
        } else {
            $sql = "SELECT id, name from maintainer WHERE id = '".$id."'";
        }
        $res = $this->conn->query($sql) or die($this->conn->error);

        if ($res->num_rows > 0) {
	        while($row = $res->fetch_assoc()) {
                $list[] = array("name" => $row["name"], "id" => $row["id"]);
            }
        }
        return $list;
    }

    /**
     * @param optional id
     * return Array
     */
    public function list_sources($id=""){
        $list = Array();
        $this->Dbstatus() or die("cnx error");

        if(empty($id)){
            $sql = "SELECT id, url from sources";
        } else {
            $sql = "SELECT id, url from sources WHERE id = '".$id."'";
        }
        $res = $this->conn->query($sql) or die($this->conn->error);

        if ($res->num_rows > 0) {
	        while($row = $res->fetch_assoc()) {
                $list[] = array("url" => $row["url"], "id" => $row["id"]);
            }
        }
        return $list;
    }

    /**
     * @return bool connection status
     *              db connection if not already set
     */
    private function Dbstatus(){
        if ($this->dbstatus) {
            return true;
        } else {
            $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
            if ($this->conn->connect_error) {
                echo "Connection failed: " . $this->conn->connect_error;
                $this->dbstatus = false;
                return false;
            } else {
                $this->dbstatus = true;
                return true;
            }
        }
    }

    /**
     * @param string $toolname
     * @return Array toolname => id
     * @return bool false
     */
    private function search_toolname($toolname){
        $toolnames = Array();
        $this->Dbstatus() or die("cnx error");

        $sql = "SELECT id, toolname from basics WHERE toolname = '".$toolname."'";
        $res = $this->conn->query($sql) or die($this->conn->error);

        if ($res->num_rows > 0) {
	        while($row = $res->fetch_assoc()) {
                $toolnames[$row["toolname"]] = $row["id"];
            }
        }
        return $toolnames;
	}

    /**
     * @return Array toolname => id
     */
    public function list_toolnames(){
        $toolnames = Array();
        $this->Dbstatus() or die("cnx error");

        $sql = "SELECT id, toolname from basics";
        $res = $this->conn->query($sql) or die($this->conn->error);

        if ($res->num_rows > 0) {
	        while($row = $res->fetch_assoc()) {
                $toolnames[$row["toolname"]] = $row["id"];
            }
        }
        return $toolnames;
    }

    /**
     * @return Array toolname Array id => status
     */
    public function list_tools_and_status(){
        $toolnames = Array();
        $this->Dbstatus() or die("cnx error");

        $sql = "SELECT id, toolname, finished from basics";
        $res = $this->conn->query($sql) or die($this->conn->error);

        if ($res->num_rows > 0) {
	        while($row = $res->fetch_assoc()) {
                $toolnames[$row["toolname"]] = array("id" => $row["id"], "status" => $row["finished"]);
            }
        }
        return $toolnames;
    }

    /**
     * @param str $label
     * @return Array label => id
     */
    private function search_labels($label){
        $labels = Array();
        $this->Dbstatus() or die("cnx error");

        $sql = "SELECT id, label from labels WHERE label = '".$label."'";
        $res = $this->conn->query($sql) or die($this->conn->error);

        if ($res->num_rows > 0) {
            while($row = $res->fetch_assoc()) {
                $labels[$row["label"]] = $row["id"];
            }
        }
        return $labels;
    }

    /**
     * @param id label
     * @return Array $toolname => toolname_id 
     */
    public function getToolsByLabel($label){
        $tool = Array();
        $this->Dbstatus() or die("cnx error");

        // list existing labels => id to compare
        $all_labels = $this->list_labels();
        $labelid = "";
        foreach($all_labels as $k => $v){
            if($label == $k) {
                $labelid = $v;
            }
        }
        if(empty($labelid)){
            return $tool;
        }

        $sql = "SELECT id, toolname, labels, finished from basics";
        $res = $this->conn->query($sql) or die($this->conn->error);

        if ($res->num_rows > 0) {
            while($row = $res->fetch_assoc()) {
                // get the indexed list: 1,4,24,25
                $label_tool = $row["labels"];

                // create array(1, 4, 24, 25)
                $label_tool = explode(',', $label_tool);

                foreach($label_tool as $k => $v){
                    if($v == $labelid) {
                        $tool[] = array("toolname" => $row["toolname"], "id" => $row["id"], "status" => $row["finished"]);
                        break 1;
                    }
                }
            }
        }
        return $tool;
    }

    /**
     * @return { tags: [{tag: mytag, freq: mytag_frequency], min: minfreq, max: maxfreq }
     */
    public function list_label_freq() {
        $all_labels = $this->list_labels();

        //start json object
        $json = "({ tags:[";
        $jsonexpand = "";
        $minfreq = 0;
        $maxfreq = 0;

        foreach($all_labels as $key => $val) {
            $rel_tools = $this->getToolsByLabel($key);
            $rel_count = count($rel_tools);
            if($rel_count > 0 ) {
                if($jsonexpand != "") {
                    $jsonexpand .= ",";
                }
                $jsonexpand .= "{tag:'" . $key . "',freq:'" . $rel_count . "'}";

                if($minfreq == 0)
                    $minfreq = $rel_count;
                if($rel_count < $minfreq)
                    $minfreq = $rel_count;
                if($rel_count > $maxfreq)
                    $maxfreq = $rel_count;
            }
        }
        $json .= $jsonexpand;
        $json .= "]";
        $json .= ', minfreq: ' . $minfreq;
        $json .= ', maxfreq: ' . $maxfreq;
        $json .= "})";

        return $json;
    }

    /**
     * @return Array label => id
     * @param optional Array id list
     */
    public function list_labels($ids = ""){
        $labels = Array();
        $this->Dbstatus() or die("cnx error");

        $cond_request = "";
        if (is_array($ids)){
            foreach($ids as $key => $val) {
                if( $cond_request == "" ) {
                    $cond_request .= " WHERE id = " . (string)$val;
                } else {
                    $cond_request .= " OR id = " . (string)$val;
                }
            }
        }

        $sql = "SELECT id, label from labels" . $cond_request;
        $res = $this->conn->query($sql) or die("list_labels: [".$cond_request."] [".$sql. "] " .$this->conn->error);

        if ($res->num_rows > 0) {
            while($row = $res->fetch_assoc()) {
                $labels[$row["label"]] = $row["id"];
            }
        }
        return $labels;
    }

    /**
     * @return bool false|true
     * @param int id
     */
    public function get_tool_by_id($id){
        $tool = Array();
        $this->Dbstatus() or die("cnx error");

        $sql = "SELECT * FROM basics WHERE id = ".$id;
        $res = $this->conn->query($sql) or die("get_tool_by_id: " .$this->conn->error);
        while($row = $res->fetch_assoc()) {
            $this->toolname     = $row["toolname"];
        	$this->shrtdesc     = $row["shortdesc"];
    		$this->longdesc     = $row["longdesc"];
	    	$this->seealso      = $row["seealso"];
		    $this->tusage       = $row["tusage"];
    		$this->examples     = $row["examples"];
            $this->risks        = $row["risks"];
	    	$this->labels       = explode(',', $row["labels"]);
	    	$this->codesid      = $row["examples"];
		    $this->sources      = $this->list_sources($row["sources"]);
		    $this->maintainer   = $this->list_maintainers($row["maintainer"]);
            $this->isfinished   = $row["finished"];
        }
        return true;
    }

    /**
     * @param int id of code in db
     * @return Array [id => int, txt -> string, cmd, string]
     * @return false if error
     */
    public function get_code($id){
        $code = Array();
        $this->Dbstatus() or die("cnx error");

        $sql = "SELECT * FROM codes WHERE id = " . $id;
        $res = $this->conn->query($sql) or die("get_code: " .$this->conn->error);
        while($row = $res->fetch_assoc()) {
            foreach( $row as $key => $val ) {
                $code[$key] = $val;
            }
        }
        return $code;
    }

    /**
     * @param str comment
     * @param str code
     * set $this->tusage with code $id
     * @return bool
     */
    public function addCode($comment, $code, $id = ""){
        $this->Dbstatus() or die("cnx error");

        if( empty($id) ){
            $sql = "INSERT INTO codes (txt, cmd) VALUES (?, ?)";
        } else {
            $sql = "UPDATE codes SET txt = ?, cmd = ? WHERE id = " . $id;
        }

        $stmt = $this->conn->prepare($sql) or die('Error with prepare: ' . htmlspecialchars($stmt->error));
        $a = trim($comment);
        $b = trim($code);
        $stmt->bind_param("ss", $a, $b) or die('Error with bind_param: ' . htmlspecialchars($stmt->error));
        $stmt->execute() or die('Error with execute: 1:'.$comment.' 2:'.$code.' 3:'.$id.' '.htmlspecialchars($stmt->error));

        if( empty($id) ){
            return $stmt->insert_id;
        }

        $stmt->close();
    }

    /**
     * @return bool
     */
    public function addToolDB(){
        $this->Dbstatus() or die("cnx error");

        if( empty($this->id) ){
            $sql = "INSERT INTO basics (
                toolname, shortdesc, longdesc, seealso, risks,
                tusage, examples, labels, sources, maintainer, finished
            ) VALUES (
                ?, ?, ?, ?, ?,
                ?, ?, ?, ?, ?, ?
            )";
        } else {
            $sql = "UPDATE basics SET
                toolname        = ?,
                shortdesc       = ?,
                longdesc        = ?,
                seealso         = ?,
                risks           = ?,
                tusage          = ?,
                examples        = ?,
                labels          = ?,
                sources         = ?,
                maintainer      = ?,
                finished        = ?
            WHERE id = ".$this->id;
        }
        $stmt = $this->conn->prepare($sql) or die('Error with prepare: ' . htmlspecialchars($stmt->error));
        $a = trim($this->toolname);
        $b = trim($this->shrtdesc);
        $c = trim($this->longdesc);
        $d = trim($this->seealso);
        $e = trim($this->risks);
        $stmt->bind_param("sssssissssi",
            $a,
            $b,
            $c,
            $d,
            $e,
            $this->tusage,
            $this->codesid,
            $this->labels,
            $this->sources["id"],
            $this->maintainer["id"],
            $this->isfinished
        ) or die('Error with bind_param: ' . htmlspecialchars($stmt->error));
        $stmt->execute() or die('Error with execute: ' . htmlspecialchars($stmt->error));
        $stmt->close();

        return true;
    }

    private function charCodeAt($string, $offset) {
        $character = substr($string, $offset, 1);
        list(, $ret) = unpack('S', mb_convert_encoding($character, 'UTF-16LE'));
        return (int) $ret;
    }

    public function getHashNameNumber($name){
        $hash = 0;
        for($i=0; $i<strlen($name); $i++){
            $hash += $this->charCodeAt($name, $i);
        }
        return $hash;
    }

}
?>
