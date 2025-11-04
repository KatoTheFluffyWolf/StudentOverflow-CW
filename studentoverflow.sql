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

insert  into `modules`(`moduleID`,`moduleName`) values ('BUSI1314','Business Ethics'),('COMP1753','Progamming Foundation'),('DESI1214','Design Thinking');

/*Table structure for table `post_comments` */

DROP TABLE IF EXISTS `post_comments`;

CREATE TABLE `post_comments` (
  `commentID` int(11) NOT NULL AUTO_INCREMENT,
  `userID` int(11) DEFAULT NULL,
  `postID` int(11) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `imgPath` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`commentID`),
  KEY `post_comments_ibfk_1` (`userID`),
  KEY `post_comments_ibfk_2` (`postID`),
  CONSTRAINT `post_comments_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`) ON DELETE CASCADE,
  CONSTRAINT `post_comments_ibfk_2` FOREIGN KEY (`postID`) REFERENCES `posts` (`postID`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `post_comments` */

insert  into `post_comments`(`commentID`,`userID`,`postID`,`content`,`created_at`,`imgPath`) values (8,3,18,'Hehehehe','2025-11-04 15:20:20',NULL),(9,3,18,'','2025-11-04 15:20:52','uploads/6909b764aff5d.jpg');

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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `post_upvotes` */

insert  into `post_upvotes`(`voteID`,`postID`,`userID`) values (9,18,3);

/*Table structure for table `posts` */

DROP TABLE IF EXISTS `posts`;

CREATE TABLE `posts` (
  `postID` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` text DEFAULT NULL,
  `userID` int(11) DEFAULT NULL,
  `moduleID` varchar(11) DEFAULT NULL,
  `dateCreated` datetime DEFAULT NULL,
  `imgPath` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`postID`),
  KEY `posts_ibfk_1` (`userID`),
  KEY `posts_ibfk_2` (`moduleID`),
  CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`) ON UPDATE CASCADE,
  CONSTRAINT `posts_ibfk_2` FOREIGN KEY (`moduleID`) REFERENCES `modules` (`moduleID`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `posts` */

insert  into `posts`(`postID`,`title`,`content`,`userID`,`moduleID`,`dateCreated`,`imgPath`) values (17,'Test','Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',3,'COMP1753','2025-11-04 15:15:37',NULL),(18,'Image Test','Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',3,'DESI1214','2025-11-04 15:20:01','uploads/6909b731da56d.jpg');

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `userID` int(255) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `role` varchar(255) DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `major` varchar(255) DEFAULT NULL,
  `avatarPath` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`userID`),
  UNIQUE KEY `unique_username` (`username`),
  UNIQUE KEY `unique_constraint_name` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `users` */

insert  into `users`(`userID`,`username`,`password`,`name`,`email`,`role`,`bio`,`created_at`,`major`,`avatarPath`) values (2,'admin','admin','John Admin','anhndgcc240003@gmail.com','admin','Fluffy ?','2025-10-31 14:01:32','Business',NULL),(3,'DesignLord','design','Emma Watson','example@gmail.com','student',NULL,'2025-10-31 14:02:48','Graphic Design',NULL),(4,'NewUser','$2y$10$v/fF4XEycM/eFgmY0ftxBeIYtD3SoReHHLlO5/tMq9J/4.Y.pcmKm','',NULL,'student',NULL,NULL,NULL,NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
