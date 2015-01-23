/*
SQLyog Enterprise - MySQL GUI v7.15 
MySQL - 5.6.16 : Database - nestedcomment
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

CREATE DATABASE /*!32312 IF NOT EXISTS*/`nestedcomment` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `nestedcomment`;

/*Table structure for table `comments` */

DROP TABLE IF EXISTS `comments`;

CREATE TABLE `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `comment` varchar(500) DEFAULT NULL,
  `parentid` int(11) DEFAULT NULL,
  `linage` varchar(300) DEFAULT NULL,
  `deep` int(11) DEFAULT NULL,
  `datecreated` datetime DEFAULT NULL,
  `lastedited` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `commented_user` varchar(300) DEFAULT NULL,
  `is_reply` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

/*Data for the table `comments` */

insert  into `comments`(`id`,`comment`,`parentid`,`linage`,`deep`,`datecreated`,`lastedited`,`commented_user`,`is_reply`) values (1,'test',0,'1',0,NULL,'2015-01-21 20:45:13','sr',0),(2,'test',0,'2',0,'2015-01-21 20:32:47','2015-01-21 20:45:14','test',0),(3,'test',0,'3',0,'2015-01-21 20:33:09','2015-01-21 20:45:15','test',0),(4,'rep1',1,'1-1',1,'2015-01-21 20:37:11','2015-01-21 20:45:37','testnn',1),(6,'test',0,'5',0,'2015-01-21 20:47:06','2015-01-21 20:47:06','test',0),(8,'this is my first comment',0,'8',0,'2015-01-21 21:54:28','2015-01-21 21:54:28','srinath',0),(9,'this is my first comment',0,'9',0,'2015-01-21 21:58:03','2015-01-21 21:58:03','srinath',0),(10,'test rep',1,'1-2',0,'2015-01-22 00:06:54','2015-01-22 00:06:54',NULL,NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
