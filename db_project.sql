/*
SQLyog Community v13.1.6 (64 bit)
MySQL - 10.4.18-MariaDB : Database - db_project
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `applicant_reg_master` */

DROP TABLE IF EXISTS `applicant_reg_master`;

CREATE TABLE `applicant_reg_master` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `reg_user_id` varchar(20) NOT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `mid_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `email_id` varchar(500) DEFAULT NULL,
  `mobile` varchar(20) DEFAULT NULL,
  `password` varchar(200) DEFAULT NULL,
  `created_by` varchar(20) DEFAULT NULL,
  `created_on` datetime DEFAULT NULL,
  PRIMARY KEY (`reg_user_id`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

/*Data for the table `applicant_reg_master` */

insert  into `applicant_reg_master`(`id`,`reg_user_id`,`first_name`,`mid_name`,`last_name`,`email_id`,`mobile`,`password`,`created_by`,`created_on`) values 
(7,'1111111111','SADSA','DSADSA','DSAD','dfdsfds@cfgfd.com',NULL,'b4dec482af190d5647e7ac637c4a2789fe94c58735f8254819976affc44f118d2d653c14c08eefffa886e177f4fb680455497a9edcc7ae387f8bb44f637dc506','1111111111','2022-02-09 22:01:20'),
(6,'3333333333','SDFDS','FDSF','DSFDSF','dsfds@ggg.com',NULL,'9ee8f235502f36090bdc353d19cea8e1e385b21731cda0cbf60b0a9c2094613fa5d31dfc6b954da8e7aaa22d2feccf85a653f36122f3b130a2001528826029dd','3333333333','2022-02-09 21:59:57'),
(8,'4444444444','ASFDSAF','DSFDS','FDSF','xvcxvxc@hhh.com',NULL,'3848c48fd56a9f5fbb0acfc52a5cb6b6aaddfe40a386736202496874496330b5bd7bc61042ed39e47cb8284cab94c493dbdee7cb76e9494dad05e160eb2663b5','4444444444','2022-02-09 22:06:57'),
(9,'8888888888','SSSS','SSSS','SSSS','JJJJJ@fff.xcon',NULL,'5f287553cd386c6697fa10637e37baec3488354d7b892e299a7fac2ca413aefeeb46c65269d035d2a3eb969582ceefd6c672b0c810a84d1395c8ad7ac71e2a3e','8888888888','2022-02-09 22:52:11');

/*Table structure for table `image_tbl` */

DROP TABLE IF EXISTS `image_tbl`;

CREATE TABLE `image_tbl` (
  `id` bigint(50) NOT NULL AUTO_INCREMENT,
  `image_path` varchar(200) DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `created_on` datetime DEFAULT NULL,
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

/*Data for the table `image_tbl` */

insert  into `image_tbl`(`id`,`image_path`,`created_by`,`created_on`) values 
(1,'public/upload/10_39_40pmfe3c6e20ffedd7810fb2d94d7002b5ee.jpg','4444444444','2022-02-09 00:00:00');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
