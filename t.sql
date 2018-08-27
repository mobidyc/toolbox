-- MySQL dump 10.14  Distrib 5.5.56-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: toolbox2
-- ------------------------------------------------------
-- Server version	5.5.56-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Current Database: `toolbox2`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `toolbox2` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `toolbox2`;

--
-- Table structure for table `basics`
--

DROP TABLE IF EXISTS `basics`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `basics` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `toolname` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `shortdesc` varchar(255) NOT NULL,
  `longdesc` varchar(4096) DEFAULT NULL,
  `seealso` varchar(255) DEFAULT NULL,
  `risks` varchar(4096) DEFAULT NULL,
  `tusage` int(11) NOT NULL,
  `examples` varchar(255) DEFAULT NULL,
  `labels` varchar(255) DEFAULT NULL,
  `sources` varchar(255) DEFAULT NULL,
  `maintainer` varchar(255) DEFAULT NULL,
  `finished` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `toolname` (`toolname`)
) ENGINE=InnoDB AUTO_INCREMENT=95 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `basics`
--

LOCK TABLES `basics` WRITE;
/*!40000 ALTER TABLE `basics` DISABLE KEYS */;
INSERT  IGNORE INTO `basics` VALUES (83,'fsops.sh','Monitor activity from stats files: sfused, biziod, sproxyd, operation counts, throughputs, parallel ops.','To get a description of (almost) all metrics, follow this link:\r\nhttps://docs.scality.com/display/ENG/Description+of+statistics+counters\r\nreal time analyzis about the connector/biziod operations, one line per second.\r\nYou can check the parallel, number, latency, size of the operations.\r\nGood to see are the latency and count metrics for the specified operations (â€œreadâ€ and â€œwriteâ€ in this instance).\r\nThe goal would be to identify a bottleneck from the highest point to the lower level. If you have a very low latency and a low number\r\nof operation,\r\nit can be a â€˜workerâ€ tuning on the connector side, if you have high latency, it can be network or disk related.','sfused','',122,'123, 124','40,43,55,58,60','6','8',1),(84,'scality-join_first_node.sh','Automatically join the first node','The auto-join (on, on_force) feature needs at least one joined node to proceed, This tool will do that first step.\r\nIt needs ringsh configured.\r\nIt will run the first node ONLY if auto-join is enabled (on or on_force).\r\n\r\nUse the scality-join_first_node.crond example to run it every minutes.','scality-join_first_node.crond','This script will be obsolete in a future ring v7 version. See ticket #RING-24340',125,'','46,70','7','9',1),(86,'pdml2tracer.py','Parse a network trace, convert and send the fields to elasticsearch.','# capture a samba traffic between client and server\r\ntcpdump -w /tmp/smb -i eth0 tcp port 445\r\n \r\n# note. tshark is part of wireshark\r\n# turn into data trace\r\ntshark -T pdml -r /tmp/smb | ./pdml2tracer.py - > /tmp/trace-smb-XXX.log','wireshark, elasticsearch','',127,'','51,49,40,58,52,50,54,53','6','8',1),(87,'scality-move_bizobjs.sh','move the bizobj.bin files located on spinning disks to a SSD for the specified RING name.','NOTE: need to find a better naming as the bizobjs are not moved but copied to ssd.\r\nThis tool will list the /scality/ mountpoint and will differentiate the disks according the following prefixes:\r\nssds = ssd*\r\ndisks = g* disk*\r\nIt will then spread the bizobjs on the ssds and will update the bizio configuration files.\r\nThe copy uses rsync so you can re-run the script in case of (I/O?) error.','rsync','The original bizobj files are not modified, you have to manually remove them to gain space.\r\n	The bizio conf files (/etc/biziod/biz*) will be rewritten to indicate the new NVP value.\r\n	Scaity-node service has to be stopped on the server, you will restart the serice manually after the operations.\r\n	This tool does not check if the SSD is mounted.',128,'','55,57,61','7','9',1),(88,'scality-sfused-changes.py','Displays non-default sfused parameters','Takes the \"sfused/meta/running_config\" file and compare it with the \"running_config_desc\" file (has to be in the same directory).\r\nDisplays the non-default parameters only, with the description of the parameter.','sfused','',129,'130','58,59,60','7','9',1),(89,'change-disk.sh','This tool needs ringsh configured on the storage node. Reload the status or change a disk in a Scality system.','This tool works on failed disks to reload the status.\r\nBy default, if not sliced, the disk will be formatted.\r\nYou can use this tool to â€œreload onlyâ€ the status.\r\nVery useful in test phase or if you want to check the different steps to repair a disk manually\r\n\r\nReplacing an SSD will check if any bizobj.bin backups are present to automatically reconciliate the datas.','change_disk-ring7.sh, ringsh','RINGSH has to be configured on the storage node to properly reload the disks on the nodes!\r\n\r\nData loss if you (force) format the wrong disk',131,'132, 133, 134, 135','61,62,63,64','7','9',1),(90,'scality-backup_confs_everywhere.sh','backup all scality configs on all servers','This tool needs to be run from the supervisor.\r\nIt also needs ssh to retrieve/send backups.\r\nBy default, the installer deploys a cron job to backup the scality conf into /var/lib/scality/backup.\r\nThis script will backup all /var/lib/scality/backup on the supervisor into /srv/scality/scality_all_backups/$serv_name.\r\nIt will also backup the /srv/ salt and pillar files from the supervisor to the other servers.\r\n\r\nIt keeps only 10 backups.\r\nBetter run it from a cron job','scality-backup_confs_everywhere.crond','check you have enough space on /srv to host all configs',136,'','65,66,67','7','9',1),(91,'scality-dfree.py','Dynamically change the dfree value of a running sfused instance.','To be run from the sfused connector after changing the supervisor IP and credentials.\r\nDisplays the correct value fromsfused, cifs, nfs.\r\nBetter run it from a cron job','sfused','',137,'138','60,68,69','7','9',1),(92,'nasdktop.py','displays realtime top metrics used by nasdk components (sfused, biziod, srebuild)','Use this tool to see what are the most used metrics in nasdk components, sort it by count, latency, throughput, etc). \r\nby knowing which metric to monitore, you can efficiently know what argument to use with fsops.\r\n\r\nUsing your keypad from number 0 to 5, you can select the column sort order.','sfused, fsops','In certain occasion your terminal can stays garbled, to solve that, use that magic command: stty sane',140,'141','55,58,60,72','9','9',1),(94,'scality-sofs_caches_sizes.sh','Displays SOFS cache usage','','','',143,'','58,60','11','11',0);
/*!40000 ALTER TABLE `basics` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `codes`
--

DROP TABLE IF EXISTS `codes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `codes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `txt` varchar(255) DEFAULT NULL,
  `cmd` longtext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=144 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `codes`
--

LOCK TABLES `codes` WRITE;
/*!40000 ALTER TABLE `codes` DISABLE KEYS */;
INSERT  IGNORE INTO `codes` VALUES (122,'# ./fsops.sh -h','usage: fsops.sh -f <stats file> [options]\r\n	-c <ops>	report ops counts\r\n	-t <ops>	report ops throughputs\r\n	-T 		report global throughput\r\n	-p <ops>	report parallel ops\r\n	-u <ops>	report ops usage\r\n	-L <ops>	report ops latency\r\n	-S <ops>	report ops size\r\n	-l <screen lines>\r\n	-w <column width>\r\n	-s <subsection>\r\n	-d <disk> (for bizio stats)\r\n	-h 		show usage\r\nThe \'stats file\' can be:\r\n	a local pseudo-file:\r\n		$ fsops -f /run/scality/.../misc/stats_sfused\r\n	a HTTP URL:\r\n		$ fsops -f  http://localhost:8001/bizobj\r\n	a bizobj descriptor:\r\n		$ fsops -f bizobj://ring:0 -d disk1'),(123,'You can obtain the list of all available stats by reading the <stats file>.\r\nThe available stats are found in the â€œoperationâ€ column.','# head /run/scality/connectors/sfused/misc/stats\r\ntimestamp: 18:15:01.419942\r\n            operation      count         //      max//     errors   avg (ms)    slowest total (ms)   total (bytes)   total_sq (ms)\r\n              getattr       4036          0          2          0          6       5040      23316               -        92296256\r\n              setattr          5          0          1          0        256        309       1280               -          335482\r\n                 open         13          0          1          0          0          0          0               -               0\r\n             readlink          0          0          0          0          0          0          0               -               0\r\n               lookup       4029          0          2          0          0        121        874               -           15027\r\n           lookup_key          0          0          0          0          0          0          0               -               0\r\n                mknod          2          0          1          0         42         46         83               -            3523\r\n                mkdir          0          0          0          0          0          0          0               -               0'),(124,'Display read/write ops count and ops latency','# fsops -f /run/scality/connectors/sfused/misc/stats_sfused -c \"read write\"  -L \"read write\" -T\r\nreading stats from /run/scality/connectors/sfused/misc/stats_sfused\r\n                      MB/s       MB/s|    count          | lat (ms)          \r\n                   readmbs   writembs      read     write      read     write\r\n18:00:33.825901       50.3      211.8       384      1616       6.9       0.1\r\n18:00:34.834831      155.2      310.0      1184      2365       2.9       0.1\r\n18:00:35.841930       71.3      333.8       544      2547       6.0       0.1\r\n18:00:36.855243      205.5      192.9      1568      1472       1.8       0.1\r\n18:00:37.857679      184.5        0.0      1408         0       2.6       0.0\r\n18:00:38.862937      289.1        0.0      2206         0       1.5       0.0'),(127,'Usage','# capture a samba traffic between client and server\r\ntcpdump -w /tmp/smb -i eth0 tcp port 445\r\n \r\n# note. tshark is part of wireshark\r\n# turn into data trace\r\ntshark -T pdml -r /tmp/smb | ./pdml2tracer.py - > /tmp/trace-smb-XXX.log'),(128,'# ./scality-move_bizobjs.sh --help','./scality-move_bizobjs.sh <ringname>\r\nplease stop the nodes before running this script:\r\n   service scality-node stop'),(129,'# ./scality-sfused-changes.py --help','Usage: ./scality-sfused-changes.py [options]\r\n\r\n    	-h, --help: __________________ Displays the usage.\r\n    	-f, --file: __________________ running_config file, need running_config_desc in the same place.\r\n\r\nExample:\r\n    	./scality-sfused-changes.py -f /run/scality/connectors/sfused/meta/running_config'),(130,'','# ./analyze_sfused_conf.py -f /run/scality/connectors/sfused/meta/running_config\r\n{\r\n    \"cache:0\": {\r\n        \"prefetch\": {\r\n            \"current_value\": \"0\",\r\n            \"default_value\": \"1\",\r\n            \"descr\": \"Enable the ability to asynchronously prefetch chunks\"\r\n        }\r\n    },\r\n    \"transport\": {\r\n        \"big_writes\": {\r\n            \"current_value\": \"1\",\r\n            \"default_value\": \"0\",\r\n            \"descr\": \"Enable write size larger than 4KB. Not supported with FUSE 2.7 or older\"\r\n        }\r\n    }\r\n}'),(131,'# ./change_disk.sh','# -f __________ to force the formatting even on already sliced disk\r\n	# --reload ____ to just reload the disk, no format\r\n	# --scan_scsi _ will just rescan the scsi chain on the system then exit\r\n	# --dryrun ____ display the list of commands that will be used, without running them\r\n	Usage example:\r\n	./change_disk.sh --scan_scsi\r\n	./change_disk.sh disk4 /dev/sdg'),(132,'A SSD will automatically take a backup of the bizobjs if it exists, and will reconciliate the containers','# ./change_disk.sh -f --dryrun ssd1 vdc\r\nblockdev --rereadpt /dev/vdc\r\nscality-iod stop ssd1\r\numount /scality/ssd1\r\nscality-iod stop g1disk1\r\numount /scality/g1disk1\r\nscality-iod stop g1disk2\r\numount /scality/g1disk2\r\nscality-iod stop g2disk1\r\numount /scality/g2disk1\r\nscality-iod stop g2disk2\r\numount /scality/g2disk2\r\nparted -s -a optimal /dev/vdc mklabel gpt\r\nparted -s -a optimal /dev/vdc mkpart primary ext4 1mb -- -1\r\nmke2fs -t ext4 -F -m0 /dev/vdc1\r\nblockdev --rereadpt /dev/vdc\r\ntune2fs -c0 -m0 -i0 /dev/vdc1\r\ncp /etc/fstab /etc/fstab.2018-01-15-09:59:02\r\nsed -i \"s@^UUID=.*\\([[:space:]]/scality/ssd1[[:space:]].*\\)@UUID=c9ea6afc-cdeb-11e7-9dc5-fa163e24ba56 \\1@\" /etc/fstab\r\nmount /scality/ssd1\r\nmkdir -p /scality/ssd1/META/0/\r\nscality-iod start ssd1\r\nbizioctl -c del_mflags -a 0x1 -N ssd1 bizobj://META:0\r\nbizioctl -c del_mflags -a 0x2 -N ssd1 bizobj://META:0\r\nbizioctl -c del_mflags -a 0x4 -N ssd1 bizobj://META:0\r\nbizioctl -c set_mflags -a 0x0 -N ssd1 bizobj://META:0\r\nReload the biziod ssd1 on the META nodes\r\nringsh -r META -u META-sitea-s3-store-3.eu.scality.cloud-n1 node chunkMgrStoreBizioReload ssd1\r\nringsh -r META -u META-sitea-s3-store-3.eu.scality.cloud-n2 node chunkMgrStoreBizioReload ssd1\r\nringsh -r META -u META-sitea-s3-store-3.eu.scality.cloud-n3 node chunkMgrStoreBizioReload ssd1\r\nringsh -r META -u META-sitea-s3-store-3.eu.scality.cloud-n4 node chunkMgrStoreBizioReload ssd1\r\nringsh -r META -u META-sitea-s3-store-3.eu.scality.cloud-n5 node chunkMgrStoreBizioReload ssd1\r\nringsh -r META -u META-sitea-s3-store-3.eu.scality.cloud-n6 node chunkMgrStoreBizioReload ssd1\r\nscality-iod stop g1disk1\r\nscality-iod stop g1disk2\r\nscality-iod stop g2disk1\r\nscality-iod stop g2disk2\r\nmkdir -pv /scality/ssd1/bizobj-g1disk1\r\nmkdir -pv /scality/ssd1/bizobj-g1disk2\r\nmkdir -pv /scality/ssd1/bizobj-g2disk1\r\nmkdir -pv /scality/ssd1/bizobj-g2disk2\r\ncp -r /scality/g1disk1/bizobj-backup/18-01-13/DATA /scality/ssd1/bizobj-g1disk1/\r\nBizobj.bin reconciliation\r\nbiziod -dl -P bp=/scality/g1disk1;nvp=/scality/ssd1/bizobj-g1disk1 -t bizobj recdump DATA 0 -CHr\r\nbiziod -dl -P bp=/scality/g1disk1;nvp=/scality/ssd1/bizobj-g1disk1 -t bizobj recdump DATA 0 -CFR\r\ncp -r /scality/g1disk2/bizobj-backup/18-01-13/DATA /scality/ssd1/bizobj-g1disk2/\r\nBizobj.bin reconciliation\r\nbiziod -dl -P bp=/scality/g1disk2;nvp=/scality/ssd1/bizobj-g1disk2 -t bizobj recdump DATA 0 -CHr\r\nbiziod -dl -P bp=/scality/g1disk2;nvp=/scality/ssd1/bizobj-g1disk2 -t bizobj recdump DATA 0 -CFR\r\ncp -r /scality/g2disk1/bizobj-backup/18-01-13/DATA /scality/ssd1/bizobj-g2disk1/\r\nBizobj.bin reconciliation\r\nbiziod -dl -P bp=/scality/g2disk1;nvp=/scality/ssd1/bizobj-g2disk1 -t bizobj recdump DATA 0 -CHr\r\nbiziod -dl -P bp=/scality/g2disk1;nvp=/scality/ssd1/bizobj-g2disk1 -t bizobj recdump DATA 0 -CFR\r\ncp -r /scality/g2disk2/bizobj-backup/18-01-13/DATA /scality/ssd1/bizobj-g2disk2/\r\nBizobj.bin reconciliation\r\nbiziod -dl -P bp=/scality/g2disk2;nvp=/scality/ssd1/bizobj-g2disk2 -t bizobj recdump DATA 0 -CHr\r\nbiziod -dl -P bp=/scality/g2disk2;nvp=/scality/ssd1/bizobj-g2disk2 -t bizobj recdump DATA 0 -CFR\r\nscality-iod start g1disk1\r\nscality-iod start g1disk2\r\nscality-iod start g2disk1\r\nscality-iod start g2disk2\r\nbizioctl -c del_mflags -a 0x1 -N g1disk1 bizobj://DATA:0\r\nbizioctl -c del_mflags -a 0x2 -N g1disk1 bizobj://DATA:0\r\nbizioctl -c del_mflags -a 0x4 -N g1disk1 bizobj://DATA:0\r\nbizioctl -c set_mflags -a 0x0 -N g1disk1 bizobj://DATA:0\r\nReload the biziod g1disk1 on the DATA nodes\r\nringsh -r DATA -u DATA-sitea-s3-store-3.eu.scality.cloud-n1 node chunkMgrStoreBizioReload g1disk1\r\nringsh -r DATA -u DATA-sitea-s3-store-3.eu.scality.cloud-n2 node chunkMgrStoreBizioReload g1disk1\r\nringsh -r DATA -u DATA-sitea-s3-store-3.eu.scality.cloud-n3 node chunkMgrStoreBizioReload g1disk1\r\nringsh -r DATA -u DATA-sitea-s3-store-3.eu.scality.cloud-n4 node chunkMgrStoreBizioReload g1disk1\r\nringsh -r DATA -u DATA-sitea-s3-store-3.eu.scality.cloud-n5 node chunkMgrStoreBizioReload g1disk1\r\nringsh -r DATA -u DATA-sitea-s3-store-3.eu.scality.cloud-n6 node chunkMgrStoreBizioReload g1disk1\r\nbizioctl -c del_mflags -a 0x1 -N g1disk2 bizobj://DATA:0\r\nbizioctl -c del_mflags -a 0x2 -N g1disk2 bizobj://DATA:0\r\nbizioctl -c del_mflags -a 0x4 -N g1disk2 bizobj://DATA:0\r\nbizioctl -c set_mflags -a 0x0 -N g1disk2 bizobj://DATA:0\r\nrm -rf /scality/ssd1/bizobj-g1disk2/DATA/0/*\r\nrm -rf /scality/g1disk2/DATA/0/bizobj_prot.bin /scality/g1disk2/DATA/0/data\r\nbizioopen -c -N g1disk2 bizobj://DATA:0'),(133,'Dryrun option will not run any command, safe way to understand the process','# ./change_disk.sh -f --dryrun g1disk2 vdd\r\nblockdev --rereadpt /dev/vdd\r\nscality-iod stop g1disk2\r\numount /scality/g1disk2\r\nparted -s -a optimal /dev/vdd mklabel gpt\r\nparted -s -a optimal /dev/vdd mkpart primary ext4 1mb -- -1\r\nmke2fs -t ext4 -F -m0 /dev/vdd1\r\nblockdev --rereadpt /dev/vdd\r\ntune2fs -c0 -m0 -i0 /dev/vdd1\r\ncp /etc/fstab /etc/fstab.2018-01-15-09:56:30\r\nsed -i \"s@^UUID=.*\\([[:space:]]/scality/g1disk2[[:space:]].*\\)@UUID=cd035014-cdeb-11e7-9dc5-fa163e24ba56 \\1@\" /etc/fstab\r\nmount /scality/g1disk2\r\nmkdir -p /scality/g1disk2/DATA/0/\r\nscality-iod start g1disk2\r\nbizioctl -c del_mflags -a 0x1 -N g1disk2 bizobj://DATA:0\r\nbizioctl -c del_mflags -a 0x2 -N g1disk2 bizobj://DATA:0\r\nbizioctl -c del_mflags -a 0x4 -N g1disk2 bizobj://DATA:0\r\nbizioctl -c set_mflags -a 0x0 -N g1disk2 bizobj://DATA:0\r\nrm -rf /scality/ssd1/bizobj-g1disk2/DATA/0/*\r\nrm -rf /scality/g1disk2/DATA/0/bizobj_prot.bin /scality/g1disk2/DATA/0/data\r\nbizioopen -c -N g1disk2 bizobj://DATA:0'),(134,'There is a disk check before changing a disk','# ./change_disk.sh g1disk2 vdd\r\n/!\\ disk already contains partition(s) /!\\'),(135,'Remove any failed status and reload the disk in nodes','# ./change_disk.sh --reload g1disk2\r\n0x0\r\n0x0\r\n0x0\r\n0x0\r\nReload the biziod g1disk2 on the DATA nodes\r\nDone!'),(136,'Usage','# ./scality-backup_confs_everywhere.sh supervisor node1 node2 conn1 â€¦'),(137,'You need to edit the file to enter the supervisor IP and credentials','# python scality-dfree.py'),(138,'before/after','# df -h /ring/fs \r\nFilesystem      Size  Used Avail Use% Mounted on\r\n/dev/fuse       954T     0  954T   0% /ring/fs.1193781764097405212\r\n\r\n# python scality-dfree.py\r\n250368 217120\r\n\r\n# df -h /ring/fs\r\nFilesystem      Size  Used Avail Use% Mounted on\r\n/dev/fuse       245G   33G  213G  14% /ring/fs.1193781764097405212'),(139,'','./nasdktop.py -h\r\n$mylabel_arr\r\nUsage: ./nasdktop.py [options]\r\n\r\n    	-h, --help: __________________ Displays the usage.\r\n    	-f, --file: __________________ stats file or http.\r\n    	-c, --column: ________________ sort on this column number - from 0 to 5.\r\n    	-t, --time: __________________ change the polling time in seconds.\r\n\r\n\r\n    	\"--column 0\" means no sort at all\r\n    	Tips: You can use numbers from 0 to 5 during execution to dynamically change the column sorting\r\n\r\n    	if no file is provided, the default will be:\r\n    		/run/scality/connectors/sfused/misc/stats_sfused\r\n\r\n    Usage examples::\r\n    ./nasdktop.py -f \'http://127.0.0.1:35951/store/bizobj/DATA/0?ctl=bizobj_advanced_stats\'\r\n    ./nasdktop.py -f /run/scality/connectors/sfused/misc/stats_sfused\r\n    ./nasdktop.py -c 2 --time .5\r\n    ./nasdktop.py --time 30'),(140,'','./nasdktop.py -h\r\n\r\nUsage: ./nasdktop.py [options]\r\n\r\n    	-h, --help: __________________ Displays the usage.\r\n    	-f, --file: __________________ stats file or http.\r\n    	-c, --column: ________________ sort on this column number - from 0 to 5.\r\n    	-t, --time: __________________ change the polling time in seconds.\r\n\r\n\r\n    	\"--column 0\" means no sort at all\r\n    	Tips: You can use numbers from 0 to 5 during execution to dynamically change the column sorting\r\n\r\n    	if no file is provided, the default will be:\r\n    		/run/scality/connectors/sfused/misc/stats_sfused\r\n\r\n    Usage examples::\r\n    ./nasdktop.py -f \'http://127.0.0.1:35951/store/bizobj/DATA/0?ctl=bizobj_advanced_stats\'\r\n    ./nasdktop.py -f /run/scality/connectors/sfused/misc/stats_sfused\r\n    ./nasdktop.py -c 2 --time .5\r\n    ./nasdktop.py --time 30'),(141,'# dd if=/dev/zero of=/ring/fs/data/test2.dd bs=54K count=100000 status=progress\r\n670519296Â octets (671 MB) copiÃ©s, 5,003653 s, 134 MB/s','Name    Cnt     //   Errs    Latms  bytes_sz\r\n###########   ####   ####   ####     ####    ####\r\nREAD: 0.00 MiB/s - WRITE: 163.79 MiB/s                                                                  \r\n\r\n   getxattr| _2963| ____0| ____0| ______0| _____0\r\n      write| _2962| ____0| ____0| ______0| _55296\r\n     lookup| ____0| ____0| ____0| ______0| _____0\r\n     forget| ____0| ____0| ____0| ______0| _____0\r\n    getattr| ____0| ____0| ____0| ______0| _____0\r\n    setattr| ____0| ____0| ____0| ______0| _____0\r\n      mknod| ____0| ____0| ____0| ______0| _____0\r\n      mkdir| ____0| ____0| ____0| ______0| _____0\r\n     unlink| ____0| ____0| ____0| ______0| _____0\r\n      rmdir| ____0| ____0| ____0| ______0| _____0\r\n    symlink| ____0| ____0| ____0| ______0| _____0\r\n     rename| ____0| ____0| ____0| ______0| _____0\r\n       link| ____0| ____0| ____0| ______0| _____0\r\n   readlink| ____0| ____0| ____0| ______0| _____0\r\n       open| ____0| ____0| ____0| ______0| _____0\r\n    release| ____0| ____0| ____0| ______0| _____0\r\n      fsync| ____0| ____0| ____0| ______0| _____0\r\n    opendir| ____0| ____0| ____0| ______0| _____0\r\n    readdir| ____0| ____0| ____0| ______0| _____0\r\n Time: 2018-01-22 14:43:28.257794 / Sort Columns: 1'),(143,'','');
/*!40000 ALTER TABLE `codes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `labels`
--

DROP TABLE IF EXISTS `labels`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `labels` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `label` (`label`)
) ENGINE=InnoDB AUTO_INCREMENT=73 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `labels`
--

LOCK TABLES `labels` WRITE;
/*!40000 ALTER TABLE `labels` DISABLE KEYS */;
INSERT  IGNORE INTO `labels` VALUES (69,'CIFS'),(68,'NFS'),(57,'NVP'),(65,'backup'),(55,'biziod'),(61,'bizobj'),(51,'cifs'),(67,'config'),(59,'configuration'),(63,'disk'),(49,'elasticsearch'),(70,'high availability'),(43,'latency'),(72,'nasdk'),(40,'network'),(46,'node'),(58,'perf'),(62,'repair'),(66,'salt'),(52,'samba'),(60,'sfused'),(50,'smb'),(64,'storage'),(54,'trace'),(53,'wireshark');
/*!40000 ALTER TABLE `labels` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `maintainer`
--

DROP TABLE IF EXISTS `maintainer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `maintainer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `maintainer`
--

LOCK TABLES `maintainer` WRITE;
/*!40000 ALTER TABLE `maintainer` DISABLE KEYS */;
INSERT  IGNORE INTO `maintainer` VALUES (11,''),(9,'CÃ©drick'),(8,'Jean-Marc');
/*!40000 ALTER TABLE `maintainer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sources`
--

DROP TABLE IF EXISTS `sources`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sources` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sources`
--

LOCK TABLES `sources` WRITE;
/*!40000 ALTER TABLE `sources` DISABLE KEYS */;
INSERT  IGNORE INTO `sources` VALUES (6,'JM Bitbucket'),(7,'CSE Bitbucket'),(9,'git@github.com:mobidyc/nasdktop.git'),(11,'');
/*!40000 ALTER TABLE `sources` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-08-24 11:24:29
