-- MySQL dump 10.13  Distrib 5.7.16, for Linux (x86_64)
--
-- Host: localhost    Database: p2
-- ------------------------------------------------------
-- Server version	5.7.16-0ubuntu0.16.10.1

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
-- Table structure for table `commandes`
--

DROP TABLE IF EXISTS `commandes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `commandes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `prix` float(6,2) NOT NULL,
  `date_achat` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `etat_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_commandes_users` (`user_id`),
  KEY `fk_commandes_etats` (`etat_id`),
  CONSTRAINT `fk_commandes_etats` FOREIGN KEY (`etat_id`) REFERENCES `etats` (`id`),
  CONSTRAINT `fk_commandes_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `commandes`
--

LOCK TABLES `commandes` WRITE;
/*!40000 ALTER TABLE `commandes` DISABLE KEYS */;
INSERT INTO `commandes` VALUES (1,1,200.00,'2016-11-19 12:51:36',1),(2,1,8.50,'2016-11-19 13:02:45',1),(3,1,108.50,'2016-11-19 13:10:42',1),(4,1,108.50,'2016-11-19 13:11:00',1),(5,1,108.50,'2016-11-19 13:11:16',1),(6,1,917.00,'2016-11-19 13:23:24',1),(7,1,6346.50,'2016-11-19 13:36:00',1),(8,1,100.00,'2016-11-19 13:49:15',1),(9,1,105.50,'2016-11-19 13:54:50',1),(10,1,5000.00,'2016-11-19 13:55:15',1);
/*!40000 ALTER TABLE `commandes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `etats`
--

DROP TABLE IF EXISTS `etats`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `etats` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `etats`
--

LOCK TABLES `etats` WRITE;
/*!40000 ALTER TABLE `etats` DISABLE KEYS */;
INSERT INTO `etats` VALUES (1,'A préparer'),(3,'Expédié');
/*!40000 ALTER TABLE `etats` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `paniers`
--

DROP TABLE IF EXISTS `paniers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `paniers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `quantite` int(11) NOT NULL,
  `prix` float(6,2) NOT NULL,
  `dateAjoutPanier` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(11) NOT NULL,
  `produit_id` int(11) NOT NULL,
  `commande_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_paniers_users` (`user_id`),
  KEY `fk_paniers_produits` (`produit_id`),
  KEY `fk_paniers_commandes` (`commande_id`),
  CONSTRAINT `fk_paniers_commandes` FOREIGN KEY (`commande_id`) REFERENCES `commandes` (`id`),
  CONSTRAINT `fk_paniers_produits` FOREIGN KEY (`produit_id`) REFERENCES `produits` (`id`),
  CONSTRAINT `fk_paniers_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `paniers`
--

LOCK TABLES `paniers` WRITE;
/*!40000 ALTER TABLE `paniers` DISABLE KEYS */;
INSERT INTO `paniers` VALUES (1,4,400.00,'2016-11-19 13:47:38',1,1,10),(2,1,5.50,'2016-11-19 13:49:41',1,2,10),(3,1,100.00,'2016-11-19 13:54:42',1,1,10),(4,50,5000.00,'2016-11-19 13:55:02',1,1,10);
/*!40000 ALTER TABLE `paniers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `produits`
--

DROP TABLE IF EXISTS `produits`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `produits` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `typeProduit_id` int(10) DEFAULT NULL,
  `nom` varchar(50) DEFAULT NULL,
  `prix` float(6,2) DEFAULT NULL,
  `photo` varchar(50) DEFAULT NULL,
  `dispo` tinyint(4) NOT NULL,
  `stock` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_produits_typeProduits` (`typeProduit_id`),
  CONSTRAINT `fk_produits_typeProduits` FOREIGN KEY (`typeProduit_id`) REFERENCES `typeProduits` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `produits`
--

LOCK TABLES `produits` WRITE;
/*!40000 ALTER TABLE `produits` DISABLE KEYS */;
INSERT INTO `produits` VALUES (1,1,'Pomme',1.00,'pommes.jpg',1,9938),(2,1,'Poires',1.10,'poires.jpeg',1,9997),(3,1,'Bananes',2.50,'bananes.png',1,999),(4,2,'Potirons',8.00,'potiron.jpg',1,42),(5,2,'Peche',55.00,'peche.jpeg',1,4),(6,3,'Papaye',5.00,'papaye.jpg',1,10);
/*!40000 ALTER TABLE `produits` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `typeProduits`
--

DROP TABLE IF EXISTS `typeProduits`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `typeProduits` (
  `id` int(10) NOT NULL,
  `libelle` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `typeProduits`
--

LOCK TABLES `typeProduits` WRITE;
/*!40000 ALTER TABLE `typeProduits` DISABLE KEYS */;
INSERT INTO `typeProduits` VALUES (1,'Fruits'),(2,'Légumes'),(3,'Autre');
/*!40000 ALTER TABLE `typeProduits` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `login` varchar(255) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `code_postal` varchar(255) NOT NULL,
  `ville` varchar(255) NOT NULL,
  `adresse` varchar(255) NOT NULL,
  `valide` tinyint(4) NOT NULL,
  `droit` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'admin@gmail.com','admin','admin','','','','',1,'DROITadmin'),(2,'vendeur@gmail.com','vendeur','vendeur','','','','',1,'DROITadmin'),(3,'client@gmail.com','client','client','','','','',1,'DROITclient'),(4,'client2@gmail.com','client2','client2','','','','',1,'DROITclient'),(5,'client3@gmail.com','client3','client3','','','','',1,'DROITclient');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-11-21  9:45:50
