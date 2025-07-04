-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3307
-- Tiempo de generación: 05-07-2025 a las 00:39:36
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `colombianocomacontento`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `Consultar_Años_Disponibles` ()   BEGIN
    SELECT DISTINCT YEAR(fecha) AS año
    FROM venta
    ORDER BY año DESC;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Consultar_Detalle_Venta_Por_Id` (IN `p_id_venta` INT)   BEGIN
    SELECT
        v.id_venta,
        v.fecha,
        v.valor_total,
        p.id_plato,
        p.nombre AS nombre_plato,
        dv.cantidad_platos,
        dv.precio_unitario,
        dv.subtotal
    FROM venta v
    JOIN detalle_venta dv ON v.id_venta = dv.id_venta
    JOIN plato p ON dv.id_plato = p.id_plato
    WHERE v.id_venta = p_id_venta;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Consultar_Resumen_Ventas_Por_Mes` (IN `p_año` INT)   BEGIN
    SELECT
        YEAR(v.fecha) AS año,
        MONTH(v.fecha) AS mes,
        SUM(v.valor_total) AS total_ventas,
        COUNT(v.id_venta) AS cantidad_ventas
    FROM venta v
    WHERE (p_año IS NULL OR YEAR(v.fecha) = p_año)
    GROUP BY YEAR(v.fecha), MONTH(v.fecha)
    ORDER BY año DESC, mes DESC;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Consultar_Ventas_Plato_Por_Mes_Año` (IN `p_mes` INT, IN `p_año` INT)   BEGIN
    SELECT
        p.id_plato,
        p.nombre AS nombre_plato,
        SUM(dv.cantidad_platos) AS cantidad_vendida,
        SUM(dv.subtotal) AS total_vendido
    FROM detalle_venta dv
    JOIN plato p ON dv.id_plato = p.id_plato
    JOIN venta v ON dv.id_venta = v.id_venta
    WHERE MONTH(v.fecha) = p_mes AND YEAR(v.fecha) = p_año
    GROUP BY p.id_plato, p.nombre
    ORDER BY total_vendido DESC;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carta`
--

CREATE TABLE `carta` (
  `id_carta` int(11) NOT NULL,
  `fecha_inicio` date DEFAULT NULL,
  `fecha_fin` date DEFAULT NULL,
  `es_vigente` tinyint(1) DEFAULT NULL,
  `descripcion` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `carta`
--

INSERT INTO `carta` (`id_carta`, `fecha_inicio`, `fecha_fin`, `es_vigente`, `descripcion`) VALUES
(1, '2023-01-01', '2023-03-31', 0, 'Carta de temporada de verano'),
(2, '2023-04-01', '2023-06-30', 0, 'Carta de temporada de invierno'),
(3, '2023-07-01', '2023-09-30', 1, 'Carta actual de temporada'),
(7, '2025-05-05', '2050-05-05', 0, 'penepenepenepenepenepenepenepenepene'),
(8, '2016-06-06', '2060-06-06', 0, 'asdasdASDasda');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carta_plato`
--

CREATE TABLE `carta_plato` (
  `id_carta` int(11) NOT NULL,
  `id_plato` int(11) NOT NULL,
  `orden` int(11) DEFAULT NULL COMMENT 'Orden de aparición en la carta'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `carta_plato`
--

INSERT INTO `carta_plato` (`id_carta`, `id_plato`, `orden`) VALUES
(1, 1, 1),
(1, 2, 2),
(1, 3, 3),
(1, 4, 4),
(1, 5, 5),
(1, 6, 6),
(1, 7, 7),
(1, 8, 8),
(1, 9, 9),
(1, 10, 10),
(1, 11, 11),
(1, 12, 12),
(1, 13, 13),
(1, 14, 14),
(1, 15, 15),
(2, 16, 1),
(2, 17, 2),
(2, 18, 3),
(2, 19, 4),
(2, 20, 5),
(2, 21, 6),
(2, 22, 7),
(2, 23, 8),
(2, 24, 9),
(2, 25, 10),
(2, 26, 11),
(2, 27, 12),
(2, 28, 13),
(2, 29, 14),
(2, 30, 15),
(3, 1, 1),
(3, 3, 2),
(3, 5, 3),
(3, 7, 4),
(3, 9, 5),
(3, 11, 6),
(3, 13, 7),
(3, 15, 8),
(3, 17, 9),
(3, 19, 10),
(3, 21, 11),
(3, 23, 12),
(3, 25, 13),
(3, 27, 14),
(3, 29, 15);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `id_cat` int(11) NOT NULL,
  `nombre` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`id_cat`, `nombre`) VALUES
(1, 'Sopas'),
(2, 'Arroces'),
(3, 'Carnes'),
(4, 'Pollo'),
(5, 'Pescados y Mariscos'),
(6, 'Postres');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_venta`
--

CREATE TABLE `detalle_venta` (
  `cantidad_platos` int(11) DEFAULT NULL,
  `precio_unitario` decimal(10,2) DEFAULT NULL,
  `subtotal` decimal(10,2) DEFAULT NULL,
  `id_venta` int(11) NOT NULL,
  `id_plato` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `detalle_venta`
--

INSERT INTO `detalle_venta` (`cantidad_platos`, `precio_unitario`, `subtotal`, `id_venta`, `id_plato`) VALUES
(1, 25000.00, 25000.00, 1, 1),
(2, 50000.00, 100000.00, 1, 4),
(1, 25000.00, 25000.00, 1, 9),
(1, 30000.00, 30000.00, 2, 2),
(1, 15000.00, 15000.00, 2, 10),
(1, 8000.00, 8000.00, 2, 18),
(1, 22000.00, 22000.00, 2, 19),
(1, 32000.00, 32000.00, 3, 4),
(1, 28000.00, 28000.00, 4, 3),
(1, 10000.00, 10000.00, 4, 14),
(1, 7000.00, 7000.00, 4, 21),
(1, 15000.00, 15000.00, 5, 10),
(1, 35000.00, 35000.00, 5, 16),
(1, 18000.00, 18000.00, 5, 17),
(1, 29000.00, 29000.00, 6, 15),
(1, 38000.00, 38000.00, 7, 11),
(1, 10000.00, 10000.00, 7, 14),
(1, 7000.00, 7000.00, 7, 21),
(1, 22000.00, 22000.00, 8, 7),
(1, 8000.00, 8000.00, 8, 18),
(1, 8000.00, 8000.00, 8, 28),
(1, 18000.00, 18000.00, 9, 6),
(1, 12000.00, 12000.00, 9, 23),
(1, 31000.00, 31000.00, 9, 27),
(1, 2000.00, 2000.00, 9, 30),
(1, 12000.00, 12000.00, 10, 9),
(1, 24000.00, 24000.00, 10, 20),
(1, 5000.00, 5000.00, 10, 30),
(1, 27000.00, 27000.00, 11, 5),
(1, 8000.00, 8000.00, 11, 18),
(1, 18000.00, 18000.00, 11, 29),
(1, 26000.00, 26000.00, 12, 12),
(1, 15000.00, 15000.00, 12, 25),
(1, 6000.00, 6000.00, 12, 26),
(1, 20000.00, 20000.00, 13, 13),
(1, 10000.00, 10000.00, 13, 14),
(1, 6000.00, 6000.00, 13, 26),
(1, 30000.00, 30000.00, 14, 2),
(1, 15000.00, 15000.00, 14, 10),
(1, 22000.00, 22000.00, 14, 19),
(1, 5000.00, 5000.00, 14, 30),
(1, 35000.00, 35000.00, 15, 8),
(1, 18000.00, 18000.00, 15, 17),
(1, 5000.00, 5000.00, 15, 30),
(1, 15000.00, 15000.00, 16, 10),
(1, 19000.00, 19000.00, 16, 29),
(1, 5000.00, 5000.00, 16, 30),
(1, 28000.00, 28000.00, 17, 3),
(1, 22000.00, 22000.00, 17, 7),
(1, 12000.00, 12000.00, 17, 23),
(1, 2000.00, 2000.00, 17, 30),
(1, 32000.00, 32000.00, 18, 4),
(1, 15000.00, 15000.00, 18, 25),
(1, 4000.00, 4000.00, 18, 30),
(1, 27000.00, 27000.00, 19, 5),
(1, 12000.00, 12000.00, 19, 9),
(1, 2000.00, 2000.00, 19, 30),
(1, 38000.00, 38000.00, 20, 11),
(1, 22000.00, 22000.00, 20, 19),
(1, 7000.00, 7000.00, 20, 21),
(1, 25000.00, 25000.00, 21, 1),
(1, 18000.00, 18000.00, 21, 17),
(1, 6000.00, 6000.00, 21, 26),
(1, 18000.00, 18000.00, 22, 6),
(1, 29000.00, 29000.00, 22, 15),
(1, 7000.00, 7000.00, 22, 21),
(1, 24000.00, 24000.00, 23, 20),
(1, 12000.00, 12000.00, 23, 23),
(1, 1000.00, 1000.00, 23, 30),
(1, 22000.00, 22000.00, 24, 7),
(1, 31000.00, 31000.00, 24, 27),
(1, 8000.00, 8000.00, 24, 28),
(1, 26000.00, 26000.00, 25, 12),
(1, 8000.00, 8000.00, 25, 18),
(1, 18000.00, 18000.00, 25, 29),
(1, 18000.00, 18000.00, 26, 6),
(1, 20000.00, 20000.00, 26, 13),
(1, 10000.00, 10000.00, 26, 14),
(1, 35000.00, 35000.00, 27, 16),
(1, 22000.00, 22000.00, 27, 19),
(1, 12000.00, 12000.00, 27, 23),
(1, 28000.00, 28000.00, 28, 3),
(1, 10000.00, 10000.00, 28, 14),
(1, 18000.00, 18000.00, 28, 17),
(1, 18000.00, 18000.00, 29, 6),
(1, 15000.00, 15000.00, 29, 10),
(1, 9000.00, 9000.00, 29, 22),
(1, 30000.00, 30000.00, 30, 2),
(1, 22000.00, 22000.00, 30, 7),
(1, 15000.00, 15000.00, 30, 10),
(1, 6000.00, 6000.00, 30, 26);

--
-- Disparadores `detalle_venta`
--
DELIMITER $$
CREATE TRIGGER `trg_delete_detalle_venta` AFTER DELETE ON `detalle_venta` FOR EACH ROW BEGIN
  DECLARE region_id INT;
  DECLARE total_plato DECIMAL(10,2);
  DECLARE cantidad INT;

  SELECT p.id_reg, OLD.cantidad_platos * p.precio_base
  INTO region_id, total_plato
  FROM plato p
  WHERE p.id_plato = OLD.id_plato;

  SET cantidad = OLD.cantidad_platos;

  UPDATE total_ventas_region
  SET 
    total_cantidad = total_cantidad - cantidad,
    total_venta = total_venta - total_plato
  WHERE id_region = region_id;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_insert_detalle_venta` AFTER INSERT ON `detalle_venta` FOR EACH ROW BEGIN
  DECLARE region_id INT;
  DECLARE total_plato DECIMAL(10,2);
  DECLARE cantidad INT;
  DECLARE nombre VARCHAR(100);

  SELECT p.id_reg, r.nombre, NEW.cantidad_platos * p.precio_base
  INTO region_id, nombre, total_plato
  FROM plato p
  JOIN region r ON p.id_reg = r.id_reg
  WHERE p.id_plato = NEW.id_plato;

  SET cantidad = NEW.cantidad_platos;

  INSERT INTO total_ventas_region (id_region, nombre_region, total_cantidad, total_venta)
  VALUES (region_id, nombre, cantidad, total_plato)
  ON DUPLICATE KEY UPDATE 
    total_cantidad = total_cantidad + cantidad,
    total_venta = total_venta + total_plato;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_update_detalle_venta` AFTER UPDATE ON `detalle_venta` FOR EACH ROW BEGIN
  DECLARE region_id INT;
  DECLARE viejo_total DECIMAL(10,2);
  DECLARE nuevo_total DECIMAL(10,2);
  DECLARE cantidad_diff INT;

  SELECT p.id_reg INTO region_id
  FROM plato p
  WHERE p.id_plato = NEW.id_plato;

  SET viejo_total = OLD.cantidad_platos * (SELECT precio_base FROM plato WHERE id_plato = OLD.id_plato);
  SET nuevo_total = NEW.cantidad_platos * (SELECT precio_base FROM plato WHERE id_plato = NEW.id_plato);
  SET cantidad_diff = NEW.cantidad_platos - OLD.cantidad_platos;

  UPDATE total_ventas_region
  SET 
    total_cantidad = total_cantidad + cantidad_diff,
    total_venta = total_venta - viejo_total + nuevo_total
  WHERE id_region = region_id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `encargado`
--

CREATE TABLE `encargado` (
  `id_enc` int(11) NOT NULL,
  `nombre` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `encargado`
--

INSERT INTO `encargado` (`id_enc`, `nombre`) VALUES
(1, 'Carlos Martínez'),
(2, 'Ana Gómez'),
(3, 'Luis Ramírez'),
(4, 'María Rodríguez'),
(5, 'Jorge Pérez'),
(6, 'Sofía López'),
(7, 'Pedro Sánchez'),
(8, 'Laura García'),
(9, 'Andrés Fernández'),
(10, 'Carmen Díaz'),
(11, 'Juan Castro'),
(12, 'Patricia Ruiz'),
(13, 'Diego Hernández'),
(14, 'Elena Muñoz'),
(15, 'Fernando Ortega'),
(16, 'Isabel Jiménez'),
(17, 'Ricardo Torres'),
(18, 'Adriana Vargas'),
(19, 'Oscar Mendoza'),
(20, 'Lucía Rojas'),
(21, 'Mario Silva'),
(22, 'Natalia Peña'),
(23, 'Héctor Guzmán'),
(24, 'Verónica Herrera'),
(25, 'Alberto Núñez'),
(26, 'Diana Medina'),
(27, 'Raúl Cortés'),
(28, 'Gabriela Ríos'),
(29, 'Felipe Mora'),
(30, 'Silvia Castillo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ingrediente`
--

CREATE TABLE `ingrediente` (
  `id_ing` int(11) NOT NULL,
  `nombre` varchar(45) DEFAULT NULL,
  `unidad_medida` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `ingrediente`
--

INSERT INTO `ingrediente` (`id_ing`, `nombre`, `unidad_medida`) VALUES
(1, 'Arroz', 'gramos'),
(2, 'Papa', 'gramos'),
(3, 'Pollo', 'gramos'),
(4, 'Carne de res', 'gramos'),
(5, 'Pescado', 'gramos'),
(6, 'Camarones', 'gramos'),
(7, 'Plátano', 'unidades'),
(8, 'Yuca', 'gramos'),
(9, 'Huevos', 'unidades'),
(10, 'Leche', 'mililitros'),
(11, 'Queso', 'gramos'),
(12, 'Maíz', 'gramos'),
(13, 'Aguacate', 'unidades'),
(14, 'Tomate', 'gramos'),
(15, 'Cebolla', 'gramos'),
(16, 'Ajo', 'gramos'),
(17, 'Cilantro', 'gramos'),
(18, 'Ají', 'gramos'),
(19, 'Panela', 'gramos'),
(20, 'Harina', 'gramos'),
(21, 'Mantequilla', 'gramos'),
(22, 'Aceite', 'mililitros'),
(23, 'Sal', 'gramos'),
(24, 'Pimienta', 'gramos'),
(25, 'Comino', 'gramos'),
(26, 'Chocolate', 'gramos'),
(27, 'Vainilla', 'mililitros'),
(28, 'Canela', 'gramos'),
(29, 'Limón', 'unidades'),
(30, 'Azúcar', 'gramos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `momento_consumo`
--

CREATE TABLE `momento_consumo` (
  `id_mc` int(11) NOT NULL,
  `momento` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `momento_consumo`
--

INSERT INTO `momento_consumo` (`id_mc`, `momento`) VALUES
(1, 'Desayuno'),
(2, 'Almuerzo'),
(3, 'Cena');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nivel_complejidad`
--

CREATE TABLE `nivel_complejidad` (
  `id_nivel` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `nivel_complejidad`
--

INSERT INTO `nivel_complejidad` (`id_nivel`, `nombre`, `descripcion`) VALUES
(1, 'Fácil', 'Platos simples con pocos ingredientes y técnicas básicas'),
(2, 'Sencillo', 'Preparaciones con pasos simples pero que requieren atención'),
(3, 'Intermedio', 'Platos que requieren múltiples pasos y técnicas'),
(4, 'Difícil', 'Preparaciones complejas con técnicas avanzadas'),
(5, 'Gourmet', 'Alta cocina con técnicas profesionales e ingredientes especiales');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `plato`
--

CREATE TABLE `plato` (
  `id_plato` int(11) NOT NULL,
  `nombre` varchar(45) DEFAULT NULL,
  `descripcion` longtext DEFAULT NULL,
  `precio_base` decimal(10,2) DEFAULT NULL,
  `id_nivel` int(11) DEFAULT NULL,
  `foto` text DEFAULT NULL,
  `id_cat` int(11) DEFAULT NULL,
  `id_mc` int(11) DEFAULT NULL,
  `id_reg` int(11) DEFAULT NULL,
  `id_enc` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `plato`
--

INSERT INTO `plato` (`id_plato`, `nombre`, `descripcion`, `precio_base`, `id_nivel`, `foto`, `id_cat`, `id_mc`, `id_reg`, `id_enc`) VALUES
(1, 'Ajiaco', 'Sopa típica bogotana con pollo, papa y guascas', 25000.00, 2, 'img/platos/ajiaco.png', 1, 2, 1, 1),
(2, 'Bandeja Paisa', 'Plato típico antioqueño con frijoles, arroz, carne y más', 30000.00, 3, 'bandeja_paisa.jpg', 3, 2, 1, 2),
(3, 'Sancocho de Gallina', 'Sopa espesa con gallina, yuca y plátano', 28000.00, 3, 'sancocho.jpg', 1, 2, 3, 3),
(4, 'Lechona', 'Cerdo relleno con arroz y especias', 32000.00, 4, 'lechona.jpg', 3, 2, 1, 4),
(5, 'Mojarra Frita', 'Pescado frito típico de la región Caribe', 27000.00, 2, 'mojarra.jpg', 5, 2, 3, 5),
(6, 'Arroz con Coco', 'Arroz preparado con leche de coco', 18000.00, 2, 'arroz_coco.jpg', 2, 2, 3, 6),
(7, 'Tamal Tolimense', 'Masa de maíz con carne y vegetales envuelta en hoja', 22000.00, 4, 'tamal.jpg', 3, 1, 1, 7),
(8, 'Hormigas Culonas', 'Hormigas tostadas típicas de Santander', 35000.00, 1, 'hormigas.jpg', 3, 3, 1, 8),
(9, 'Changua', 'Sopa de leche con huevo para desayuno', 12000.00, 1, 'changua.jpg', 1, 1, 1, 9),
(10, 'Arepa de Huevo', 'Arepa frita rellena de huevo', 15000.00, 2, 'img/platos/ArepaHuevo.jpg', 4, 1, 3, 10),
(11, 'Cazuela de Mariscos', 'Mezcla de mariscos en salsa de coco', 38000.00, 4, 'cazuela.jpg', 5, 2, 3, 11),
(12, 'Mute Santandereano', 'Sopa espesa con carne y maíz', 26000.00, 3, 'mute.jpg', 1, 2, 1, 12),
(13, 'Arroz Atollado', 'Arroz con pollo y cerdo', 20000.00, 2, 'img/platos/arrozatollado.jpg', 2, 2, 4, 13),
(14, 'Patacones', 'Plátanos verdes aplastados y fritos', 10000.00, 1, 'patacones.jpg', 4, 3, 3, 14),
(15, 'Pescado a la Llanera', 'Pescado asado al estilo llanero', 29000.00, 3, 'pescado_llanero.jpg', 5, 2, 2, 15),
(16, 'Mamona', 'Carne de ternera asada al estilo llanero', 35000.00, 3, 'mamona.jpg', 3, 2, 2, 16),
(17, 'Cuchuco de Trigo', 'Sopa espesa con trigo y carne', 18000.00, 2, 'cuchuco.jpg', 1, 2, 1, 17),
(18, 'Empanadas', 'Masa de maíz rellena de carne', 8000.00, 1, 'empanadas.jpg', 3, 3, 1, 18),
(19, 'Arroz con Pollo', 'Arroz amarillo con pollo y vegetales', 22000.00, 2, 'arroz_pollo.jpg', 2, 2, 1, 19),
(20, 'Sudado de Pollo', 'Pollo cocinado en salsa de tomate', 24000.00, 2, 'sudado.jpg', 4, 2, 1, 20),
(21, 'Cocada', 'Dulce de coco típico de la costa', 7000.00, 1, 'cocada.jpg', 6, 3, 3, 21),
(22, 'Postre de Natas', 'Dulce hecho con la nata de la leche', 9000.00, 2, 'natas.jpg', 6, 3, 1, 22),
(23, 'Aborrajados', 'Plátanos maduros rellenos de queso', 12000.00, 2, 'img/platos/aborrajados.jpg', 6, 3, 3, 23),
(24, 'Chicharrón', 'Carne de cerdo frita crujiente', 18000.00, 1, 'chicharron.jpg', 3, 3, 1, 24),
(25, 'Caldo de Costilla', 'Sopa de huesos y carne para desayuno', 15000.00, 1, 'caldo_costilla.jpg', 1, 1, 1, 25),
(26, 'Pandebono', 'Pan de queso y almidón de yuca', 6000.00, 1, 'pandebono.jpg', 6, 1, 1, 26),
(27, 'Pargo Rojo Frito', 'Pescado frito típico del Pacífico', 31000.00, 2, 'pargo.jpg', 5, 2, 4, 27),
(28, 'Envueltos de Mazorca', 'Tamales dulces de maíz', 8000.00, 2, 'envueltos.jpg', 6, 3, 1, 28),
(29, 'Fríjoles Antioqueños', 'Fríjoles con carne y plátano', 19000.00, 2, 'frijoles.jpg', 3, 2, 1, 29),
(30, 'Buñuelos', 'Bolitas fritas de queso y harina', 5000.00, 1, 'bunuelos.jpg', 6, 1, 1, 30),
(31, 'Calentado Paisa', 'Plato con arroz, frijoles, huevo y arepa con queso', 15000.00, 1, 'img/platos/684586de829a0_calentado.jpeg', 2, 1, 1, 1),
(32, 'Envuelto boyacense ', 'Masa de maíz con queso envuelta en hoja de plátano ', 3500.00, 3, 'img/platos/68458a187c336_envuelto.jpg', 6, 1, 1, 19),
(33, 'Palitos de queso', 'Palitos hechos de harina de trigo rellenos de queso', 2500.00, 3, 'img/platos/68458def932dc_Palitos.jpg', 6, 2, 1, 10),
(34, 'Pan de bono', 'Pan de bono', 5000.00, 1, 'img/platos/68479297bd2f1_pandebono.jpg', 6, 1, 1, 9);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `plato_ingrediente`
--

CREATE TABLE `plato_ingrediente` (
  `cantidad` decimal(10,2) DEFAULT NULL,
  `id_plato` int(11) NOT NULL,
  `id_ing` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `plato_ingrediente`
--

INSERT INTO `plato_ingrediente` (`cantidad`, `id_plato`, `id_ing`) VALUES
(300.00, 1, 2),
(200.00, 1, 3),
(50.00, 1, 15),
(20.00, 1, 16),
(10.00, 1, 17),
(200.00, 2, 1),
(150.00, 2, 4),
(2.00, 2, 7),
(100.00, 2, 11),
(1.00, 2, 13),
(200.00, 3, 3),
(2.00, 3, 7),
(150.00, 3, 8),
(50.00, 3, 15),
(20.00, 3, 16),
(500.00, 4, 1),
(1000.00, 4, 4),
(100.00, 4, 15),
(50.00, 4, 16),
(20.00, 4, 25),
(1.00, 5, 5),
(20.00, 5, 16),
(30.00, 5, 22),
(10.00, 5, 23),
(5.00, 5, 24),
(200.00, 6, 1),
(100.00, 6, 12),
(50.00, 6, 22),
(5.00, 6, 23),
(10.00, 6, 25),
(150.00, 7, 4),
(2.00, 7, 7),
(50.00, 7, 15),
(20.00, 7, 16),
(200.00, 7, 20),
(20.00, 8, 22),
(10.00, 8, 23),
(5.00, 8, 24),
(50.00, 8, 30),
(2.00, 9, 9),
(200.00, 9, 10),
(10.00, 9, 17),
(10.00, 9, 23),
(5.00, 9, 24),
(1.00, 10, 9),
(150.00, 10, 20),
(20.00, 10, 22),
(5.00, 10, 23),
(100.00, 11, 5),
(200.00, 11, 6),
(50.00, 11, 12),
(20.00, 11, 16),
(100.00, 11, 22),
(100.00, 12, 2),
(200.00, 12, 4),
(150.00, 12, 12),
(50.00, 12, 15),
(20.00, 12, 16),
(200.00, 13, 1),
(150.00, 13, 3),
(100.00, 13, 4),
(50.00, 13, 15),
(20.00, 13, 16),
(2.00, 14, 7),
(30.00, 14, 22),
(5.00, 14, 23),
(1.00, 15, 5),
(20.00, 15, 16),
(10.00, 15, 17),
(50.00, 15, 22),
(5.00, 15, 24),
(300.00, 16, 4),
(50.00, 16, 23),
(10.00, 16, 24),
(20.00, 16, 25),
(100.00, 17, 4),
(50.00, 17, 15),
(20.00, 17, 16),
(10.00, 17, 17),
(150.00, 17, 20),
(100.00, 18, 4),
(50.00, 18, 15),
(20.00, 18, 16),
(150.00, 18, 20),
(30.00, 18, 22),
(200.00, 19, 1),
(150.00, 19, 3),
(50.00, 19, 15),
(20.00, 19, 16),
(10.00, 19, 17),
(200.00, 20, 3),
(100.00, 20, 14),
(50.00, 20, 15),
(20.00, 20, 16),
(10.00, 20, 17),
(200.00, 21, 12),
(50.00, 21, 26),
(100.00, 21, 30),
(200.00, 22, 10),
(5.00, 22, 28),
(100.00, 22, 30),
(2.00, 23, 7),
(50.00, 23, 11),
(30.00, 23, 22),
(50.00, 23, 30),
(200.00, 24, 4),
(30.00, 24, 22),
(5.00, 24, 23),
(150.00, 25, 2),
(200.00, 25, 4),
(50.00, 25, 15),
(20.00, 25, 16),
(10.00, 25, 17),
(50.00, 26, 8),
(1.00, 26, 9),
(100.00, 26, 11),
(150.00, 26, 20),
(1.00, 27, 5),
(20.00, 27, 16),
(30.00, 27, 22),
(10.00, 27, 23),
(5.00, 27, 24),
(200.00, 28, 12),
(50.00, 28, 26),
(5.00, 28, 28),
(100.00, 28, 30),
(150.00, 29, 4),
(2.00, 29, 7),
(200.00, 29, 12),
(50.00, 29, 15),
(20.00, 29, 16),
(1.00, 30, 9),
(100.00, 30, 11),
(150.00, 30, 20),
(50.00, 30, 30);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `region`
--

CREATE TABLE `region` (
  `id_reg` int(11) NOT NULL,
  `nombre` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `region`
--

INSERT INTO `region` (`id_reg`, `nombre`) VALUES
(1, 'Andina'),
(2, 'Llanos Orientales'),
(3, 'Caribe'),
(4, 'Pacífica'),
(5, 'Amazonía');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `total_ventas_region`
--

CREATE TABLE `total_ventas_region` (
  `id_region` int(11) NOT NULL,
  `nombre_region` varchar(100) DEFAULT NULL,
  `total_cantidad` int(11) DEFAULT 0,
  `total_venta` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `total_ventas_region`
--

INSERT INTO `total_ventas_region` (`id_region`, `nombre_region`, `total_cantidad`, `total_venta`) VALUES
(1, 'Andina', 2, 64000.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `venta`
--

CREATE TABLE `venta` (
  `id_venta` int(11) NOT NULL,
  `fecha` date DEFAULT NULL,
  `valor_total` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `venta`
--

INSERT INTO `venta` (`id_venta`, `fecha`, `valor_total`) VALUES
(1, '2023-01-05', 50000.00),
(2, '2023-01-07', 75000.00),
(3, '2023-01-10', 32000.00),
(4, '2023-01-12', 45000.00),
(5, '2023-01-15', 68000.00),
(6, '2023-01-18', 29000.00),
(7, '2023-01-20', 55000.00),
(8, '2023-01-22', 38000.00),
(9, '2023-01-25', 62000.00),
(10, '2023-01-28', 41000.00),
(11, '2023-02-02', 53000.00),
(12, '2023-02-05', 47000.00),
(13, '2023-02-08', 36000.00),
(14, '2023-02-11', 72000.00),
(15, '2023-02-14', 58000.00),
(16, '2023-02-17', 39000.00),
(17, '2023-02-20', 64000.00),
(18, '2023-02-23', 51000.00),
(19, '2023-02-26', 43000.00),
(20, '2023-03-01', 67000.00),
(21, '2023-03-04', 49000.00),
(22, '2023-03-07', 54000.00),
(23, '2024-03-10', 37000.00),
(24, '2023-03-13', 61000.00),
(25, '2023-03-16', 52000.00),
(26, '2023-03-19', 48000.00),
(27, '2023-03-22', 69000.00),
(28, '2023-03-25', 56000.00),
(29, '2023-03-28', 42000.00),
(30, '2023-03-31', 73000.00);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vistasventasdetalle`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vistasventasdetalle` (
`id_venta` int(11)
,`fecha` date
,`valor_total` decimal(10,2)
,`id_plato` int(11)
,`nombre_plato` varchar(45)
,`cantidad_platos` int(11)
,`precio_unitario` decimal(10,2)
,`subtotal` decimal(10,2)
,`año_venta` int(4)
,`mes_venta` int(2)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vistasventaspormomento`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vistasventaspormomento` (
`id_mc` int(11)
,`nombre_momento` varchar(45)
,`id_plato` int(11)
,`nombre_plato` varchar(45)
,`cantidad_vendida` decimal(32,0)
,`total_vendido` decimal(32,2)
,`mes_venta` int(2)
,`año_venta` int(4)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vistasventasporregion`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vistasventasporregion` (
`id_reg` int(11)
,`nombre_region` varchar(45)
,`id_plato` int(11)
,`nombre_plato` varchar(45)
,`cantidad_vendida` decimal(32,0)
,`total_vendido` decimal(32,2)
,`año_venta` int(4)
,`mes_venta` int(2)
);

-- --------------------------------------------------------

--
-- Estructura para la vista `vistasventasdetalle`
--
DROP TABLE IF EXISTS `vistasventasdetalle`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vistasventasdetalle`  AS SELECT `v`.`id_venta` AS `id_venta`, `v`.`fecha` AS `fecha`, `v`.`valor_total` AS `valor_total`, `dv`.`id_plato` AS `id_plato`, `p`.`nombre` AS `nombre_plato`, `dv`.`cantidad_platos` AS `cantidad_platos`, `dv`.`precio_unitario` AS `precio_unitario`, `dv`.`subtotal` AS `subtotal`, year(`v`.`fecha`) AS `año_venta`, month(`v`.`fecha`) AS `mes_venta` FROM ((`venta` `v` join `detalle_venta` `dv` on(`v`.`id_venta` = `dv`.`id_venta`)) join `plato` `p` on(`dv`.`id_plato` = `p`.`id_plato`)) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vistasventaspormomento`
--
DROP TABLE IF EXISTS `vistasventaspormomento`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vistasventaspormomento`  AS SELECT `mc`.`id_mc` AS `id_mc`, `mc`.`momento` AS `nombre_momento`, `p`.`id_plato` AS `id_plato`, `p`.`nombre` AS `nombre_plato`, sum(`dv`.`cantidad_platos`) AS `cantidad_vendida`, sum(`dv`.`subtotal`) AS `total_vendido`, month(`v`.`fecha`) AS `mes_venta`, year(`v`.`fecha`) AS `año_venta` FROM (((`detalle_venta` `dv` join `plato` `p` on(`dv`.`id_plato` = `p`.`id_plato`)) join `momento_consumo` `mc` on(`p`.`id_mc` = `mc`.`id_mc`)) join `venta` `v` on(`dv`.`id_venta` = `v`.`id_venta`)) GROUP BY `mc`.`id_mc`, `mc`.`momento`, `p`.`id_plato`, `p`.`nombre`, month(`v`.`fecha`), year(`v`.`fecha`) ORDER BY `mc`.`momento` ASC, sum(`dv`.`subtotal`) DESC ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vistasventasporregion`
--
DROP TABLE IF EXISTS `vistasventasporregion`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vistasventasporregion`  AS SELECT `r`.`id_reg` AS `id_reg`, `r`.`nombre` AS `nombre_region`, `p`.`id_plato` AS `id_plato`, `p`.`nombre` AS `nombre_plato`, sum(`dv`.`cantidad_platos`) AS `cantidad_vendida`, sum(`dv`.`subtotal`) AS `total_vendido`, year(`v`.`fecha`) AS `año_venta`, month(`v`.`fecha`) AS `mes_venta` FROM (((`venta` `v` join `detalle_venta` `dv` on(`v`.`id_venta` = `dv`.`id_venta`)) join `plato` `p` on(`dv`.`id_plato` = `p`.`id_plato`)) join `region` `r` on(`p`.`id_reg` = `r`.`id_reg`)) GROUP BY `r`.`id_reg`, `r`.`nombre`, `p`.`id_plato`, `p`.`nombre`, year(`v`.`fecha`), month(`v`.`fecha`) ORDER BY `r`.`nombre` ASC, sum(`dv`.`subtotal`) DESC ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `carta`
--
ALTER TABLE `carta`
  ADD PRIMARY KEY (`id_carta`);

--
-- Indices de la tabla `carta_plato`
--
ALTER TABLE `carta_plato`
  ADD PRIMARY KEY (`id_carta`,`id_plato`),
  ADD KEY `fk_cartaplato_plato` (`id_plato`);

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`id_cat`);

--
-- Indices de la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  ADD PRIMARY KEY (`id_venta`,`id_plato`),
  ADD KEY `fk_dv_plato` (`id_plato`);

--
-- Indices de la tabla `encargado`
--
ALTER TABLE `encargado`
  ADD PRIMARY KEY (`id_enc`);

--
-- Indices de la tabla `ingrediente`
--
ALTER TABLE `ingrediente`
  ADD PRIMARY KEY (`id_ing`);

--
-- Indices de la tabla `momento_consumo`
--
ALTER TABLE `momento_consumo`
  ADD PRIMARY KEY (`id_mc`);

--
-- Indices de la tabla `nivel_complejidad`
--
ALTER TABLE `nivel_complejidad`
  ADD PRIMARY KEY (`id_nivel`);

--
-- Indices de la tabla `plato`
--
ALTER TABLE `plato`
  ADD PRIMARY KEY (`id_plato`),
  ADD KEY `fk_plato_categoria` (`id_cat`),
  ADD KEY `fk_plato_momento` (`id_mc`),
  ADD KEY `fk_plato_region` (`id_reg`),
  ADD KEY `fk_plato_encargado` (`id_enc`),
  ADD KEY `fk_plato_nivel_complejidad` (`id_nivel`);

--
-- Indices de la tabla `plato_ingrediente`
--
ALTER TABLE `plato_ingrediente`
  ADD PRIMARY KEY (`id_plato`,`id_ing`),
  ADD KEY `fk_pi_ingrediente` (`id_ing`);

--
-- Indices de la tabla `region`
--
ALTER TABLE `region`
  ADD PRIMARY KEY (`id_reg`);

--
-- Indices de la tabla `total_ventas_region`
--
ALTER TABLE `total_ventas_region`
  ADD PRIMARY KEY (`id_region`);

--
-- Indices de la tabla `venta`
--
ALTER TABLE `venta`
  ADD PRIMARY KEY (`id_venta`);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `carta_plato`
--
ALTER TABLE `carta_plato`
  ADD CONSTRAINT `fk_cartaplato_carta` FOREIGN KEY (`id_carta`) REFERENCES `carta` (`id_carta`),
  ADD CONSTRAINT `fk_cartaplato_plato` FOREIGN KEY (`id_plato`) REFERENCES `plato` (`id_plato`);

--
-- Filtros para la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  ADD CONSTRAINT `fk_dv_plato` FOREIGN KEY (`id_plato`) REFERENCES `plato` (`id_plato`),
  ADD CONSTRAINT `fk_dv_venta` FOREIGN KEY (`id_venta`) REFERENCES `venta` (`id_venta`);

--
-- Filtros para la tabla `plato`
--
ALTER TABLE `plato`
  ADD CONSTRAINT `fk_plato_categoria` FOREIGN KEY (`id_cat`) REFERENCES `categoria` (`id_cat`),
  ADD CONSTRAINT `fk_plato_encargado` FOREIGN KEY (`id_enc`) REFERENCES `encargado` (`id_enc`),
  ADD CONSTRAINT `fk_plato_momento` FOREIGN KEY (`id_mc`) REFERENCES `momento_consumo` (`id_mc`),
  ADD CONSTRAINT `fk_plato_nivel_complejidad` FOREIGN KEY (`id_nivel`) REFERENCES `nivel_complejidad` (`id_nivel`),
  ADD CONSTRAINT `fk_plato_region` FOREIGN KEY (`id_reg`) REFERENCES `region` (`id_reg`);

--
-- Filtros para la tabla `plato_ingrediente`
--
ALTER TABLE `plato_ingrediente`
  ADD CONSTRAINT `fk_pi_ingrediente` FOREIGN KEY (`id_ing`) REFERENCES `ingrediente` (`id_ing`),
  ADD CONSTRAINT `fk_pi_plato` FOREIGN KEY (`id_plato`) REFERENCES `plato` (`id_plato`);

--
-- Filtros para la tabla `total_ventas_region`
--
ALTER TABLE `total_ventas_region`
  ADD CONSTRAINT `fk_region_ventas` FOREIGN KEY (`id_region`) REFERENCES `region` (`id_reg`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
