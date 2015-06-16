-- MySQL dump 10.11
--
-- Host: localhost    Database: mindac_HH
-- ------------------------------------------------------
-- Server version	5.0.96-community-log

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
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `catid` int(10) unsigned NOT NULL auto_increment,
  `catname` char(10) NOT NULL,
  PRIMARY KEY  (`catid`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'Helmets'),(2,'Gloves'),(3,'Jerseys'),(4,'Skates'),(5,'Sticks');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `creditcard`
--

DROP TABLE IF EXISTS `creditcard`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `creditcard` (
  `ccnum` char(16) NOT NULL,
  `customerid` int(10) unsigned NOT NULL,
  `name` char(60) default NULL,
  `expdate` char(5) default NULL,
  `secnum` char(3) default NULL,
  `billstreet` char(30) default NULL,
  `billcity` char(30) default NULL,
  `billstate` char(2) default NULL,
  `zip` char(5) default NULL,
  PRIMARY KEY  (`ccnum`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `creditcard`
--

LOCK TABLES `creditcard` WRITE;
/*!40000 ALTER TABLE `creditcard` DISABLE KEYS */;
/*!40000 ALTER TABLE `creditcard` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customer`
--

DROP TABLE IF EXISTS `customer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customer` (
  `customerid` int(10) unsigned NOT NULL auto_increment,
  `firstName` char(20) NOT NULL,
  `lastName` char(20) NOT NULL,
  `street` char(45) NOT NULL,
  `city` char(30) NOT NULL,
  `st` char(2) default NULL,
  `zip` char(5) default NULL,
  `email` char(40) default NULL,
  `username` char(20) default NULL,
  `password` char(40) NOT NULL,
  PRIMARY KEY  (`customerid`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customer`
--

LOCK TABLES `customer` WRITE;
/*!40000 ALTER TABLE `customer` DISABLE KEYS */;
INSERT INTO `customer` VALUES (1,'Frank','Smith','654 Franklin Place','Paramus','NJ','07452','fsmith@gmule.com','smithy','fa9edc42d09e8228ef1cebaf571c291bf9f317bd');
/*!40000 ALTER TABLE `customer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `employees`
--

DROP TABLE IF EXISTS `employees`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `employees` (
  `employeeid` int(10) unsigned NOT NULL auto_increment,
  `username` char(16) NOT NULL,
  `ssn` char(9) NOT NULL,
  `category` char(10) default NULL,
  `firstName` char(20) NOT NULL,
  `lastName` char(20) NOT NULL,
  `street` char(45) NOT NULL,
  `city` char(30) NOT NULL,
  `st` char(2) default NULL,
  `zip` char(5) default NULL,
  `email` char(40) default NULL,
  `phone` char(12) default NULL,
  `password` char(40) NOT NULL,
  `paymenttype` char(10) NOT NULL default 'hourly',
  `hoursworked` tinyint(3) unsigned NOT NULL default '0',
  `paymentamount` float(8,2) NOT NULL,
  PRIMARY KEY  (`ssn`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `employeeid` (`employeeid`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employees`
--

LOCK TABLES `employees` WRITE;
/*!40000 ALTER TABLE `employees` DISABLE KEYS */;
INSERT INTO `employees` VALUES (3,'batman','iambatman','finance','Bruce','Wayne','4 Wayne Manor Drive','Gotham City','NY','09042','bwayne@wanye.org','212-894-4444','300646b7440f09ef1a8bc0ca8cd5504cf236cd5b','salary',0,85732.57),(4,'deadpool','somepun4u','shipping','Wade','Wilson','23 Marvel Street','Carlstadt','NJ','07045','mercwithamouth@internet.org','111-111-1111','2cacb144c135bc943c89b7d66b2618019018e320','hourly',0,15.75),(2,'cminda','thisafake','admin','Chris','Minda','123 Washington Ave.','Hackensack','NJ','07602','cminda@thatsite.net','474-848-9295','756528af53c11a25f37e639d12e34126460c10da','salary',0,45534.56);
/*!40000 ALTER TABLE `employees` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gloves`
--

DROP TABLE IF EXISTS `gloves`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gloves` (
  `exId` char(6) NOT NULL,
  `itemid` int(10) NOT NULL,
  `color` char(15) NOT NULL,
  `glovesize` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  KEY `itemid` (`itemid`),
  CONSTRAINT `gloves_ibfk_3` FOREIGN KEY (`itemid`) REFERENCES `merchandise` (`itemid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gloves`
--

LOCK TABLES `gloves` WRITE;
/*!40000 ALTER TABLE `gloves` DISABLE KEYS */;
INSERT INTO `gloves` VALUES ('bl13',1,'Black',13,14),('blg13',1,'Black/Gold',13,10),('blg15',1,'Black/Gold',15,3),('blo13',3,'Black/Orange',13,12),('blo14',3,'Black/Orange',14,4),('brw14',2,'Black/Red/White',14,10),('brw15',2,'Black/Red/White',15,7),('bw15',2,'Black/White',15,4),('Nav14',1,'Navy',14,5),('Nav15',1,'Navy',15,7),('nw13',2,'Navy/White',13,3),('blo15',3,'Black/Orange',15,6),('brw15',3,'Black/Red/White',15,2),('blo13',4,'Black/Orange',13,3),('blo15',4,'Black/Orange',15,11),('nw14',4,'Navy/White',14,7),('brw13',4,'Black/Red/White',13,9),('nav13',5,'Navy',13,2),('br14',5,'Black/Red',14,7),('rw15',1,'Red/White',15,22);
/*!40000 ALTER TABLE `gloves` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `helmets`
--

DROP TABLE IF EXISTS `helmets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `helmets` (
  `exId` char(6) NOT NULL,
  `itemid` int(10) NOT NULL,
  `color` char(20) NOT NULL,
  `helmetsize` char(4) NOT NULL,
  `quantity` int(11) NOT NULL,
  KEY `itemid` (`itemid`),
  CONSTRAINT `helmets_ibfk_1` FOREIGN KEY (`itemid`) REFERENCES `merchandise` (`itemid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `helmets`
--

LOCK TABLES `helmets` WRITE;
/*!40000 ALTER TABLE `helmets` DISABLE KEYS */;
INSERT INTO `helmets` VALUES ('bls',6,'Black','S',7),('blm',6,'Black','M',5),('bll',6,'Black','L',12),('bll',6,'White','L',2),('navxl',6,'Navy','XL',3),('bls',7,'Black','S',4),('roys',7,'Royal','S',6),('redl',7,'Red','L',3),('wl',7,'White','L',4),('blxs',8,'Black','XS',5),('bls',8,'Black','S',8),('blm',8,'Black','M',2),('bll',8,'Black','L',4),('wm',8,'White','M',4),('blbls',9,'Black w/ Black Vents','S',4),('blgrm',9,'Black w/ Grey Vents','M',12),('navgrl',9,'Navy w/ Grey Vents','L',4),('blblm',9,'Black w/ Black Vents','M',7),('bls',10,'Black','S',5),('ws',10,'White','S',14),('blm',10,'Black','M',3),('wm',10,'White','M',12),('bll',10,'Black','L',3),('wxl',10,'White','XL',5);
/*!40000 ALTER TABLE `helmets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jerseys`
--

DROP TABLE IF EXISTS `jerseys`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jerseys` (
  `exId` char(6) NOT NULL,
  `itemid` int(10) NOT NULL,
  `color` char(15) NOT NULL,
  `team` char(20) NOT NULL,
  `jerseysize` char(10) NOT NULL,
  `quantity` int(11) NOT NULL,
  KEY `itemid` (`itemid`),
  CONSTRAINT `jerseys_ibfk_1` FOREIGN KEY (`itemid`) REFERENCES `merchandise` (`itemid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jerseys`
--

LOCK TABLES `jerseys` WRITE;
/*!40000 ALTER TABLE `jerseys` DISABLE KEYS */;
INSERT INTO `jerseys` VALUES ('bllxl',11,'Black','Practice','Large/XL',7),('blsm',11,'Black','Practice','Small/Med',5),('dgl',12,'Dark Green','Practice','Large',8),('dgm',12,'Dark Green','Practice','Medium',10),('dgs',12,'Dark Green','Practice','Small',14),('dgxl',12,'Dark Green','Practice','XL',3),('navl',13,'Navy','Practice','Large',3),('navm',13,'Navy','Practice','Medium',11),('navs',13,'Navy','Practice','Small',13),('orl',13,'Orange','Practice','Large',17),('purlxl',11,'Purple','Practice','Large/XL',20),('pursm',11,'Purple','Practice','Small/Med',4),('redm',13,'Red','Practice','Medium',12),('roylxl',11,'Royal','Practice','Large/XL',17),('roysm',11,'Royal','Practice','Small/Med',6),('silm',13,'Silver','Practice','Medium',14),('sils',13,'Silver','Practice','Small',12),('blxl',14,'Black','Practice','XL',17),('whm',14,'White','Practice','Medium',11),('redxxl',14,'Red','Practice','XXL',15),('wxl',14,'White','Practice','XL',9),('navxl',14,'Navy','Practice','XL',10),('blum',15,'Blue','Practice','Medium',14),('blul',15,'Blue','Practice','Large',8),('bluxl',15,'Blue','Practice','XL',7),('bws',16,'Black/White','Practice','Small',14),('bwl',16,'Black/White','Practice','Large',4),('rwm',16,'Red/White','Practice','Medium',12),('rwl',16,'Red/White','Practice','Large',11),('nvwxxl',16,'Navy/White','Practice','XXL',2),('nvwgol',16,'Navy/White','Practice','Goalie',12),('gws',16,'Green/White','Practice','Small',6),('gwgol',16,'Green/White','Practice','Goalie',4);
/*!40000 ALTER TABLE `jerseys` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `merchandise`
--

DROP TABLE IF EXISTS `merchandise`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `merchandise` (
  `itemid` int(11) NOT NULL auto_increment,
  `name` char(80) NOT NULL,
  `manufacturer` char(15) NOT NULL,
  `catid` int(10) unsigned NOT NULL,
  `price` float(5,2) default NULL,
  `description` text,
  PRIMARY KEY  (`itemid`)
) ENGINE=InnoDB AUTO_INCREMENT=68 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `merchandise`
--

LOCK TABLES `merchandise` WRITE;
/*!40000 ALTER TABLE `merchandise` DISABLE KEYS */;
INSERT INTO `merchandise` VALUES (1,'Bauer Supreme TOTALONE Senior Hockey Gloves','Bauer',2,149.99,'Foams - Dual Density foams featuring MAX-SORB protection <br />\r\n\r\nThumb - Patented by 3-Piece Free Flex Lock Thumb\r\nInserts - Poly\r\n\r\nShell - Lightweight stretch matrix nylon, textured synthetic leather\r\n\r\nFIT/MOBILITY :\r\nOverall Fit - Anatomical\r\nBackhand Pad - Memory foam for personalized fit\r\nFingers - 3 piece index finger\r\nPalm - Nubuck nash with gecko nash overlay\r\nBack Roll - Center segmentation\r\nCuff - Pro multi segmented cuff\r\nLiner - THERMO MAX+'),(2,'CCM U+ 06 Senior Hockey Gloves','CCM',2,69.99,'								Thumb: New flex thumb\r\nBackhand: Soft triple decker foam construction\r\nPalm: Reinforced Nash with nylon mesh gussets\r\nCuff: Pro open cuff roll\r\nFingers: Soft triple decker foam construction\r\nLiner: Soft fabric liner with comfort foam\r\nExterior: Hybrid nylon / PU (weekly usage)'),(3,'Easton Stealth 85S Senior Hockey Gloves','Easton',2,124.99,'Enhanced range of motion and mobility with new angled cuff roll design\r\nPalm is Nash base with AX Suede? overlay for durability and excellent feel\r\nTriple-segmented index, middle and ring fingers provide excellent mobility\r\nLightweight shell provides the rich look, while PE inserts over mid-density foams provide protection\r\n'),(4,'Reebok 7k KFS Senior Hockey Gloves','Reebok',2,109.99,'Cuff - Seamless flexible cuff with now binding for increased comfort and flexibility\r\nPalm - Combination stretch and nash palm\r\nProtection - Plastic inserts in backhand protect against slashes\r\nBlocking Pattern - KFS locking pattern allows the glove to follow the natural movement of the hand with HD foam and PE inserts'),(5,'Warrior Remix Senior Hockey Gloves- 2012','Warrior',2,124.99,'4 Bar style design, classic pro look with a refined traditional high-volume fit and feel\r\nLightweight Tufftek outer shell\r\nDual-layered foam with plastic insert protection\r\nDual-layered extra durable Clarino Authentic Pro Palm\r\nV-Tek? micro-mesh liner controls moisture and odor'),(6,'Bauer 9900 Hockey Helmet','Bauer',1,139.99,'				FXPP Liner - Located in key impact zones, the Fused Expanded Polypropylene foam liner helps dissipate 20% less energy during impact than the same volume of traditional EPP foam\r\nBiomechanical Shell - Dual-density HDPE shell combines both protective and flexible material, allowing the helmet to self-adjust to the vast head shapes in the game and provide a better, more personalized fit\r\nPORON® XRD? Technology - Exclusive to BAUER Hockey, PORON® XRD? Extreme impact Protection is a super-light, pliable material with the ability to dissipate more than 90% of force on impact. Placed strategically in the helmet, PORON® XRD? offers breathable and flexible protection while consistently managing impact where you head needs it most\r\nSpecs\r\nGameday Protection: FXPP foam protection / Triple density impact management foam / PORON® XRD? / Ergo translucent ear covers / CSA, HECC, CE certified\r\nCustomized Fit: Bio-mechanical shell / Occipital lock 2.0 / Tool-free adjustment / Three distinct shell sizes\r\nComfort: Slow memory comfort foam / Ventilation ports / Molded memory foam temple pads / MICROBAN® antibacterial protection\r\n'),(7,'CCM Vector V10 Hockey Helmet with Cage','CCM',1,149.99,'Brand new ergonomic, aerodynamic shell design\r\nEPP liner for multiple impact protection\r\nHeat activated molded memory foam for comfort\r\nLift and lock tool-free length adjustment\r\nExtensive venting for maximum air flow'),(8,'Easton E600 Hockey Helmet','Easton',1,124.99,'Full coverage EPP foam liner with PC shell and HDPE subshell to provide multi-impact durability\r\nGiro inspired Fit system combined with plush padding for excellent stability and best in class comfort\r\nA lightweight performance helmet that has excellent crush resistant properties'),(9,'Reebok 11k Hockey Helmet with Cage','Reebok',1,204.99,'New Reebok Shell - Next generations aerodynamic shell with ventilation designed for a low-profile fit\r\nEPP Floating Liner - EPP flexible liner with comfort cushions contours to the unique shape of your head\r\nMicrodial II - Permits 360 degree wrap and vertical adjustments to alleviate pressure points and hold helmet firmly in place\r\nFit Clips - Permits easy tool-less length adjustment\r\nSubshells - Using carbon fiber technology that revolutionized the stick market, Reebok designed a lightweight helmet without sacrificing protection'),(10,'Warrior Krown 360 Hockey Helmet','Warrior',1,159.99,'\r\nIntroducing the KROWN 360 ? a unique helmet design focused on paramount fit and layered impact protection for comfort and safety.\r\n\r\nThe Krown 360 uses a unique helmet design focused on paramount fit and layered impact protection for comfort and safety. Its four-piece shell and liner converge to create a true 360 degree fit, with a one-of-a-kind single dial adjustment that conveniently activates the 4-Play Fit System.\r\n\r\n\r\nWarrior Krown Helmet Features159.99\r\nEPP foam for lightweight, high-impact protection\r\nComfort foam pads for fit stability and cushioning\r\nCSA, HECC and CE certified\r\nFour precisely sized shells (S, M, L and XL)\r\nStrategically located Impax Molded Foam for protection against multiple low impacts\r\n360° FIT\r\n\r\nFour-piece shell and liner converge to create a true 360 degree fit\r\nA unique single dial adjustment conveniently activates the 4-Play Fit System\r\n360° PROTECTION\r\n\r\nThree intelligently selected, impact-specific layers of foam protection:\r\nEFP for lightweight, high-impact protection'),(11,'CCM 10200 Hockey Practice Jersey','CCM',3,19.99,'CCM patented lightweight Air-Knit fabric\r\n100% polyester double knit\r\nSingle-layer shoulders\r\nCross-over interlock collar'),(12,'CCM 17000 Center Ice Hockey Jersey- Dallas Stars','CCM',3,79.99,'Patented Air-Knit 100% polyester double knit\r\nReinforced stitching on shoulders and armholes\r\nDouble shoulders\r\nInterlock neck trim\r\nCCM/NHL neck label\r\nExclusive NHL replica practice jersey\r\nChest logos feature a combination of embroidery and applique twill\r\nCCM embroidery patch on back of the neck and front hem\r\nNHL Center Ice embroidered patch on front upper chest\r\n'),(13,'Kamazu 14100 Flexx Lite Hockey Jersey','Kamazu',3,29.99,'\r\nKamazu patented lightweight Air-Knit fabric\r\n100% Polyester double knit\r\nSingle-layer shoulders\r\nCross-over interlock collar'),(14,'Nike Bauer Hockey Goalie Jersey','Bauer',3,24.99,'Content : 100% Polyester Mesh\r\nV-neck bounded collar opening with front and back yoke. NIKE BAUER design trademark screen print across back bottom hem. Front of jersey open for team embellishment\r\nGoalie Cut Jersey'),(15,'RBK 27000 Platinum Performance Hockey Practice Jersey- Toronto Maple Leafs','Reebok',3,79.99,'Mid-weight ULTRAFIL 100% polyester\r\nExclusive replica practice jersey of the NHL\r\nPolyester mesh gusset inserts for improved ventilation\r\nChest crests feature a combination of embroidery and applique twill\r\nReflective shoulder and sleeve braid\r\nInterlock neck trim\r\nReinforced stitching on shoulders and armholes\r\nReebok logo direct embroidered patch on front neckline insert\r\nNHL shield embroidered patch on front neckline insert\r\nReebok/NHL licensed jersey woven neck label\r\n'),(16,'Reebok 20P00 Edge Practice Jersey','Reebok',3,39.99,'\r\nMid weight Ultrafil base with contrasting inserts\r\nMesh inserts\r\n100% polyester\r\nEmbroidered Reebok logos'),(17,'Bauer Nexus 1000','Bauer',4,749.99,'The Nexus skate series is where tradition meets technology, for the player who is looking \r\nfor maximum comfort and explosive acceleration.\r\n\r\nThey have a classic fit profile, which means that you sit deeper in this boot with more \r\nwrap and width than what you would experience in either of the Supreme or Vapor series \r\nskates.\r\n\r\nBauer uses an ultra light weight yet robust Tech Mesh quarter panel in the boot. It is \r\nfully heat moldable to help you achieve an optimal fit with minimal break in time. This \r\nconstruction provides pro-level support and also allows for efficient energy transfer \r\nbetween you and your skate. Beneath the hydrophobic retro tan Clarino® liner, the deep V \r\nheel fit is enhanced with very generous anatomical foam ankle pads that not only provide \r\na great amount of heel lock, but also make the skates very comfortable right out of the \r\nbox. The Nexus 1000 also features Total Edge comfort which helps alleviate abrasion high \r\non the ankle.\r\n\r\nDouble lace bite protection is achieved from the two-piece design of the ultra-thick pro \r\nfelt tongue and the molded metatarsal guard which also helps protect the front of the foot\r\nwhile blocking shots. This is the thickest white felt tongue that Bauer offers, but for \r\nas robust as it is, it still allows for a good amount of forward flex.\r\n\r\nIt has an ultra lightweight vented composite outsole which provides a nice rigid platform\r\n for the boot and reduces torque under the boot while you\'re skating.\r\n\r\nIf you\'re looking for a top-of-the-line classic retro-style skate that is infused with\r\n current skate technologies, look no further than the Nexus 1000 from Bauer.'),(18,'CCM Uplus12','CCM',4,479.99,'-U Foam Pro core construction\r\n-Vector Armor surlyn quarter package\r\n-Moisture wicking Clarino interior liner\r\n-Carbon composite exhaust outsole\r\n-Custom support exhaust insole\r\n-CCM Armor tongue\r\n-CCM E-Pro Holder with ProFormance Lite Stainless Steel Runner\r\n-Skate Weight: One skate, in size 8.0 D weighs 856 grams/30.19 ounces'),(19,'Easton Stealth s12','Easton',4,449.99,'-This skate tends to fit 1/2 Size smaller than your shoe size\r\n-Unmatched composite value with more lateral flex in the upper ankle\r\n-Coil Technology? texalium-glass composite boot form with Dryflow? - light, flexible, protective\r\n-Stealth Padlock ? molded anatomical ankle shape locks down heel for increased power\r\n-Pro-style white felt tongue with flexible lace-bite protection\r\n-Bio-Dri? Microfiber liner provides added grip and classic feel\r\n-InTS Integrated Tendon Structure is comfortable and functional\r\n-Easton Bio-Dri? Composite footbed with removable heel lift\r\n-Injected abrasion guard in high wear areas for improved durability\r\n-Composite toecap fully covered with longer-lasting rubber guard\r\n-Lightweight Parabolic Stainless Steel (LPS2) runner ? fast and flexible'),(20,'Graf Ultra G3S','Graf',4,779.99,'-EPP quarter construction\r\n-Thermolam construction system\r\n-AMC composite lining\r\n-Anatomical ankle padding'),(21,'RBK 20k Pump','Reebok',4,959.99,'The Reebok K skate series was designed to maximize power transmission, while \r\nproviding a customized fit that enhances the skaters stride. The Dynamic Support \r\nSystem, or DSS, is evident throughout the series and refers to the ideal skate \r\nconstruction which optimizes flexibility and stiffness. Reebok uses its proprietary \r\nlast, designed and engineered to provide stride-enhancing fit accuracy.\r\n\r\nThe 20K has a generous fit profile, but is armed with the Pump® technology which allows \r\nair to circulate around the ankles for great heel lock and a customized fit. The 20K is \r\nalso equipped with the Skate Lock feature which allows for variability within two \r\nseparate lacing zones - lower and upper.\r\n\r\nReebok uses its Pro Armour? V construction in the quarter. This is a fused multi-layered \r\npackage reinforced with metal mesh for great durability, long term performance and great \r\nstiffness. The other elements of the quarter are part of the Dynamic Support System. The \r\nflexion zone is an embedded composite zone, the fibers of which are oriented at 45° which \r\nprovides excellent support, but at the same time helps to control forward flex. The spinal\r\nzone is also an embedded composite zone, however, these fibers are oriented at 90° and 0° \r\nwhich is a stronger orientation for locking the heel in place.\r\n\r\nHeel lock is further enhanced through the use of internal memory foams and the Pump®. The \r\nfact that these are heat moldable just adds to the already great amount of customization \r\nthat this skate offers, which of course is going to further reduce break in time. The \r\ntongue is made of pro felt with a lightweight EPE foam core and an external molded lace \r\nbite protector, giving you a good amount of forward flex. Meanwhile, on the opposite end \r\nof the skating stride, the 20K tendon guard has rubber inserts that allow it to flex which\r\nenhances your mobility.\r\n\r\nThe 20K has the ventilated full lightweight carbon composite outsole which helps reduce \r\nweight in a skate and provides excellent rigidity under the boot thus reducing torque \r\nwhile you skate. If you\'re looking for a skate with great customized fit features and \r\ntechnology that helps to maximize power transmission, look no further than the 20K from \r\nReebok.'),(22,'Bauer Vapor APX Griptac','Bauer',5,249.99,'\r\nWith the creation of the VAPOR X:60, BAUER introduced to the hockey world the smartest\r\nstick in the history of the game. The X:60 features revolutionary Intelli-Sense Shot\r\nTechnology, which utilizes a dual kick zone flex profile for a quick release on wrist\r\nand snap shots while producing powerful slap shots and one-timers. \r\n\r\nWith feedback taken from elite level players around the globe, Bauer has developed a new\r\nblade core that offers the soft feel of SUPREME TOTALONE\'s Power Core 3 and combines it\r\nwith the lightweight performance of VAPOR\'s Aero Foam II Core to create the ultimate\r\nbalance of light weight and feel for the puck. As a testament to its uniqueness, the\r\nblade core was awarded a patent by both the U.S. and Canadian governments. \r\n\r\nPackaged together with the Pure Shot Blade Profile for improved accuracy, Monocomp \r\nTechnology for optimized balance and feel, and our exclusive use of light weight \r\nTeXtreme® carbon fiber, the new blade core will help you score more goals from anywhere \r\non the ice... and make you \"feel\" really good about it. \r\n\r\n-Patented dual density blade core\r\n-Intelli-Sense shot technology\r\n-Monocomp Technology\r\n-Pure Shot blade profile\r\n-Lightweight TeXtreme® construction\r\n-Micro Feel II shaft dimension\r\n-Double concave walls\r\n-VAPOR premium dual taper\r\nGRIPTAC grip application\r\nLength - 60in.'),(23,'Easton Stealth RS II Grip','Easton',5,309.99,'If you love to shoot, the Stealth line of sticks offer features and technologies at every\r\nprice point to help enhance shot accuracy. Drawing on the successes of the original RS,\r\nEaston set out to make this version of the RS even better. This RS II is lighter, very\r\nwell-balanced, more responsive and more durable than its predecessor and it looks great\r\ntoo. Easton kept with the tonal black look on the RS II and the entire Stealth line uses\r\nasymmetrical graphics where the forehand graphic is different than the backhand graphic\r\non the stick.\r\n\r\nVibration dampening and improved durability from impacts such as slashes and shots are two\r\nof the benefits of the proprietary textured woven Kevlar® wrap on the outermost layer of\r\nthe shaft. The shaft geometry, which is very popular among Easton\'s pro players, has\r\nsquare corners with slightly concave walls and allows you to get a nice secure grip of\r\nyour stick. The RS II is available in either a matte or Grip finish.\r\n\r\nIt\'s the elliptical profile of the taper that sets the RS II apart from all other sticks.\r\nThis is a finely tuned taper section that provides torsional resistance towards the blade\r\nopening up, which is a contributing factor to shot accuracy. This area also provides the\r\nlow kick point of the stick, which allows for a quick release.\r\n\r\nThe blade was a main area of focus for Easton as they re-engineered it to be more\r\nresponsive and durable. Easton uses a multi-rib construction through its micro-bladder\r\nprocess. Basically, this means that there are 3 structural ribs that run the length of\r\nthe blade with a combination of a bladder and 4 foam core inserts between the ribs. This\r\nprovides a more durable core to wall bond as well as dampening for a great feel.\r\n\r\nGo ahead, take the shot. The Easton Stealth RS II has been engineered to enhance shot\r\naccuracy.'),(24,'Easton Synergy SY50','Easton',5,36.99,'-Aircraft veneer construction\r\n-Aspen core\r\n-5mm corner radius\r\n-Senior (95 Flex) 58\"'),(25,'RBK 20k Sickkick 4 Fullgrip','Reebok',5,299.99,'The Sickick IV series of sticks from Reebok is all about control, accuracy and a quick\r\nrelease. The quick release comes from the low-mid kick point, while control and accuracy\r\ncome from their Dual Matrix II? and AccuBlade? technologies which are also found\r\nthroughout the line. The 20K is lightweight, has great balance and a nice clean look.\r\n\r\nReebok uses its Pure Fiber?, or true one-piece construction of high modulus carbon\r\nfiber for this stick. This type of construction eliminates overlapping material in the\r\nlower shaft, thus reducing weight and improving consistency in energy transfer.\r\nThe senior shaft uses a Traditional geometry with square-corners.\r\n\r\nThe 20K is available with Reebok\'s Dual Grip Technology where the bottom half of the\r\nshaft has a matte finish and allows your hand to move up and down freely and quickly,\r\nwhile the top half of the shaft has a Griptonite finish that helps lock the stick in\r\nplace when you clamp down. If you prefer the full Griptonite finish on the shaft, the\r\nsenior model of the 20K is also available in full grip.\r\n\r\nThe gradual taper of the stick is what gives it the low-mid kick point.\r\n\r\nDual Matrix II? is technology that is used in the shaft and the blade of the stick, but is\r\nclearly visible in the blade. The orientation of the fibers on the forehand are at 0°\r\nand 90°, while the fibers on the backhand are at 45°. This variation causes tension\r\nduring loading that creates a slingshot effect on release. The other technology that\r\nReebok uses is called AccuBlade?. This is a foam core blade that gets stiffer as you go\r\nfrom heel to toe resulting in less torqueing to keep the blade face closed.\r\n\r\nWith technologies that enhance control, accuracy and release time, the Reebok 20K is all\r\nthat, and more...'),(26,'Sherwood Endure 180','Sherwood',5,29.99,'-Compression molded shaft for a consistent flex profile and greater responsivess\r\n-Multi-layer birch lamination Responsive stick\r\n-Ensures great control and superior sliding on all surfaces\r\n-Prevents premature wearing and increases blade stiffness\r\n-ABS construction');
/*!40000 ALTER TABLE `merchandise` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orderitems`
--

DROP TABLE IF EXISTS `orderitems`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orderitems` (
  `orderid` int(10) unsigned NOT NULL,
  `itemid` int(10) NOT NULL,
  `specid` char(6) NOT NULL default '000000',
  `itemprice` float(6,2) NOT NULL,
  `quantity` tinyint(4) default '1',
  PRIMARY KEY  (`orderid`,`itemid`),
  KEY `itemid` (`itemid`),
  CONSTRAINT `orderitems_ibfk_1` FOREIGN KEY (`orderid`) REFERENCES `orders` (`orderid`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `orderitems_ibfk_2` FOREIGN KEY (`itemid`) REFERENCES `merchandise` (`itemid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orderitems`
--

LOCK TABLES `orderitems` WRITE;
/*!40000 ALTER TABLE `orderitems` DISABLE KEYS */;
INSERT INTO `orderitems` VALUES (12,1,'bl13',149.99,1),(12,10,'blm',159.99,1),(12,26,'Rya100',29.99,2),(13,11,'roysm',19.99,1),(13,19,'7d',449.99,1);
/*!40000 ALTER TABLE `orderitems` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders` (
  `orderid` int(10) unsigned NOT NULL auto_increment,
  `customerid` int(10) unsigned NOT NULL,
  `totalcost` float(6,2) default NULL,
  `orderdate` date default NULL,
  `orderstatus` char(15) default NULL,
  `shipName` char(60) default NULL,
  `shipAddress` char(80) default NULL,
  `shipCity` char(30) default NULL,
  `shipState` char(20) default NULL,
  `shipZip` char(10) default NULL,
  PRIMARY KEY  (`orderid`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (12,1,369.96,'2012-12-10','Shipped','Frank Smith','43 Paramus Road','Paramus','NJ','07452'),(13,1,469.98,'2012-12-10','Preparing','Frank Smith','43 Paramus Road','Paramus','NJ','07452');
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reviews`
--

DROP TABLE IF EXISTS `reviews`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reviews` (
  `itemid` int(10) NOT NULL,
  `customerid` int(10) unsigned NOT NULL,
  `score` int(10) unsigned NOT NULL,
  `blurb` text,
  KEY `itemid` (`itemid`,`customerid`),
  KEY `customerid` (`customerid`),
  CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`customerid`) REFERENCES `customer` (`customerid`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`itemid`) REFERENCES `merchandise` (`itemid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reviews`
--

LOCK TABLES `reviews` WRITE;
/*!40000 ALTER TABLE `reviews` DISABLE KEYS */;
INSERT INTO `reviews` VALUES (1,1,4,'These gloves are great. I love the way they feel. They are extremely durable as well.');
/*!40000 ALTER TABLE `reviews` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `skates`
--

DROP TABLE IF EXISTS `skates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `skates` (
  `exId` char(6) NOT NULL,
  `itemid` int(10) NOT NULL,
  `bootsize` tinyint(3) unsigned NOT NULL,
  `quantity` int(11) NOT NULL,
  KEY `itemid` (`itemid`),
  CONSTRAINT `skates_ibfk_1` FOREIGN KEY (`itemid`) REFERENCES `merchandise` (`itemid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `skates`
--

LOCK TABLES `skates` WRITE;
/*!40000 ALTER TABLE `skates` DISABLE KEYS */;
INSERT INTO `skates` VALUES ('13d',17,13,14),('12d',17,12,11),('7d',17,7,4),('8d',17,8,7),('6d',18,6,15),('7d',18,7,6),('9d',18,9,9),('10d',18,10,5),('10d',19,10,17),('11d',19,11,8),('7d',19,7,4),('9d',19,9,7),('7d',20,7,4),('8d',20,8,9),('12d',20,12,15),('11d',20,11,7),('7d',21,7,6),('9d',21,9,9),('11d',21,11,7),('12d',21,12,6);
/*!40000 ALTER TABLE `skates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sticks`
--

DROP TABLE IF EXISTS `sticks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sticks` (
  `exId` char(6) NOT NULL,
  `itemid` int(10) NOT NULL,
  `curve` char(10) NOT NULL,
  `flex` tinyint(3) unsigned NOT NULL,
  `quantity` int(11) NOT NULL,
  KEY `itemid` (`itemid`),
  CONSTRAINT `sticks_ibfk_1` FOREIGN KEY (`itemid`) REFERENCES `merchandise` (`itemid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sticks`
--

LOCK TABLES `sticks` WRITE;
/*!40000 ALTER TABLE `sticks` DISABLE KEYS */;
INSERT INTO `sticks` VALUES ('Bac77',22,'Backstrom',77,18),('Bac102',22,'Backstrom',102,7),('Kan95',22,'Kane',95,4),('Ove87',22,'Ovechkin',87,5),('Ove102',22,'Ovechkin',102,8),('Mal95',22,'Malkin',95,15),('Cam75',23,'Cammalleri',75,7),('Cam100',23,'Cammalleri',100,9),('Sha110',23,'Shanahan',110,11),('Sak100',23,'Sakic',100,6),('Char95',24,'Chara',95,7),('Sak95',24,'Sakic',95,8),('Zet95',24,'Zetterberg',95,11),('Par95',24,'Parise',95,15),('Spez75',25,'Spezza',75,9),('Ham100',25,'Hamrlik',100,12),('Cros10',25,'Crosby',100,10),('Cros85',25,'Crosby',85,7),('Cof100',26,'Coffey',100,5),('Sta100',26,'Statsny',100,7),('Bou100',26,'Bouchard',100,2),('Rya100',26,'Ryan',100,1);
/*!40000 ALTER TABLE `sticks` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2012-12-15 16:31:53
