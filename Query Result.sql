# Host: localhost  (Version 5.7.31)
# Date: 2022-09-26 22:51:03
# Generator: MySQL-Front 6.0  (Build 2.20)


#
# Structure for table "pessoa"
#

DROP TABLE IF EXISTS `pessoa`;
CREATE TABLE `pessoa` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(40) DEFAULT NULL,
  `telefone` varchar(15) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

#
# Data for table "pessoa"
#

