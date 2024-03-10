SET FOREIGN_KEY_CHECKS=0;

CREATE DATABASE IF NOT EXISTS basedatosvd;

USE basedatosvd;

DROP TABLE IF EXISTS categorias;

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `categoria` text NOT NULL,
  `descripcion` text NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO categorias VALUES("21","Café Divinass","Encontraras 15 tipos de cafés","2024-01-11 23:11:22");
INSERT INTO categorias VALUES("31","Suplementos","Encontraras 16 tipos de suplementos","2023-12-15 09:10:52");



DROP TABLE IF EXISTS clientes;

CREATE TABLE `clientes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` text NOT NULL,
  `apellidoPa` varchar(45) NOT NULL,
  `apellidoMa` varchar(45) NOT NULL,
  `documento` int(11) NOT NULL,
  `email` text NOT NULL,
  `telefono` text NOT NULL,
  `direccion` text NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `compras` int(11) NOT NULL,
  `ultima_compra` datetime NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO clientes VALUES("22","Maria Fernanda","Boyas","Guzman","99","cajo200007@upemor.edu.mx","(777) 589-6565","calle pera #13 col bugas","1991-02-22","61","2024-03-04 11:24:00","2024-03-04 10:24:00");
INSERT INTO clientes VALUES("28","Jonathan","Hernandez","Arroyo","2111","fernanda_bg@outlook.es","(123) 123-1231","calle golondrinas 14","2011-11-11","9","2024-03-04 09:45:54","2024-03-04 08:45:54");
INSERT INTO clientes VALUES("29","Isabela","Boyas","Guzman","1002","isabela@gmail.com","(213) 123-1231","sdfasdf sadfasdf ","2012-03-12","0","0000-00-00 00:00:00","2024-03-07 23:05:58");
INSERT INTO clientes VALUES("30","sadfsadf","sdfsadf","sdfadsf","12221","sdfsa@sadf.com","(213) 123-1231","asdfsadf sadfasdf ","2012-03-12","0","0000-00-00 00:00:00","2024-03-07 23:06:28");



DROP TABLE IF EXISTS descuentos;

CREATE TABLE `descuentos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_producto` int(11) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `descuento` decimal(5,2) DEFAULT NULL,
  `fecha_inicio` timestamp NULL DEFAULT NULL,
  `fecha_final` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

INSERT INTO descuentos VALUES("57","75","tendra descuento este producto","10.00","2024-03-05 00:00:00","2024-03-07");
INSERT INTO descuentos VALUES("58","74","ojojoj","50.00","2024-03-05 00:00:00","2024-03-08");
INSERT INTO descuentos VALUES("59","76","popppp","12.00","2024-03-05 00:00:00","2024-03-05");



DROP TABLE IF EXISTS eventos;

CREATE TABLE `eventos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `fecha_inicio` datetime NOT NULL,
  `fecha_final` datetime NOT NULL,
  `descripcion` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;




DROP TABLE IF EXISTS productos;

CREATE TABLE `productos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_categoria` int(11) NOT NULL,
  `codigo` text NOT NULL,
  `descripcion` text NOT NULL,
  `imagen` text NOT NULL,
  `stock` int(11) NOT NULL,
  `precio_compra` float NOT NULL,
  `precio_venta` float NOT NULL,
  `ventas` int(11) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fecha_caducidad` date NOT NULL,
  `descuento_activo` int(11) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=79 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO productos VALUES("74","21","2101","Prueba1","vistas/img/productos/2101/985.png","3","112","156.8","7","2024-03-04 10:23:27","0000-00-00","1");
INSERT INTO productos VALUES("75","31","3101","Prueba2","vistas/img/productos/3101/392.png","93","100","200","8","2024-03-04 10:20:18","0000-00-00","1");
INSERT INTO productos VALUES("76","31","3102","prueba4","vistas/img/productos/3102/149.png","5","100","200","5","2024-03-04 10:24:00","0000-00-00","1");
INSERT INTO productos VALUES("77","21","2102","hoal","vistas/img/productos/2102/814.png","9","111","155.4","1","2024-03-04 10:24:00","0000-00-00","0");
INSERT INTO productos VALUES("78","21","2103","gjhghghjgjasdas","vistas/img/productos/2103/597.png","122","1231","1723.4","1","2024-03-04 10:23:27","0000-00-00","0");



DROP TABLE IF EXISTS prueba;

CREATE TABLE `prueba` (
  `sadf` int(11) NOT NULL,
  `asd` int(11) NOT NULL,
  `asdf` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;




DROP TABLE IF EXISTS schedule_list;

CREATE TABLE `schedule_list` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `description` text NOT NULL,
  `start_datetime` datetime NOT NULL,
  `end_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO schedule_list VALUES("42","prueba","asdfd","2024-02-26 10:13:00","2024-02-28 10:10:00");



DROP TABLE IF EXISTS usuarios;

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` text NOT NULL,
  `apellidoPa` text DEFAULT NULL,
  `apellidoMa` text NOT NULL,
  `usuario` text NOT NULL,
  `password` text NOT NULL,
  `perfil` text NOT NULL,
  `foto` text NOT NULL,
  `estado` int(11) NOT NULL,
  `ultimo_login` datetime NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `correo` varchar(45) DEFAULT NULL,
  `token_recuperacion` varchar(255) DEFAULT NULL,
  `expiracion_token` datetime DEFAULT NULL,
  `recuperacion_completada` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=85 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO usuarios VALUES("68","gerenteb","a","asd","gerente","$2a$07$asxx54ahjppf45sd87a5aurxwsuKZ45wFSbiNfdS6xl.3y0E2/122","Especial","vistas/img/usuarios/gerente/569.png","1","2024-03-08 14:13:21","2024-03-08 13:13:21","sadf@asdfasd.com","","0000-00-00 00:00:00","0");
INSERT INTO usuarios VALUES("69","vendedor","vendedor","vendedor","vendedor","$2y$10$SoOELUZwI6/9DVOkea2NFeS93RRqig0lENUaS4g5oHlxsEiK9WXmi","Vendedor","vistas/img/usuarios/vendedor/113.png","1","2024-03-08 14:11:06","2024-03-08 13:11:29","vendedor@gmail.com","","0000-00-00 00:00:00","0");
INSERT INTO usuarios VALUES("84","jonathan","Modificar","Modificar","jonathan01","$2y$10$1PcEzEie0TtJwhYNPooMYOVD52oWFk7rmZY0.8aUS7z.F7A70o5tS","Administrador","vistas/img/usuarios/jonathan01/350.png","1","2024-03-08 14:33:04","2024-03-08 13:33:04","Modificar","","0000-00-00 00:00:00","0");



DROP TABLE IF EXISTS ventas;

CREATE TABLE `ventas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `codigo` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `id_vendedor` int(11) NOT NULL,
  `productos` text NOT NULL,
  `impuesto` float NOT NULL,
  `neto` float NOT NULL,
  `total` float NOT NULL,
  `metodo_pago` text NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=69 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO ventas VALUES("50","10001","15","83","[{\"id\":\"62\",\"descripcion\":\"Cx99\",\"cantidad\":\"13\",\"stock\":\"8\",\"precio\":\"2000\",\"total\":\"26000\"},{\"id\":\"61\",\"descripcion\":\"Black Tea\",\"cantidad\":\"1\",\"stock\":\"11\",\"precio\":\"1800\",\"total\":\"1800\"}]","0","27800","27800","Efectivo","2024-02-19 01:52:56");
INSERT INTO ventas VALUES("51","10002","15","83","[{\"id\":\"62\",\"descripcion\":\"Cx99\",\"cantidad\":\"5\",\"stock\":\"3\",\"precio\":\"2000\",\"total\":\"10000\"},{\"id\":\"61\",\"descripcion\":\"Black Tea\",\"cantidad\":\"2\",\"stock\":\"9\",\"precio\":\"1800\",\"total\":\"3600\"}]","0","13600","13600","Efectivo","2024-02-19 01:53:53");
INSERT INTO ventas VALUES("52","10003","15","83","[{\"id\":\"62\",\"descripcion\":\"Cx99\",\"cantidad\":\"1\",\"stock\":\"2\",\"precio\":\"2000\",\"total\":\"2000\"},{\"id\":\"61\",\"descripcion\":\"Black Tea\",\"cantidad\":\"3\",\"stock\":\"6\",\"precio\":\"1800\",\"total\":\"5400\"}]","0","7400","7400","Efectivo","2024-01-19 01:55:12");
INSERT INTO ventas VALUES("53","10004","15","83","[{\"id\":\"62\",\"descripcion\":\"Cx99\",\"cantidad\":\"10\",\"stock\":\"12\",\"precio\":\"2000\",\"total\":\"20000\"},{\"id\":\"61\",\"descripcion\":\"Black Tea\",\"cantidad\":\"10\",\"stock\":\"50\",\"precio\":\"1800\",\"total\":\"18000\"}]","0","38000","38000","Efectivo","2023-12-19 01:56:34");
INSERT INTO ventas VALUES("54","10005","27","83","[{\"id\":\"62\",\"descripcion\":\"Cx99\",\"cantidad\":\"1\",\"stock\":\"11\",\"precio\":\"2000\",\"total\":\"2000\"},{\"id\":\"61\",\"descripcion\":\"Black Tea\",\"cantidad\":\"1\",\"stock\":\"49\",\"precio\":\"1800\",\"total\":\"1800\"}]","0","3800","3800","Efectivo","2023-11-19 01:58:30");
INSERT INTO ventas VALUES("55","10006","22","83","[{\"id\":\"62\",\"descripcion\":\"Cx99\",\"cantidad\":\"10\",\"stock\":\"1\",\"precio\":\"2000\",\"total\":\"20000\"},{\"id\":\"61\",\"descripcion\":\"Black Tea\",\"cantidad\":\"30\",\"stock\":\"19\",\"precio\":\"1800\",\"total\":\"54000\"}]","0","74000","74000","Efectivo","2022-11-19 01:59:29");
INSERT INTO ventas VALUES("56","10007","28","75","[{\"id\":\"71\",\"descripcion\":\"pueba\",\"cantidad\":\"2\",\"stock\":\"9\",\"precio\":\"14\",\"total\":\"28\"}]","0.56","28","28.56","Efectivo","2024-02-29 19:16:25");
INSERT INTO ventas VALUES("57","10008","22","75","[{\"id\":\"72\",\"descripcion\":\"gjhghghjgj\",\"cantidad\":\"1\",\"stock\":\"122\",\"precio\":\"16.8\",\"total\":\"16.8\"},{\"id\":\"71\",\"descripcion\":\"pueba\",\"cantidad\":\"4\",\"stock\":\"5\",\"precio\":\"14\",\"total\":\"56\"},{\"id\":\"70\",\"descripcion\":\"asdf\",\"cantidad\":\"1\",\"stock\":\"9\",\"precio\":\"1709.4\",\"total\":\"1709.4\"}]","0","1782.2","1782.2","Efectivo","2024-02-29 19:48:10");
INSERT INTO ventas VALUES("58","10009","22","84","[{\"id\":\"75\",\"descripcion\":\"Prueba2\",\"cantidad\":\"1\",\"stock\":\"100\",\"precio\":\"200\",\"total\":\"200\"}]","400","200","600","Efectivo","2024-03-04 07:58:48");
INSERT INTO ventas VALUES("59","10010","22","84","[{\"id\":\"75\",\"descripcion\":\"Prueba2\",\"cantidad\":\"1\",\"stock\":\"99\",\"precio\":\"200\",\"total\":\"200\"}]","0","200","200","Efectivo","2024-03-04 08:00:07");
INSERT INTO ventas VALUES("60","10011","22","84","[{\"id\":\"75\",\"descripcion\":\"Prueba2\",\"cantidad\":\"1\",\"stock\":\"98\",\"precio\":\"200\",\"total\":\"200\"},{\"id\":\"74\",\"descripcion\":\"Prueba1\",\"cantidad\":\"1\",\"stock\":\"9\",\"precio\":\"156.8\",\"total\":\"156.8\"}]","0","356.8","356.8","Efectivo","2024-03-04 08:01:42");
INSERT INTO ventas VALUES("61","10012","22","84","[{\"id\":\"75\",\"descripcion\":\"Prueba2\",\"cantidad\":\"1\",\"stock\":\"97\",\"precio\":\"200\",\"total\":\"200\"},{\"id\":\"74\",\"descripcion\":\"Prueba1\",\"cantidad\":\"1\",\"stock\":\"8\",\"precio\":\"156.8\",\"total\":\"156.8\"}]","0","356.8","356.8","Efectivo","2024-03-04 08:06:49");
INSERT INTO ventas VALUES("62","10013","22","84","[{\"id\":\"75\",\"descripcion\":\"Prueba2\",\"cantidad\":\"1\",\"stock\":\"96\",\"precio\":\"200\",\"total\":\"200\"},{\"id\":\"74\",\"descripcion\":\"Prueba1\",\"cantidad\":\"1\",\"stock\":\"7\",\"precio\":\"156.8\",\"total\":\"156.8\"}]","0","356.8","356.8","Efectivo","2024-03-04 08:17:59");
INSERT INTO ventas VALUES("63","10014","28","84","[{\"id\":\"76\",\"descripcion\":\"prueba4\",\"cantidad\":\"1\",\"stock\":\"9\",\"precio\":\"200\",\"total\":\"200\"}]","0","200","200","Efectivo","2024-03-04 08:37:36");
INSERT INTO ventas VALUES("64","10015","28","84","[{\"id\":\"75\",\"descripcion\":\"Prueba2\",\"cantidad\":\"1\",\"stock\":\"95\",\"precio\":\"200\",\"total\":\"200\"},{\"id\":\"74\",\"descripcion\":\"Prueba1\",\"cantidad\":\"1\",\"stock\":\"6\",\"precio\":\"156.8\",\"total\":\"156.8\"},{\"id\":\"76\",\"descripcion\":\"prueba4\",\"cantidad\":\"1\",\"stock\":\"8\",\"precio\":\"200\",\"total\":\"200\"}]","0","556.8","556.8","Efectivo","2024-03-04 08:41:13");
INSERT INTO ventas VALUES("65","10016","28","84","[{\"id\":\"76\",\"descripcion\":\"prueba4\",\"cantidad\":\"1\",\"stock\":\"7\",\"precio\":\"176\",\"total\":\"176\"},{\"id\":\"75\",\"descripcion\":\"Prueba2\",\"cantidad\":\"1\",\"stock\":\"94\",\"precio\":\"180\",\"total\":\"180\"},{\"id\":\"74\",\"descripcion\":\"Prueba1\",\"cantidad\":\"1\",\"stock\":\"5\",\"precio\":\"78.4\",\"total\":\"78.4\"}]","0","434.4","434.4","Efectivo","2024-03-04 08:45:54");
INSERT INTO ventas VALUES("66","10017","22","84","[{\"id\":\"76\",\"descripcion\":\"prueba4\",\"cantidad\":\"1\",\"stock\":\"6\",\"precio\":\"176\",\"total\":\"176\"},{\"id\":\"75\",\"descripcion\":\"Prueba2\",\"cantidad\":\"1\",\"stock\":\"93\",\"precio\":\"180\",\"total\":\"180\"},{\"id\":\"74\",\"descripcion\":\"Prueba1\",\"cantidad\":\"1\",\"stock\":\"4\",\"precio\":\"78.4\",\"total\":\"78.4\"}]","0","434.4","434.4","Efectivo","2024-03-04 10:20:18");
INSERT INTO ventas VALUES("67","10018","22","84","[{\"id\":\"78\",\"descripcion\":\"gjhghghjgjasdas\",\"cantidad\":\"1\",\"stock\":\"122\",\"precio\":\"1723.4\",\"total\":\"1723.4\"},{\"id\":\"74\",\"descripcion\":\"Prueba1\",\"cantidad\":\"1\",\"stock\":\"3\",\"precio\":\"78.4\",\"total\":\"78.4\"}]","0","1801.8","1801.8","Efectivo","2024-03-04 10:23:27");
INSERT INTO ventas VALUES("68","10019","22","84","[{\"id\":\"77\",\"descripcion\":\"hoal\",\"cantidad\":\"1\",\"stock\":\"9\",\"precio\":\"155.4\",\"total\":\"155.4\"},{\"id\":\"76\",\"descripcion\":\"prueba4\",\"cantidad\":\"1\",\"stock\":\"5\",\"precio\":\"176\",\"total\":\"176\"}]","0","331.4","331.4","Efectivo","2024-03-04 10:24:00");



SET FOREIGN_KEY_CHECKS=1;