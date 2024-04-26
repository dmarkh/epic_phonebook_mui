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
-- Table structure for table `institutions`
--

DROP TABLE IF EXISTS `institutions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `institutions` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `status` enum('active','onhold','inactive') NOT NULL DEFAULT 'onhold',
  `status_change_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `status_change_reason` varchar(255) NOT NULL DEFAULT '',
  `last_update_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `join_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `status` (`status`)
) ENGINE=MyISAM AUTO_INCREMENT=669 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `institutions_data_dates`
--

DROP TABLE IF EXISTS `institutions_data_dates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `institutions_data_dates` (
  `institutions_id` int(11) unsigned NOT NULL DEFAULT '0',
  `institutions_fields_id` int(11) unsigned NOT NULL DEFAULT '0',
  `value` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`institutions_id`,`institutions_fields_id`),
  KEY `institutions_fields_id` (`institutions_fields_id`),
  KEY `institutions_id` (`institutions_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `institutions_data_ints`
--

DROP TABLE IF EXISTS `institutions_data_ints`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `institutions_data_ints` (
  `institutions_id` int(11) unsigned NOT NULL DEFAULT '0',
  `institutions_fields_id` int(11) unsigned NOT NULL DEFAULT '0',
  `value` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`institutions_id`,`institutions_fields_id`),
  KEY `institutions_id` (`institutions_id`),
  KEY `institutions_fields_id` (`institutions_fields_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `institutions_data_strings`
--

DROP TABLE IF EXISTS `institutions_data_strings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `institutions_data_strings` (
  `institutions_id` int(11) unsigned NOT NULL DEFAULT '0',
  `institutions_fields_id` int(11) unsigned NOT NULL DEFAULT '0',
  `value` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`institutions_id`,`institutions_fields_id`),
  KEY `institutions_fields_id` (`institutions_fields_id`),
  KEY `institutions_id` (`institutions_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `institutions_data_texts`
--

DROP TABLE IF EXISTS `institutions_data_texts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `institutions_data_texts` (
  `institutions_id` int(11) unsigned NOT NULL DEFAULT '0',
  `institutions_fields_id` int(11) unsigned NOT NULL DEFAULT '0',
  `value` mediumtext,
  PRIMARY KEY (`institutions_id`,`institutions_fields_id`),
  KEY `institutions_fields_id` (`institutions_fields_id`),
  KEY `institutions_id` (`institutions_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `institutions_fields`
--

DROP TABLE IF EXISTS `institutions_fields`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `institutions_fields` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name_fixed` varchar(255) NOT NULL DEFAULT '',
  `name_desc` varchar(255) NOT NULL DEFAULT '',
  `weight` int(11) NOT NULL DEFAULT '0',
  `type` enum('string','date','int','text') DEFAULT NULL,
  `options` text NOT NULL,
  `size_min` int(3) NOT NULL DEFAULT '0',
  `size_max` int(3) NOT NULL DEFAULT '255',
  `hint_short` varchar(255) NOT NULL DEFAULT '',
  `hint_full` varchar(255) NOT NULL DEFAULT '',
  `group` int(11) NOT NULL DEFAULT '1',
  `is_required` enum('y','n') NOT NULL DEFAULT 'n',
  `is_enabled` enum('y','n') NOT NULL DEFAULT 'y',
  `privacy` enum('public','users_auth','users_admin') NOT NULL DEFAULT 'public',
  `always_latest` enum('n','y') NOT NULL DEFAULT 'n',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_short` (`name_fixed`)
) ENGINE=MyISAM AUTO_INCREMENT=51 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `institutions_fields`
--

LOCK TABLES `institutions_fields` WRITE;
/*!40000 ALTER TABLE `institutions_fields` DISABLE KEYS */;
INSERT INTO `institutions_fields` VALUES (1,'name_full','Full name of the institution',0,'string','',1,255,'','Please provide full name of the institution',2,'y','y','public','n');
INSERT INTO `institutions_fields` VALUES (2,'name_short','Institution acronym',1,'string','',1,10,'BNL. ANL, WSU, ...','A short acronym the institutions is known by',2,'n','y','public','n');
INSERT INTO `institutions_fields` VALUES (3,'name_group','Group name',2,'string','',1,255,'','',2,'n','y','public','n');
INSERT INTO `institutions_fields` VALUES (4,'name_latex','LaTeX affiliation name',3,'string','',1,255,'','This field is required for displaying authors',2,'n','y','public','n');
INSERT INTO `institutions_fields` VALUES (5,'name_unicode','Unicode name of the institution',1,'string','',1,255,'','',2,'n','y','public','n');
INSERT INTO `institutions_fields` VALUES (6,'name_sortby','Name to use in sorting',4,'string','',1,255,'','',2,'n','y','public','n');
INSERT INTO `institutions_fields` VALUES (7,'website_group','Website of the EIC group',5,'string','',1,255,'','',2,'n','n','public','n');
INSERT INTO `institutions_fields` VALUES (8,'website_institution','Web site of the institution',6,'string','',1,255,'','',2,'n','y','public','n');
INSERT INTO `institutions_fields` VALUES (9,'council_representative','Council representative',7,'int','',0,255,'','',2,'n','y','public','n');
INSERT INTO `institutions_fields` VALUES (10,'address_line_1','Address line 1',0,'string','',0,255,'','',3,'n','y','public','n');
INSERT INTO `institutions_fields` VALUES (11,'address_line_2','Address line 2',1,'string','',0,255,'','',3,'n','y','public','n');
INSERT INTO `institutions_fields` VALUES (12,'city','City',2,'string','',0,255,'','',3,'n','y','public','n');
INSERT INTO `institutions_fields` VALUES (13,'state','State/Region',3,'string','',0,255,'','',3,'n','y','public','n');
INSERT INTO `institutions_fields` VALUES (14,'country','Country',6,'string','',0,255,'','',3,'n','y','public','n');
INSERT INTO `institutions_fields` VALUES (15,'postcode','Postcode/Zipcode',8,'string','',0,255,'','',3,'n','y','public','n');
INSERT INTO `institutions_fields` VALUES (16,'phone_contact','Contact phone of the institution',10,'string','',0,255,'','',3,'n','y','users_auth','n');
INSERT INTO `institutions_fields` VALUES (20,'office','External: office number',0,'string','',0,255,'','',4,'n','y','public','n');
INSERT INTO `institutions_fields` VALUES (21,'building','External: building number',1,'string','',0,255,'','',4,'n','y','public','n');
INSERT INTO `institutions_fields` VALUES (22,'phone_office','External: office phone number',2,'string','',0,255,'','',4,'n','y','public','n');
INSERT INTO `institutions_fields` VALUES (34,'country_code','Country code',4,'string','',2,2,'','',3,'n','y','public','n');
INSERT INTO `institutions_fields` VALUES (40,'region','Region of the World',9,'string','un:UNSPECIFIED,af:AFRICA,as:ASIA,eu:EUROPE,na:NORTH AMERICA,sa:SOUTH AMERICA,oc:OCEANIA,po:POLAR REGIONS',2,2,'region','region of the world',3,'n','y','public','n');
INSERT INTO `institutions_fields` VALUES (41,'date_joined','Join date',0,'date','',1,20,'Join date','Date when Institution joined collaboration',2,'n','y','public','n');
INSERT INTO `institutions_fields` VALUES (42,'date_leave','Leave date',0,'date','',1,20,'Leave date','Date when Institution left collaboration',2,'n','y','public','n');
INSERT INTO `institutions_fields` VALUES (43,'geo_lattitude','Lattitude',11,'string','',1,255,'Lattitude','Lattitude of the institution address',3,'n','y','public','n');
INSERT INTO `institutions_fields` VALUES (44,'geo_longitude','Longitude',12,'string','',1,255,'Longitude','Longitude of the institution address',3,'n','y','public','n');
INSERT INTO `institutions_fields` VALUES (45,'associated_id','Parent Institution (association)',8,'int','',1,1000,'ID of the parent institution','ID of the parent institution',2,'n','y','public','n');
INSERT INTO `institutions_fields` VALUES (46,'alt_council_representative','Alt. Council representative',7,'int','',0,255,' ',' ',2,'n','y','public','n');
INSERT INTO `institutions_fields` VALUES (47,'exofficio_council_representative1','Ex-officio Council Rep 1',7,'int','',0,255,' ',' ',2,'n','y','public','n');
INSERT INTO `institutions_fields` VALUES (48,'exofficio_council_representative2','Ex-officio Council Rep 2',7,'int','',0,255,' ',' ',2,'n','y','public','n');
INSERT INTO `institutions_fields` VALUES (49,'ror_id','ROR ID',1,'string','',1,255,'ROR ID','Research Organization Registry ID',2,'y','y','public','y');
INSERT INTO `institutions_fields` VALUES (50,'contact_email','Contact Email',1,'string','',1,255,'contact email','The email of the Institution representative',2,'n','y','public','n');
/*!40000 ALTER TABLE `institutions_fields` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `institutions_fields_groups`
--

DROP TABLE IF EXISTS `institutions_fields_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `institutions_fields_groups` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name_short` varchar(255) NOT NULL DEFAULT '',
  `name_full` varchar(255) NOT NULL DEFAULT '',
  `is_enabled` enum('y','n') NOT NULL DEFAULT 'y',
  `weight` int(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `institutions_fields_groups`
--

LOCK TABLES `institutions_fields_groups` WRITE;
/*!40000 ALTER TABLE `institutions_fields_groups` DISABLE KEYS */;
INSERT INTO `institutions_fields_groups` VALUES (1,'default','default group','y',10);
INSERT INTO `institutions_fields_groups` VALUES (2,'institution_personal','Institution information','y',1);
INSERT INTO `institutions_fields_groups` VALUES (3,'institution_address','Institution address','y',2);
INSERT INTO `institutions_fields_groups` VALUES (4,'institution_address_bnl','Institution BNL address','y',3);
/*!40000 ALTER TABLE `institutions_fields_groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `institutions_history`
--

DROP TABLE IF EXISTS `institutions_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `institutions_history` (
  `institutions_id` int(11) unsigned NOT NULL DEFAULT '0',
  `institutions_fields_id` int(11) unsigned NOT NULL DEFAULT '0',
  `date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `value_from_string` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `value_to_string` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `value_from_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `value_to_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `value_from_int` int(11) NOT NULL DEFAULT '0',
  `value_to_int` int(11) NOT NULL DEFAULT '0',
  `ip` varchar(255) NOT NULL DEFAULT '',
  `user` varchar(255) NOT NULL DEFAULT '',
  KEY `institutions_id` (`institutions_id`),
  KEY `institutions_fields_id` (`institutions_fields_id`),
  KEY `date` (`date`),
  KEY `inst_field_ids` (`institutions_id`,`institutions_fields_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `members`
--

DROP TABLE IF EXISTS `members`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `members` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `status` enum('active','onhold','inactive') NOT NULL DEFAULT 'onhold',
  `status_change_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `status_change_reason` varchar(255) NOT NULL DEFAULT '',
  `last_update_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `join_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `status` (`status`)
) ENGINE=MyISAM AUTO_INCREMENT=2986 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `members_data_dates`
--

DROP TABLE IF EXISTS `members_data_dates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `members_data_dates` (
  `members_id` int(11) unsigned NOT NULL DEFAULT '0',
  `members_fields_id` int(11) unsigned NOT NULL DEFAULT '0',
  `value` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`members_id`,`members_fields_id`),
  KEY `members_id` (`members_id`),
  KEY `members_fields_id` (`members_fields_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `members_data_ints`
--

DROP TABLE IF EXISTS `members_data_ints`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `members_data_ints` (
  `members_id` int(11) unsigned NOT NULL DEFAULT '0',
  `members_fields_id` int(11) unsigned NOT NULL DEFAULT '0',
  `value` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`members_id`,`members_fields_id`),
  KEY `members_id` (`members_id`),
  KEY `members_fields_id` (`members_fields_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `members_data_strings`
--

DROP TABLE IF EXISTS `members_data_strings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `members_data_strings` (
  `members_id` int(11) unsigned NOT NULL DEFAULT '0',
  `members_fields_id` int(11) unsigned NOT NULL DEFAULT '0',
  `value` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`members_id`,`members_fields_id`),
  KEY `members_id` (`members_id`),
  KEY `members_fields_id` (`members_fields_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `members_data_texts`
--

DROP TABLE IF EXISTS `members_data_texts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `members_data_texts` (
  `members_id` int(11) unsigned NOT NULL DEFAULT '0',
  `members_fields_id` int(11) unsigned NOT NULL DEFAULT '0',
  `value` mediumtext NOT NULL,
  PRIMARY KEY (`members_id`,`members_fields_id`),
  KEY `members_id` (`members_id`),
  KEY `members_fields_id` (`members_fields_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `members_fields`
--

DROP TABLE IF EXISTS `members_fields`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `members_fields` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name_fixed` varchar(255) NOT NULL DEFAULT '',
  `name_desc` varchar(255) NOT NULL DEFAULT '',
  `weight` int(11) NOT NULL DEFAULT '0',
  `type` enum('string','date','int','text') DEFAULT NULL,
  `options` varchar(255) NOT NULL DEFAULT '',
  `size_min` int(3) NOT NULL DEFAULT '0',
  `size_max` int(3) NOT NULL DEFAULT '255',
  `hint_short` varchar(255) NOT NULL DEFAULT '',
  `hint_full` varchar(255) NOT NULL DEFAULT '',
  `group` int(3) NOT NULL DEFAULT '0',
  `is_required` enum('y','n') NOT NULL DEFAULT 'n',
  `is_enabled` enum('y','n') NOT NULL DEFAULT 'y',
  `privacy` enum('public','users_auth','users_user','users_admin') NOT NULL DEFAULT 'public',
  `always_latest` enum('n','y') NOT NULL DEFAULT 'n',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_group` (`name_fixed`,`group`)
) ENGINE=MyISAM AUTO_INCREMENT=94 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `members_fields`
--

LOCK TABLES `members_fields` WRITE;
/*!40000 ALTER TABLE `members_fields` DISABLE KEYS */;
INSERT INTO `members_fields` VALUES (1,'name_first','First name',0,'string','',1,255,'','Please provide your full first name',2,'y','y','public','n');
INSERT INTO `members_fields` VALUES (2,'name_initials','Initials',1,'string','',1,6,'','Initials will be used to alter the first name auto-initial OR, if that field exists, in conjunction with the Latex Name to form the name to appear on publication',2,'n','y','public','n');
INSERT INTO `members_fields` VALUES (3,'name_last','Last Name',2,'string','',1,255,'','Last name or Family name (chain)',2,'y','y','public','n');
INSERT INTO `members_fields` VALUES (4,'name_latex','Latex Last Name',3,'string','',1,255,'','If used, this will be the Last-name equivalent appearing on publications',2,'n','y','public','n');
INSERT INTO `members_fields` VALUES (5,'name_unicode','Unicode name',4,'string','',1,255,'','This field is used to display foreign names in their original language (Chinese, Russian, Korean, Japanese, Arabic, ...) or to display special accentuation. If exists, this field will appear in full in the public PhoneBook interface',2,'n','y','public','n');
INSERT INTO `members_fields` VALUES (6,'inspire_id','Inspire ID',5,'int','',0,255,'','',2,'n','y','public','n');
INSERT INTO `members_fields` VALUES (7,'gender','Gender',6,'string','U:Unspecified,M:Male,F:Female,O:Other',0,255,'Man/Woman/Unspecified','If known, please consider entering it - this will be useful to generate statistical analysis',2,'n','y','users_user','n');
INSERT INTO `members_fields` VALUES (10,'address_line_1','Address line 1',0,'string','',1,255,'','If used, this will be the Last-name equivalent appearing on publications',3,'n','y','public','n');
INSERT INTO `members_fields` VALUES (11,'address_line_2','Address line 2',1,'string','',1,255,'','',3,'n','y','public','n');
INSERT INTO `members_fields` VALUES (12,'address_line_3','Address line 3',2,'string','',1,255,'','',3,'n','y','public','n');
INSERT INTO `members_fields` VALUES (13,'city','City',3,'string','',1,255,'','',3,'n','y','public','n');
INSERT INTO `members_fields` VALUES (14,'state','State/Region',4,'string','',1,255,'','',3,'n','y','public','n');
INSERT INTO `members_fields` VALUES (15,'country','Country',5,'string','',1,255,'','',3,'n','y','public','n');
INSERT INTO `members_fields` VALUES (16,'postcode','Postcode/zipcode',6,'string','',1,6,'','',3,'n','y','public','n');
INSERT INTO `members_fields` VALUES (17,'institution_id','Home institution',7,'int','',1,11,'','',3,'y','y','public','n');
INSERT INTO `members_fields` VALUES (20,'email','E-mail address',0,'string','',1,255,'','',4,'n','y','public','n');
INSERT INTO `members_fields` VALUES (21,'email_alt','Alternative e-mail address',1,'string','',1,255,'','',4,'n','y','public','n');
INSERT INTO `members_fields` VALUES (22,'phone_work','Work phone',2,'string','',1,255,'','',4,'n','y','public','n');
INSERT INTO `members_fields` VALUES (23,'phone_cell','Cell phone',3,'string','',1,255,'','',4,'n','y','public','n');
INSERT INTO `members_fields` VALUES (24,'fax','Fax number',4,'string','',1,255,'','',4,'n','y','public','n');
INSERT INTO `members_fields` VALUES (25,'url','Website address url',5,'string','',1,255,'','',4,'n','y','public','n');
INSERT INTO `members_fields` VALUES (30,'bnl_office','External: Office Number',0,'string','',1,255,'','',5,'n','y','public','n');
INSERT INTO `members_fields` VALUES (31,'bnl_building','External: Building Number',1,'string','',1,255,'','',5,'n','y','public','n');
INSERT INTO `members_fields` VALUES (32,'bnl_phone_office','External: Office phone',2,'string','',1,255,'','',5,'n','y','public','n');
INSERT INTO `members_fields` VALUES (33,'bnl_phone_alt','External: Alternate Phone',3,'string','',1,255,'','',5,'n','y','public','n');
INSERT INTO `members_fields` VALUES (40,'is_author','Is author',0,'string','n:No,y:Yes',1,1,'','',6,'n','y','public','n');
INSERT INTO `members_fields` VALUES (41,'is_junior','Is junior',1,'string','n:No,y:Yes',1,1,'','',6,'n','y','public','n');
INSERT INTO `members_fields` VALUES (42,'is_shifter','Is shifter',2,'string','n:No,y:Yes',1,1,'','',6,'n','y','public','n');
INSERT INTO `members_fields` VALUES (43,'is_expert','Is expert',5,'string','n:No,y:Yes',1,1,'','',6,'n','y','public','n');
INSERT INTO `members_fields` VALUES (44,'is_emeritus','Is emeritus',4,'string','n:No,y:Yes',1,1,'','',6,'n','y','public','n');
INSERT INTO `members_fields` VALUES (45,'expertise','Area of expertise',6,'string','',1,255,'','',6,'n','y','public','n');
INSERT INTO `members_fields` VALUES (46,'expert_credit','Expert credit',7,'int','',1,1,'','',6,'n','y','public','n');
INSERT INTO `members_fields` VALUES (84,'date_joined','Join date',0,'date','',1,20,'Join date','Date when person joined collaboration',6,'y','y','public','n');
INSERT INTO `members_fields` VALUES (85,'date_leave','Leave date',0,'date','',1,20,'Leave date','Date when person left collaboration',6,'n','y','public','n');
INSERT INTO `members_fields` VALUES (86,'disabled_reason','Disabled Reason',0,'string','',0,255,'Disabled Reason (shifts accounting)','Disabled Reason (shifts accounting)',6,'n','y','public','n');
INSERT INTO `members_fields` VALUES (87,'qa_certified','Certified for offline QA',8,'int','',0,1,'1/0','0=not certified, 1=certified',6,'n','y','public','n');
INSERT INTO `members_fields` VALUES (88,'rcf_login','RCF login name',4,'string','',1,255,'rcf login','RCF login name',5,'n','y','public','n');
INSERT INTO `members_fields` VALUES (89,'person_category','Area',8,'string','u:Unknown,t:Theory,e:Experiment,a:Accelerator,s:Support,c:Software and Computing',1,1,' ','Area: t:Theory, e:Experiment, a:Accelerator, s:Support, c:SoftwareAndComputing',2,'n','y','public','n');
INSERT INTO `members_fields` VALUES (90,'orcid_id','ORCID',1,'string','',1,255,'ORCID','ORCID',6,'y','y','public','y');
INSERT INTO `members_fields` VALUES (91,'member_role','Member Role',1,'string','mb:Member,rp:Representative,arp:Representative (alt),erp:Representative (ex-officio),ecr:Early-Career Representative',1,255,'member role','member role',6,'n','y','public','n');
INSERT INTO `members_fields` VALUES (92,'extra_institution_id','Additional Instititution Affiliations',8,'string','',1,255,'','',3,'n','y','public','n');
INSERT INTO `members_fields` VALUES (93,'photo','Photo of the member: png/jpg file',100,'text','',0,16000000,'image file','image file',6,'n','y','public','n');
/*!40000 ALTER TABLE `members_fields` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `members_fields_groups`
--

DROP TABLE IF EXISTS `members_fields_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `members_fields_groups` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name_short` varchar(255) NOT NULL DEFAULT '',
  `name_full` varchar(255) NOT NULL DEFAULT '',
  `is_enabled` enum('y','n') NOT NULL DEFAULT 'y',
  `weight` int(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `members_fields_groups`
--

LOCK TABLES `members_fields_groups` WRITE;
/*!40000 ALTER TABLE `members_fields_groups` DISABLE KEYS */;
INSERT INTO `members_fields_groups` VALUES (1,'default','default group','y',10);
INSERT INTO `members_fields_groups` VALUES (2,'name','user name','y',1);
INSERT INTO `members_fields_groups` VALUES (3,'address','user address','y',2);
INSERT INTO `members_fields_groups` VALUES (4,'contact','user contact information','y',3);
INSERT INTO `members_fields_groups` VALUES (5,'bnl','user BNL information','y',4);
INSERT INTO `members_fields_groups` VALUES (6,'collaboration','collaboration data','y',5);
INSERT INTO `members_fields_groups` VALUES (7,'talks','talk related information','n',1);
/*!40000 ALTER TABLE `members_fields_groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `members_history`
--

DROP TABLE IF EXISTS `members_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `members_history` (
  `members_id` int(11) unsigned NOT NULL DEFAULT '0',
  `members_fields_id` int(11) unsigned NOT NULL DEFAULT '0',
  `date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `value_from_string` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `value_to_string` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `value_from_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `value_to_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `value_from_int` int(11) NOT NULL DEFAULT '0',
  `value_to_int` int(11) NOT NULL DEFAULT '0',
  `ip` varchar(255) NOT NULL DEFAULT '',
  `user` varchar(255) NOT NULL DEFAULT '',
  KEY `members_id` (`members_id`),
  KEY `members_fields_id` (`members_fields_id`),
  KEY `date` (`date`),
  KEY `mem_field_ids` (`members_id`,`members_fields_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*!40101 SET character_set_client = @saved_cs_client */;

/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
