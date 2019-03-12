-- MySQL dump 10.13  Distrib 5.6.39, for Linux (x86_64)
--
-- Host: localhost    Database: escuelatf
-- ------------------------------------------------------
-- Server version	5.6.39-cll-lve

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
-- Table structure for table `administrador`
--

DROP TABLE IF EXISTS `administrador`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `administrador` (
  `numempleado` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `nombre` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `rol` varchar(10) COLLATE utf8_spanish_ci DEFAULT 'admin',
  `correo` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `contrasena` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `contrasena_plano` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`numempleado`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `administrador`
--

LOCK TABLES `administrador` WRITE;
/*!40000 ALTER TABLE `administrador` DISABLE KEYS */;
INSERT INTO `administrador` VALUES ('10','Jorge Guzman','admin','jogs78@hotmail.com','d033e22ae348aeb5660fc2140aec35850c4da997','12345');
/*!40000 ALTER TABLE `administrador` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `alumno`
--

DROP TABLE IF EXISTS `alumno`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `alumno` (
  `numcontrol` int(5) NOT NULL,
  `apellidos` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `nombres` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fec_na` date DEFAULT NULL,
  `sexo` char(1) COLLATE utf8_spanish_ci DEFAULT NULL,
  `direccion` varchar(300) COLLATE utf8_spanish_ci NOT NULL,
  `telefono` varchar(15) COLLATE utf8_spanish_ci NOT NULL,
  `correo_e` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `contrasena` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `baja` int(3) DEFAULT '0',
  `rol` varchar(10) COLLATE utf8_spanish_ci DEFAULT 'alumno',
  `fecha_reg` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `semestre_act` int(3) DEFAULT '0',
  PRIMARY KEY (`numcontrol`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `alumno`
--

LOCK TABLES `alumno` WRITE;
/*!40000 ALTER TABLE `alumno` DISABLE KEYS */;
/*!40000 ALTER TABLE `alumno` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cicloescolar`
--

DROP TABLE IF EXISTS `cicloescolar`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cicloescolar` (
  `idciclo` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `iniciop` date DEFAULT NULL,
  `finp` date DEFAULT NULL,
  `periodoactual` int(1) DEFAULT '1',
  `periodoiniciado` int(1) DEFAULT '0',
  PRIMARY KEY (`idciclo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cicloescolar`
--

LOCK TABLES `cicloescolar` WRITE;
/*!40000 ALTER TABLE `cicloescolar` DISABLE KEYS */;
/*!40000 ALTER TABLE `cicloescolar` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `grupo`
--

DROP TABLE IF EXISTS `grupo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `grupo` (
  `idgrupo` int(3) NOT NULL AUTO_INCREMENT,
  `clavemateria` int(3) DEFAULT NULL,
  `idprofesor` varchar(30) COLLATE utf8_spanish_ci DEFAULT NULL,
  `idciclo` varchar(30) COLLATE utf8_spanish_ci DEFAULT NULL,
  `capturar` int(3) DEFAULT '0',
  PRIMARY KEY (`idgrupo`),
  KEY `tiene` (`idciclo`),
  KEY `imparte` (`idprofesor`),
  KEY `esimpartida` (`clavemateria`),
  CONSTRAINT `esimpartida` FOREIGN KEY (`clavemateria`) REFERENCES `materia` (`clavemateria`),
  CONSTRAINT `imparte` FOREIGN KEY (`idprofesor`) REFERENCES `profesor` (`cedula`),
  CONSTRAINT `tiene` FOREIGN KEY (`idciclo`) REFERENCES `cicloescolar` (`idciclo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `grupo`
--

LOCK TABLES `grupo` WRITE;
/*!40000 ALTER TABLE `grupo` DISABLE KEYS */;
/*!40000 ALTER TABLE `grupo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kardex`
--

DROP TABLE IF EXISTS `kardex`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kardex` (
  `numcontrol` int(3) NOT NULL DEFAULT '0',
  `materia` int(3) NOT NULL DEFAULT '0',
  `calificacionfinal` int(3) DEFAULT NULL,
  `ciclo` varchar(50) COLLATE utf8_spanish_ci NOT NULL DEFAULT '',
  `ee` int(3) DEFAULT NULL,
  `ets` int(3) DEFAULT NULL,
  `observaciones` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fechacontrol` date DEFAULT NULL,
  PRIMARY KEY (`materia`,`numcontrol`,`ciclo`),
  KEY `t` (`numcontrol`),
  KEY `a` (`ciclo`),
  CONSTRAINT `a` FOREIGN KEY (`ciclo`) REFERENCES `cicloescolar` (`idciclo`),
  CONSTRAINT `e` FOREIGN KEY (`materia`) REFERENCES `materia` (`clavemateria`),
  CONSTRAINT `t` FOREIGN KEY (`numcontrol`) REFERENCES `alumno` (`numcontrol`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kardex`
--

LOCK TABLES `kardex` WRITE;
/*!40000 ALTER TABLE `kardex` DISABLE KEYS */;
/*!40000 ALTER TABLE `kardex` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lista`
--

DROP TABLE IF EXISTS `lista`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lista` (
  `idgrupo` int(3) NOT NULL DEFAULT '0',
  `numcontrol` int(3) NOT NULL DEFAULT '0',
  `primera_e` float DEFAULT NULL,
  `segunda_e` float DEFAULT NULL,
  `tercera_e` float DEFAULT NULL,
  `cuarta_e` float DEFAULT NULL,
  `calificacionfinal` float DEFAULT NULL,
  `ee` float DEFAULT NULL,
  `ets` float DEFAULT NULL,
  `observaciones` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`idgrupo`,`numcontrol`),
  KEY `per` (`numcontrol`),
  CONSTRAINT `per` FOREIGN KEY (`numcontrol`) REFERENCES `alumno` (`numcontrol`),
  CONSTRAINT `pertenece` FOREIGN KEY (`idgrupo`) REFERENCES `grupo` (`idgrupo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lista`
--

LOCK TABLES `lista` WRITE;
/*!40000 ALTER TABLE `lista` DISABLE KEYS */;
/*!40000 ALTER TABLE `lista` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `materia`
--

DROP TABLE IF EXISTS `materia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `materia` (
  `clavemateria` int(3) NOT NULL,
  `asignatura` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `seriacion` int(3) DEFAULT NULL,
  `hteoria` int(3) DEFAULT NULL,
  `hpractica` int(3) DEFAULT NULL,
  `htotal` int(3) DEFAULT NULL,
  `creditos` int(3) NOT NULL,
  `semestre` int(3) NOT NULL,
  `taller` char(1) COLLATE utf8_spanish_ci DEFAULT NULL,
  `nc` char(70) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`clavemateria`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `materia`
--

LOCK TABLES `materia` WRITE;
/*!40000 ALTER TABLE `materia` DISABLE KEYS */;
INSERT INTO `materia` VALUES (101,'INVALIDEZ Y SOCIEDAD',NULL,3,1,4,7,1,'T','INVALIDEZ Y SOCIEDAD'),(102,'ANATOMIA MUSCULOESQUELETICA',NULL,5,1,6,10,1,'T','ANATOMIA MUSCULOESQUELETICA'),(103,'ANATOMIA DE APARATOS Y SISTEMAS',NULL,3,0,3,6,1,'T','ANATOMIA DE APARATOS Y SISTEMAS'),(104,'FISIOLOGIA MUSCOESQUELETICA',NULL,3,0,6,6,1,'T','FISIOLOGIA MUSCOESQUELETICA'),(105,'FISIOLOGIA DE APARATOS Y SISTEMAS',NULL,3,0,3,6,1,'T','FISIOLOGIA DE APARATOS Y SISTEMAS'),(106,'NEUROANATOMIA',NULL,4,0,4,8,1,'T','NEUROANATOMIA'),(107,'ANATOMIA Y FISIOLOGIA DEL APARATO FONOARTICULADOR',NULL,3,0,3,6,1,'T','ANAT. Y FISIOL. DEL APARATO FONOARTICULADOR'),(108,'NEUROFISIOLOGIA',NULL,3,0,3,6,1,'T','NEUROFISIOLOGIA'),(209,'BIOMECANICA',102,4,0,4,8,2,'T','BIOMECANICA'),(210,'INTRODUCCION A LA PRACTICA REHABILITADORA',104,1,4,5,6,2,'T','INTRODUCCION A LA PRAC. REHABILITADORA'),(211,'NEUROFISIOLOGIA DEL INCREMENTO Y EL DESARROLLO',NULL,3,0,3,6,2,'T','NEUROFISIOLOGIA DEL INCREMENTO Y EL DESARROLLO'),(213,'CRECIMIENTO Y DESARROLLO NORMAL',NULL,5,2,7,12,2,'T','CRECIMIENTO Y DESARROLLO NORMAL'),(214,'GENETICA',NULL,2,0,2,4,2,'T','GENETICA'),(215,'TEORIA DEL DESARROLLO NORMAL',NULL,5,2,7,12,2,'T','TEORIA DEL DESARROLLO NORMAL'),(315,'DESVIACION DEL DESARROLLO',212,4,2,6,10,3,'T','DESVIACION DEL DESARROLLO'),(316,'ADOLESCENCIA Y PUBERTAD',212,2,0,2,4,3,'T','ADOLESCENCIA Y PUBERTAD'),(317,'FACTORES DE RIESGOS DE INVALIDEZ EN PUBERTAD Y ADOLESCENCIA',211,2,0,2,4,3,'T','FACTS DE RIESGOS DE INVALIDEZ EN PUBERTAD Y ADOLESCENCIA'),(318,'FISIOLOGIA DEL EJERCICIO',103,3,0,3,6,3,'T','FISIOLOGIA DEL EJERCICIO'),(319,'MADUREZ E INVALIDEZ',NULL,3,0,3,6,3,'T','MADUREZ E INVALIDEZ'),(320,'ENFERMEDADES MAS FRECUENTES EN LOS ANCIANOS',NULL,3,0,3,6,3,'T','ENFERMEDADES MAS FRECUENTES EN LOS ANCIANOS'),(321,'PRACTICA CLINICA EN LAS DESVIACIONES DEL NEURODESARROLLO',212,4,10,14,18,3,'T','PRAC. CLINICA EN LAS DESVIACIONES DEL NEURODESARROLLO'),(422,'FISICA',NULL,2,0,2,4,4,'T','FISICA'),(423,'AGENTES FISICO',NULL,4,3,7,11,4,'T','AGENTES FISICO'),(424,'EFECTOS TERAPEUTICOS DE CALOR FRIO',NULL,3,3,6,9,4,'T','EFECTOS TERAPEUTICOS DE CALOR FRIO'),(425,'ELECTROMAGNETISMO Y ESPECTROACUSTICO',NULL,3,3,6,9,4,'T','ELECTROMAGNETISMO Y ESPECTROACUSTICO'),(426,'EJERCICIOS TERAPEUTICOS',NULL,2,5,7,7,4,'T','EJERCICIOS TERAPEUTICOS'),(427,'LA TERAPIA FISICA EN PADECIMIENTOS DE NEURONA MOTORA PERIFERICA',102,4,5,9,14,4,'T','LA T.F.  EN PADECIMIENTOS DE NEURONA MOTORA  PERIFERICA'),(428,'TERAPIA FISICA INTEGRAL',104,0,5,5,15,4,'T','TERAPIA FISICA INTEGRAL'),(528,'LA TERAPIA FISICA EN LOS PADECIMIENTOS DE NEURONA MOTORA CENTRAL',NULL,2,3,5,8,5,'T','LA T.F. EN LOS PADECIMIENTOS DE NEURONA MOTORA CENTRAL'),(529,'LA TERAPIA FISICA EN LOS AMPUTADOS',NULL,2,3,5,6,5,'T','LA TERAPIA FISICA EN LOS AMPUTADOS'),(530,'LA TERAPIA FISICA EN LAS ENFERMEDADES DEL TENIDO CONECTIVO',NULL,2,3,5,8,5,'T','LA T.F. EN LAS ENFERMEDADES DEL TENIDO CONECTIVO'),(531,'LA TERAPIA FISICA EN LESIONES MEDULARES',NULL,2,3,5,8,5,'T','LA T. F.  EN LESIONES MEDULARES'),(532,'LA TERAPIA FISICA EN LOS QUEMADOS',NULL,2,4,6,8,5,'T','LA TERAPIA FISICA EN LOS QUEMADOS'),(533,'LA TERAPIA FISICA EN LA ORTOPEDIA',NULL,2,3,5,7,5,'T','LA TERAPIA FISICA EN LA ORTOPEDIA'),(534,'LA TERAPIA FISICA EN LOS PADECIMIENTOS DEGENERATIVOS DEL SISTEMA NERVIOSO CENTRAL',NULL,1,2,3,5,5,'T','LA T. F. EN LOS PADECIMIENTOS DEGENERATIVOS DEL S.N.C.'),(535,'FISIOTERAPIA NEUROMOTORA',NULL,0,5,5,15,5,'T','FISIOTERAPIA NEUROMOTORA'),(635,'LA TERAPIA FISICA EN LA REHABILITACION CARDIACA',NULL,2,5,7,10,6,'T','LA TERAPIA FISICA EN LA REHABILITACION CARDIACA'),(636,'LA TERAPIA FISICA EN LA REHABILITACION RESPIRATORIA',NULL,2,5,7,10,6,'T','LA T. F. EN LA REHABILITACION RESPIRATORIA'),(637,'LA TERAPIA FISICA EN LA REHABILITACION DEL INVIDENTE',NULL,3,4,7,10,6,'T','LA T. F.  EN LA REHABILITACION DEL INVIDENTE'),(638,'LA TERAPIA FISICA EN LA REHABILITACION DE LA MANO',NULL,2,4,6,10,6,'T','LA T. F. EN LA REHABILITACION DE LA MANO'),(639,'LA TERAPIA FISICA EN EL LENGUAJE NORMAL Y SU PAGOLOGIA',NULL,4,1,5,9,6,'T','LA T. F.  EN EL LENGUAJE NORMAL Y SU PAGOLOGIA'),(640,'METODOLOGIA CIENTIFICA',NULL,2,1,3,5,6,'T','METODOLOGIA CIENTIFICA'),(641,'FISIOLOGIA NEUROMOTORA',NULL,0,5,5,15,6,'T','FISIOLOGIA NEUROMOTORA');
/*!40000 ALTER TABLE `materia` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `profesor`
--

DROP TABLE IF EXISTS `profesor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `profesor` (
  `cedula` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `nombre` varchar(120) COLLATE utf8_spanish_ci DEFAULT NULL,
  `direccion` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `correo_e` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `telefono` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fecha_clases` date DEFAULT NULL,
  `rol` varchar(10) COLLATE utf8_spanish_ci DEFAULT 'profesor',
  `especialidad` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `fecha_reg` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `contrasena` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`cedula`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `profesor`
--

LOCK TABLES `profesor` WRITE;
/*!40000 ALTER TABLE `profesor` DISABLE KEYS */;
INSERT INTO `profesor` VALUES ('6068','ANTONIO DE JESUS','AV GALEANA BIENESTAR SOCIAL','antonio@gmail.com','9611234568','2013-02-04','profesor','terapeuta','2013-08-30 13:09:13','d033e22ae348aeb5660fc2140aec35850c4da997'),('abcde','PRUEBA','PRUEBA','prueba@hotmail.com','23232323','2013-08-04','profesor','prueba','2013-08-30 13:15:53','03de6c570bfe24bfc328ccd7ca46b76eadaf4334');
/*!40000 ALTER TABLE `profesor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `recuperar`
--

DROP TABLE IF EXISTS `recuperar`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `recuperar` (
  `usuario` varchar(100) COLLATE utf8_spanish_ci NOT NULL DEFAULT '',
  `clave` varchar(40) COLLATE utf8_spanish_ci NOT NULL DEFAULT '',
  `tipo` varchar(30) COLLATE utf8_spanish_ci DEFAULT NULL,
  `validez` date NOT NULL,
  PRIMARY KEY (`clave`,`validez`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `recuperar`
--

LOCK TABLES `recuperar` WRITE;
/*!40000 ALTER TABLE `recuperar` DISABLE KEYS */;
/*!40000 ALTER TABLE `recuperar` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-04-25 16:20:06
