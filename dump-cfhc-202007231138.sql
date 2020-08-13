-- MySQL dump 10.13  Distrib 5.7.30, for Linux (x86_64)
--
-- Host: 34.67.140.109    Database: cfhc
-- ------------------------------------------------------
-- Server version	5.7.25-google-log

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
SET @MYSQLDUMP_TEMP_LOG_BIN = @@SESSION.SQL_LOG_BIN;
SET @@SESSION.SQL_LOG_BIN= 0;

--
-- GTID state at the beginning of the backup 
--

SET @@GLOBAL.GTID_PURGED='bbc6d595-aa6d-11ea-b7e5-42010a8003ef:1-759984';

--
-- Table structure for table `actividades_cuarentena`
--

DROP TABLE IF EXISTS `actividades_cuarentena`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `actividades_cuarentena` (
  `id_actividad` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  PRIMARY KEY (`id_actividad`),
  KEY `fk_activida_fk_usuari_usuarios` (`id_usuario`),
  CONSTRAINT `fk_activida_fk_usuari_usuarios` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `actividades_cuarentena`
--

LOCK TABLES `actividades_cuarentena` WRITE;
/*!40000 ALTER TABLE `actividades_cuarentena` DISABLE KEYS */;
INSERT INTO `actividades_cuarentena` VALUES (2,2,'Limpiar mi Cuarto'),(4,2,'estar en la sala'),(6,2,'cocinar'),(7,9,'jsbsb'),(8,18,'Actividad 1111'),(9,18,'Actividad 1111'),(10,18,'Actividad 1111'),(11,18,'Actividad cultural, personal, gastronómica..?'),(12,18,'Actividad cultural, personal, gastronómica..?'),(13,19,'no hay actividad'),(14,59,'gg'),(15,2,'ejercicio');
/*!40000 ALTER TABLE `actividades_cuarentena` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `alergias`
--

DROP TABLE IF EXISTS `alergias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `alergias` (
  `id_alergia` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  PRIMARY KEY (`id_alergia`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `alergias`
--

LOCK TABLES `alergias` WRITE;
/*!40000 ALTER TABLE `alergias` DISABLE KEYS */;
INSERT INTO `alergias` VALUES (1,'Nueces'),(2,'Lácteos'),(8,'gluten'),(9,'almendras'),(10,'piña'),(11,'ghjh'),(12,'fyyf'),(13,'colada'),(14,'arañafobuia :u'),(15,'prueba 2'),(16,'prueba 2'),(17,'prueba'),(18,'prueba3'),(19,'prueba4'),(20,'p5'),(21,'p6'),(22,'p6'),(23,'p7'),(24,'prueba 8'),(25,'fssfa');
/*!40000 ALTER TABLE `alergias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `alergias_usuario`
--

DROP TABLE IF EXISTS `alergias_usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `alergias_usuario` (
  `id_alergia` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  PRIMARY KEY (`id_alergia`,`id_usuario`),
  KEY `fk_alergias_usuarios_usuarios` (`id_usuario`),
  CONSTRAINT `fk_alergias_usuarios_alergias` FOREIGN KEY (`id_alergia`) REFERENCES `alergias` (`id_alergia`),
  CONSTRAINT `fk_alergias_usuarios_usuarios` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `alergias_usuario`
--

LOCK TABLES `alergias_usuario` WRITE;
/*!40000 ALTER TABLE `alergias_usuario` DISABLE KEYS */;
INSERT INTO `alergias_usuario` VALUES (9,2),(10,2),(8,59);
/*!40000 ALTER TABLE `alergias_usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `alimentos_cuarentena`
--

DROP TABLE IF EXISTS `alimentos_cuarentena`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `alimentos_cuarentena` (
  `id_alimentos` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  PRIMARY KEY (`id_alimentos`),
  KEY `fk_alimento_fk_usuari_usuarios` (`id_usuario`),
  CONSTRAINT `fk_alimento_fk_usuari_usuarios` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `alimentos_cuarentena`
--

LOCK TABLES `alimentos_cuarentena` WRITE;
/*!40000 ALTER TABLE `alimentos_cuarentena` DISABLE KEYS */;
INSERT INTO `alimentos_cuarentena` VALUES (1,2,'Carnes'),(2,2,'fideos'),(4,2,'sopas'),(5,2,'pizza'),(7,2,'atún'),(8,59,'ttt');
/*!40000 ALTER TABLE `alimentos_cuarentena` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bares`
--

DROP TABLE IF EXISTS `bares`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bares` (
  `id_bar` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) DEFAULT NULL,
  `id_usuario` int(11) NOT NULL,
  `celular` varchar(10) NOT NULL,
  PRIMARY KEY (`id_bar`),
  KEY `bares_fk` (`id_usuario`),
  CONSTRAINT `bares_fk` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bares`
--

LOCK TABLES `bares` WRITE;
/*!40000 ALTER TABLE `bares` DISABLE KEYS */;
INSERT INTO `bares` VALUES (9,'Bar Informática',2,'0961186713'),(10,'Delicias de Tosagua',4,'0978630130'),(11,'Bar Mis Delicias',7,'0993498083'),(12,'Panes del Juanes',36,'0986075334'),(13,'Delicias de Ambato',52,'0963186513'),(14,'El parangaricu',61,'0986075334'),(15,'El memeparanga',64,'0986075334');
/*!40000 ALTER TABLE `bares` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `calificacion`
--

DROP TABLE IF EXISTS `calificacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `calificacion` (
  `id_bar` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `calificacion` int(11) NOT NULL,
  PRIMARY KEY (`id_bar`,`id_usuario`),
  KEY `fk_califica_calificac_usuarios` (`id_usuario`),
  CONSTRAINT `fk_califica_calificac_bares` FOREIGN KEY (`id_bar`) REFERENCES `bares` (`id_bar`),
  CONSTRAINT `fk_califica_calificac_usuarios` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `calificacion`
--

LOCK TABLES `calificacion` WRITE;
/*!40000 ALTER TABLE `calificacion` DISABLE KEYS */;
/*!40000 ALTER TABLE `calificacion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categoria_alimentos`
--

DROP TABLE IF EXISTS `categoria_alimentos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categoria_alimentos` (
  `id_categoria_alimento` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  PRIMARY KEY (`id_categoria_alimento`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categoria_alimentos`
--

LOCK TABLES `categoria_alimentos` WRITE;
/*!40000 ALTER TABLE `categoria_alimentos` DISABLE KEYS */;
INSERT INTO `categoria_alimentos` VALUES (1,'Carnes'),(3,'Mariscos');
/*!40000 ALTER TABLE `categoria_alimentos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `compuesto_quimico_organico`
--

DROP TABLE IF EXISTS `compuesto_quimico_organico`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `compuesto_quimico_organico` (
  `id_compuesto` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_compuesto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `compuesto_quimico_organico`
--

LOCK TABLES `compuesto_quimico_organico` WRITE;
/*!40000 ALTER TABLE `compuesto_quimico_organico` DISABLE KEYS */;
/*!40000 ALTER TABLE `compuesto_quimico_organico` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `enfermedades`
--

DROP TABLE IF EXISTS `enfermedades`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `enfermedades` (
  `id_enfermedad` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  PRIMARY KEY (`id_enfermedad`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `enfermedades`
--

LOCK TABLES `enfermedades` WRITE;
/*!40000 ALTER TABLE `enfermedades` DISABLE KEYS */;
INSERT INTO `enfermedades` VALUES (1,'Diabetes'),(3,'Hipertensión'),(4,'fggr'),(5,'jwbbshsjs'),(6,'prueba1'),(7,'prueba 2'),(8,'p3'),(9,'p4'),(10,'p5'),(11,'p6'),(12,'p7'),(13,'p8'),(14,'0p9'),(15,'udos'),(16,'u3');
/*!40000 ALTER TABLE `enfermedades` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `enfermedades_usuario`
--

DROP TABLE IF EXISTS `enfermedades_usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `enfermedades_usuario` (
  `id_enfermedad` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  PRIMARY KEY (`id_enfermedad`,`id_usuario`),
  KEY `fk_enfermed_usuarios_usuarios` (`id_usuario`),
  CONSTRAINT `fk_enfermed_usuarios_enfermed` FOREIGN KEY (`id_enfermedad`) REFERENCES `enfermedades` (`id_enfermedad`),
  CONSTRAINT `fk_enfermed_usuarios_usuarios` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `enfermedades_usuario`
--

LOCK TABLES `enfermedades_usuario` WRITE;
/*!40000 ALTER TABLE `enfermedades_usuario` DISABLE KEYS */;
INSERT INTO `enfermedades_usuario` VALUES (1,2),(3,2),(1,59);
/*!40000 ALTER TABLE `enfermedades_usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `estilos_vida`
--

DROP TABLE IF EXISTS `estilos_vida`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `estilos_vida` (
  `id_estilo_vida` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  PRIMARY KEY (`id_estilo_vida`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estilos_vida`
--

LOCK TABLES `estilos_vida` WRITE;
/*!40000 ALTER TABLE `estilos_vida` DISABLE KEYS */;
INSERT INTO `estilos_vida` VALUES (1,'Vegano'),(3,'Judío'),(4,'bjahavs'),(5,'bjahavs'),(6,'bjahavs'),(7,'Islam'),(8,'salim');
/*!40000 ALTER TABLE `estilos_vida` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `estilos_vida_usuario`
--

DROP TABLE IF EXISTS `estilos_vida_usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `estilos_vida_usuario` (
  `id_estilo_vida` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  PRIMARY KEY (`id_estilo_vida`,`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estilos_vida_usuario`
--

LOCK TABLES `estilos_vida_usuario` WRITE;
/*!40000 ALTER TABLE `estilos_vida_usuario` DISABLE KEYS */;
INSERT INTO `estilos_vida_usuario` VALUES (1,2),(3,2);
/*!40000 ALTER TABLE `estilos_vida_usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lista_productos`
--

DROP TABLE IF EXISTS `lista_productos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lista_productos` (
  `id_producto` int(11) NOT NULL,
  `id_bar` int(11) NOT NULL,
  `precio` double DEFAULT NULL,
  PRIMARY KEY (`id_producto`,`id_bar`),
  KEY `fk_lista_pr_lista_pro_bares` (`id_bar`),
  CONSTRAINT `fk_lista_pr_lista_pro_bares` FOREIGN KEY (`id_bar`) REFERENCES `bares` (`id_bar`),
  CONSTRAINT `fk_lista_pr_lista_pro_producto` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lista_productos`
--

LOCK TABLES `lista_productos` WRITE;
/*!40000 ALTER TABLE `lista_productos` DISABLE KEYS */;
INSERT INTO `lista_productos` VALUES (5,9,1),(5,10,1),(6,10,0.5),(6,15,3.5),(7,9,2),(8,9,3.4),(8,11,0.75),(8,14,2),(9,9,1.5),(9,10,2),(9,12,2),(10,9,0.25),(13,9,1),(14,14,5),(14,15,8.25),(15,15,5),(16,15,5);
/*!40000 ALTER TABLE `lista_productos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menu_diario`
--

DROP TABLE IF EXISTS `menu_diario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `menu_diario` (
  `id_menu_diario` int(11) NOT NULL AUTO_INCREMENT,
  `id_producto` int(11) NOT NULL,
  `id_bar` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `precio` double NOT NULL,
  PRIMARY KEY (`id_menu_diario`),
  KEY `fk_menu_dia_menu_diar_bares` (`id_bar`),
  KEY `fk_menu_dia_menu_diar_producto` (`id_producto`),
  CONSTRAINT `fk_menu_dia_menu_diar_bares` FOREIGN KEY (`id_bar`) REFERENCES `bares` (`id_bar`),
  CONSTRAINT `fk_menu_dia_menu_diar_producto` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menu_diario`
--

LOCK TABLES `menu_diario` WRITE;
/*!40000 ALTER TABLE `menu_diario` DISABLE KEYS */;
INSERT INTO `menu_diario` VALUES (2,8,9,'2020-06-11',0.5),(3,7,12,'2020-06-11',1),(4,9,12,'2020-06-11',1),(5,10,12,'2020-06-11',0.5),(6,8,9,'2020-06-16',2.3),(7,7,9,'2020-06-16',2.3),(8,7,9,'2020-06-16',2.3),(9,7,9,'2020-06-16',2.3),(12,5,9,'2020-06-16',2.3),(20,8,9,'2020-06-17',2.3),(21,7,9,'2020-06-17',2.3),(22,7,9,'2020-06-17',2.3),(23,7,9,'2020-06-17',2.3),(24,5,9,'2020-06-17',2.3),(25,10,9,'2020-06-22',0.5),(26,8,9,'2020-06-22',0.75),(27,12,14,'2020-06-23',1),(28,14,14,'2020-06-23',1),(29,14,14,'2020-06-23',3),(30,7,9,'2020-06-30',0.5),(33,7,9,'2020-07-01',2),(34,10,9,'2020-07-01',0.25),(35,13,9,'2020-07-01',1),(36,6,15,'2020-07-10',3.5),(37,14,15,'2020-07-10',8.25),(38,14,15,'2020-07-10',8.25);
/*!40000 ALTER TABLE `menu_diario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `preferencia`
--

DROP TABLE IF EXISTS `preferencia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `preferencia` (
  `id_categoria_alimento` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `valor` int(11) NOT NULL,
  PRIMARY KEY (`id_categoria_alimento`,`id_usuario`),
  KEY `fk_preferen_preferenc_usuarios` (`id_usuario`),
  CONSTRAINT `fk_preferen_preferenc_categori` FOREIGN KEY (`id_categoria_alimento`) REFERENCES `categoria_alimentos` (`id_categoria_alimento`),
  CONSTRAINT `fk_preferen_preferenc_usuarios` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `preferencia`
--

LOCK TABLES `preferencia` WRITE;
/*!40000 ALTER TABLE `preferencia` DISABLE KEYS */;
INSERT INTO `preferencia` VALUES (1,2,1),(3,2,3),(3,59,1);
/*!40000 ALTER TABLE `preferencia` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `productos`
--

DROP TABLE IF EXISTS `productos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `productos` (
  `id_producto` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_producto`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `productos`
--

LOCK TABLES `productos` WRITE;
/*!40000 ALTER TABLE `productos` DISABLE KEYS */;
INSERT INTO `productos` VALUES (5,'Gatorade'),(6,'Muchines'),(7,'Yapingachos'),(8,'Papas Fritas'),(9,'Salchipapa'),(10,'Deditos de Queso'),(12,'GATORADE2'),(13,'GATORADE2'),(14,'Parangaricutirimicuaro picante'),(15,'Las paparangas completas'),(16,'Las paparangas completas');
/*!40000 ALTER TABLE `productos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `productos_categoria`
--

DROP TABLE IF EXISTS `productos_categoria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `productos_categoria` (
  `id_categoria_alimento` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  PRIMARY KEY (`id_categoria_alimento`,`id_producto`),
  KEY `fk_producto_productos_producto` (`id_producto`),
  CONSTRAINT `fk_producto_productos_categori` FOREIGN KEY (`id_categoria_alimento`) REFERENCES `categoria_alimentos` (`id_categoria_alimento`),
  CONSTRAINT `fk_producto_productos_producto` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `productos_categoria`
--

LOCK TABLES `productos_categoria` WRITE;
/*!40000 ALTER TABLE `productos_categoria` DISABLE KEYS */;
/*!40000 ALTER TABLE `productos_categoria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `productos_componentes`
--

DROP TABLE IF EXISTS `productos_componentes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `productos_componentes` (
  `id_compuesto` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  PRIMARY KEY (`id_compuesto`,`id_producto`),
  CONSTRAINT `fk_producto_productos_compuest` FOREIGN KEY (`id_compuesto`) REFERENCES `compuesto_quimico_organico` (`id_compuesto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `productos_componentes`
--

LOCK TABLES `productos_componentes` WRITE;
/*!40000 ALTER TABLE `productos_componentes` DISABLE KEYS */;
/*!40000 ALTER TABLE `productos_componentes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rest_categoria_enfermedad`
--

DROP TABLE IF EXISTS `rest_categoria_enfermedad`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rest_categoria_enfermedad` (
  `id_categoria_alimento` int(11) NOT NULL,
  `id_enfermedad` int(11) NOT NULL,
  `tipo` varchar(20) NOT NULL,
  PRIMARY KEY (`id_categoria_alimento`,`id_enfermedad`),
  KEY `fk_rest_cat_restricci_enfermed` (`id_enfermedad`),
  CONSTRAINT `fk_rest_cat_restricci_categori` FOREIGN KEY (`id_categoria_alimento`) REFERENCES `categoria_alimentos` (`id_categoria_alimento`),
  CONSTRAINT `fk_rest_cat_restricci_enfermed` FOREIGN KEY (`id_enfermedad`) REFERENCES `enfermedades` (`id_enfermedad`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rest_categoria_enfermedad`
--

LOCK TABLES `rest_categoria_enfermedad` WRITE;
/*!40000 ALTER TABLE `rest_categoria_enfermedad` DISABLE KEYS */;
/*!40000 ALTER TABLE `rest_categoria_enfermedad` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rest_categoria_estilo_vida`
--

DROP TABLE IF EXISTS `rest_categoria_estilo_vida`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rest_categoria_estilo_vida` (
  `id_categoria_alimento` int(11) NOT NULL,
  `id_estilo_vida` int(11) NOT NULL,
  PRIMARY KEY (`id_categoria_alimento`,`id_estilo_vida`),
  KEY `fk_rest_cat_restricci_estilos_` (`id_estilo_vida`),
  CONSTRAINT `fk_rest_cat_restricci_estilos_` FOREIGN KEY (`id_estilo_vida`) REFERENCES `estilos_vida` (`id_estilo_vida`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rest_categoria_estilo_vida`
--

LOCK TABLES `rest_categoria_estilo_vida` WRITE;
/*!40000 ALTER TABLE `rest_categoria_estilo_vida` DISABLE KEYS */;
/*!40000 ALTER TABLE `rest_categoria_estilo_vida` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rest_compuesto_enfermedad`
--

DROP TABLE IF EXISTS `rest_compuesto_enfermedad`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rest_compuesto_enfermedad` (
  `id_compuesto` int(11) NOT NULL,
  `id_enfermedad` int(11) NOT NULL,
  `tipo` varchar(20) NOT NULL,
  PRIMARY KEY (`id_compuesto`,`id_enfermedad`),
  KEY `fk_rest_com_restricci_enfermed` (`id_enfermedad`),
  CONSTRAINT `fk_rest_com_restricci_compuest` FOREIGN KEY (`id_compuesto`) REFERENCES `compuesto_quimico_organico` (`id_compuesto`),
  CONSTRAINT `fk_rest_com_restricci_enfermed` FOREIGN KEY (`id_enfermedad`) REFERENCES `enfermedades` (`id_enfermedad`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rest_compuesto_enfermedad`
--

LOCK TABLES `rest_compuesto_enfermedad` WRITE;
/*!40000 ALTER TABLE `rest_compuesto_enfermedad` DISABLE KEYS */;
/*!40000 ALTER TABLE `rest_compuesto_enfermedad` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `restriccion_categoria_alergia`
--

DROP TABLE IF EXISTS `restriccion_categoria_alergia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `restriccion_categoria_alergia` (
  `id_categoria_alimento` int(11) NOT NULL,
  `id_alergia` int(11) NOT NULL,
  PRIMARY KEY (`id_categoria_alimento`,`id_alergia`),
  KEY `fk_restricc_restricci_alergias` (`id_alergia`),
  CONSTRAINT `fk_restricc_restricci_alergias` FOREIGN KEY (`id_alergia`) REFERENCES `alergias` (`id_alergia`),
  CONSTRAINT `fk_restricc_restricci_categori` FOREIGN KEY (`id_categoria_alimento`) REFERENCES `categoria_alimentos` (`id_categoria_alimento`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `restriccion_categoria_alergia`
--

LOCK TABLES `restriccion_categoria_alergia` WRITE;
/*!40000 ALTER TABLE `restriccion_categoria_alergia` DISABLE KEYS */;
/*!40000 ALTER TABLE `restriccion_categoria_alergia` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `restriccion_compuesto_alergia`
--

DROP TABLE IF EXISTS `restriccion_compuesto_alergia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `restriccion_compuesto_alergia` (
  `id_compuesto` int(11) NOT NULL,
  `id_alergia` int(11) NOT NULL,
  PRIMARY KEY (`id_compuesto`,`id_alergia`),
  CONSTRAINT `fk_restricc_restricci_compuest` FOREIGN KEY (`id_compuesto`) REFERENCES `compuesto_quimico_organico` (`id_compuesto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `restriccion_compuesto_alergia`
--

LOCK TABLES `restriccion_compuesto_alergia` WRITE;
/*!40000 ALTER TABLE `restriccion_compuesto_alergia` DISABLE KEYS */;
/*!40000 ALTER TABLE `restriccion_compuesto_alergia` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipo_usuario`
--

DROP TABLE IF EXISTS `tipo_usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipo_usuario` (
  `id_tipo_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  PRIMARY KEY (`id_tipo_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipo_usuario`
--

LOCK TABLES `tipo_usuario` WRITE;
/*!40000 ALTER TABLE `tipo_usuario` DISABLE KEYS */;
INSERT INTO `tipo_usuario` VALUES (1,'Estudiante'),(2,'Docente'),(3,'Operario de Bar');
/*!40000 ALTER TABLE `tipo_usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `id_tipo_usuario` int(11) DEFAULT NULL,
  `apellido_paterno` varchar(40) NOT NULL,
  `apellido_materno` varchar(40) NOT NULL,
  `nombre` varchar(40) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `pass` varchar(25) NOT NULL,
  PRIMARY KEY (`id_usuario`),
  UNIQUE KEY `correo` (`correo`),
  KEY `fk_usuarios_fk_usuari_tipo_usu` (`id_tipo_usuario`),
  CONSTRAINT `fk_usuarios_fk_usuari_tipo_usu` FOREIGN KEY (`id_tipo_usuario`) REFERENCES `tipo_usuario` (`id_tipo_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (1,1,'ahsbsn','absbbd','absbbsp','ahsbs','12345678'),(2,3,'Cuenca','Meza','Franklin Andreé','andreecuenca1999@gmail.com','12345678'),(3,1,'meza','menendez','maria eufemia','mariameza39@hotmail.com','12345678'),(4,3,'Vera','Almeida','Cristhian Manuel','cvera@gmail.com','12345678'),(5,1,'Cuenca','Meza','Frana Isabella','franaisabella@gmail.com','12345678'),(6,3,'Cedeño','Zambrano','Limber Alejandro','limber@gmail.com','12345678'),(7,3,'Cedeño','Cedeño','Washington Alí','washali@gmail.com','12345678'),(8,1,'cedeño','cedeño','limber','limber_12@live.com','12345678'),(9,1,'tstsy','habah','hahha','la','12345678'),(11,1,'gah','bsbbs','bah','li','12345678'),(12,1,'Garcia','Cabrera','Michael ','mgarcia9995@utm.edu.ec','12345678'),(13,2,'Ordoñez','Cedeño	','Zaid Ricardo','ecssolt@gmail.com','11223344'),(15,2,'1111','2222','3333','4444','12345678'),(18,2,'Ordoñez','Avila','Memerson','eordonez@utm.edu.ec','87654321'),(19,1,'678','901','qqq','gmcedenop@utm.edu.ec','12345678'),(23,1,'Vera','Velez','Juan','vera@gmail.com','12345678'),(24,1,'Zambran9','Almeida','Cristhian','cveragmail.com','12345678'),(25,1,'Tigua','Avellan','Abel','Gustavo','lahorasad2016'),(27,1,'riko','rika','riki','abel@gmail.com','123'),(28,1,'Arev','Adiemld','Naihtsirc Leunam','c@gmail.com','12345678'),(29,2,'Cedeño	','Palacios	','Gema María	','gpalacios.dpm@gmail.com','123456789'),(36,3,'Olmedo	','Martínez	','Juanes Ronaldhino	','eljuanes@gmail.com','123456789'),(44,2,'meza','quijije','erick ronald','erick13@gmail.com','12345678'),(48,1,'bsksjsd','sksksid','sjsjdj','erick12@gmail.com','q23r5678'),(52,3,'isksjd','nsksns','snsks','erick14@gmail.com','12345678'),(53,1,'Vera','Almeida','Cristhian','cv@gmail.com','12345678'),(54,1,'dff','dfd','fdf','dsfsd','12345678'),(55,3,'Cedeño','Palacios','Gema María','gpalacios.dpm@utm.edu.ec','88888888'),(56,1,'Pinoargote','Vera','Bryan','doppelgangerf94@gmail.com','cognitivepass69_'),(57,1,'Pinoargote','Vera','Bryan','bryankarter17@hotmail.it','Hotmail77'),(58,1,'Vera','Vera','Bryan','bjose94@outlook.com','Hotmail7'),(59,1,'cedeño','Zambrano','limber','limber_10@au.com','12345678'),(60,1,'11','22','33 44','ecssolt@gmail.com	','32323232'),(61,3,'99	','11	','77	','88.com','12121212'),(62,2,'ee','ff','qq rr','121212.121212','eeeeeeeee'),(63,3,'33','44','ww cc','ee','52525252'),(64,3,'Ordoñez','Avila','Parangaricutirimicuaro Meme','parangaricutirimicuaro@gmail.com','PARANGA2020');
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'cfhc'
--
SET @@SESSION.SQL_LOG_BIN = @MYSQLDUMP_TEMP_LOG_BIN;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-07-23 11:39:01
