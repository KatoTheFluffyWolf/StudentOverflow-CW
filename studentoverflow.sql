/*
SQLyog Ultimate v10.00 Beta1
MySQL - 5.5.5-10.4.32-MariaDB : Database - studentoverflow
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`studentoverflow` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci */;

USE `studentoverflow`;

/*Table structure for table `modules` */

DROP TABLE IF EXISTS `modules`;

CREATE TABLE `modules` (
  `moduleID` varchar(11) NOT NULL,
  `moduleName` varchar(255) NOT NULL,
  PRIMARY KEY (`moduleID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `modules` */

insert  into `modules`(`moduleID`,`moduleName`) values ('BUSI1314','Business Ethics'),('COMP1753','Programming Foundation'),('DESI1214','Design Thinking');

/*Table structure for table `post_comments` */

DROP TABLE IF EXISTS `post_comments`;

CREATE TABLE `post_comments` (
  `commentID` int(11) NOT NULL AUTO_INCREMENT,
  `userID` int(11) DEFAULT NULL,
  `postID` int(11) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`commentID`),
  KEY `userID` (`userID`),
  KEY `postID` (`postID`),
  CONSTRAINT `post_comments_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`),
  CONSTRAINT `post_comments_ibfk_2` FOREIGN KEY (`postID`) REFERENCES `posts` (`postID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `post_comments` */

insert  into `post_comments`(`commentID`,`userID`,`postID`,`content`,`created_at`) values (2,2,4,'Yoooo\r\n','2025-10-28 15:35:06');

/*Table structure for table `post_upvotes` */

DROP TABLE IF EXISTS `post_upvotes`;

CREATE TABLE `post_upvotes` (
  `voteID` int(11) NOT NULL AUTO_INCREMENT,
  `postID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  PRIMARY KEY (`voteID`),
  UNIQUE KEY `post_id` (`postID`,`userID`),
  KEY `user_id` (`userID`),
  CONSTRAINT `post_upvotes_ibfk_1` FOREIGN KEY (`postID`) REFERENCES `posts` (`postID`) ON DELETE CASCADE,
  CONSTRAINT `post_upvotes_ibfk_2` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `post_upvotes` */

insert  into `post_upvotes`(`voteID`,`postID`,`userID`) values (4,3,1),(1,4,1),(7,4,2);

/*Table structure for table `posts` */

DROP TABLE IF EXISTS `posts`;

CREATE TABLE `posts` (
  `postID` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `userID` int(11) DEFAULT NULL,
  `moduleID` varchar(11) DEFAULT NULL,
  PRIMARY KEY (`postID`),
  KEY `userID` (`userID`),
  KEY `posts_ibfk_2` (`moduleID`),
  CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`),
  CONSTRAINT `posts_ibfk_2` FOREIGN KEY (`moduleID`) REFERENCES `modules` (`moduleID`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `posts` */

insert  into `posts`(`postID`,`title`,`content`,`userID`,`moduleID`) values (1,'Should i learn Python ?','Many of my friends have told me that Python is the easiest language to learn.',1,NULL),(2,'Should i learn Python ?','Many of my friends have told me that Python is the easiest language to learn.',1,'COMP1753'),(3,'Should i learn Python?','Many of my friends told me to learn Python. They claim that it\'s the easiest-to-learn programming language.',1,'COMP1753'),(4,'Wa wa wa wa','Skibidi',1,'DESI1214');

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `userID` int(255) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `role` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`userID`),
  UNIQUE KEY `unique_username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `users` */

insert  into `users`(`userID`,`username`,`password`,`name`,`email`,`role`) values (1,'Kato','Kato','Duy Anh Nguyen','anhndgcc240003@gmail.com','student'),(2,'admin','admin','John Admin','katotinminecraft@gmail.com','admin');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
