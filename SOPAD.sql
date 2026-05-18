-- MySQL dump 10.13  Distrib 8.0.30, for Win64 (x86_64)
--
-- Host: localhost    Database: SOPAD
-- ------------------------------------------------------
-- Server version	8.0.30

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `administra`
--

DROP TABLE IF EXISTS `administra`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `administra` (
  `id_usuario` int NOT NULL,
  `id_evento` int NOT NULL,
  PRIMARY KEY (`id_usuario`,`id_evento`),
  KEY `id_evento` (`id_evento`),
  CONSTRAINT `administra_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`),
  CONSTRAINT `administra_ibfk_2` FOREIGN KEY (`id_evento`) REFERENCES `eventos` (`id_evento`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `administra`
--

LOCK TABLES `administra` WRITE;
/*!40000 ALTER TABLE `administra` DISABLE KEYS */;
/*!40000 ALTER TABLE `administra` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `articulo`
--

DROP TABLE IF EXISTS `articulo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `articulo` (
  `id_a` int NOT NULL AUTO_INCREMENT,
  `descripcion` text NOT NULL,
  `costp_uni` decimal(10,2) NOT NULL,
  `estado_articulo` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_a`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `articulo`
--

LOCK TABLES `articulo` WRITE;
/*!40000 ALTER TABLE `articulo` DISABLE KEYS */;
/*!40000 ALTER TABLE `articulo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categoria`
--

DROP TABLE IF EXISTS `categoria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categoria` (
  `id_categoria` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `estado` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_categoria`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categoria`
--

LOCK TABLES `categoria` WRITE;
/*!40000 ALTER TABLE `categoria` DISABLE KEYS */;
/*!40000 ALTER TABLE `categoria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contiene`
--

DROP TABLE IF EXISTS `contiene`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `contiene` (
  `id_e` int NOT NULL,
  `id_a` int NOT NULL,
  PRIMARY KEY (`id_e`,`id_a`),
  KEY `id_a` (`id_a`),
  CONSTRAINT `contiene_ibfk_1` FOREIGN KEY (`id_e`) REFERENCES `escenario_financiero` (`id_e`),
  CONSTRAINT `contiene_ibfk_2` FOREIGN KEY (`id_a`) REFERENCES `articulo` (`id_a`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contiene`
--

LOCK TABLES `contiene` WRITE;
/*!40000 ALTER TABLE `contiene` DISABLE KEYS */;
/*!40000 ALTER TABLE `contiene` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `costo_venta`
--

DROP TABLE IF EXISTS `costo_venta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `costo_venta` (
  `id_costo` int NOT NULL AUTO_INCREMENT,
  `id_mp` int DEFAULT NULL,
  `id_labor` int DEFAULT NULL,
  `id_venta` int DEFAULT NULL,
  `mes` int DEFAULT NULL,
  `anno` int DEFAULT NULL,
  PRIMARY KEY (`id_costo`),
  KEY `id_mp` (`id_mp`),
  KEY `id_labor` (`id_labor`),
  KEY `id_venta` (`id_venta`),
  CONSTRAINT `costo_venta_ibfk_1` FOREIGN KEY (`id_mp`) REFERENCES `materia_prima` (`id_mp`),
  CONSTRAINT `costo_venta_ibfk_2` FOREIGN KEY (`id_labor`) REFERENCES `labor_directa` (`id_labor`),
  CONSTRAINT `costo_venta_ibfk_3` FOREIGN KEY (`id_venta`) REFERENCES `ventas_anuales` (`id_venta`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `costo_venta`
--

LOCK TABLES `costo_venta` WRITE;
/*!40000 ALTER TABLE `costo_venta` DISABLE KEYS */;
/*!40000 ALTER TABLE `costo_venta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `escenario_financiero`
--

DROP TABLE IF EXISTS `escenario_financiero`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `escenario_financiero` (
  `id_e` int NOT NULL AUTO_INCREMENT,
  `mes` int NOT NULL,
  `anno` int NOT NULL,
  `total_mes` decimal(15,2) NOT NULL,
  `total_anno` decimal(15,2) DEFAULT NULL,
  `descripcion` text,
  `fecha_evaluacion` date NOT NULL,
  PRIMARY KEY (`id_e`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `escenario_financiero`
--

LOCK TABLES `escenario_financiero` WRITE;
/*!40000 ALTER TABLE `escenario_financiero` DISABLE KEYS */;
/*!40000 ALTER TABLE `escenario_financiero` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `eventos`
--

DROP TABLE IF EXISTS `eventos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `eventos` (
  `id_evento` int NOT NULL AUTO_INCREMENT,
  `nombre_evento` varchar(100) NOT NULL,
  `etapa` enum('cerrada','abierta') NOT NULL,
  `periodo` varchar(50) DEFAULT NULL,
  `convocatoria` enum('ordinaria','extraordinaria') DEFAULT NULL,
  `descripcion_evento` text,
  PRIMARY KEY (`id_evento`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `eventos`
--

LOCK TABLES `eventos` WRITE;
/*!40000 ALTER TABLE `eventos` DISABLE KEYS */;
INSERT INTO `eventos` VALUES (4,'hackaTec','cerrada','2025-2026','ordinaria','sdfghjkl.,mnbvcx'),(6,'innovacion','cerrada','2025-2026','ordinaria','desarrollar sistema web de evaluacion financiera'),(7,'innovacion','cerrada','2025-2026','extraordinaria','vender chicharrones'),(9,'innovacion','cerrada','2025-2027','ordinaria','bffrrvrsrvdr'),(12,'InnovaTec','cerrada','2025-2027','extraordinaria','vender productos de origen natural'),(13,'InnovaTec','abierta','2025-2027','extraordinaria','vender productos de origen natural'),(14,'InnovaTec','abierta','2025-2027','extraordinaria','venta de productos naturales como jabón'),(15,'InnovaTec','cerrada','2025-2027','extraordinaria','venta de productos naturales como jabón'),(16,'InnovaTec','cerrada','2025-2027','extraordinaria','zdfghjklñ-´-.,mnbvcx'),(17,'InnovaTec','cerrada','2025-2027','ordinaria','srtyuiop`+');
/*!40000 ALTER TABLE `eventos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `institucion`
--

DROP TABLE IF EXISTS `institucion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `institucion` (
  `id_institucion` int NOT NULL AUTO_INCREMENT,
  `nom_institucion` varchar(100) NOT NULL,
  `descripcion` text,
  `ubicacion` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_institucion`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `institucion`
--

LOCK TABLES `institucion` WRITE;
/*!40000 ALTER TABLE `institucion` DISABLE KEYS */;
INSERT INTO `institucion` VALUES (1,'universidad tecnológica nacional','institución educativa enfocada en carreras tecnológicas y de ingeniería.','san martin'),(2,'instituto nacional de investigación','centro de investigación científica y desarrollo tecnológico.','san martin'),(3,'academia de ciencias aplicadas','organización que promueve la ciencia y la tecnología.','san martin'),(4,'centro de innovación empresarial','institución dedicada al apoyo y desarrollo de empresas innovadoras.','san martin');
/*!40000 ALTER TABLE `institucion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `labor_directa`
--

DROP TABLE IF EXISTS `labor_directa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `labor_directa` (
  `id_labor` int NOT NULL AUTO_INCREMENT,
  `operario` decimal(10,2) DEFAULT NULL,
  `disenador` decimal(10,2) DEFAULT NULL,
  `costo_directo` decimal(10,2) NOT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id_labor`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `labor_directa`
--

LOCK TABLES `labor_directa` WRITE;
/*!40000 ALTER TABLE `labor_directa` DISABLE KEYS */;
INSERT INTO `labor_directa` VALUES (1,1000.00,80.00,20.00,1080.00),(2,1000.00,3000.00,5000.00,4000.00),(3,1000.00,3000.00,5000.00,4000.00),(4,1000.00,3000.00,5000.00,4000.00),(5,100.00,400.00,5000.00,500.00);
/*!40000 ALTER TABLE `labor_directa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `materia_prima`
--

DROP TABLE IF EXISTS `materia_prima`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `materia_prima` (
  `id_mp` int NOT NULL AUTO_INCREMENT,
  `nombre_articulo` varchar(100) NOT NULL,
  `tipo` varchar(50) DEFAULT NULL,
  `descripcion` text,
  `costo_unitario` decimal(10,2) NOT NULL,
  `cantidad` int NOT NULL DEFAULT '1',
  `total` int DEFAULT NULL,
  `estado` tinyint(1) DEFAULT '1',
  `usuario_creacion` varchar(100) DEFAULT NULL,
  `fecha_creacion` datetime DEFAULT NULL,
  `usuario_modificacion` varchar(100) DEFAULT NULL,
  `fecha_modificacion` datetime DEFAULT NULL,
  PRIMARY KEY (`id_mp`)
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `materia_prima`
--

LOCK TABLES `materia_prima` WRITE;
/*!40000 ALTER TABLE `materia_prima` DISABLE KEYS */;
INSERT INTO `materia_prima` VALUES (4,'Tornillos 3/4','Ferretería','Caja con tornillos de acero',150.50,1,200,1,NULL,NULL,NULL,NULL),(5,'Madera','Madera','Madera para construcción o fabricación',150.00,1,20,1,NULL,NULL,NULL,NULL),(7,'cable','electronico','cable para conectar un circuito',50.00,1,50,1,NULL,NULL,NULL,NULL),(8,'cubetas','plastico','transportar agua',30.00,5,150,1,NULL,NULL,NULL,NULL),(10,'bote','plastico','bote para pintura',50.00,11,550,1,NULL,NULL,NULL,NULL),(11,'cepillos','plastico','cepillos de dientes',20.00,20,400,1,NULL,NULL,NULL,NULL),(12,'Madera de Pino','Madera','Tablas de pino de 2x4 pulgadas',25.50,100,2550,1,NULL,NULL,NULL,NULL),(13,'Clavos de Acero','Fijación','Clavos galvanizados de 3 pulgadas',5.75,500,2875,1,NULL,NULL,NULL,NULL),(14,'Pintura Blanca','Acabado','Pintura látex mate para interiores',18.90,30,567,1,NULL,NULL,NULL,NULL),(15,'Cemento Portland','Construcción','Saco de 50 kg para construcciones',12.00,80,960,1,NULL,NULL,NULL,NULL),(16,'Lija Grano 120','Acabado','Lija para madera de grano medio',2.50,200,500,1,NULL,NULL,NULL,NULL),(17,'Tornillos Phillips','Fijación','Tornillos de acero inoxidable #8',8.30,300,2490,1,NULL,NULL,NULL,NULL),(18,'Cerámica Blanca','Acabado','Baldosa cerámica 30x30 cm',3.75,150,563,1,NULL,NULL,NULL,NULL),(19,'Arena Fina','Construcción','Arena para mezcla de concreto',15.00,50,750,1,NULL,NULL,NULL,NULL),(20,'Barniz Transparente','Acabado','Barniz para madera de alto brillo',22.40,40,896,1,NULL,NULL,NULL,NULL),(21,'Varilla Corrugada','Construcción','Varilla de acero de 1/2 pulgada',7.80,120,936,1,NULL,NULL,NULL,NULL),(22,'Yeso','Construcción','Yeso para paredes interiores',9.60,70,672,1,NULL,NULL,NULL,NULL),(23,'Pegamento para Madera','Adhesivo','Adhesivo de contacto para madera',6.25,90,563,1,NULL,NULL,NULL,NULL),(24,'Ladrillo Rojo','Construcción','Ladrillo hueco para muros',0.85,1000,850,1,NULL,NULL,NULL,NULL),(25,'Silicona Transparente','Sellador','Silicona para baño y cocina',4.50,60,270,1,NULL,NULL,NULL,NULL),(26,'Cable Eléctrico','Eléctrico','Cable THHN calibre 12',1.20,400,480,1,NULL,NULL,NULL,NULL),(27,'Tuerca Hexagonal','Fijación','Tuerca de acero grado 5',0.15,1000,150,1,NULL,NULL,NULL,NULL),(28,'Lámina de Policarbonato','Cubierta','Lámina transparente de 6 mm',45.00,25,1125,1,NULL,NULL,NULL,NULL),(29,'Malla Ciclónica','Construcción','Malla galvanizada de 1.5 m',18.75,40,750,1,NULL,NULL,NULL,NULL),(30,'Pegamento Cerámico','Adhesivo','Adhesivo para colocación de cerámica',11.30,55,622,1,NULL,NULL,NULL,NULL),(31,'Tubo PVC','Plomería','Tubo de PVC de 1 pulgada',3.40,80,272,1,NULL,NULL,NULL,NULL),(32,'Perfil de Aluminio','Estructura','Perfil para ventanas de aluminio',12.80,45,576,1,NULL,NULL,NULL,NULL),(33,'Block de Concreto','Construcción','Block hueco de 15x20x40 cm',1.50,500,750,1,NULL,NULL,NULL,NULL),(34,'Cinta Métrica','Herramienta','Cinta métrica de 5 metros',7.90,25,198,1,NULL,NULL,NULL,NULL),(35,'Taladro Eléctrico','Herramienta','Taladro percutor de 600W',65.00,10,650,1,NULL,NULL,NULL,NULL),(36,'Martillo','Herramienta','Martillo de uña de 16 oz',12.50,30,375,1,NULL,NULL,NULL,NULL),(37,'Destornillador Plano','Herramienta','Destornillador de 1/4 pulgada',3.20,50,160,1,NULL,NULL,NULL,NULL),(38,'Llave Inglesa','Herramienta','Llave ajustable de 10 pulgadas',15.75,20,315,1,NULL,NULL,NULL,NULL),(39,'Sierra Circular','Herramienta','Sierra circular de 7-1/4 pulgadas',85.00,8,680,1,NULL,NULL,NULL,NULL),(40,'Guantes de Trabajo','Seguridad','Guantes de cuero para construcción',6.80,60,408,1,NULL,NULL,NULL,NULL),(41,'Lentes de Seguridad','Seguridad','Lentes protectores transparentes',4.25,75,319,1,NULL,NULL,NULL,NULL),(42,'Casco de Seguridad','Seguridad','Casco para construcción color amarillo',8.90,40,356,1,NULL,NULL,NULL,NULL),(43,'Piedra Chancada','Construcción','Piedra de 3/4 para concreto',20.00,30,600,1,NULL,NULL,NULL,NULL),(44,'Cal Hidratada','Construcción','Cal para construcción en sacos',10.50,45,473,1,NULL,NULL,NULL,NULL),(45,'Puerta de Madera','Acabado','Puerta sólida de madera de 90 cm',120.00,5,600,1,NULL,NULL,NULL,NULL),(46,'Ventana de Aluminio','Acabado','Ventana corrediza de 1x1 m',95.00,8,760,1,NULL,NULL,NULL,NULL),(47,'Grifo de Cocina','Plomería','Grifo monomando para cocina',45.00,15,675,1,NULL,NULL,NULL,NULL),(48,'Inodoro','Plomería','Inodoro de porcelana de una pieza',85.00,6,510,1,NULL,NULL,NULL,NULL),(49,'Lavamanos','Plomería','Lavamanos de porcelana blanco',55.00,10,550,1,NULL,NULL,NULL,NULL),(50,'Azulejo Decorativo','Acabado','Azulejo para baño 20x20 cm',2.80,200,560,1,NULL,NULL,NULL,NULL),(51,'Canaleta PVC','Eléctrico','Canaleta para instalación eléctrica',1.75,150,263,1,NULL,NULL,NULL,NULL),(52,'Interruptor Simple','Eléctrico','Interruptor de pared blanco',3.40,100,340,1,NULL,NULL,NULL,NULL),(53,'Tomacorriente','Eléctrico','Tomacorriente doble polarizado',4.20,80,336,1,NULL,NULL,NULL,NULL),(54,'Bombillo LED','Eléctrico','Bombillo LED de 9W equivalente a 60W',2.90,120,348,1,NULL,NULL,NULL,NULL),(55,'Tubo Conduit','Eléctrico','Tubo rígido de 1/2 pulgada',2.10,90,189,1,NULL,NULL,NULL,NULL),(56,'Pegamento PVC','Adhesivo','Cemento para unión de tubos PVC',5.60,40,224,1,NULL,NULL,NULL,NULL),(57,'Cinta Aislante','Eléctrico','Cinta aislante negra',1.20,80,96,1,NULL,NULL,NULL,NULL),(58,'Lana de Vidrio','Aislamiento','Panel aislante térmico y acústico',18.00,25,450,1,NULL,NULL,NULL,NULL),(59,'Pintura Roja','Acabado','Pintura esmalte para exteriores',21.50,35,753,1,NULL,NULL,NULL,NULL),(60,'Brocha de 2 Pulgadas','Herramienta','Brocha para pintura sintética',3.75,65,244,1,NULL,NULL,NULL,NULL),(61,'Rodillo de Espuma','Herramienta','Rodillo para pintura de paredes',4.80,50,240,1,NULL,NULL,NULL,NULL),(62,'tubo','metal','flvpnñkjhgfdfh',20.00,10,200,1,NULL,NULL,NULL,NULL),(63,'tubo','plastico','sdfghjklñlkjhgf',10.00,5,50,1,'admin','2026-04-22 00:01:56',NULL,NULL),(64,'tubo','metal','bnm,.-.jhgfd',900.00,10,9000,1,'admin','2026-05-11 15:56:19',NULL,NULL);
/*!40000 ALTER TABLE `materia_prima` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (6,'2014_10_12_000000_create_users_table',1),(7,'2014_10_12_100000_create_password_reset_tokens_table',1),(8,'2019_08_19_000000_create_failed_jobs_table',1),(9,'2019_12_14_000001_create_personal_access_tokens_table',1),(10,'2025_11_29_022654_add_2fa_fields_to_users',1),(11,'2025_11_29_222715_add_two_factor_fields_to_usuario_table',2),(12,'2026_05_11_193911_add_tipo_usuario_to_users_table',3);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `presenta`
--

DROP TABLE IF EXISTS `presenta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `presenta` (
  `id_institucion` int NOT NULL,
  `id_categoria` int NOT NULL,
  PRIMARY KEY (`id_institucion`,`id_categoria`),
  KEY `id_categoria` (`id_categoria`),
  CONSTRAINT `presenta_ibfk_1` FOREIGN KEY (`id_institucion`) REFERENCES `institucion` (`id_institucion`),
  CONSTRAINT `presenta_ibfk_2` FOREIGN KEY (`id_categoria`) REFERENCES `categoria` (`id_categoria`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `presenta`
--

LOCK TABLES `presenta` WRITE;
/*!40000 ALTER TABLE `presenta` DISABLE KEYS */;
/*!40000 ALTER TABLE `presenta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `proporciona`
--

DROP TABLE IF EXISTS `proporciona`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `proporciona` (
  `id_mp` int NOT NULL,
  `id_e` int NOT NULL,
  PRIMARY KEY (`id_mp`,`id_e`),
  KEY `id_e` (`id_e`),
  CONSTRAINT `proporciona_ibfk_1` FOREIGN KEY (`id_mp`) REFERENCES `materia_prima` (`id_mp`),
  CONSTRAINT `proporciona_ibfk_2` FOREIGN KEY (`id_e`) REFERENCES `escenario_financiero` (`id_e`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `proporciona`
--

LOCK TABLES `proporciona` WRITE;
/*!40000 ALTER TABLE `proporciona` DISABLE KEYS */;
/*!40000 ALTER TABLE `proporciona` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `proyecto`
--

DROP TABLE IF EXISTS `proyecto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `proyecto` (
  `id_proyecto` int NOT NULL AUTO_INCREMENT,
  `nom_proyecto` varchar(100) NOT NULL,
  `descripcion` text,
  `fecha` date NOT NULL,
  `id_usuario` int DEFAULT NULL,
  `estado` varchar(1) DEFAULT '1',
  `usuario_creacion` varchar(100) DEFAULT NULL,
  `fecha_creacion` date DEFAULT NULL,
  `usuario_modificacion` varchar(100) DEFAULT NULL,
  `fecha_modificacion` date DEFAULT NULL,
  PRIMARY KEY (`id_proyecto`),
  KEY `id_usuario` (`id_usuario`),
  CONSTRAINT `proyecto_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `proyecto`
--

LOCK TABLES `proyecto` WRITE;
/*!40000 ALTER TABLE `proyecto` DISABLE KEYS */;
INSERT INTO `proyecto` VALUES (3,'SOPAD','evaluacion','2026-04-21',34,'1','admin','2026-04-21','admin','2026-04-21'),(4,'SOPAD','sdfghjkl,kmhfd','2026-04-21',34,'0','admin','2026-04-21',NULL,NULL),(5,'Hotel Luna','Administración de habitaciones','2026-04-21',34,'1','admin','2026-04-21','admin','2026-04-21'),(6,'SOPAD','finanzas','2026-04-22',28,'1','admin','2026-04-22',NULL,NULL),(7,'GARASUATO','VENTAS','2026-05-11',37,'1','admin','2026-05-11',NULL,NULL);
/*!40000 ALTER TABLE `proyecto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `requiere`
--

DROP TABLE IF EXISTS `requiere`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `requiere` (
  `id_proyecto` int NOT NULL,
  `id_mp` int NOT NULL,
  PRIMARY KEY (`id_proyecto`,`id_mp`),
  KEY `id_mp` (`id_mp`),
  CONSTRAINT `requiere_ibfk_1` FOREIGN KEY (`id_proyecto`) REFERENCES `proyecto` (`id_proyecto`),
  CONSTRAINT `requiere_ibfk_2` FOREIGN KEY (`id_mp`) REFERENCES `materia_prima` (`id_mp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `requiere`
--

LOCK TABLES `requiere` WRITE;
/*!40000 ALTER TABLE `requiere` DISABLE KEYS */;
/*!40000 ALTER TABLE `requiere` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `two_factor_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `two_factor_expires_at` datetime DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tipo_usuario` enum('administrador','profesor','estudiante') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'estudiante',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuario` (
  `id_usuario` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `apellido_p` varchar(50) NOT NULL,
  `apellido_m` varchar(50) DEFAULT NULL,
  `correo` varchar(100) NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  `rol` varchar(50) NOT NULL,
  `id_institucion` int DEFAULT NULL,
  `two_factor_code` varchar(255) DEFAULT NULL,
  `two_factor_expires_at` timestamp NULL DEFAULT NULL,
  `estado` tinyint(1) DEFAULT '1',
  `usuario_creacion` varchar(100) DEFAULT NULL,
  `fecha_creacion` datetime DEFAULT NULL,
  `usuario_modificacion` varchar(100) DEFAULT NULL,
  `fecha_modificacion` datetime DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_usuario`),
  UNIQUE KEY `correo` (`correo`),
  KEY `id_institucion` (`id_institucion`),
  CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`id_institucion`) REFERENCES `institucion` (`id_institucion`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES (26,'karla','minero','lazaro','l22240039@smartin.tecnm.mx','2234dsvffff','estudiante',NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL),(27,'sarai','escobar','villalba','l22240024@smartin.tecnm.mx','$2y$12$5sD1u48ZPHPDJRTMgnfGYex90YMrUyG8KPZupuXZNP9Q4B12BGh9S','estudiante',NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL),(28,'Gabriel','palacios','garcia','l22240055@smartin.tecnm.mx','$2y$12$gch//y/r0VG9fDK/ZXwBbeb7m9AVg.7UkMqGjHjxQiLphPwX/PeXa','admin',NULL,'282896','2026-05-12 20:01:12',1,NULL,NULL,NULL,NULL,'usuarios/xbAuALejBhNBxpL1QGvNpPPqRYO1OovtNiWKGEn0.jpg'),(31,'Vianey','lopez','hernandez','l22240045@smartin.tecnm.mx','Vianey123.','profesor',NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL),(34,'Fany Alondra','Juarez','Rodriguez','l22240035@smartin.tecnm.mx','$2y$12$tQmtg0LbzGQjm5rNQrtkI.K8csP7Ckmr/nGdLhbNYxgNrhDAvoLOa','admin',NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,'usuarios/LxlFDoOGasJGjXP0CeTTurK2JijoY1Ov3Ckryu3B.jpg'),(35,'Paola','Solis','Flores','l22240068@smartin.tecnm.mx','$2y$12$F0o1pGRR0uUSRaekqulBnO9P4wf2sR3xJ7X8Izj1S9ez8Nd0STqFO','profesor',NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL),(37,'Sandra','Miron','Nava','l22240058@smartin.tecnm.mx','Sandi1234','estudiante',NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL),(40,'panchito','perez','ramirez','l22240000@smartin.tecnm.mx','123456780','estudiante',NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL),(41,'ramiro','rodriguez','ramirez','l22240001@smartin.tecnm.mx','Ramiroramires','estudiante',NULL,NULL,NULL,1,'admin','2026-04-21 23:54:54','admin','2026-04-21 23:56:29',NULL),(43,'maria','ramos','rojas','l22240077@smartin.tecnm.mx','$2y$12$5iHOf.HRwXjFqcA.w4JmzOrHYIA0CuRvmTUD7TDke1831XZt098ce','estudiante',NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ventas_anuales`
--

DROP TABLE IF EXISTS `ventas_anuales`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ventas_anuales` (
  `id_venta` int NOT NULL AUTO_INCREMENT,
  `anno` int NOT NULL,
  `id_mp` int DEFAULT NULL,
  `num_articulo` int NOT NULL DEFAULT '0',
  `costo_unitario` decimal(15,2) NOT NULL DEFAULT '0.00',
  `mensual` decimal(15,2) DEFAULT NULL,
  `anual` decimal(15,2) DEFAULT NULL,
  `estado` tinyint(1) DEFAULT '1',
  `usuario_creacion` varchar(100) DEFAULT NULL,
  `fecha_creacion` datetime DEFAULT NULL,
  `usuario_modificacion` varchar(100) DEFAULT NULL,
  `fecha_modificacion` datetime DEFAULT NULL,
  PRIMARY KEY (`id_venta`),
  KEY `id_mp` (`id_mp`),
  CONSTRAINT `ventas_anuales_ibfk_1` FOREIGN KEY (`id_mp`) REFERENCES `materia_prima` (`id_mp`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ventas_anuales`
--

LOCK TABLES `ventas_anuales` WRITE;
/*!40000 ALTER TABLE `ventas_anuales` DISABLE KEYS */;
INSERT INTO `ventas_anuales` VALUES (1,1,NULL,0,0.00,3000.00,5000.00,1,NULL,NULL,NULL,NULL),(2,5,NULL,0,0.00,5000.00,220333.00,1,NULL,NULL,NULL,NULL),(3,3,NULL,12,40.00,123456.00,3456934567890.00,1,NULL,NULL,NULL,NULL),(4,2026,NULL,3,40.00,120.00,1440.00,1,NULL,NULL,NULL,NULL),(5,2026,NULL,7,10.00,70.00,840.00,1,NULL,NULL,NULL,NULL),(6,2026,NULL,4,40.00,160.00,1920.00,1,NULL,NULL,NULL,NULL),(7,2026,NULL,4,50.00,200.00,2400.00,1,NULL,NULL,NULL,NULL),(8,2026,7,1,50.00,50.00,600.00,1,NULL,NULL,NULL,NULL),(9,2026,5,1,150.00,150.00,1800.00,1,NULL,NULL,NULL,NULL),(10,2026,14,30,18.90,567.00,6804.00,1,NULL,NULL,NULL,NULL),(11,2026,10,11,50.00,550.00,6600.00,1,NULL,NULL,NULL,NULL),(12,2026,16,200,2.50,500.00,6000.00,1,'admin','2026-04-22 00:53:36',NULL,NULL),(13,2026,8,5,30.00,150.00,1800.00,1,'admin','2026-04-22 17:21:44',NULL,NULL);
/*!40000 ALTER TABLE `ventas_anuales` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-05-16 20:23:04
