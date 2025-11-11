-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: semillas
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `autorizaciones`
--

DROP TABLE IF EXISTS `autorizaciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `autorizaciones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `clave` varchar(255) NOT NULL,
  `modulo` varchar(100) NOT NULL,
  `usada` enum('no','si') DEFAULT 'no',
  `creado_por` int(11) DEFAULT NULL,
  `creado_en` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `autorizaciones`
--

LOCK TABLES `autorizaciones` WRITE;
/*!40000 ALTER TABLE `autorizaciones` DISABLE KEYS */;
/*!40000 ALTER TABLE `autorizaciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categorias`
--

DROP TABLE IF EXISTS `categorias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categorias` (
  `id_categoria` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `imagen` varchar(255) NOT NULL,
  PRIMARY KEY (`id_categoria`),
  UNIQUE KEY `nombre` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categorias`
--

LOCK TABLES `categorias` WRITE;
/*!40000 ALTER TABLE `categorias` DISABLE KEYS */;
INSERT INTO `categorias` VALUES (1,'Animales','Descripci?n de animales','Cat_animales.png'),(2,'Chiles','Descripci?n de chiles','Cat_Chiles'),(3,'Cuidado facial','Descripci?n de cuidado facial','Cat_cuidado_facial.jpg'),(4,'Dulces','Descripci?n de dulces','Cat_Dulces'),(5,'Enlatados','Descripci?n de enlatados','Cat_Enlatados'),(6,'Especias','Descripci?n de especias','Cat_especias.jpeg'),(7,'Higiene','Descripci?n de higiene','Cat_Higiene'),(8,'Salsas','Descripci?n de salsas','Cat_Salsas'),(9,'Semillas','Descripci?n de semillas','Cat_Semillas'),(10,'Bebidas','Diferentes bebidas','Cat_bebidas.jpg'),(17,'Sin_definir','Categor?a por defecto para productos sin categor?a asignada.','Cat_sin_definir.jpeg');
/*!40000 ALTER TABLE `categorias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categorias_relacionadas`
--

DROP TABLE IF EXISTS `categorias_relacionadas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categorias_relacionadas` (
  `id_producto1` int(11) NOT NULL,
  `id_producto2` int(11) NOT NULL,
  PRIMARY KEY (`id_producto1`,`id_producto2`),
  KEY `id_producto2` (`id_producto2`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categorias_relacionadas`
--

LOCK TABLES `categorias_relacionadas` WRITE;
/*!40000 ALTER TABLE `categorias_relacionadas` DISABLE KEYS */;
/*!40000 ALTER TABLE `categorias_relacionadas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `clientes`
--

DROP TABLE IF EXISTS `clientes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `clientes` (
  `id_cliente` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `correo` varchar(100) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_cliente`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clientes`
--

LOCK TABLES `clientes` WRITE;
/*!40000 ALTER TABLE `clientes` DISABLE KEYS */;
/*!40000 ALTER TABLE `clientes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `compras`
--

DROP TABLE IF EXISTS `compras`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `compras` (
  `id_compra` int(11) NOT NULL AUTO_INCREMENT,
  `id_proveedor` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp(),
  `total` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id_compra`),
  KEY `id_proveedor` (`id_proveedor`),
  KEY `id_usuario` (`id_usuario`),
  CONSTRAINT `compras_ibfk_1` FOREIGN KEY (`id_proveedor`) REFERENCES `proveedores` (`id_proveedor`),
  CONSTRAINT `compras_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `compras`
--

LOCK TABLES `compras` WRITE;
/*!40000 ALTER TABLE `compras` DISABLE KEYS */;
/*!40000 ALTER TABLE `compras` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `detalle_compras`
--

DROP TABLE IF EXISTS `detalle_compras`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `detalle_compras` (
  `id_detalle_compra` int(11) NOT NULL AUTO_INCREMENT,
  `id_compra` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `costo` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id_detalle_compra`),
  KEY `id_compra` (`id_compra`),
  KEY `id_producto` (`id_producto`),
  CONSTRAINT `detalle_compras_ibfk_1` FOREIGN KEY (`id_compra`) REFERENCES `compras` (`id_compra`),
  CONSTRAINT `detalle_compras_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detalle_compras`
--

LOCK TABLES `detalle_compras` WRITE;
/*!40000 ALTER TABLE `detalle_compras` DISABLE KEYS */;
/*!40000 ALTER TABLE `detalle_compras` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `detalle_ventas`
--

DROP TABLE IF EXISTS `detalle_ventas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `detalle_ventas` (
  `id_detalle` int(11) NOT NULL AUTO_INCREMENT,
  `id_venta` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id_detalle`),
  KEY `id_venta` (`id_venta`),
  KEY `id_producto` (`id_producto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detalle_ventas`
--

LOCK TABLES `detalle_ventas` WRITE;
/*!40000 ALTER TABLE `detalle_ventas` DISABLE KEYS */;
/*!40000 ALTER TABLE `detalle_ventas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `devoluciones`
--

DROP TABLE IF EXISTS `devoluciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `devoluciones` (
  `id_devolucion` int(11) NOT NULL AUTO_INCREMENT,
  `tipo` enum('Compra','Venta') NOT NULL,
  `id_referencia` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `motivo` text DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp(),
  `id_usuario` int(11) NOT NULL,
  PRIMARY KEY (`id_devolucion`),
  KEY `id_usuario` (`id_usuario`),
  KEY `id_producto` (`id_producto`),
  CONSTRAINT `devoluciones_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`),
  CONSTRAINT `devoluciones_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `devoluciones`
--

LOCK TABLES `devoluciones` WRITE;
/*!40000 ALTER TABLE `devoluciones` DISABLE KEYS */;
/*!40000 ALTER TABLE `devoluciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inventarios`
--

DROP TABLE IF EXISTS `inventarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `inventarios` (
  `id_inventario` int(11) NOT NULL AUTO_INCREMENT,
  `id_producto` int(11) NOT NULL,
  `tipo_movimiento` enum('entrada','salida','ajuste') NOT NULL,
  `cantidad` decimal(10,2) NOT NULL,
  `unidad` varchar(50) DEFAULT 'gramos',
  `motivo` varchar(255) DEFAULT NULL,
  `fecha_movimiento` datetime DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id_inventario`),
  KEY `fk_inventarios_productos` (`id_producto`),
  CONSTRAINT `fk_inventarios_productos` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inventarios`
--

LOCK TABLES `inventarios` WRITE;
/*!40000 ALTER TABLE `inventarios` DISABLE KEYS */;
/*!40000 ALTER TABLE `inventarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menuasignado`
--

DROP TABLE IF EXISTS `menuasignado`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `menuasignado` (
  `id_menuAsignado` int(11) NOT NULL AUTO_INCREMENT,
  `id_rol` int(11) NOT NULL,
  `id_menu` int(11) NOT NULL,
  PRIMARY KEY (`id_menuAsignado`),
  KEY `fk_menuAsignado_rol` (`id_rol`),
  KEY `fk_menuAsignado_menu` (`id_menu`),
  CONSTRAINT `fk_menuAsignado_menu` FOREIGN KEY (`id_menu`) REFERENCES `menus` (`id_menu`),
  CONSTRAINT `fk_menuAsignado_rol` FOREIGN KEY (`id_rol`) REFERENCES `rol` (`id_rol`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menuasignado`
--

LOCK TABLES `menuasignado` WRITE;
/*!40000 ALTER TABLE `menuasignado` DISABLE KEYS */;
INSERT INTO `menuasignado` VALUES (1,1,1),(2,1,2),(3,1,3),(4,1,4),(5,1,5),(6,1,6),(7,2,1),(8,2,2),(9,2,4),(10,2,5),(11,2,6),(12,1,7),(13,2,7),(15,1,8),(17,1,10),(18,1,9);
/*!40000 ALTER TABLE `menuasignado` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menus`
--

DROP TABLE IF EXISTS `menus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `menus` (
  `id_menu` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `icono` varchar(50) DEFAULT NULL,
  `url` varchar(100) DEFAULT NULL,
  `visible` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`id_menu`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menus`
--

LOCK TABLES `menus` WRITE;
/*!40000 ALTER TABLE `menus` DISABLE KEYS */;
INSERT INTO `menus` VALUES (1,'Inicio','P?gina de inicio del sistema','home','/home',1),(2,'Existencias','Control de inventario','inventory_2','/existencias',1),(3,'Reportes','Generaci?n de reportes de ventas','analytics','/reportes',1),(4,'Venta','M?dulo de punto de venta','shopping_cart','/venta',1),(5,'Cerrar sesi?n','Salir del sistema','logout','/logout',1),(6,'Configuraci?n','Ajustes t?cnicos del sistema','settings','/configuracion',1),(7,'Inventario','Control de existencias y movimientos','inventory','/inventarios',1),(8,'Clientes','Administraci?n de clientes','person','/clientes',1),(9,'Proveedores','Control de proveedores','local_shipping','/proveedores',1),(10,'Compras','Registro y seguimiento de compras','shopping_bag','/compras',1),(11,'Devoluciones','Control de devoluciones','assignment_return','/devoluciones',1);
/*!40000 ALTER TABLE `menus` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2025_10_03_070610_create_productos_table',1),(5,'2025_10_03_070616_create_detalle_ventas_table',1),(6,'2025_10_03_070617_add_cascade_to_detalle_ventas_foreign_key',1),(7,'2025_10_16_211123_create_menus_table',1),(8,'2025_10_30_190742_create_proveedors_table',1),(9,'2025_10_30_190743_create_clientes_table',1),(10,'2025_10_30_190744_create_compras_table',1),(11,'2025_10_30_190745_create_detalle_compras_table',1),(12,'2025_10_30_190746_create_autorizacions_table',1),(13,'2025_10_30_190746_create_devolucions_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `preferencias_notificaciones`
--

DROP TABLE IF EXISTS `preferencias_notificaciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `preferencias_notificaciones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` int(11) NOT NULL,
  `stock_bajo` enum('si','no') DEFAULT 'no',
  `venta` enum('si','no') DEFAULT 'no',
  `notificacion_interna` enum('si','no') DEFAULT 'no',
  `nuevo_producto` enum('si','no') DEFAULT 'no',
  PRIMARY KEY (`id`),
  KEY `usuario_id` (`usuario_id`),
  CONSTRAINT `fk_preferencias_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `preferencias_notificaciones`
--

LOCK TABLES `preferencias_notificaciones` WRITE;
/*!40000 ALTER TABLE `preferencias_notificaciones` DISABLE KEYS */;
INSERT INTO `preferencias_notificaciones` VALUES (1,1,'no','no','no','no');
/*!40000 ALTER TABLE `preferencias_notificaciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `productos`
--

DROP TABLE IF EXISTS `productos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `productos` (
  `id_producto` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `stock` int(11) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `costo` decimal(10,2) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `categoria_id` int(11) DEFAULT NULL,
  `imagenes` varchar(255) DEFAULT NULL,
  `stock_min` int(11) NOT NULL DEFAULT 0,
  `unidad_venta` varchar(50) NOT NULL,
  `unidad_venta_id` int(11) DEFAULT NULL,
  `ubicaciones` varchar(10) DEFAULT NULL,
  `ubicacion` varchar(10) DEFAULT NULL,
  `estado` enum('activo','inactivo') NOT NULL DEFAULT 'activo',
  `codigo_barras` varchar(100) DEFAULT NULL,
  `id_proveedor` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_producto`),
  UNIQUE KEY `codigo_barras` (`codigo_barras`),
  KEY `categoria_id` (`categoria_id`),
  KEY `fk_unidad_venta` (`unidad_venta_id`),
  KEY `fk_productos_proveedor` (`id_proveedor`),
  CONSTRAINT `fk_productos_categoria` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id_categoria`),
  CONSTRAINT `fk_productos_proveedor` FOREIGN KEY (`id_proveedor`) REFERENCES `proveedores` (`id_proveedor`),
  CONSTRAINT `fk_productos_unidad` FOREIGN KEY (`unidad_venta_id`) REFERENCES `unidades_venta` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `productos`
--

LOCK TABLES `productos` WRITE;
/*!40000 ALTER TABLE `productos` DISABLE KEYS */;
INSERT INTO `productos` VALUES (1,'Comida para Perro',3,150.00,120.00,'Alimento balanceado para perros de todas las razas.',1,'comida_perro.jpg',30,'paquetes',1,'A1','A1','activo',NULL,NULL),(2,'Juguete para Perro',150,100.00,80.00,'Juguete interactivo para perros peque?os y medianos.',1,'juguete_perro.jpg',20,'',3,'A2','A2','activo',NULL,NULL),(3,'Collar para Perro',300,50.00,35.00,'Collar ajustable y c?modo para perros.',1,'collar_perro.jpg',50,'',3,NULL,'A3','activo',NULL,NULL),(4,'Chile Habanero',500,80.00,60.00,'Chile habanero fresco, ideal para salsas y platillos picantes.',2,'chile_habanero.jpg',100,'',1,NULL,'A4','activo',NULL,NULL),(5,'Chile Seco',350,120.00,90.00,'Chile seco para condimentar sopas y salsas.',2,'chile_seco.jpg',80,'',1,NULL,'A5','activo',NULL,NULL),(6,'Chile Poblano',250,100.00,75.00,'Chile poblano fresco, ideal para asar o rellenar.',2,'chile_poblano.jpg',50,'',1,NULL,'B1','activo',NULL,NULL),(7,'Crema Hidratante',100,250.00,180.00,'Crema hidratante para el rostro, ideal para piel seca.',3,'crema_hidratante.jpg',20,'',2,NULL,'B2','activo',NULL,NULL),(8,'Jab?n Facial',200,80.00,60.00,'Jab?n facial suave para todo tipo de piel.',3,'jab?n_facial.jpg',50,'paquetes',2,NULL,'B3','activo',NULL,NULL),(9,'Exfoliante Facial',150,150.00,100.00,'Exfoliante facial con microgr?nulos, ideal para eliminar impurezas.',3,'exfoliante_facial.jpg',30,'',2,NULL,'B4','activo',NULL,NULL),(10,'Paleta Payaso',1000,20.00,10.00,'Paleta de chocolate rellena de malvavisco.',4,'paleta_payaso.jpg',100,'paquetes',1,NULL,'B5','activo',NULL,NULL),(11,'Chicles Bubbaloo',500,25.00,15.00,'Chicles de sabores variados.',4,'chicles_bubbaloo.jpg',100,'',3,NULL,'C1','activo',NULL,NULL),(12,'Galletas Marinela',600,40.00,30.00,'Galletas rellenas de crema.',4,'galletas_marinela.jpg',100,'',3,NULL,'C2','activo',NULL,NULL),(13,'At?n en lata',300,60.00,50.00,'At?n en agua de 200 g.',5,'atun_lata.jpg',50,'',4,NULL,'C3','activo',NULL,NULL),(14,'Sardinas en lata',200,50.00,40.00,'Sardinas en salsa de tomate.',5,'sardinas_lata.jpg',50,'',4,NULL,'C4','activo',NULL,NULL),(15,'Pimienta Negra',150,30.00,20.00,'Pimienta negra molida.',6,'pimienta_negra.jpg',20,'',1,NULL,'C5','activo',NULL,NULL),(16,'Canela en polvo',120,35.00,25.00,'Canela en polvo 100% natural.',6,'canela_polvo.jpg',20,'',1,NULL,'D1','activo',NULL,NULL),(17,'Cepillo Dental',200,60.00,40.00,'Cepillo dental suave, ideal para toda la familia.',7,'cepillo_dental.jpg',50,'',3,NULL,'D2','activo',NULL,NULL),(18,'Pasta Dental',150,80.00,60.00,'Pasta dental con fluor.',7,'pasta_dental.jpg',50,'',3,NULL,'D3','activo',NULL,NULL),(19,'Salsa Catsup',300,25.00,15.00,'Salsa de tomate estilo ketchup.',8,'salsa_catsup.jpg',50,'',4,NULL,'D4','activo',NULL,NULL),(20,'Salsa Picante',250,30.00,20.00,'Salsa picante de habanero.',8,'salsa_picante.jpg',50,'',4,NULL,'D5','activo',NULL,NULL),(21,'Semilla de Tomate',500,15.00,8.00,'Semilla de tomate h?brido.',9,'semilla_tomate.jpg',50,'',1,NULL,'E1','activo',NULL,NULL),(22,'Semilla de Chile',400,18.00,10.00,'Semilla de chile jalape?o.',9,'semilla_chile.jpg',50,'',1,NULL,'E2','activo',NULL,NULL),(23,'Semilla de Pepino',300,12.00,7.00,'Semilla de pepino largo.',9,'semilla_pepino.jpg',50,'',1,NULL,'E3','activo',NULL,NULL),(24,'Agua Mineral',1000,12.00,5.00,'Agua mineral embotellada 500 ml.',10,'agua_mineral.jpg',100,'',2,NULL,'E4','activo',NULL,NULL),(25,'Jugo de Naranja',800,25.00,15.00,'Jugo natural de naranja 1 L.',10,'jugo_naranja.jpg',100,'',2,NULL,'E5','activo',NULL,NULL),(26,'Refresco Cola',900,18.00,10.00,'Refresco de cola 355 ml.',10,'refresco_cola.jpg',100,'',2,NULL,'F1','activo',NULL,NULL),(27,'Cerveza',600,35.00,20.00,'Cerveza nacional 355 ml.',10,'cerveza.jpg',100,'',2,NULL,'F2','activo',NULL,NULL),(28,'Sin categor?a',0,0.00,0.00,'Producto sin categor?a asignada.',17,'sin_categoria.jpg',0,'',3,NULL,'F3','inactivo',NULL,NULL);
/*!40000 ALTER TABLE `productos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `proveedores`
--

DROP TABLE IF EXISTS `proveedores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `proveedores` (
  `id_proveedor` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `direccion` text DEFAULT NULL,
  `correo` varchar(100) DEFAULT NULL,
  `estado` enum('Activo','Inactivo') DEFAULT 'Activo',
  PRIMARY KEY (`id_proveedor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `proveedores`
--

LOCK TABLES `proveedores` WRITE;
/*!40000 ALTER TABLE `proveedores` DISABLE KEYS */;
/*!40000 ALTER TABLE `proveedores` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rol`
--

DROP TABLE IF EXISTS `rol`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rol` (
  `id_rol` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `descripcion` text DEFAULT NULL,
  PRIMARY KEY (`id_rol`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rol`
--

LOCK TABLES `rol` WRITE;
/*!40000 ALTER TABLE `rol` DISABLE KEYS */;
INSERT INTO `rol` VALUES (1,'Administrador','Rol con todos los permisos'),(2,'Empleado','Rol con permisos limitados');
/*!40000 ALTER TABLE `rol` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `unidades_venta`
--

DROP TABLE IF EXISTS `unidades_venta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `unidades_venta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `unidades_venta`
--

LOCK TABLES `unidades_venta` WRITE;
/*!40000 ALTER TABLE `unidades_venta` DISABLE KEYS */;
INSERT INTO `unidades_venta` VALUES (1,'Paquete'),(2,'Litro'),(3,'Unidad'),(4,'Caja');
/*!40000 ALTER TABLE `unidades_venta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `apellido_paterno` varchar(50) NOT NULL,
  `apellido_materno` varchar(50) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  `direccion` text DEFAULT NULL,
  `estado` enum('Activo','Inactivo') DEFAULT 'Activo',
  `correo_electronico` varchar(100) NOT NULL,
  `id_rolAsignado` int(11) NOT NULL,
  `foto_perfil` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_usuario`),
  UNIQUE KEY `usuario` (`usuario`),
  UNIQUE KEY `correo_electronico` (`correo_electronico`),
  KEY `fk_usuarios_rol` (`id_rolAsignado`),
  CONSTRAINT `fk_usuarios_rol` FOREIGN KEY (`id_rolAsignado`) REFERENCES `rol` (`id_rol`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (1,'Ana','Carmona','Aviles','admin','$2y$12$Yh9UEqg3GdI5vMAGpDBwMO34nvk.IaQNa3VvVRZiMDxFOD4soq0uO','Oficina Central','Activo','carmonaavilesanakaren@gmail.com',1,NULL),(2,'Ciclalli','L?pez','Mart?nez','ciclalli','$2y$12$n1.qqC06pP51cT9.K/I4nODpPh0axtxiv3S.NTpJkfC3uYxwqVPvG','Sucursal Norte','Activo','jaquincfyupvt@gmail.com',2,NULL),(3,'Cardoso','Ram?rez','Vega','cardoso','$2y$12$U3YPcEEopyKZxvZQ17vtCOJZB0dcjPlDIMDD8f1Zi42Qh1DPgnetK','Sucursal Sur','Activo','ani.cardo004@gmail.com',2,NULL);
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ventas`
--

DROP TABLE IF EXISTS `ventas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ventas` (
  `id_venta` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp(),
  `id_usuario` int(11) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id_venta`),
  KEY `id_usuario` (`id_usuario`),
  CONSTRAINT `fk_ventas_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ventas`
--

LOCK TABLES `ventas` WRITE;
/*!40000 ALTER TABLE `ventas` DISABLE KEYS */;
/*!40000 ALTER TABLE `ventas` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-10-31  0:07:25
