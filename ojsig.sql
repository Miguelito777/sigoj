-- MySQL dump 10.13  Distrib 5.6.28, for Linux (x86_64)
--
-- Host: localhost    Database: sigOJ
-- ------------------------------------------------------
-- Server version	5.6.28

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
-- Table structure for table `Departamentos`
--

DROP TABLE IF EXISTS `Departamentos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Departamentos` (
  `idDepartamento` int(11) NOT NULL AUTO_INCREMENT,
  `nombreDepartamento` varchar(95) DEFAULT NULL,
  `RegionesIdRegion` int(11) NOT NULL,
  PRIMARY KEY (`idDepartamento`),
  KEY `RegionesIdRegion` (`RegionesIdRegion`),
  CONSTRAINT `Departamentos_ibfk_1` FOREIGN KEY (`RegionesIdRegion`) REFERENCES `Regiones` (`idRegion`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Departamentos`
--

LOCK TABLES `Departamentos` WRITE;
/*!40000 ALTER TABLE `Departamentos` DISABLE KEYS */;
INSERT INTO `Departamentos` VALUES (1,'Totonicapán',1),(2,'Quetzaltenango',1),(3,'San Marcos',1),(4,'Huehuetenango',1),(5,'Quiche',1),(6,'Reu',2);
/*!40000 ALTER TABLE `Departamentos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Hardware`
--

DROP TABLE IF EXISTS `Hardware`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Hardware` (
  `idHardware` int(11) NOT NULL AUTO_INCREMENT,
  `Descripcion` varchar(88) DEFAULT NULL,
  `Estado` varchar(88) DEFAULT NULL,
  `Marca` varchar(88) DEFAULT NULL,
  `MunicipiosIdMunicipio` int(11) NOT NULL,
  PRIMARY KEY (`idHardware`),
  KEY `MunicipiosIdMunicipio` (`MunicipiosIdMunicipio`),
  CONSTRAINT `Hardware_ibfk_1` FOREIGN KEY (`MunicipiosIdMunicipio`) REFERENCES `Municipios` (`idMunicipio`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Hardware`
--

LOCK TABLES `Hardware` WRITE;
/*!40000 ALTER TABLE `Hardware` DISABLE KEYS */;
/*!40000 ALTER TABLE `Hardware` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Juzgados`
--

DROP TABLE IF EXISTS `Juzgados`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Juzgados` (
  `idJuzgado` int(11) NOT NULL AUTO_INCREMENT,
  `nombreJuzgado` varchar(100) DEFAULT NULL,
  `direccionJuzgado` varchar(75) DEFAULT NULL,
  `telefonoJuzgado` varchar(8) DEFAULT NULL,
  `MunicipiosIdMunicipio` int(11) NOT NULL,
  PRIMARY KEY (`idJuzgado`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Juzgados`
--

LOCK TABLES `Juzgados` WRITE;
/*!40000 ALTER TABLE `Juzgados` DISABLE KEYS */;
INSERT INTO `Juzgados` VALUES (1,'Juzgado de Paz','Zona 1','77662895',3),(2,'Juzgado 1 Instancia','Zona 2','77668895',3),(3,'Juzgado Penal','Zona 2','77668877',3),(4,'Juzgado Ejecucion','Zona 3','77666677',3),(5,'Ejecución','Zona 1','77664148',1),(6,'EjecuciÃ³n','Zona 1','77664148',1),(7,'Paz','Zona 2','77662589',1),(8,'Sentencia','Zona 3','77662589',1),(9,'Civil','Zona 1','77664148',1),(10,'Paz','Zona 2','77662589',1),(11,'Sentencia','Zona 3','77662589',1),(12,'Civil','Zona 1','77664148',1),(13,'Paz','Zona 2','77662589',1),(14,'Sentencia','Zona 3','77662589',1),(15,'Mayor Riezgo','Zona 1','77664148',1),(16,'Paz','Zona 2','77662589',1),(17,'Sentencia','Zona 3','77662589',1),(18,'Menor Riezgo','Zona 1','77664148',1),(19,'Paz','Zona 2','77662589',1),(20,'Sentencia','Zona 3','77662589',1);
/*!40000 ALTER TABLE `Juzgados` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Municipios`
--

DROP TABLE IF EXISTS `Municipios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Municipios` (
  `idMunicipio` int(11) NOT NULL AUTO_INCREMENT,
  `nombreMunicipio` varchar(100) DEFAULT NULL,
  `DepartamentosIdDepartamento` int(11) NOT NULL,
  PRIMARY KEY (`idMunicipio`),
  KEY `DepartamentosIdDepartamento` (`DepartamentosIdDepartamento`),
  CONSTRAINT `Municipios_ibfk_1` FOREIGN KEY (`DepartamentosIdDepartamento`) REFERENCES `Departamentos` (`idDepartamento`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Municipios`
--

LOCK TABLES `Municipios` WRITE;
/*!40000 ALTER TABLE `Municipios` DISABLE KEYS */;
INSERT INTO `Municipios` VALUES (1,'San Bartolo',1),(2,'San Francisco',1),(3,'Totonicapán',1),(4,'San Cristobal',1),(5,'San Andres Xecul',1),(6,'Momostenango',1),(7,'Santa Maria Chiquimula',1),(8,'Santa Lucia la Reforma',1);
/*!40000 ALTER TABLE `Municipios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Regiones`
--

DROP TABLE IF EXISTS `Regiones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Regiones` (
  `idRegion` int(11) NOT NULL AUTO_INCREMENT,
  `nombreRegion` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`idRegion`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Regiones`
--

LOCK TABLES `Regiones` WRITE;
/*!40000 ALTER TABLE `Regiones` DISABLE KEYS */;
INSERT INTO `Regiones` VALUES (1,'Occidente'),(2,'Norte'),(3,'Sur'),(4,'Oriente');
/*!40000 ALTER TABLE `Regiones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Resupuesto`
--

DROP TABLE IF EXISTS `Resupuesto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Resupuesto` (
  `idResupuesto` int(11) NOT NULL AUTO_INCREMENT,
  `MunicipiosIdMunicipio` int(11) NOT NULL,
  PRIMARY KEY (`idResupuesto`),
  KEY `MunicipiosIdMunicipio` (`MunicipiosIdMunicipio`),
  CONSTRAINT `Resupuesto_ibfk_1` FOREIGN KEY (`MunicipiosIdMunicipio`) REFERENCES `Municipios` (`idMunicipio`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Resupuesto`
--

LOCK TABLES `Resupuesto` WRITE;
/*!40000 ALTER TABLE `Resupuesto` DISABLE KEYS */;
/*!40000 ALTER TABLE `Resupuesto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `idUser` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(150) DEFAULT NULL,
  `password` varchar(150) DEFAULT NULL,
  `typeUser` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`idUser`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'miguel','12345678',0),(2,'bryan','123456789',1);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'sigOJ'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-11-29  9:15:21
