-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 09-09-2025 a las 20:02:33
-- Versión del servidor: 8.4.3
-- Versión de PHP: 8.2.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `auto`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actas_entrega`
--

CREATE TABLE `actas_entrega` (
  `id` bigint UNSIGNED NOT NULL,
  `cotizacion_id` bigint UNSIGNED NOT NULL,
  `codigo` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `fecha_entrega` date NOT NULL,
  `persona_entrega` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `vehiculo_detalle` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `placa` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `kilometraje` int NOT NULL,
  `nivel_combustible` int NOT NULL,
  `estado` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `observaciones` text COLLATE utf8mb4_general_ci,
  `documento_firmado` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `check_manual` tinyint(1) DEFAULT '0',
  `check_garantia` tinyint(1) DEFAULT '0',
  `check_tarjeta` tinyint(1) DEFAULT '0',
  `check_soat` tinyint(1) DEFAULT '0',
  `check_llave` tinyint(1) DEFAULT '0',
  `check_gata` tinyint(1) DEFAULT '0',
  `check_rueda` tinyint(1) DEFAULT '0',
  `check_herramientas` tinyint(1) DEFAULT '0',
  `check_carroceria` tinyint(1) DEFAULT '0',
  `check_pintura` tinyint(1) DEFAULT '0',
  `check_lunas` tinyint(1) DEFAULT '0',
  `check_llantas` tinyint(1) DEFAULT '0',
  `check_asientos` tinyint(1) DEFAULT '0',
  `check_tablero` tinyint(1) DEFAULT '0',
  `check_radio` tinyint(1) DEFAULT '0',
  `check_climatizacion` tinyint(1) DEFAULT '0',
  `check_motor` tinyint(1) DEFAULT '0',
  `check_luces` tinyint(1) DEFAULT '0',
  `check_frenos` tinyint(1) DEFAULT '0',
  `check_direccion` tinyint(1) DEFAULT '0',
  `check_bateria` tinyint(1) DEFAULT '0',
  `check_arranque` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `adelantos`
--

CREATE TABLE `adelantos` (
  `id` bigint UNSIGNED NOT NULL,
  `cita_id` bigint UNSIGNED NOT NULL,
  `monto` decimal(10,2) NOT NULL,
  `metodo_pago` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `adelantos`
--

INSERT INTO `adelantos` (`id`, `cita_id`, `monto`, `metodo_pago`, `created_at`, `updated_at`) VALUES
(1, 1, 1500.00, 'efectivo', '2025-04-29 20:39:24', '2025-04-29 20:39:24'),
(2, 2, 500.00, 'efectivo', '2025-04-30 04:46:26', '2025-04-30 04:46:26');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `almacenes`
--

CREATE TABLE `almacenes` (
  `id` bigint UNSIGNED NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `direccion` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `es_vehiculos` tinyint(1) NOT NULL DEFAULT '0',
  `centro_costo_id` bigint UNSIGNED NOT NULL,
  `parent_id` bigint UNSIGNED DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `almacenes`
--

INSERT INTO `almacenes` (`id`, `nombre`, `direccion`, `es_vehiculos`, `centro_costo_id`, `parent_id`, `activo`, `created_at`, `updated_at`) VALUES
(1, 'Almacen 1', 'Av. Atahualpa 152, Cajamarca', 1, 1, NULL, 1, '2025-03-27 23:29:57', '2025-03-27 23:29:57'),
(2, 'Subalmacen', 'Av. Heroes del Cenepa 556', 0, 1, 1, 1, '2025-03-28 00:24:42', '2025-03-28 00:24:42');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `almacen_items`
--

CREATE TABLE `almacen_items` (
  `id` bigint UNSIGNED NOT NULL,
  `almacen_id` bigint UNSIGNED NOT NULL,
  `item_id` bigint UNSIGNED NOT NULL,
  `tipo_item` enum('parte','vehiculo') COLLATE utf8mb4_general_ci NOT NULL,
  `stock` decimal(10,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `anios_modelo`
--

CREATE TABLE `anios_modelo` (
  `id` bigint UNSIGNED NOT NULL,
  `marca_id` bigint UNSIGNED NOT NULL,
  `modelo_id` bigint UNSIGNED NOT NULL,
  `version_id` bigint UNSIGNED NOT NULL,
  `anio` int NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `moneda` enum('SOL','USD') COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `anios_modelo`
--

INSERT INTO `anios_modelo` (`id`, `marca_id`, `modelo_id`, `version_id`, `anio`, `precio`, `moneda`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 2023, 25000.00, 'USD', '2025-03-28 03:20:27', '2025-03-28 03:20:27'),
(2, 2, 1, 1, 2025, 50000.00, 'SOL', '2025-04-20 05:10:04', '2025-04-20 05:10:04');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bancos`
--

CREATE TABLE `bancos` (
  `id` int NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `bancos`
--

INSERT INTO `bancos` (`id`, `nombre`, `created_at`, `updated_at`) VALUES
(1, 'BCP', '2025-03-28 04:37:21', '2025-03-28 04:37:21'),
(2, 'Interbank', '2025-03-28 04:37:27', '2025-03-28 04:37:27'),
(3, 'BBVA', '2025-03-28 04:37:33', '2025-03-28 04:37:33');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `canal_captacion`
--

CREATE TABLE `canal_captacion` (
  `id` bigint UNSIGNED NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `canal_captacion`
--

INSERT INTO `canal_captacion` (`id`, `nombre`, `created_at`, `updated_at`) VALUES
(1, 'Campañas', '2025-03-20 12:25:17', '2025-03-20 12:25:17'),
(2, 'Piso', '2025-03-20 12:25:17', '2025-03-20 12:25:17'),
(3, 'Redes sociales', '2025-03-20 12:25:17', '2025-03-20 12:25:17'),
(4, 'Web', '2025-03-20 12:25:17', '2025-03-20 12:25:17'),
(5, 'Recomendación', '2025-03-20 12:25:17', '2025-03-20 12:25:17');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cargos`
--

CREATE TABLE `cargos` (
  `id` bigint UNSIGNED NOT NULL,
  `nombre_cargo` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cargos`
--

INSERT INTO `cargos` (`id`, `nombre_cargo`, `created_at`, `updated_at`) VALUES
(1, 'Gerente', '2025-03-20 18:20:24', '2025-03-20 18:20:24'),
(2, 'Administrador', '2025-03-20 19:37:18', '2025-03-20 19:37:18');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `catalogos`
--

CREATE TABLE `catalogos` (
  `id` bigint UNSIGNED NOT NULL,
  `marca_id` bigint UNSIGNED NOT NULL,
  `modelo_id` bigint UNSIGNED NOT NULL,
  `version_id` bigint UNSIGNED NOT NULL,
  `anio_modelo_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `fotografia` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `catalogos`
--

INSERT INTO `catalogos` (`id`, `marca_id`, `modelo_id`, `version_id`, `anio_modelo_id`, `created_at`, `updated_at`, `fotografia`) VALUES
(1, 1, 1, 1, 1, '2025-03-28 03:20:45', '2025-04-25 04:13:59', 'C:\\xampp\\tmp\\phpC0B7.tmp'),
(6, 2, 1, 1, 1, '2025-04-25 04:15:02', '2025-04-25 04:27:22', 'vehiculos/83WXnqN0eIjxISCP6OkK1C1buSMTPn7s5S1pdKFE.png'),
(7, 3, 2, 1, 2, '2025-04-25 22:02:54', '2025-04-25 22:02:54', 'vehiculos/TBjnRAaNdiDMmtXqBxU4NbMAQbyqibNEnHOcSENU.png'),
(8, 3, 1, 1, 1, '2025-08-19 04:11:12', '2025-08-19 04:11:12', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias_partes`
--

CREATE TABLE `categorias_partes` (
  `id` bigint UNSIGNED NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_general_ci,
  `descuento` decimal(5,2) DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias_partes`
--

INSERT INTO `categorias_partes` (`id`, `nombre`, `descripcion`, `descuento`, `created_at`, `updated_at`) VALUES
(1, 'Cate Part A', NULL, 0.00, '2025-03-28 03:22:54', '2025-03-28 03:22:54'),
(2, 'CAT 55', NULL, 0.00, '2025-04-20 02:53:51', '2025-04-20 02:53:51');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias_proveedor`
--

CREATE TABLE `categorias_proveedor` (
  `id` int NOT NULL,
  `nombre_categoria_proveedor` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias_proveedor`
--

INSERT INTO `categorias_proveedor` (`id`, `nombre_categoria_proveedor`, `created_at`, `updated_at`) VALUES
(1, 'Categoria Proveedor A', '2025-03-28 04:45:58', '2025-03-28 04:45:58'),
(2, 'Cat B', '2025-04-20 02:19:21', '2025-04-20 02:19:21');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias_servicios_tercerizados`
--

CREATE TABLE `categorias_servicios_tercerizados` (
  `id` bigint UNSIGNED NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias_servicios_tercerizados`
--

INSERT INTO `categorias_servicios_tercerizados` (`id`, `nombre`, `created_at`, `updated_at`) VALUES
(1, 'Propios', '2025-04-20 03:57:58', '2025-04-20 03:57:58'),
(2, 'Terceros', '2025-04-20 03:58:08', '2025-04-20 03:58:08');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria_clientes`
--

CREATE TABLE `categoria_clientes` (
  `id` bigint UNSIGNED NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categoria_clientes`
--

INSERT INTO `categoria_clientes` (`id`, `nombre`, `created_at`, `updated_at`) VALUES
(1, 'Nueva categoría', '2025-03-20 16:50:01', '2025-03-20 16:50:01'),
(2, 'Otra categoría', '2025-03-20 16:56:03', '2025-03-20 16:56:03');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `centros_costos`
--

CREATE TABLE `centros_costos` (
  `id` bigint UNSIGNED NOT NULL,
  `codigo` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_general_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `centros_costos`
--

INSERT INTO `centros_costos` (`id`, `codigo`, `nombre`, `descripcion`, `created_at`, `updated_at`) VALUES
(1, '1', 'MSA Cajamarca', 'Nuevo', '2025-03-20 19:12:14', '2025-03-20 19:12:14');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `citas_mantenimiento`
--

CREATE TABLE `citas_mantenimiento` (
  `id` bigint UNSIGNED NOT NULL,
  `vehiculo_id` bigint UNSIGNED NOT NULL,
  `cliente_id` bigint UNSIGNED NOT NULL,
  `fecha_hora_cita` datetime NOT NULL,
  `motivo_visita` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `descripcion_problema` text COLLATE utf8mb4_general_ci,
  `estado` enum('pendiente','confirmada','en_progreso','completada','cancelada') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'pendiente',
  `tecnico_id` bigint UNSIGNED DEFAULT NULL,
  `notas_adicionales` text COLLATE utf8mb4_general_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `citas_mantenimiento`
--

INSERT INTO `citas_mantenimiento` (`id`, `vehiculo_id`, `cliente_id`, `fecha_hora_cita`, `motivo_visita`, `descripcion_problema`, `estado`, `tecnico_id`, `notas_adicionales`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2025-04-30 11:38:00', 'SSSS', 'SSSS', 'confirmada', 2, NULL, '2025-04-29 20:39:24', '2025-04-29 20:50:20'),
(2, 2, 1, '2025-04-30 07:00:00', 'mmmmmmmm', 'sasasasasasasasasasasasa', 'confirmada', 2, 'aaaaaa', '2025-04-30 04:46:26', '2025-04-30 04:46:56');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id` bigint UNSIGNED NOT NULL,
  `documento_identidad` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `tipo_cliente` enum('natural','juridica') COLLATE utf8mb4_general_ci NOT NULL,
  `apellido_paterno` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `apellido_materno` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nombres` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `razon_social` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `departamento` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `provincia` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `distrito` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `correo` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `categoria_cliente_id` bigint UNSIGNED NOT NULL,
  `canal_captacion_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id`, `documento_identidad`, `tipo_cliente`, `apellido_paterno`, `apellido_materno`, `nombres`, `razon_social`, `departamento`, `provincia`, `distrito`, `correo`, `categoria_cliente_id`, `canal_captacion_id`, `created_at`, `updated_at`) VALUES
(1, '42511978', 'natural', 'Chavez', 'Gamboa', 'Edwin Hernan', NULL, 'Cajamarca', 'Cajamarca', 'Cajamarca', 'quipuh@gmail.com', 1, 1, '2025-03-20 17:28:05', '2025-03-20 17:28:05'),
(2, '73461219', 'natural', 'LOPEZ', 'MEDRANO', 'JHEYDY MERCEDES', NULL, 'Arequipa', 'Arequipa', 'Arequipa', 'correo@gmail.com', 2, 4, '2025-03-20 19:33:28', '2025-03-20 19:33:28'),
(3, '20100190797', 'juridica', NULL, NULL, NULL, 'LECHE GLORIA SOCIEDAD ANONIMA - GLORIA S.A.', 'ICA', 'ICA', 'ICA', 'aaa@gmail.com', 1, 1, '2025-03-28 23:53:09', '2025-03-28 23:53:09'),
(4, '42511979', 'natural', 'SANCHEZ', 'ZEVALLOS', 'JOSE DEMETRIO', NULL, 'AREQUIPA', 'CARAVELI', 'ATICO', 'aaa@gmail.com', 2, 1, '2025-03-28 23:57:23', '2025-03-28 23:57:23'),
(5, '26611596', 'natural', 'FERNANDEZ', 'LEIVA', 'MARIA AMPARO', NULL, 'ANCASH', 'ANTONIO RAYMONDI', 'ACZO', 'aaa@gmail.com', 1, 1, '2025-03-29 01:16:32', '2025-03-29 01:16:32'),
(6, '42519856', 'natural', 'GONZALES', 'GONZALES', 'JESSICA PAOLA', NULL, 'CAJAMARCA', 'CAJAMARCA', 'CAJAMARCA', 'aaa@gmail.com', 2, 2, '2025-04-30 10:36:22', '2025-04-30 10:36:22');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `colores`
--

CREATE TABLE `colores` (
  `id` bigint UNSIGNED NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `hexadecimal` varchar(7) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `colores`
--

INSERT INTO `colores` (`id`, `nombre`, `hexadecimal`, `created_at`, `updated_at`) VALUES
(1, 'Rojo', '#ef1d22', '2025-03-28 03:15:55', '2025-03-28 03:15:55'),
(2, 'Negro', '#000000', '2025-04-25 21:58:43', '2025-04-25 21:58:43');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `combustibles`
--

CREATE TABLE `combustibles` (
  `id` bigint UNSIGNED NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `combustibles`
--

INSERT INTO `combustibles` (`id`, `nombre`, `created_at`, `updated_at`) VALUES
(1, 'Diesel', '2025-03-27 22:19:44', '2025-03-27 22:19:50'),
(2, 'Gasolina', '2025-03-27 22:19:52', '2025-03-27 22:19:55');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentarios_seguimiento`
--

CREATE TABLE `comentarios_seguimiento` (
  `id` bigint UNSIGNED NOT NULL,
  `seguimiento_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `contenido` text COLLATE utf8mb4_general_ci NOT NULL,
  `archivo` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `comentarios_seguimiento`
--

INSERT INTO `comentarios_seguimiento` (`id`, `seguimiento_id`, `user_id`, `contenido`, `archivo`, `created_at`, `updated_at`) VALUES
(1, 2, 1, '111', NULL, '2025-04-25 21:54:31', '2025-04-25 21:54:31'),
(2, 16, 1, 'dfgfdsgfdsgfdg', NULL, '2025-09-07 13:21:37', '2025-09-07 13:21:37'),
(3, 16, 1, 'ggggggggg', 'comentarios/1757233305_Imagen de WhatsApp 2025-09-07 a las 02.04.22_b980969a.jpg', '2025-09-07 13:21:46', '2025-09-07 13:21:46'),
(4, 17, 1, 'fdgdfgdfgdf', 'comentarios/1757233322_Imagen de WhatsApp 2025-09-07 a las 02.04.22_b980969a.jpg', '2025-09-07 13:22:02', '2025-09-07 13:22:02'),
(5, 17, 1, 'sdfadasdsa', 'comentarios/1757233418_Imagen de WhatsApp 2025-09-07 a las 02.10.41_8311eacd.jpg', '2025-09-07 13:23:38', '2025-09-07 13:23:38'),
(6, 17, 1, 'sss', NULL, '2025-09-07 13:23:54', '2025-09-07 13:23:54'),
(7, 16, 1, '33', NULL, '2025-09-07 13:26:41', '2025-09-07 13:26:41');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentarios_seguimiento_orden`
--

CREATE TABLE `comentarios_seguimiento_orden` (
  `id` bigint UNSIGNED NOT NULL,
  `seguimiento_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `contenido` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `archivo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `comentarios_seguimiento_orden`
--

INSERT INTO `comentarios_seguimiento_orden` (`id`, `seguimiento_id`, `user_id`, `contenido`, `archivo`, `created_at`, `updated_at`) VALUES
(1, 9, 1, 'hola', NULL, '2025-04-30 09:22:31', '2025-04-30 09:22:31'),
(2, 9, 1, 'hola', NULL, '2025-04-30 09:22:31', '2025-04-30 09:22:31'),
(3, 11, 1, '333', NULL, '2025-04-30 09:30:05', '2025-04-30 09:30:05'),
(4, 12, 1, 'aaaaaaaaaa', NULL, '2025-09-07 21:11:18', '2025-09-07 21:11:18');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `componente_plan_mantenimientos`
--

CREATE TABLE `componente_plan_mantenimientos` (
  `id` bigint UNSIGNED NOT NULL,
  `plan_mantenimiento_id` bigint UNSIGNED NOT NULL,
  `parte_id` bigint UNSIGNED NOT NULL,
  `cantidad` decimal(8,2) NOT NULL,
  `unidad_medida` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `accion` enum('Reemplazar','Inspeccionar','Lubricar') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Reemplazar',
  `proveedor_id` int UNSIGNED DEFAULT NULL,
  `precio_base` decimal(10,2) DEFAULT NULL,
  `moneda` enum('USD','PEN') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'PEN',
  `observaciones` text COLLATE utf8mb4_unicode_ci,
  `activo` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comprobantes`
--

CREATE TABLE `comprobantes` (
  `id` bigint UNSIGNED NOT NULL,
  `cotizacion_id` bigint UNSIGNED NOT NULL,
  `tipo` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `serie` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `numero` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `fecha_emision` date NOT NULL,
  `monto` decimal(12,2) NOT NULL,
  `moneda` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `detalle` text COLLATE utf8mb4_general_ci,
  `archivo` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `comprobantes`
--

INSERT INTO `comprobantes` (`id`, `cotizacion_id`, `tipo`, `serie`, `numero`, `fecha_emision`, `monto`, `moneda`, `detalle`, `archivo`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 2, 'Boleta', 'B001', '654', '2025-04-25', 11800.00, 'Dólares', '11', 'comprobantes/QenHScXtpOR1EV2le9Nrq5alXN36KRfIRnW9OqT5.pdf', 1, '2025-04-25 21:55:03', '2025-04-25 21:55:03'),
(2, 49, 'Factura', 'B001', '234', '2025-09-07', 654.90, 'Soles', NULL, NULL, 1, '2025-09-07 13:27:29', '2025-09-07 13:27:29');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contactos_proveedores`
--

CREATE TABLE `contactos_proveedores` (
  `id` int NOT NULL,
  `proveedor_id` int NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `telefono` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `contactos_proveedores`
--

INSERT INTO `contactos_proveedores` (`id`, `proveedor_id`, `nombre`, `telefono`, `created_at`, `updated_at`) VALUES
(1, 2, 'contabilidad', '987654321', '2025-03-28 05:45:57', '2025-03-28 05:45:57'),
(2, 2, 'administrador', '321654987', '2025-03-28 05:45:57', '2025-03-28 05:45:57');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `correos_proveedores`
--

CREATE TABLE `correos_proveedores` (
  `id` int NOT NULL,
  `proveedor_id` int NOT NULL,
  `correo` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `correos_proveedores`
--

INSERT INTO `correos_proveedores` (`id`, `proveedor_id`, `correo`, `created_at`, `updated_at`) VALUES
(1, 2, 'proveedor@mail.com', '2025-03-28 05:45:57', '2025-03-28 05:45:57'),
(2, 2, 'proveedors@mail.com', '2025-03-28 05:45:57', '2025-03-28 05:45:57');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cotizaciones`
--

CREATE TABLE `cotizaciones` (
  `id` bigint UNSIGNED NOT NULL,
  `codigo` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `cliente_id` bigint UNSIGNED NOT NULL,
  `almacen_id` bigint UNSIGNED NOT NULL,
  `condicion` enum('Nuevo','Usado') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Nuevo',
  `canal` enum('Chevy Plan','Flota','Retail','Transferencia','Usado') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Retail',
  `moneda` enum('Soles','Dólares') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Dólares',
  `forma_pago` enum('Contado','Crédito') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Contado',
  `datos_adicionales` text COLLATE utf8mb4_general_ci,
  `subtotal` decimal(12,2) NOT NULL DEFAULT '0.00',
  `impuestos` decimal(12,2) NOT NULL DEFAULT '0.00',
  `total` decimal(12,2) NOT NULL DEFAULT '0.00',
  `estado_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `fecha_validez` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `gestionado` tinyint(1) DEFAULT '0',
  `porcentaje_abono` decimal(5,2) DEFAULT '100.00',
  `abono` decimal(12,2) DEFAULT NULL,
  `saldo_pendiente` decimal(12,2) DEFAULT NULL,
  `items_pendientes` text COLLATE utf8mb4_general_ci COMMENT 'Descripción de items sin stock',
  `regla_vencimiento_id` bigint UNSIGNED DEFAULT NULL,
  `fecha_ultimo_seguimiento` datetime DEFAULT NULL COMMENT 'Última fecha de seguimiento o actividad',
  `fecha_vencimiento` datetime DEFAULT NULL COMMENT 'Fecha calculada de vencimiento',
  `fecha_alerta` datetime DEFAULT NULL COMMENT 'Fecha para enviar alerta de vencimiento próximo',
  `vencida` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Si la cotización está vencida',
  `reasignable` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Si puede ser reasignada a otro asesor',
  `historial_vencimiento` json DEFAULT NULL COMMENT 'Historial de cambios por vencimiento'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cotizaciones`
--

INSERT INTO `cotizaciones` (`id`, `codigo`, `cliente_id`, `almacen_id`, `condicion`, `canal`, `moneda`, `forma_pago`, `datos_adicionales`, `subtotal`, `impuestos`, `total`, `estado_id`, `user_id`, `fecha_validez`, `created_at`, `updated_at`, `deleted_at`, `gestionado`, `porcentaje_abono`, `abono`, `saldo_pendiente`, `items_pendientes`, `regla_vencimiento_id`, `fecha_ultimo_seguimiento`, `fecha_vencimiento`, `fecha_alerta`, `vencida`, `reasignable`, `historial_vencimiento`) VALUES
(2, 'COT-202504000001', 4, 1, 'Nuevo', 'Retail', 'Dólares', 'Contado', NULL, 10000.00, 1800.00, 11800.00, 1, 1, '2025-05-25', '2025-04-25 21:10:50', '2025-04-25 21:10:50', NULL, 0, 100.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL),
(3, 'COT-202504000002', 1, 1, 'Nuevo', 'Flota', 'Dólares', 'Contado', NULL, 455555.00, 81999.90, 537554.90, 1, 1, '2025-05-30', '2025-04-30 10:07:37', '2025-06-27 10:55:49', NULL, 0, 100.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL),
(4, 'COT-202504000003', 6, 1, 'Nuevo', 'Flota', 'Dólares', 'Contado', NULL, 30000.00, 5400.00, 35400.00, 4, 1, '2025-05-30', '2025-04-30 10:46:49', '2025-04-30 10:48:35', NULL, 0, 100.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL),
(5, 'COT-202504000004', 6, 1, 'Nuevo', 'Flota', 'Dólares', 'Contado', NULL, 50000.00, 9000.00, 59000.00, 1, 1, '2025-05-30', '2025-04-30 20:41:26', '2025-04-30 20:41:26', NULL, 0, 100.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL),
(49, 'COT-20250005', 6, 1, 'Nuevo', 'Retail', 'Soles', 'Contado', 'Venta generada desde POS\nTipo de documento: Boleta\n\nITEMS SIN STOCK:\nParrillas (Solicitados: 1, Disponibles: 0)', 555.00, 99.90, 654.90, 3, 1, '2025-10-07', '2025-09-07 05:13:47', '2025-09-07 12:50:40', NULL, 0, 100.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuentas_proveedores`
--

CREATE TABLE `cuentas_proveedores` (
  `id` int NOT NULL,
  `proveedor_id` int NOT NULL,
  `banco_id` int NOT NULL,
  `moneda` enum('Soles','Dólares') COLLATE utf8mb4_general_ci NOT NULL,
  `tipo_cuenta` enum('Ahorros','Corriente') COLLATE utf8mb4_general_ci NOT NULL,
  `numero_cuenta` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `cci` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cuentas_proveedores`
--

INSERT INTO `cuentas_proveedores` (`id`, `proveedor_id`, `banco_id`, `moneda`, `tipo_cuenta`, `numero_cuenta`, `cci`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 'Soles', 'Corriente', '321654987654321', '3213213265468796565', '2025-03-28 05:46:32', '2025-03-28 05:46:32'),
(3, 2, 1, 'Soles', 'Ahorros', '32135165', '21351325', '2025-03-28 05:58:28', '2025-03-28 05:58:28');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `departamentos`
--

CREATE TABLE `departamentos` (
  `id` int UNSIGNED NOT NULL,
  `departamento` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `departamentos`
--

INSERT INTO `departamentos` (`id`, `departamento`, `created_at`, `updated_at`) VALUES
(1, 'AMAZONAS', NULL, NULL),
(2, 'ANCASH', NULL, NULL),
(3, 'APURIMAC', NULL, NULL),
(4, 'AREQUIPA', NULL, NULL),
(5, 'AYACUCHO', NULL, NULL),
(6, 'CAJAMARCA', NULL, NULL),
(7, 'CALLAO', NULL, NULL),
(8, 'CUSCO', NULL, NULL),
(9, 'HUANCAVELICA', NULL, NULL),
(10, 'HUÁNUCO', NULL, NULL),
(11, 'ICA', NULL, NULL),
(12, 'JUNÍN', NULL, NULL),
(13, 'LA LIBERTAD', NULL, NULL),
(14, 'LAMBAYEQUE', NULL, NULL),
(15, 'LIMA', NULL, NULL),
(16, 'LORETO', NULL, NULL),
(17, 'MADRE DE DIOS', NULL, NULL),
(18, 'MOQUEGUA', NULL, NULL),
(19, 'PASCO', NULL, NULL),
(20, 'PIURA', NULL, NULL),
(21, 'PUNO', NULL, NULL),
(22, 'SAN MARTÍN', NULL, NULL),
(23, 'TACNA', NULL, NULL),
(24, 'TUMBES', NULL, NULL),
(25, 'UCAYALI', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalles_cotizacion`
--

CREATE TABLE `detalles_cotizacion` (
  `id` bigint UNSIGNED NOT NULL,
  `cotizacion_id` bigint UNSIGNED NOT NULL,
  `vehiculo_catalogo_id` bigint UNSIGNED DEFAULT NULL,
  `color_id` bigint UNSIGNED DEFAULT NULL,
  `repuesto_id` bigint UNSIGNED DEFAULT NULL,
  `servicio_id` bigint UNSIGNED DEFAULT NULL,
  `cantidad` int NOT NULL DEFAULT '1',
  `precio_unitario` decimal(12,2) NOT NULL,
  `descuento` decimal(5,2) NOT NULL DEFAULT '0.00',
  `subtotal` decimal(12,2) NOT NULL,
  `total` decimal(12,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `vehiculo_id` bigint UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalles_cotizacion`
--

INSERT INTO `detalles_cotizacion` (`id`, `cotizacion_id`, `vehiculo_catalogo_id`, `color_id`, `repuesto_id`, `servicio_id`, `cantidad`, `precio_unitario`, `descuento`, `subtotal`, `total`, `created_at`, `updated_at`, `vehiculo_id`) VALUES
(2, 2, 1, 1, NULL, NULL, 1, 10000.00, 0.00, 10000.00, 10000.00, '2025-04-25 21:10:50', '2025-04-25 21:10:50', NULL),
(3, 3, 1, 2, NULL, NULL, 1, 455555.00, 0.00, 455555.00, 455555.00, '2025-04-30 10:07:37', '2025-04-30 10:07:37', NULL),
(4, 4, 1, 2, NULL, NULL, 1, 30000.00, 0.00, 30000.00, 30000.00, '2025-04-30 10:46:49', '2025-04-30 10:46:49', NULL),
(5, 5, 1, 2, NULL, NULL, 1, 50000.00, 0.00, 50000.00, 50000.00, '2025-04-30 20:41:26', '2025-04-30 20:41:26', NULL),
(9, 49, NULL, NULL, 4, NULL, 1, 55.00, 0.00, 55.00, 55.00, '2025-09-07 05:13:47', '2025-09-07 05:13:47', NULL),
(10, 49, NULL, NULL, 1, NULL, 1, 500.00, 0.00, 500.00, 500.00, '2025-09-07 05:13:47', '2025-09-07 05:13:47', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalles_devolucion_proveedor`
--

CREATE TABLE `detalles_devolucion_proveedor` (
  `id` bigint UNSIGNED NOT NULL,
  `devolucion_proveedor_id` bigint UNSIGNED NOT NULL,
  `item_id` bigint UNSIGNED NOT NULL,
  `tipo_item` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `cantidad` decimal(10,2) NOT NULL,
  `motivo_detalle` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalles_devolucion_proveedor`
--

INSERT INTO `detalles_devolucion_proveedor` (`id`, `devolucion_proveedor_id`, `item_id`, `tipo_item`, `cantidad`, `motivo_detalle`, `created_at`, `updated_at`) VALUES
(8, 14, 1, 'parte', 1.00, '321321', '2025-09-07 21:44:41', '2025-09-07 21:44:41'),
(9, 15, 1, 'parte', 1.00, NULL, '2025-09-07 21:47:24', '2025-09-07 21:47:24');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalles_requerimientos_compra`
--

CREATE TABLE `detalles_requerimientos_compra` (
  `id` bigint UNSIGNED NOT NULL,
  `requerimiento_compra_id` bigint UNSIGNED NOT NULL,
  `item_id` bigint UNSIGNED NOT NULL,
  `tipo_item` enum('parte','vehiculo') COLLATE utf8mb4_general_ci NOT NULL,
  `cantidad` decimal(10,2) NOT NULL,
  `descripcion` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `color_id` bigint UNSIGNED DEFAULT NULL,
  `cotizacion_detalle_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalles_requerimientos_compra`
--

INSERT INTO `detalles_requerimientos_compra` (`id`, `requerimiento_compra_id`, `item_id`, `tipo_item`, `cantidad`, `descripcion`, `color_id`, `cotizacion_detalle_id`, `created_at`, `updated_at`) VALUES
(5, 5, 1, 'vehiculo', 1.00, 'Volvo V-100 5000 (Negro)', 2, 4, '2025-04-30 20:37:48', '2025-04-30 20:37:48'),
(6, 6, 1, 'parte', 30.00, NULL, NULL, NULL, '2025-05-26 18:27:13', '2025-05-26 18:27:13'),
(7, 7, 1, 'parte', 30.00, NULL, NULL, NULL, '2025-05-26 18:53:08', '2025-05-26 18:53:08'),
(8, 8, 1, 'parte', 25.00, NULL, NULL, NULL, '2025-05-27 01:31:28', '2025-05-27 01:31:28'),
(9, 8, 4, 'parte', 30.00, NULL, NULL, NULL, '2025-05-27 01:31:28', '2025-05-27 01:31:28');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalles_venta`
--

CREATE TABLE `detalles_venta` (
  `id` bigint UNSIGNED NOT NULL,
  `venta_id` bigint UNSIGNED NOT NULL,
  `parte_id` bigint UNSIGNED DEFAULT NULL,
  `servicio_id` bigint UNSIGNED DEFAULT NULL,
  `cantidad` decimal(10,2) NOT NULL,
  `precio_unitario` decimal(12,2) NOT NULL,
  `descuento` decimal(5,2) DEFAULT '0.00',
  `subtotal` decimal(12,2) NOT NULL,
  `total` decimal(12,2) NOT NULL,
  `tipo_item` enum('parte','servicio') COLLATE utf8mb4_general_ci NOT NULL,
  `descripcion` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalles_venta_pos`
--

CREATE TABLE `detalles_venta_pos` (
  `id` bigint UNSIGNED NOT NULL,
  `venta_id` bigint UNSIGNED NOT NULL,
  `parte_id` bigint UNSIGNED NOT NULL,
  `cantidad` decimal(10,3) NOT NULL DEFAULT '1.000',
  `precio_unitario` decimal(12,2) NOT NULL,
  `descuento` decimal(5,2) NOT NULL DEFAULT '0.00',
  `codigo_parte` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Código de referencia rápida',
  `nombre_parte` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Nombre del repuesto en el momento de la venta',
  `subtotal` decimal(12,2) GENERATED ALWAYS AS ((`cantidad` * `precio_unitario`)) VIRTUAL,
  `total_descuento` decimal(12,2) GENERATED ALWAYS AS (((`cantidad` * `precio_unitario`) * (`descuento` / 100))) VIRTUAL,
  `total` decimal(12,2) GENERATED ALWAYS AS (((`cantidad` * `precio_unitario`) - ((`cantidad` * `precio_unitario`) * (`descuento` / 100)))) VIRTUAL,
  `almacen_id` bigint UNSIGNED DEFAULT NULL,
  `notas` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `fecha_registro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_guias_entrega`
--

CREATE TABLE `detalle_guias_entrega` (
  `id` bigint UNSIGNED NOT NULL,
  `guia_entrega_id` bigint UNSIGNED NOT NULL,
  `producto_id` bigint UNSIGNED NOT NULL,
  `tipo_producto` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `codigo_producto` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre_producto` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cantidad_enviada` decimal(8,2) NOT NULL,
  `cantidad_recibida` decimal(8,2) NOT NULL DEFAULT '0.00',
  `precio_unitario` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `observaciones_detalle` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_orden_compras`
--

CREATE TABLE `detalle_orden_compras` (
  `id` bigint UNSIGNED NOT NULL,
  `orden_compra_id` bigint UNSIGNED NOT NULL,
  `item_id` bigint UNSIGNED NOT NULL,
  `tipo_item` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `codigo` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `nombre_producto` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `cantidad_requerida` decimal(10,2) NOT NULL,
  `cantidad_en_compra` decimal(10,2) NOT NULL,
  `cantidad_recibida` decimal(10,2) DEFAULT '0.00',
  `cantidad_pendiente` decimal(10,2) DEFAULT '0.00',
  `estado_recepcion` varchar(30) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `unidad` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `precio_compra` decimal(10,2) NOT NULL DEFAULT '0.00',
  `descuento` decimal(10,2) NOT NULL DEFAULT '0.00',
  `total` decimal(10,2) NOT NULL DEFAULT '0.00',
  `afecto_igv` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `motivo_faltante` text COLLATE utf8mb4_general_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalle_orden_compras`
--

INSERT INTO `detalle_orden_compras` (`id`, `orden_compra_id`, `item_id`, `tipo_item`, `codigo`, `nombre_producto`, `cantidad_requerida`, `cantidad_en_compra`, `cantidad_recibida`, `cantidad_pendiente`, `estado_recepcion`, `unidad`, `precio_compra`, `descuento`, `total`, `afecto_igv`, `created_at`, `updated_at`, `motivo_faltante`) VALUES
(1, 1, 1, 'vehiculo', 'V1', 'Volvo V-100 5000 2023', 5.00, 5.00, 2.00, 0.00, 'completo', 'UND', 50000.00, 0.00, 250000.00, 1, '2025-04-25 22:03:56', '2025-05-26 21:10:40', NULL),
(2, 2, 6, 'vehiculo', 'V6', 'Chevrolet V-100 5000 2023', 10.00, 10.00, 10.00, 0.00, 'completo', 'UND', 50000.00, 0.00, 500000.00, 1, '2025-04-25 22:16:06', '2025-05-26 21:26:08', NULL),
(3, 3, 6, 'vehiculo', 'V6', 'Chevrolet V-100 5000 2023', 10.00, 10.00, 10.00, 0.00, 'completo', 'UND', 43234.00, 0.00, 432340.00, 1, '2025-04-25 22:41:41', '2025-05-26 21:18:35', NULL),
(4, 5, 1, 'vehiculo', 'V1', 'Volvo V-100 5000 2023', 50.00, 50.00, 3.00, 0.00, 'completo', 'UND', 5000.00, 0.00, 250000.00, 1, '2025-04-25 22:56:59', '2025-05-26 21:18:12', NULL),
(5, 6, 1, 'vehiculo', 'V1', 'Volvo V-100 5000 2023', 1.00, 1.00, 1.00, 0.00, 'completo', 'UND', 30.00, 0.00, 30.00, 1, '2025-05-26 19:18:25', '2025-05-26 21:44:13', NULL),
(6, 7, 1, 'parte', '000001', 'Reten A', 25.00, 25.00, 25.00, 0.00, 'completo', 'UND', 35.00, 0.00, 875.00, 1, '2025-05-27 01:32:07', '2025-05-27 01:35:29', NULL),
(7, 7, 4, 'parte', '000004', 'Parrillas', 30.00, 30.00, 30.00, 0.00, 'completo', 'UND', 26.00, 0.00, 780.00, 1, '2025-05-27 01:32:07', '2025-05-27 01:35:29', NULL),
(8, 8, 1, 'parte', '000001', 'Reten A', 25.00, 25.00, 1.00, 0.00, 'parcial', 'UND', 0.00, 0.00, 0.00, 1, '2025-09-07 22:13:34', '2025-09-07 22:20:12', NULL),
(9, 8, 4, 'parte', '000004', 'Parrillas', 30.00, 30.00, 1.00, 0.00, 'completo_con_faltantes', 'UND', 0.00, 0.00, 0.00, 1, '2025-09-07 22:13:34', '2025-09-07 22:19:34', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_orden_trabajo_repuestos`
--

CREATE TABLE `detalle_orden_trabajo_repuestos` (
  `id` bigint UNSIGNED NOT NULL,
  `orden_trabajo_id` bigint UNSIGNED NOT NULL,
  `parte_id` bigint UNSIGNED DEFAULT NULL,
  `descripcion` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `cantidad` int NOT NULL,
  `precio_unitario` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) DEFAULT NULL,
  `notas` text COLLATE utf8mb4_general_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalle_orden_trabajo_repuestos`
--

INSERT INTO `detalle_orden_trabajo_repuestos` (`id`, `orden_trabajo_id`, `parte_id`, `descripcion`, `cantidad`, `precio_unitario`, `subtotal`, `notas`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 'producto 2', 1, 321.00, NULL, NULL, '2025-04-29 21:23:05', '2025-04-29 21:23:05'),
(2, 1, 2, 'producto 2', 1, 321.00, NULL, NULL, '2025-04-29 21:35:53', '2025-04-29 21:35:53'),
(4, 2, 4, 'Parrillas', 1, 55.00, NULL, NULL, '2025-09-07 21:13:00', '2025-09-07 21:13:00'),
(6, 2, 2, 'producto 2', 1, 321.00, 321.00, NULL, '2025-09-07 21:16:52', '2025-09-07 21:16:52'),
(7, 2, 4, 'Parrillas', 1, 55.00, 55.00, NULL, '2025-09-07 21:18:42', '2025-09-07 21:18:42'),
(8, 2, 4, 'Parrillas', 1, 55.00, 55.00, NULL, '2025-09-07 21:21:00', '2025-09-07 21:21:00'),
(9, 2, 4, 'Parrillas', 1, 55.00, 55.00, NULL, '2025-09-07 21:21:10', '2025-09-07 21:21:10');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_orden_trabajo_servicios`
--

CREATE TABLE `detalle_orden_trabajo_servicios` (
  `id` bigint UNSIGNED NOT NULL,
  `orden_trabajo_id` bigint UNSIGNED NOT NULL,
  `servicio_id` bigint UNSIGNED DEFAULT NULL,
  `descripcion` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `cantidad` int NOT NULL,
  `precio_unitario` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `tiempo_estimado` decimal(5,2) DEFAULT NULL,
  `tiempo_real` decimal(5,2) DEFAULT NULL,
  `notas` text COLLATE utf8mb4_general_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalle_orden_trabajo_servicios`
--

INSERT INTO `detalle_orden_trabajo_servicios` (`id`, `orden_trabajo_id`, `servicio_id`, `descripcion`, `cantidad`, `precio_unitario`, `subtotal`, `tiempo_estimado`, `tiempo_real`, `notas`, `created_at`, `updated_at`) VALUES
(1, 2, 2, 'Colocación Videro Liquido', 1, 200.00, 200.00, NULL, NULL, NULL, '2025-09-07 21:15:29', '2025-09-07 21:15:29'),
(2, 2, 1, 'Inyección', 1, 300.00, 300.00, NULL, NULL, NULL, '2025-09-07 21:15:40', '2025-09-07 21:15:40'),
(3, 2, 1, 'Inyección', 1, 300.00, 300.00, NULL, NULL, NULL, '2025-09-07 21:21:06', '2025-09-07 21:21:06');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_vales_devolucion`
--

CREATE TABLE `detalle_vales_devolucion` (
  `id` bigint UNSIGNED NOT NULL,
  `vale_devolucion_id` bigint UNSIGNED NOT NULL,
  `producto_id` bigint UNSIGNED NOT NULL,
  `tipo_producto` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `codigo_producto` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre_producto` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cantidad` decimal(8,2) NOT NULL,
  `precio_unitario` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `motivo_detalle` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `observaciones_detalle` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `devoluciones_orden_compra`
--

CREATE TABLE `devoluciones_orden_compra` (
  `id` bigint UNSIGNED NOT NULL,
  `detalle_orden_compra_id` bigint UNSIGNED NOT NULL,
  `cantidad_devuelta` int NOT NULL,
  `motivo` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_devolucion` date NOT NULL,
  `devuelto_por` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `devoluciones_orden_compra`
--

INSERT INTO `devoluciones_orden_compra` (`id`, `detalle_orden_compra_id`, `cantidad_devuelta`, `motivo`, `fecha_devolucion`, `devuelto_por`, `created_at`, `updated_at`) VALUES
(1, 8, 1, 'sssssssssssssssssssssssssssss', '2025-09-07', 1, '2025-09-07 22:20:12', '2025-09-07 22:20:12');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `devoluciones_proveedor`
--

CREATE TABLE `devoluciones_proveedor` (
  `id` bigint UNSIGNED NOT NULL,
  `codigo` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `proveedor_id` bigint UNSIGNED NOT NULL,
  `motivo` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `fecha_emision` date NOT NULL,
  `observaciones` text COLLATE utf8mb4_general_ci,
  `estado` varchar(255) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'PENDIENTE',
  `usuario_id` bigint UNSIGNED NOT NULL,
  `almacen_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `devoluciones_proveedor`
--

INSERT INTO `devoluciones_proveedor` (`id`, `codigo`, `proveedor_id`, `motivo`, `fecha_emision`, `observaciones`, `estado`, `usuario_id`, `almacen_id`, `created_at`, `updated_at`) VALUES
(14, 'DEV-202509000001', 2, 'DOMINIO Y HOSTING PERIODO JULIO 2025 A 2026', '2025-09-07', 'dsadsa', 'PENDIENTE', 1, 1, '2025-09-07 21:44:41', '2025-09-07 21:44:41'),
(15, 'DEV-202509000002', 2, 'IMPLEMENTACIÓN DE SISTEMA DE GESTIÓN, AULA VIRTUAL, PÁGINA WEB Y FACTURACIÓN ELECTRÓNICA, PARA EL COLEGIO DE ECONOMISTAS DE HUANUCO', '2025-09-07', NULL, 'PROCESADA', 1, 2, '2025-09-07 21:47:24', '2025-09-07 21:53:05');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `distritos`
--

CREATE TABLE `distritos` (
  `id` int UNSIGNED NOT NULL,
  `distrito` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `provincia_id` int UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `distritos`
--

INSERT INTO `distritos` (`id`, `distrito`, `status`, `provincia_id`, `created_at`, `updated_at`) VALUES
(1, 'CHACHAPOYAS', NULL, 1, NULL, NULL),
(2, 'ASUNCION', NULL, 1, NULL, NULL),
(3, 'BALSAS', NULL, 1, NULL, NULL),
(4, 'CHETO', NULL, 1, NULL, NULL),
(5, 'CHILIQUIN', NULL, 1, NULL, NULL),
(6, 'CHUQUIBAMBA', NULL, 1, NULL, NULL),
(7, 'GRANADA', NULL, 1, NULL, NULL),
(8, 'HUANCAS', NULL, 1, NULL, NULL),
(9, 'LA JALCA', NULL, 1, NULL, NULL),
(10, 'LEIMEBAMBA', NULL, 1, NULL, NULL),
(11, 'LEVANTO', NULL, 1, NULL, NULL),
(12, 'MAGDALENA', NULL, 1, NULL, NULL),
(13, 'MARISCAL CASTILLA', NULL, 1, NULL, NULL),
(14, 'MOLINOPAMPA', NULL, 1, NULL, NULL),
(15, 'MONTEVIDEO', NULL, 1, NULL, NULL),
(16, 'OLLEROS', NULL, 1, NULL, NULL),
(17, 'QUINJALCA', NULL, 1, NULL, NULL),
(18, 'SAN FRANCISCO DE DAGUAS', NULL, 1, NULL, NULL),
(19, 'SAN ISIDRO DE MAINO', NULL, 1, NULL, NULL),
(20, 'SOLOCO', NULL, 1, NULL, NULL),
(21, 'SONCHE', NULL, 1, NULL, NULL),
(22, 'LA PECA', NULL, 2, NULL, NULL),
(23, 'ARAMANGO', NULL, 2, NULL, NULL),
(24, 'COPALLIN', NULL, 2, NULL, NULL),
(25, 'EL PARCO', NULL, 2, NULL, NULL),
(26, 'IMAZA', NULL, 2, NULL, NULL),
(27, 'JUMBILLA', NULL, 3, NULL, NULL),
(28, 'CHISQUILLA', NULL, 3, NULL, NULL),
(29, 'CHURUJA', NULL, 3, NULL, NULL),
(30, 'COROSHA', NULL, 3, NULL, NULL),
(31, 'CUISPES', NULL, 3, NULL, NULL),
(32, 'FLORIDA', NULL, 3, NULL, NULL),
(33, 'JAZAN', NULL, 3, NULL, NULL),
(34, 'RECTA', NULL, 3, NULL, NULL),
(35, 'SAN CARLOS', NULL, 3, NULL, NULL),
(36, 'SHIPASBAMBA', NULL, 3, NULL, NULL),
(37, 'VALERA', NULL, 3, NULL, NULL),
(38, 'YAMBRASBAMBA', NULL, 3, NULL, NULL),
(39, 'NIEVA', NULL, 4, NULL, NULL),
(40, 'EL CENEPA', NULL, 4, NULL, NULL),
(41, 'RIO SANTIAGO', NULL, 4, NULL, NULL),
(42, 'LAMUD', NULL, 5, NULL, NULL),
(43, 'CAMPORREDONDO', NULL, 5, NULL, NULL),
(44, 'COCABAMBA', NULL, 5, NULL, NULL),
(45, 'COLCAMAR', NULL, 5, NULL, NULL),
(46, 'CONILA', NULL, 5, NULL, NULL),
(47, 'INGUILPATA', NULL, 5, NULL, NULL),
(48, 'LONGUITA', NULL, 5, NULL, NULL),
(49, 'LONYA CHICO', NULL, 5, NULL, NULL),
(50, 'LUYA', NULL, 5, NULL, NULL),
(51, 'LUYA VIEJO', NULL, 5, NULL, NULL),
(52, 'MARIA', NULL, 5, NULL, NULL),
(53, 'OCALLI', NULL, 5, NULL, NULL),
(54, 'OCUMAL', NULL, 5, NULL, NULL),
(55, 'PISUQUIA', NULL, 5, NULL, NULL),
(56, 'PROVIDENCIA', NULL, 5, NULL, NULL),
(57, 'SAN CRISTOBAL', NULL, 5, NULL, NULL),
(58, 'SAN FRANCISCO DEL YESO', NULL, 5, NULL, NULL),
(59, 'SAN JERONIMO', NULL, 5, NULL, NULL),
(60, 'SAN JUAN DE LOPECANCHA', NULL, 5, NULL, NULL),
(61, 'SANTA CATALINA', NULL, 5, NULL, NULL),
(62, 'SANTO TOMAS', NULL, 5, NULL, NULL),
(63, 'TINGO', NULL, 5, NULL, NULL),
(64, 'TRITA', NULL, 5, NULL, NULL),
(65, 'SAN NICOLAS', NULL, 6, NULL, NULL),
(66, 'CHIRIMOTO', NULL, 6, NULL, NULL),
(67, 'COCHAMAL', NULL, 6, NULL, NULL),
(68, 'HUAMBO', NULL, 6, NULL, NULL),
(69, 'LIMABAMBA', NULL, 6, NULL, NULL),
(70, 'LONGAR', NULL, 6, NULL, NULL),
(71, 'MARISCAL BENAVIDES', NULL, 6, NULL, NULL),
(72, 'MILPUC', NULL, 6, NULL, NULL),
(73, 'OMIA', NULL, 6, NULL, NULL),
(74, 'SANTA ROSA', NULL, 6, NULL, NULL),
(75, 'TOTORA', NULL, 6, NULL, NULL),
(76, 'VISTA ALEGRE', NULL, 6, NULL, NULL),
(77, 'BAGUA GRANDE', NULL, 7, NULL, NULL),
(78, 'CAJARURO', NULL, 7, NULL, NULL),
(79, 'CUMBA', NULL, 7, NULL, NULL),
(80, 'EL MILAGRO', NULL, 7, NULL, NULL),
(81, 'JAMALCA', NULL, 7, NULL, NULL),
(82, 'LONYA GRANDE', NULL, 7, NULL, NULL),
(83, 'YAMON', NULL, 7, NULL, NULL),
(84, 'HUARAZ', NULL, 8, NULL, NULL),
(85, 'COCHABAMBA', NULL, 8, NULL, NULL),
(86, 'COLCABAMBA', NULL, 8, NULL, NULL),
(87, 'HUANCHAY', NULL, 8, NULL, NULL),
(88, 'INDEPENDENCIA', NULL, 8, NULL, NULL),
(89, 'JANGAS', NULL, 8, NULL, NULL),
(90, 'LA LIBERTAD', NULL, 8, NULL, NULL),
(91, 'OLLEROS', NULL, 8, NULL, NULL),
(92, 'PAMPAS', NULL, 8, NULL, NULL),
(93, 'PARIACOTO', NULL, 8, NULL, NULL),
(94, 'PIRA', NULL, 8, NULL, NULL),
(95, 'TARICA', NULL, 8, NULL, NULL),
(96, 'AIJA', NULL, 9, NULL, NULL),
(97, 'CORIS', NULL, 9, NULL, NULL),
(98, 'HUACLLAN', NULL, 9, NULL, NULL),
(99, 'LA MERCED', NULL, 9, NULL, NULL),
(100, 'SUCCHA', NULL, 9, NULL, NULL),
(101, 'LLAMELLIN', NULL, 10, NULL, NULL),
(102, 'ACZO', NULL, 10, NULL, NULL),
(103, 'CHACCHO', NULL, 10, NULL, NULL),
(104, 'CHINGAS', NULL, 10, NULL, NULL),
(105, 'MIRGAS', NULL, 10, NULL, NULL),
(106, 'SAN JUAN DE RONTOY', NULL, 10, NULL, NULL),
(107, 'CHACAS', NULL, 11, NULL, NULL),
(108, 'ACOCHACA', NULL, 11, NULL, NULL),
(109, 'CHIQUIAN', NULL, 12, NULL, NULL),
(110, 'ABELARDO PARDO LEZAMETA', NULL, 12, NULL, NULL),
(111, 'ANTONIO RAYMONDI', NULL, 12, NULL, NULL),
(112, 'AQUIA', NULL, 12, NULL, NULL),
(113, 'CAJACAY', NULL, 12, NULL, NULL),
(114, 'CANIS', NULL, 12, NULL, NULL),
(115, 'COLQUIOC', NULL, 12, NULL, NULL),
(116, 'HUALLANCA', NULL, 12, NULL, NULL),
(117, 'HUASTA', NULL, 12, NULL, NULL),
(118, 'HUAYLLACAYAN', NULL, 12, NULL, NULL),
(119, 'LA PRIMAVERA', NULL, 12, NULL, NULL),
(120, 'MANGAS', NULL, 12, NULL, NULL),
(121, 'PACLLON', NULL, 12, NULL, NULL),
(122, 'SAN MIGUEL DE CORPANQUI', NULL, 12, NULL, NULL),
(123, 'TICLLOS', NULL, 12, NULL, NULL),
(124, 'CARHUAZ', NULL, 13, NULL, NULL),
(125, 'ACOPAMPA', NULL, 13, NULL, NULL),
(126, 'AMASHCA', NULL, 13, NULL, NULL),
(127, 'ANTA', NULL, 13, NULL, NULL),
(128, 'ATAQUERO', NULL, 13, NULL, NULL),
(129, 'MARCARA', NULL, 13, NULL, NULL),
(130, 'PARIAHUANCA', NULL, 13, NULL, NULL),
(131, 'SAN MIGUEL DE ACO', NULL, 13, NULL, NULL),
(132, 'SHILLA', NULL, 13, NULL, NULL),
(133, 'TINCO', NULL, 13, NULL, NULL),
(134, 'YUNGAR', NULL, 13, NULL, NULL),
(135, 'SAN LUIS', NULL, 14, NULL, NULL),
(136, 'SAN NICOLAS', NULL, 14, NULL, NULL),
(137, 'YAUYA', NULL, 14, NULL, NULL),
(138, 'CASMA', NULL, 15, NULL, NULL),
(139, 'BUENA VISTA ALTA', NULL, 15, NULL, NULL),
(140, 'COMANDANTE NOEL', NULL, 15, NULL, NULL),
(141, 'YAUTAN', NULL, 15, NULL, NULL),
(142, 'CORONGO', NULL, 16, NULL, NULL),
(143, 'ACO', NULL, 16, NULL, NULL),
(144, 'BAMBAS', NULL, 16, NULL, NULL),
(145, 'CUSCA', NULL, 16, NULL, NULL),
(146, 'LA PAMPA', NULL, 16, NULL, NULL),
(147, 'YANAC', NULL, 16, NULL, NULL),
(148, 'YUPAN', NULL, 16, NULL, NULL),
(149, 'HUARI', NULL, 17, NULL, NULL),
(150, 'ANRA', NULL, 17, NULL, NULL),
(151, 'CAJAY', NULL, 17, NULL, NULL),
(152, 'CHAVIN DE HUANTAR', NULL, 17, NULL, NULL),
(153, 'HUACACHI', NULL, 17, NULL, NULL),
(154, 'HUACCHIS', NULL, 17, NULL, NULL),
(155, 'HUACHIS', NULL, 17, NULL, NULL),
(156, 'HUANTAR', NULL, 17, NULL, NULL),
(157, 'MASIN', NULL, 17, NULL, NULL),
(158, 'PAUCAS', NULL, 17, NULL, NULL),
(159, 'PONTO', NULL, 17, NULL, NULL),
(160, 'RAHUAPAMPA', NULL, 17, NULL, NULL),
(161, 'RAPAYAN', NULL, 17, NULL, NULL),
(162, 'SAN MARCOS', NULL, 17, NULL, NULL),
(163, 'SAN PEDRO DE CHANA', NULL, 17, NULL, NULL),
(164, 'UCO', NULL, 17, NULL, NULL),
(165, 'HUARMEY', NULL, 18, NULL, NULL),
(166, 'COCHAPETI', NULL, 18, NULL, NULL),
(167, 'CULEBRAS', NULL, 18, NULL, NULL),
(168, 'HUAYAN', NULL, 18, NULL, NULL),
(169, 'MALVAS', NULL, 18, NULL, NULL),
(170, 'CARAZ', NULL, 26, NULL, NULL),
(171, 'HUALLANCA', NULL, 26, NULL, NULL),
(172, 'HUATA', NULL, 26, NULL, NULL),
(173, 'HUAYLAS', NULL, 26, NULL, NULL),
(174, 'MATO', NULL, 26, NULL, NULL),
(175, 'PAMPAROMAS', NULL, 26, NULL, NULL),
(176, 'PUEBLO LIBRE', NULL, 26, NULL, NULL),
(177, 'SANTA CRUZ', NULL, 26, NULL, NULL),
(178, 'SANTO TORIBIO', NULL, 26, NULL, NULL),
(179, 'YURACMARCA', NULL, 26, NULL, NULL),
(180, 'PISCOBAMBA', NULL, 27, NULL, NULL),
(181, 'CASCA', NULL, 27, NULL, NULL),
(182, 'ELEAZAR GUZMAN BARRON', NULL, 27, NULL, NULL),
(183, 'FIDEL OLIVAS ESCUDERO', NULL, 27, NULL, NULL),
(184, 'LLAMA', NULL, 27, NULL, NULL),
(185, 'LLUMPA', NULL, 27, NULL, NULL),
(186, 'LUCMA', NULL, 27, NULL, NULL),
(187, 'MUSGA', NULL, 27, NULL, NULL),
(188, 'OCROS', NULL, 21, NULL, NULL),
(189, 'ACAS', NULL, 21, NULL, NULL),
(190, 'CAJAMARQUILLA', NULL, 21, NULL, NULL),
(191, 'CARHUAPAMPA', NULL, 21, NULL, NULL),
(192, 'COCHAS', NULL, 21, NULL, NULL),
(193, 'CONGAS', NULL, 21, NULL, NULL),
(194, 'LLIPA', NULL, 21, NULL, NULL),
(195, 'SAN CRISTOBAL DE RAJAN', NULL, 21, NULL, NULL),
(196, 'SAN PEDRO', NULL, 21, NULL, NULL),
(197, 'SANTIAGO DE CHILCAS', NULL, 21, NULL, NULL),
(198, 'CABANA', NULL, 22, NULL, NULL),
(199, 'BOLOGNESI', NULL, 22, NULL, NULL),
(200, 'CONCHUCOS', NULL, 22, NULL, NULL),
(201, 'HUACASCHUQUE', NULL, 22, NULL, NULL),
(202, 'HUANDOVAL', NULL, 22, NULL, NULL),
(203, 'LACABAMBA', NULL, 22, NULL, NULL),
(204, 'LLAPO', NULL, 22, NULL, NULL),
(205, 'PALLASCA', NULL, 22, NULL, NULL),
(206, 'PAMPAS', NULL, 22, NULL, NULL),
(207, 'SANTA ROSA', NULL, 22, NULL, NULL),
(208, 'TAUCA', NULL, 22, NULL, NULL),
(209, 'POMABAMBA', NULL, 23, NULL, NULL),
(210, 'HUAYLLAN', NULL, 23, NULL, NULL),
(211, 'PAROBAMBA', NULL, 23, NULL, NULL),
(212, 'QUINUABAMBA', NULL, 23, NULL, NULL),
(213, 'RECUAY', NULL, 24, NULL, NULL),
(214, 'CATAC', NULL, 24, NULL, NULL),
(215, 'COTAPARACO', NULL, 24, NULL, NULL),
(216, 'HUAYLLAPAMPA', NULL, 24, NULL, NULL),
(217, 'LLACLLIN', NULL, 24, NULL, NULL),
(218, 'MARCA', NULL, 24, NULL, NULL),
(219, 'PAMPAS CHICO', NULL, 24, NULL, NULL),
(220, 'PARARIN', NULL, 24, NULL, NULL),
(221, 'TAPACOCHA', NULL, 24, NULL, NULL),
(222, 'TICAPAMPA', NULL, 24, NULL, NULL),
(223, 'CHIMBOTE', NULL, 25, NULL, NULL),
(224, 'CACERES DEL PERU', NULL, 25, NULL, NULL),
(225, 'COISHCO', NULL, 25, NULL, NULL),
(226, 'MACATE', NULL, 25, NULL, NULL),
(227, 'MORO', NULL, 25, NULL, NULL),
(228, 'NEPEÑA', NULL, 25, NULL, NULL),
(229, 'SAMANCO', NULL, 25, NULL, NULL),
(230, 'SANTA', NULL, 25, NULL, NULL),
(231, 'NUEVO CHIMBOTE', NULL, 25, NULL, NULL),
(232, 'SIHUAS', NULL, 26, NULL, NULL),
(233, 'ACOBAMBA', NULL, 26, NULL, NULL),
(234, 'ALFONSO UGARTE', NULL, 26, NULL, NULL),
(235, 'CASHAPAMPA', NULL, 26, NULL, NULL),
(236, 'CHINGALPO', NULL, 26, NULL, NULL),
(237, 'HUAYLLABAMBA', NULL, 26, NULL, NULL),
(238, 'QUICHES', NULL, 26, NULL, NULL),
(239, 'RAGASH', NULL, 26, NULL, NULL),
(240, 'SAN JUAN', NULL, 26, NULL, NULL),
(241, 'SICSIBAMBA', NULL, 26, NULL, NULL),
(242, 'YUNGAY', NULL, 27, NULL, NULL),
(243, 'CASCAPARA', NULL, 27, NULL, NULL),
(244, 'MANCOS', NULL, 27, NULL, NULL),
(245, 'MATACOTO', NULL, 27, NULL, NULL),
(246, 'QUILLO', NULL, 27, NULL, NULL),
(247, 'RANRAHIRCA', NULL, 27, NULL, NULL),
(248, 'SHUPLUY', NULL, 27, NULL, NULL),
(249, 'YANAMA', NULL, 27, NULL, NULL),
(250, 'ABANCAY', NULL, 28, NULL, NULL),
(251, 'CHACOCHE', NULL, 28, NULL, NULL),
(252, 'CIRCA', NULL, 28, NULL, NULL),
(253, 'CURAHUASI', NULL, 28, NULL, NULL),
(254, 'HUANIPACA', NULL, 28, NULL, NULL),
(255, 'LAMBRAMA', NULL, 28, NULL, NULL),
(256, 'PICHIRHUA', NULL, 28, NULL, NULL),
(257, 'SAN PEDRO DE CACHORA', NULL, 28, NULL, NULL),
(258, 'TAMBURCO', NULL, 28, NULL, NULL),
(259, 'ANDAHUAYLAS', NULL, 29, NULL, NULL),
(260, 'ANDARAPA', NULL, 29, NULL, NULL),
(261, 'CHIARA', NULL, 29, NULL, NULL),
(262, 'HUANCARAMA', NULL, 29, NULL, NULL),
(263, 'HUANCARAY', NULL, 29, NULL, NULL),
(264, 'HUAYANA', NULL, 29, NULL, NULL),
(265, 'KISHUARA', NULL, 29, NULL, NULL),
(266, 'PACOBAMBA', NULL, 29, NULL, NULL),
(267, 'PACUCHA', NULL, 29, NULL, NULL),
(268, 'PAMPACHIRI', NULL, 29, NULL, NULL),
(269, 'POMACOCHA', NULL, 29, NULL, NULL),
(270, 'SAN ANTONIO DE CACHI', NULL, 29, NULL, NULL),
(271, 'SAN JERONIMO', NULL, 29, NULL, NULL),
(272, 'SAN MIGUEL DE CHACCRAMPA', NULL, 29, NULL, NULL),
(273, 'SANTA MARIA DE CHICMO', NULL, 29, NULL, NULL),
(274, 'TALAVERA', NULL, 29, NULL, NULL),
(275, 'TUMAY HUARACA', NULL, 29, NULL, NULL),
(276, 'TURPO', NULL, 29, NULL, NULL),
(277, 'KAQUIABAMBA', NULL, 29, NULL, NULL),
(278, 'ANTABAMBA', NULL, 30, NULL, NULL),
(279, 'EL ORO', NULL, 30, NULL, NULL),
(280, 'HUAQUIRCA', NULL, 30, NULL, NULL),
(281, 'JUAN ESPINOZA MEDRANO', NULL, 30, NULL, NULL),
(282, 'OROPESA', NULL, 30, NULL, NULL),
(283, 'PACHACONAS', NULL, 30, NULL, NULL),
(284, 'SABAINO', NULL, 30, NULL, NULL),
(285, 'CHALHUANCA', NULL, 31, NULL, NULL),
(286, 'CAPAYA', NULL, 31, NULL, NULL),
(287, 'CARAYBAMBA', NULL, 31, NULL, NULL),
(288, 'CHAPIMARCA', NULL, 31, NULL, NULL),
(289, 'COLCABAMBA', NULL, 31, NULL, NULL),
(290, 'COTARUSE', NULL, 31, NULL, NULL),
(291, 'HUAYLLO', NULL, 31, NULL, NULL),
(292, 'JUSTO APU SAHUARAURA', NULL, 31, NULL, NULL),
(293, 'LUCRE', NULL, 31, NULL, NULL),
(294, 'POCOHUANCA', NULL, 31, NULL, NULL),
(295, 'SAN JUAN DE CHACÑA', NULL, 31, NULL, NULL),
(296, 'SAÑAYCA', NULL, 31, NULL, NULL),
(297, 'SORAYA', NULL, 31, NULL, NULL),
(298, 'TAPAIRIHUA', NULL, 31, NULL, NULL),
(299, 'TINTAY', NULL, 31, NULL, NULL),
(300, 'TORAYA', NULL, 31, NULL, NULL),
(301, 'YANACA', NULL, 31, NULL, NULL),
(302, 'TAMBOBAMBA', NULL, 32, NULL, NULL),
(303, 'COTABAMBAS', NULL, 32, NULL, NULL),
(304, 'COYLLURQUI', NULL, 32, NULL, NULL),
(305, 'HAQUIRA', NULL, 32, NULL, NULL),
(306, 'MARA', NULL, 32, NULL, NULL),
(307, 'CHALLHUAHUACHO', NULL, 32, NULL, NULL),
(308, 'CHINCHEROS', NULL, 33, NULL, NULL),
(309, 'ANCO-HUALLO', NULL, 33, NULL, NULL),
(310, 'COCHARCAS', NULL, 33, NULL, NULL),
(311, 'HUACCANA', NULL, 33, NULL, NULL),
(312, 'OCOBAMBA', NULL, 33, NULL, NULL),
(313, 'ONGOY', NULL, 33, NULL, NULL),
(314, 'URANMARCA', NULL, 33, NULL, NULL),
(315, 'RANRACANCHA', NULL, 33, NULL, NULL),
(316, 'CHUQUIBAMBILLA', NULL, 34, NULL, NULL),
(317, 'CURPAHUASI', NULL, 34, NULL, NULL),
(318, 'GAMARRA', NULL, 34, NULL, NULL),
(319, 'HUAYLLATI', NULL, 34, NULL, NULL),
(320, 'MAMARA', NULL, 34, NULL, NULL),
(321, 'MICAELA BASTIDAS', NULL, 34, NULL, NULL),
(322, 'PATAYPAMPA', NULL, 34, NULL, NULL),
(323, 'PROGRESO', NULL, 34, NULL, NULL),
(324, 'SAN ANTONIO', NULL, 34, NULL, NULL),
(325, 'SANTA ROSA', NULL, 34, NULL, NULL),
(326, 'TURPAY', NULL, 34, NULL, NULL),
(327, 'VILCABAMBA', NULL, 34, NULL, NULL),
(328, 'VIRUNDO', NULL, 34, NULL, NULL),
(329, 'CURASCO', NULL, 34, NULL, NULL),
(330, 'AREQUIPA', NULL, 35, NULL, NULL),
(331, 'ALTO SELVA ALEGRE', NULL, 35, NULL, NULL),
(332, 'CAYMA', NULL, 35, NULL, NULL),
(333, 'CERRO COLORADO', NULL, 35, NULL, NULL),
(334, 'CHARACATO', NULL, 35, NULL, NULL),
(335, 'CHIGUATA', NULL, 35, NULL, NULL),
(336, 'JACOBO HUNTER', NULL, 35, NULL, NULL),
(337, 'LA JOYA', NULL, 35, NULL, NULL),
(338, 'MARIANO MELGAR', NULL, 35, NULL, NULL),
(339, 'MIRAFLORES', NULL, 35, NULL, NULL),
(340, 'MOLLEBAYA', NULL, 35, NULL, NULL),
(341, 'PAUCARPATA', NULL, 35, NULL, NULL),
(342, 'POCSI', NULL, 35, NULL, NULL),
(343, 'POLOBAYA', NULL, 35, NULL, NULL),
(344, 'QUEQUEÑA', NULL, 35, NULL, NULL),
(345, 'SABANDIA', NULL, 35, NULL, NULL),
(346, 'SACHACA', NULL, 35, NULL, NULL),
(347, 'SAN JUAN DE SIGUAS', NULL, 35, NULL, NULL),
(348, 'SAN JUAN DE TARUCANI', NULL, 35, NULL, NULL),
(349, 'SANTA ISABEL DE SIGUAS', NULL, 35, NULL, NULL),
(350, 'SANTA RITA DE SIGUAS', NULL, 35, NULL, NULL),
(351, 'SOCABAYA', NULL, 35, NULL, NULL),
(352, 'TIABAYA', NULL, 35, NULL, NULL),
(353, 'UCHUMAYO', NULL, 35, NULL, NULL),
(354, 'VITOR', NULL, 35, NULL, NULL),
(355, 'YANAHUARA', NULL, 35, NULL, NULL),
(356, 'YARABAMBA', NULL, 35, NULL, NULL),
(357, 'YURA', NULL, 35, NULL, NULL),
(358, 'JOSE LUIS BUSTAMANTE Y RIVERO', NULL, 35, NULL, NULL),
(359, 'CAMANA', NULL, 36, NULL, NULL),
(360, 'JOSE MARIA QUIMPER', NULL, 36, NULL, NULL),
(361, 'MARIANO NICOLAS VALCARCEL', NULL, 36, NULL, NULL),
(362, 'MARISCAL CACERES', NULL, 36, NULL, NULL),
(363, 'NICOLAS DE PIEROLA', NULL, 36, NULL, NULL),
(364, 'OCOÑA', NULL, 36, NULL, NULL),
(365, 'QUILCA', NULL, 36, NULL, NULL),
(366, 'SAMUEL PASTOR', NULL, 36, NULL, NULL),
(367, 'CARAVELI', NULL, 37, NULL, NULL),
(368, 'ACARI', NULL, 37, NULL, NULL),
(369, 'ATICO', NULL, 37, NULL, NULL),
(370, 'ATIQUIPA', NULL, 37, NULL, NULL),
(371, 'BELLA UNION', NULL, 37, NULL, NULL),
(372, 'CAHUACHO', NULL, 37, NULL, NULL),
(373, 'CHALA', NULL, 37, NULL, NULL),
(374, 'CHAPARRA', NULL, 37, NULL, NULL),
(375, 'HUANUHUANU', NULL, 37, NULL, NULL),
(376, 'JAQUI', NULL, 37, NULL, NULL),
(377, 'LOMAS', NULL, 37, NULL, NULL),
(378, 'QUICACHA', NULL, 37, NULL, NULL),
(379, 'YAUCA', NULL, 37, NULL, NULL),
(380, 'APLAO', NULL, 38, NULL, NULL),
(381, 'ANDAGUA', NULL, 38, NULL, NULL),
(382, 'AYO', NULL, 38, NULL, NULL),
(383, 'CHACHAS', NULL, 38, NULL, NULL),
(384, 'CHILCAYMARCA', NULL, 38, NULL, NULL),
(385, 'CHOCO', NULL, 38, NULL, NULL),
(386, 'HUANCARQUI', NULL, 38, NULL, NULL),
(387, 'MACHAGUAY', NULL, 38, NULL, NULL),
(388, 'ORCOPAMPA', NULL, 38, NULL, NULL),
(389, 'PAMPACOLCA', NULL, 38, NULL, NULL),
(390, 'TIPAN', NULL, 38, NULL, NULL),
(391, 'UÑON', NULL, 38, NULL, NULL),
(392, 'URACA', NULL, 38, NULL, NULL),
(393, 'VIRACO', NULL, 38, NULL, NULL),
(394, 'CHIVAY', NULL, 39, NULL, NULL),
(395, 'ACHOMA', NULL, 39, NULL, NULL),
(396, 'CABANACONDE', NULL, 39, NULL, NULL),
(397, 'CALLALLI', NULL, 39, NULL, NULL),
(398, 'CAYLLOMA', NULL, 39, NULL, NULL),
(399, 'COPORAQUE', NULL, 39, NULL, NULL),
(400, 'HUAMBO', NULL, 39, NULL, NULL),
(401, 'HUANCA', NULL, 39, NULL, NULL),
(402, 'ICHUPAMPA', NULL, 39, NULL, NULL),
(403, 'LARI', NULL, 39, NULL, NULL),
(404, 'LLUTA', NULL, 39, NULL, NULL),
(405, 'MACA', NULL, 39, NULL, NULL),
(406, 'MADRIGAL', NULL, 39, NULL, NULL),
(407, 'SAN ANTONIO DE CHUCA', NULL, 39, NULL, NULL),
(408, 'SIBAYO', NULL, 39, NULL, NULL),
(409, 'TAPAY', NULL, 39, NULL, NULL),
(410, 'TISCO', NULL, 39, NULL, NULL),
(411, 'TUTI', NULL, 39, NULL, NULL),
(412, 'YANQUE', NULL, 39, NULL, NULL),
(413, 'MAJES', NULL, 39, NULL, NULL),
(414, 'CHUQUIBAMBA', NULL, 40, NULL, NULL),
(415, 'ANDARAY', NULL, 40, NULL, NULL),
(416, 'CAYARANI', NULL, 40, NULL, NULL),
(417, 'CHICHAS', NULL, 40, NULL, NULL),
(418, 'IRAY', NULL, 40, NULL, NULL),
(419, 'RIO GRANDE', NULL, 40, NULL, NULL),
(420, 'SALAMANCA', NULL, 40, NULL, NULL),
(421, 'YANAQUIHUA', NULL, 40, NULL, NULL),
(422, 'MOLLENDO', NULL, 41, NULL, NULL),
(423, 'COCACHACRA', NULL, 41, NULL, NULL),
(424, 'DEAN VALDIVIA', NULL, 41, NULL, NULL),
(425, 'ISLAY', NULL, 41, NULL, NULL),
(426, 'MEJIA', NULL, 41, NULL, NULL),
(427, 'PUNTA DE BOMBON', NULL, 41, NULL, NULL),
(428, 'COTAHUASI', NULL, 42, NULL, NULL),
(429, 'ALCA', NULL, 42, NULL, NULL),
(430, 'CHARCANA', NULL, 42, NULL, NULL),
(431, 'HUAYNACOTAS', NULL, 42, NULL, NULL),
(432, 'PAMPAMARCA', NULL, 42, NULL, NULL),
(433, 'PUYCA', NULL, 42, NULL, NULL),
(434, 'QUECHUALLA', NULL, 42, NULL, NULL),
(435, 'SAYLA', NULL, 42, NULL, NULL),
(436, 'TAURIA', NULL, 42, NULL, NULL),
(437, 'TOMEPAMPA', NULL, 42, NULL, NULL),
(438, 'TORO', NULL, 42, NULL, NULL),
(439, 'AYACUCHO', NULL, 43, NULL, NULL),
(440, 'ACOCRO', NULL, 43, NULL, NULL),
(441, 'ACOS VINCHOS', NULL, 43, NULL, NULL),
(442, 'CARMEN ALTO', NULL, 43, NULL, NULL),
(443, 'CHIARA', NULL, 43, NULL, NULL),
(444, 'OCROS', NULL, 43, NULL, NULL),
(445, 'PACAYCASA', NULL, 43, NULL, NULL),
(446, 'QUINUA', NULL, 43, NULL, NULL),
(447, 'SAN JOSE DE TICLLAS', NULL, 43, NULL, NULL),
(448, 'SAN JUAN BAUTISTA', NULL, 43, NULL, NULL),
(449, 'SANTIAGO DE PISCHA', NULL, 43, NULL, NULL),
(450, 'SOCOS', NULL, 43, NULL, NULL),
(451, 'TAMBILLO', NULL, 43, NULL, NULL),
(452, 'VINCHOS', NULL, 43, NULL, NULL),
(453, 'JESUS NAZARENO', NULL, 43, NULL, NULL),
(454, 'CANGALLO', NULL, 44, NULL, NULL),
(455, 'CHUSCHI', NULL, 44, NULL, NULL),
(456, 'LOS MOROCHUCOS', NULL, 44, NULL, NULL),
(457, 'MARIA PARADO DE BELLIDO', NULL, 44, NULL, NULL),
(458, 'PARAS', NULL, 44, NULL, NULL),
(459, 'TOTOS', NULL, 44, NULL, NULL),
(460, 'SANCOS', NULL, 45, NULL, NULL),
(461, 'CARAPO', NULL, 45, NULL, NULL),
(462, 'SACSAMARCA', NULL, 45, NULL, NULL),
(463, 'SANTIAGO DE LUCANAMARCA', NULL, 45, NULL, NULL),
(464, 'HUANTA', NULL, 46, NULL, NULL),
(465, 'AYAHUANCO', NULL, 46, NULL, NULL),
(466, 'HUAMANGUILLA', NULL, 46, NULL, NULL),
(467, 'IGUAIN', NULL, 46, NULL, NULL),
(468, 'LURICOCHA', NULL, 46, NULL, NULL),
(469, 'SANTILLANA', NULL, 46, NULL, NULL),
(470, 'SIVIA', NULL, 46, NULL, NULL),
(471, 'LLOCHEGUA', NULL, 46, NULL, NULL),
(472, 'SAN MIGUEL', NULL, 47, NULL, NULL),
(473, 'ANCO', NULL, 47, NULL, NULL),
(474, 'AYNA', NULL, 47, NULL, NULL),
(475, 'CHILCAS', NULL, 47, NULL, NULL),
(476, 'CHUNGUI', NULL, 47, NULL, NULL),
(477, 'LUIS CARRANZA', NULL, 47, NULL, NULL),
(478, 'SANTA ROSA', NULL, 47, NULL, NULL),
(479, 'TAMBO', NULL, 47, NULL, NULL),
(480, 'PUQUIO', NULL, 48, NULL, NULL),
(481, 'AUCARA', NULL, 48, NULL, NULL),
(482, 'CABANA', NULL, 48, NULL, NULL),
(483, 'CARMEN SALCEDO', NULL, 48, NULL, NULL),
(484, 'CHAVIÑA', NULL, 48, NULL, NULL),
(485, 'CHIPAO', NULL, 48, NULL, NULL),
(486, 'HUAC-HUAS', NULL, 48, NULL, NULL),
(487, 'LARAMATE', NULL, 48, NULL, NULL),
(488, 'LEONCIO PRADO', NULL, 48, NULL, NULL),
(489, 'LLAUTA', NULL, 48, NULL, NULL),
(490, 'LUCANAS', NULL, 48, NULL, NULL),
(491, 'OCAÑA', NULL, 48, NULL, NULL),
(492, 'OTOCA', NULL, 48, NULL, NULL),
(493, 'SAISA', NULL, 48, NULL, NULL),
(494, 'SAN CRISTOBAL', NULL, 48, NULL, NULL),
(495, 'SAN JUAN', NULL, 48, NULL, NULL),
(496, 'SAN PEDRO', NULL, 48, NULL, NULL),
(497, 'SAN PEDRO DE PALCO', NULL, 48, NULL, NULL),
(498, 'SANCOS', NULL, 48, NULL, NULL),
(499, 'SANTA ANA DE HUAYCAHUACHO', NULL, 48, NULL, NULL),
(500, 'SANTA LUCIA', NULL, 48, NULL, NULL),
(501, 'CORACORA', NULL, 49, NULL, NULL),
(502, 'CHUMPI', NULL, 49, NULL, NULL),
(503, 'CORONEL CASTAÑEDA', NULL, 49, NULL, NULL),
(504, 'PACAPAUSA', NULL, 49, NULL, NULL),
(505, 'PULLO', NULL, 49, NULL, NULL),
(506, 'PUYUSCA', NULL, 49, NULL, NULL),
(507, 'SAN FRANCISCO DE RAVACAYCO', NULL, 49, NULL, NULL),
(508, 'UPAHUACHO', NULL, 49, NULL, NULL),
(509, 'PAUSA', NULL, 50, NULL, NULL),
(510, 'COLTA', NULL, 50, NULL, NULL),
(511, 'CORCULLA', NULL, 50, NULL, NULL),
(512, 'LAMPA', NULL, 50, NULL, NULL),
(513, 'MARCABAMBA', NULL, 50, NULL, NULL),
(514, 'OYOLO', NULL, 50, NULL, NULL),
(515, 'PARARCA', NULL, 50, NULL, NULL),
(516, 'SAN JAVIER DE ALPABAMBA', NULL, 50, NULL, NULL),
(517, 'SAN JOSE DE USHUA', NULL, 50, NULL, NULL),
(518, 'SARA SARA', NULL, 50, NULL, NULL),
(519, 'QUEROBAMBA', NULL, 51, NULL, NULL),
(520, 'BELEN', NULL, 51, NULL, NULL),
(521, 'CHALCOS', NULL, 51, NULL, NULL),
(522, 'CHILCAYOC', NULL, 51, NULL, NULL),
(523, 'HUACAÑA', NULL, 51, NULL, NULL),
(524, 'MORCOLLA', NULL, 51, NULL, NULL),
(525, 'PAICO', NULL, 51, NULL, NULL),
(526, 'SAN PEDRO DE LARCAY', NULL, 51, NULL, NULL),
(527, 'SAN SALVADOR DE QUIJE', NULL, 51, NULL, NULL),
(528, 'SANTIAGO DE PAUCARAY', NULL, 51, NULL, NULL),
(529, 'SORAS', NULL, 51, NULL, NULL),
(530, 'HUANCAPI', NULL, 52, NULL, NULL),
(531, 'ALCAMENCA', NULL, 52, NULL, NULL),
(532, 'APONGO', NULL, 52, NULL, NULL),
(533, 'ASQUIPATA', NULL, 52, NULL, NULL),
(534, 'CANARIA', NULL, 52, NULL, NULL),
(535, 'CAYARA', NULL, 52, NULL, NULL),
(536, 'COLCA', NULL, 52, NULL, NULL),
(537, 'HUAMANQUIQUIA', NULL, 52, NULL, NULL),
(538, 'HUANCARAYLLA', NULL, 52, NULL, NULL),
(539, 'HUAYA', NULL, 52, NULL, NULL),
(540, 'SARHUA', NULL, 52, NULL, NULL),
(541, 'VILCANCHOS', NULL, 52, NULL, NULL),
(542, 'VILCAS HUAMAN', NULL, 53, NULL, NULL),
(543, 'ACCOMARCA', NULL, 53, NULL, NULL),
(544, 'CARHUANCA', NULL, 53, NULL, NULL),
(545, 'CONCEPCION', NULL, 53, NULL, NULL),
(546, 'HUAMBALPA', NULL, 53, NULL, NULL),
(547, 'INDEPENDENCIA', NULL, 53, NULL, NULL),
(548, 'SAURAMA', NULL, 53, NULL, NULL),
(549, 'VISCHONGO', NULL, 53, NULL, NULL),
(550, 'PURUS', NULL, 193, NULL, NULL),
(551, 'CAJAMARCA', NULL, 54, NULL, NULL),
(552, 'ASUNCION', NULL, 54, NULL, NULL),
(553, 'CHETILLA', NULL, 54, NULL, NULL),
(554, 'COSPAN', NULL, 54, NULL, NULL),
(555, 'ENCAÑADA', NULL, 54, NULL, NULL),
(556, 'JESUS', NULL, 54, NULL, NULL),
(557, 'LLACANORA', NULL, 54, NULL, NULL),
(558, 'LOS BAÑOS DEL INCA', NULL, 54, NULL, NULL),
(559, 'MAGDALENA', NULL, 54, NULL, NULL),
(560, 'MATARA', NULL, 54, NULL, NULL),
(561, 'NAMORA', NULL, 54, NULL, NULL),
(562, 'SAN JUAN', NULL, 54, NULL, NULL),
(563, 'CAJABAMBA', NULL, 55, NULL, NULL),
(564, 'CACHACHI', NULL, 55, NULL, NULL),
(565, 'CONDEBAMBA', NULL, 55, NULL, NULL),
(566, 'SITACOCHA', NULL, 55, NULL, NULL),
(567, 'CELENDIN', NULL, 56, NULL, NULL),
(568, 'CHUMUCH', NULL, 56, NULL, NULL),
(569, 'CORTEGANA', NULL, 56, NULL, NULL),
(570, 'HUASMIN', NULL, 56, NULL, NULL),
(571, 'JORGE CHAVEZ', NULL, 56, NULL, NULL),
(572, 'JOSE GALVEZ', NULL, 56, NULL, NULL),
(573, 'MIGUEL IGLESIAS', NULL, 56, NULL, NULL),
(574, 'OXAMARCA', NULL, 56, NULL, NULL),
(575, 'SOROCHUCO', NULL, 56, NULL, NULL),
(576, 'SUCRE', NULL, 56, NULL, NULL),
(577, 'UTCO', NULL, 56, NULL, NULL),
(578, 'LA LIBERTAD DE PALLAN', NULL, 56, NULL, NULL),
(579, 'CHOTA', NULL, 57, NULL, NULL),
(580, 'ANGUIA', NULL, 57, NULL, NULL),
(581, 'CHADIN', NULL, 57, NULL, NULL),
(582, 'CHIGUIRIP', NULL, 57, NULL, NULL),
(583, 'CHIMBAN', NULL, 57, NULL, NULL),
(584, 'CHOROPAMPA', NULL, 57, NULL, NULL),
(585, 'COCHABAMBA', NULL, 57, NULL, NULL),
(586, 'CONCHAN', NULL, 57, NULL, NULL),
(587, 'HUAMBOS', NULL, 57, NULL, NULL),
(588, 'LAJAS', NULL, 57, NULL, NULL),
(589, 'LLAMA', NULL, 57, NULL, NULL),
(590, 'MIRACOSTA', NULL, 57, NULL, NULL),
(591, 'PACCHA', NULL, 57, NULL, NULL),
(592, 'PION', NULL, 57, NULL, NULL),
(593, 'QUEROCOTO', NULL, 57, NULL, NULL),
(594, 'SAN JUAN DE LICUPIS', NULL, 57, NULL, NULL),
(595, 'TACABAMBA', NULL, 57, NULL, NULL),
(596, 'TOCMOCHE', NULL, 57, NULL, NULL),
(597, 'CHALAMARCA', NULL, 57, NULL, NULL),
(598, 'CONTUMAZA', NULL, 58, NULL, NULL),
(599, 'CHILETE', NULL, 58, NULL, NULL),
(600, 'CUPISNIQUE', NULL, 58, NULL, NULL),
(601, 'GUZMANGO', NULL, 58, NULL, NULL),
(602, 'SAN BENITO', NULL, 58, NULL, NULL),
(603, 'SANTA CRUZ DE TOLED', NULL, 58, NULL, NULL),
(604, 'TANTARICA', NULL, 58, NULL, NULL),
(605, 'YONAN', NULL, 58, NULL, NULL),
(606, 'CUTERVO', NULL, 59, NULL, NULL),
(607, 'CALLAYUC', NULL, 59, NULL, NULL),
(608, 'CHOROS', NULL, 59, NULL, NULL),
(609, 'CUJILLO', NULL, 59, NULL, NULL),
(610, 'LA RAMADA', NULL, 59, NULL, NULL),
(611, 'PIMPINGOS', NULL, 59, NULL, NULL),
(612, 'QUEROCOTILLO', NULL, 59, NULL, NULL),
(613, 'SAN ANDRES DE CUTERVO', NULL, 59, NULL, NULL),
(614, 'SAN JUAN DE CUTERVO', NULL, 59, NULL, NULL),
(615, 'SAN LUIS DE LUCMA', NULL, 59, NULL, NULL),
(616, 'SANTA CRUZ', NULL, 59, NULL, NULL),
(617, 'SANTO DOMINGO DE LA CAPILLA', NULL, 59, NULL, NULL),
(618, 'SANTO TOMAS', NULL, 59, NULL, NULL),
(619, 'SOCOTA', NULL, 59, NULL, NULL),
(620, 'TORIBIO CASANOVA', NULL, 59, NULL, NULL),
(621, 'BAMBAMARCA', NULL, 60, NULL, NULL),
(622, 'CHUGUR', NULL, 60, NULL, NULL),
(623, 'HUALGAYOC', NULL, 60, NULL, NULL),
(624, 'JAEN', NULL, 61, NULL, NULL),
(625, 'BELLAVISTA', NULL, 61, NULL, NULL),
(626, 'CHONTALI', NULL, 61, NULL, NULL),
(627, 'COLASAY', NULL, 61, NULL, NULL),
(628, 'HUABAL', NULL, 61, NULL, NULL),
(629, 'LAS PIRIAS', NULL, 61, NULL, NULL),
(630, 'POMAHUACA', NULL, 61, NULL, NULL),
(631, 'PUCARA', NULL, 61, NULL, NULL),
(632, 'SALLIQUE', NULL, 61, NULL, NULL),
(633, 'SAN FELIPE', NULL, 61, NULL, NULL),
(634, 'SAN JOSE DEL ALTO', NULL, 61, NULL, NULL),
(635, 'SANTA ROSA', NULL, 61, NULL, NULL),
(636, 'SAN IGNACIO', NULL, 62, NULL, NULL),
(637, 'CHIRINOS', NULL, 62, NULL, NULL),
(638, 'HUARANGO', NULL, 62, NULL, NULL),
(639, 'LA COIPA', NULL, 62, NULL, NULL),
(640, 'NAMBALLE', NULL, 62, NULL, NULL),
(641, 'SAN JOSE DE LOURDES', NULL, 62, NULL, NULL),
(642, 'TABACONAS', NULL, 62, NULL, NULL),
(643, 'PEDRO GALVEZ', NULL, 63, NULL, NULL),
(644, 'CHANCAY', NULL, 63, NULL, NULL),
(645, 'EDUARDO VILLANUEVA', NULL, 63, NULL, NULL),
(646, 'GREGORIO PITA', NULL, 63, NULL, NULL),
(647, 'ICHOCAN', NULL, 63, NULL, NULL),
(648, 'JOSE MANUEL QUIROZ', NULL, 63, NULL, NULL),
(649, 'JOSE SABOGAL', NULL, 63, NULL, NULL),
(650, 'SAN MIGUEL', NULL, 64, NULL, NULL),
(651, 'SAN MIGUEL', NULL, 64, NULL, NULL),
(652, 'BOLIVAR', NULL, 64, NULL, NULL),
(653, 'CALQUIS', NULL, 64, NULL, NULL),
(654, 'CATILLUC', NULL, 64, NULL, NULL),
(655, 'EL PRADO', NULL, 64, NULL, NULL),
(656, 'LA FLORIDA', NULL, 64, NULL, NULL),
(657, 'LLAPA', NULL, 64, NULL, NULL),
(658, 'NANCHOC', NULL, 64, NULL, NULL),
(659, 'NIEPOS', NULL, 64, NULL, NULL),
(660, 'SAN GREGORIO', NULL, 64, NULL, NULL),
(661, 'SAN SILVESTRE DE COCHAN', NULL, 64, NULL, NULL),
(662, 'TONGOD', NULL, 64, NULL, NULL),
(663, 'UNION AGUA BLANCA', NULL, 64, NULL, NULL),
(664, 'SAN PABLO', NULL, 65, NULL, NULL),
(665, 'SAN BERNARDINO', NULL, 65, NULL, NULL),
(666, 'SAN LUIS', NULL, 65, NULL, NULL),
(667, 'TUMBADEN', NULL, 65, NULL, NULL),
(668, 'SANTA CRUZ', NULL, 65, NULL, NULL),
(669, 'ANDABAMBA', NULL, 65, NULL, NULL),
(670, 'CATACHE', NULL, 65, NULL, NULL),
(671, 'CHANCAYBAÑOS', NULL, 65, NULL, NULL),
(672, 'LA ESPERANZA', NULL, 65, NULL, NULL),
(673, 'NINABAMBA', NULL, 65, NULL, NULL),
(674, 'PULAN', NULL, 65, NULL, NULL),
(675, 'SAUCEPAMPA', NULL, 65, NULL, NULL),
(676, 'SEXI', NULL, 65, NULL, NULL),
(677, 'UTICYACU', NULL, 65, NULL, NULL),
(678, 'YAUYUCAN', NULL, 65, NULL, NULL),
(679, 'CALLAO', NULL, 66, NULL, NULL),
(680, 'BELLAVISTA', NULL, 66, NULL, NULL),
(681, 'CARMEN DE LA LEGUA REYNOSO', NULL, 66, NULL, NULL),
(682, 'LA PERLA', NULL, 66, NULL, NULL),
(683, 'LA PUNTA', NULL, 65, NULL, NULL),
(684, 'VENTANILLA', NULL, 66, NULL, NULL),
(685, 'CUSCO', NULL, 67, NULL, NULL),
(686, 'CCORCA', NULL, 67, NULL, NULL),
(687, 'POROY', NULL, 67, NULL, NULL),
(688, 'SAN JERONIMO', NULL, 67, NULL, NULL),
(689, 'SAN SEBASTIAN', NULL, 67, NULL, NULL),
(690, 'SANTIAGO', NULL, 67, NULL, NULL),
(691, 'SAYLLA', NULL, 67, NULL, NULL),
(692, 'WANCHAQ', NULL, 67, NULL, NULL),
(693, 'ACOMAYO', NULL, 68, NULL, NULL),
(694, 'ACOPIA', NULL, 68, NULL, NULL),
(695, 'ACOS', NULL, 68, NULL, NULL),
(696, 'MOSOC LLACTA', NULL, 68, NULL, NULL),
(697, 'POMACANCHI', NULL, 68, NULL, NULL),
(698, 'RONDOCAN', NULL, 68, NULL, NULL),
(699, 'SANGARARA', NULL, 68, NULL, NULL),
(700, 'ANTA', NULL, 69, NULL, NULL),
(701, 'ANCAHUASI', NULL, 69, NULL, NULL),
(702, 'CACHIMAYO', NULL, 69, NULL, NULL),
(703, 'CHINCHAYPUJIO', NULL, 69, NULL, NULL),
(704, 'HUAROCONDO', NULL, 69, NULL, NULL),
(705, 'LIMATAMBO', NULL, 69, NULL, NULL),
(706, 'MOLLEPATA', NULL, 69, NULL, NULL),
(707, 'PUCYURA', NULL, 69, NULL, NULL),
(708, 'ZURITE', NULL, 69, NULL, NULL),
(709, 'CALCA', NULL, 70, NULL, NULL),
(710, 'COYA', NULL, 70, NULL, NULL),
(711, 'LAMAY', NULL, 70, NULL, NULL),
(712, 'LARES', NULL, 70, NULL, NULL),
(713, 'PISAC', NULL, 70, NULL, NULL),
(714, 'SAN SALVADOR', NULL, 70, NULL, NULL),
(715, 'TARAY', NULL, 70, NULL, NULL),
(716, 'YANATILE', NULL, 70, NULL, NULL),
(717, 'YANAOCA', NULL, 71, NULL, NULL),
(718, 'CHECCA', NULL, 71, NULL, NULL),
(719, 'KUNTURKANKI', NULL, 71, NULL, NULL),
(720, 'LANGUI', NULL, 71, NULL, NULL),
(721, 'LAYO', NULL, 71, NULL, NULL),
(722, 'PAMPAMARCA', NULL, 71, NULL, NULL),
(723, 'QUEHUE', NULL, 71, NULL, NULL),
(724, 'TUPAC AMARU', NULL, 71, NULL, NULL),
(725, 'SICUANI', NULL, 72, NULL, NULL),
(726, 'CHECACUPE', NULL, 72, NULL, NULL),
(727, 'COMBAPATA', NULL, 72, NULL, NULL),
(728, 'MARANGANI', NULL, 72, NULL, NULL),
(729, 'PITUMARCA', NULL, 72, NULL, NULL),
(730, 'SAN PABLO', NULL, 72, NULL, NULL),
(731, 'SAN PEDRO', NULL, 72, NULL, NULL),
(732, 'TINTA', NULL, 72, NULL, NULL),
(733, 'SANTO TOMAS', NULL, 73, NULL, NULL),
(734, 'CAPACMARCA', NULL, 73, NULL, NULL),
(735, 'CHAMACA', NULL, 73, NULL, NULL),
(736, 'COLQUEMARCA', NULL, 73, NULL, NULL),
(737, 'LIVITACA', NULL, 73, NULL, NULL),
(738, 'LLUSCO', NULL, 73, NULL, NULL),
(739, 'QUIÑOTA', NULL, 73, NULL, NULL),
(740, 'VELILLE', NULL, 73, NULL, NULL),
(741, 'ESPINAR', NULL, 74, NULL, NULL),
(742, 'CONDOROMA', NULL, 74, NULL, NULL),
(743, 'COPORAQUE', NULL, 74, NULL, NULL),
(744, 'OCORURO', NULL, 74, NULL, NULL),
(745, 'PALLPATA', NULL, 74, NULL, NULL),
(746, 'PICHIGUA', NULL, 74, NULL, NULL),
(747, 'SUYCKUTAMBO', NULL, 74, NULL, NULL),
(748, 'ALTO PICHIGUA', NULL, 74, NULL, NULL),
(749, 'SANTA ANA', NULL, 75, NULL, NULL),
(750, 'ECHARATE', NULL, 75, NULL, NULL),
(751, 'HUAYOPATA', NULL, 75, NULL, NULL),
(752, 'MARANURA', NULL, 75, NULL, NULL),
(753, 'OCOBAMBA', NULL, 75, NULL, NULL),
(754, 'QUELLOUNO', NULL, 75, NULL, NULL),
(755, 'KIMBIRI', NULL, 75, NULL, NULL),
(756, 'SANTA TERESA', NULL, 75, NULL, NULL),
(757, 'VILCABAMBA', NULL, 75, NULL, NULL),
(758, 'PICHARI', NULL, 75, NULL, NULL),
(759, 'PARURO', NULL, 76, NULL, NULL),
(760, 'ACCHA', NULL, 76, NULL, NULL),
(761, 'CCAPI', NULL, 76, NULL, NULL),
(762, 'COLCHA', NULL, 76, NULL, NULL),
(763, 'HUANOQUITE', NULL, 76, NULL, NULL),
(764, 'OMACHA', NULL, 76, NULL, NULL),
(765, 'PACCARITAMBO', NULL, 76, NULL, NULL),
(766, 'PILLPINTO', NULL, 76, NULL, NULL),
(767, 'YAURISQUE', NULL, 76, NULL, NULL),
(768, 'PAUCARTAMBO', NULL, 77, NULL, NULL),
(769, 'CAICAY', NULL, 77, NULL, NULL),
(770, 'CHALLABAMBA', NULL, 77, NULL, NULL),
(771, 'COLQUEPATA', NULL, 77, NULL, NULL),
(772, 'HUANCARANI', NULL, 77, NULL, NULL),
(773, 'KOSÑIPATA', NULL, 77, NULL, NULL),
(774, 'URCOS', NULL, 78, NULL, NULL),
(775, 'ANDAHUAYLILLAS', NULL, 78, NULL, NULL),
(776, 'CAMANTI', NULL, 78, NULL, NULL),
(777, 'CCARHUAYO', NULL, 78, NULL, NULL),
(778, 'CCATCA', NULL, 78, NULL, NULL),
(779, 'CUSIPATA', NULL, 78, NULL, NULL),
(780, 'HUARO', NULL, 78, NULL, NULL),
(781, 'LUCRE', NULL, 78, NULL, NULL),
(782, 'MARCAPATA', NULL, 78, NULL, NULL),
(783, 'OCONGATE', NULL, 78, NULL, NULL),
(784, 'OROPESA', NULL, 78, NULL, NULL),
(785, 'QUIQUIJANA', NULL, 78, NULL, NULL),
(786, 'URUBAMBA', NULL, 79, NULL, NULL),
(787, 'CHINCHERO', NULL, 79, NULL, NULL),
(788, 'HUAYLLABAMBA', NULL, 79, NULL, NULL),
(789, 'MACHUPICCHU', NULL, 79, NULL, NULL),
(790, 'MARAS', NULL, 79, NULL, NULL),
(791, 'OLLANTAYTAMBO', NULL, 79, NULL, NULL),
(792, 'YUCAY', NULL, 79, NULL, NULL),
(793, 'HUANCAVELICA', NULL, 80, NULL, NULL),
(794, 'ACOBAMBILLA', NULL, 80, NULL, NULL),
(795, 'ACORIA', NULL, 80, NULL, NULL),
(796, 'CONAYCA', NULL, 80, NULL, NULL),
(797, 'CUENCA', NULL, 80, NULL, NULL),
(798, 'HUACHOCOLPA', NULL, 80, NULL, NULL),
(799, 'HUAYLLAHUARA', NULL, 80, NULL, NULL),
(800, 'IZCUCHACA', NULL, 80, NULL, NULL),
(801, 'LARIA', NULL, 80, NULL, NULL),
(802, 'MANTA', NULL, 80, NULL, NULL),
(803, 'MARISCAL CACERES', NULL, 80, NULL, NULL),
(804, 'MOYA', NULL, 80, NULL, NULL),
(805, 'NUEVO OCCORO', NULL, 80, NULL, NULL),
(806, 'PALCA', NULL, 80, NULL, NULL),
(807, 'PILCHACA', NULL, 80, NULL, NULL),
(808, 'VILCA', NULL, 80, NULL, NULL),
(809, 'YAULI', NULL, 80, NULL, NULL),
(810, 'ASCENSION', NULL, 80, NULL, NULL),
(811, 'HUANDO', NULL, 80, NULL, NULL),
(812, 'ACOBAMBA', NULL, 81, NULL, NULL),
(813, 'ANDABAMBA', NULL, 81, NULL, NULL),
(814, 'ANTA', NULL, 81, NULL, NULL),
(815, 'CAJA', NULL, 81, NULL, NULL),
(816, 'MARCAS', NULL, 81, NULL, NULL),
(817, 'PAUCARA', NULL, 81, NULL, NULL),
(818, 'POMACOCHA', NULL, 81, NULL, NULL),
(819, 'ROSARIO', NULL, 81, NULL, NULL),
(820, 'LIRCAY', NULL, 82, NULL, NULL),
(821, 'ANCHONGA', NULL, 82, NULL, NULL),
(822, 'CALLANMARCA', NULL, 82, NULL, NULL),
(823, 'CCOCHACCASA', NULL, 82, NULL, NULL),
(824, 'CHINCHO', NULL, 82, NULL, NULL),
(825, 'CONGALLA', NULL, 82, NULL, NULL),
(826, 'HUANCA-HUANCA', NULL, 82, NULL, NULL),
(827, 'HUAYLLAY GRANDE', NULL, 82, NULL, NULL),
(828, 'JULCAMARCA', NULL, 82, NULL, NULL),
(829, 'SAN ANTONIO DE ANTAPARCO', NULL, 82, NULL, NULL),
(830, 'SANTO TOMAS DE PATA', NULL, 82, NULL, NULL),
(831, 'SECCLLA', NULL, 82, NULL, NULL),
(832, 'CASTROVIRREYNA', NULL, 83, NULL, NULL),
(833, 'ARMA', NULL, 83, NULL, NULL),
(834, 'AURAHUA', NULL, 83, NULL, NULL),
(835, 'CAPILLAS', NULL, 83, NULL, NULL),
(836, 'CHUPAMARCA', NULL, 83, NULL, NULL),
(837, 'COCAS', NULL, 83, NULL, NULL),
(838, 'HUACHOS', NULL, 83, NULL, NULL),
(839, 'HUAMATAMBO', NULL, 83, NULL, NULL),
(840, 'MOLLEPAMPA', NULL, 83, NULL, NULL),
(841, 'SAN JUAN', NULL, 83, NULL, NULL),
(842, 'SANTA ANA', NULL, 83, NULL, NULL),
(843, 'TANTARA', NULL, 83, NULL, NULL),
(844, 'TICRAPO', NULL, 83, NULL, NULL),
(845, 'CHURCAMPA', NULL, 84, NULL, NULL),
(846, 'ANCO', NULL, 84, NULL, NULL),
(847, 'CHINCHIHUASI', NULL, 84, NULL, NULL),
(848, 'EL CARMEN', NULL, 84, NULL, NULL),
(849, 'LA MERCED', NULL, 84, NULL, NULL),
(850, 'LOCROJA', NULL, 84, NULL, NULL),
(851, 'PAUCARBAMBA', NULL, 84, NULL, NULL),
(852, 'SAN MIGUEL DE MAYOCC', NULL, 84, NULL, NULL),
(853, 'SAN PEDRO DE CORIS', NULL, 84, NULL, NULL),
(854, 'PACHAMARCA', NULL, 84, NULL, NULL),
(855, 'HUAYTARA', NULL, 85, NULL, NULL),
(856, 'AYAVI', NULL, 85, NULL, NULL),
(857, 'CORDOVA', NULL, 85, NULL, NULL),
(858, 'HUAYACUNDO ARMA', NULL, 85, NULL, NULL),
(859, 'LARAMARCA', NULL, 85, NULL, NULL),
(860, 'OCOYO', NULL, 85, NULL, NULL),
(861, 'PILPICHACA', NULL, 85, NULL, NULL),
(862, 'QUERCO', NULL, 85, NULL, NULL),
(863, 'QUITO-ARMA', NULL, 85, NULL, NULL),
(864, 'SAN ANTONIO DE CUSICANCHA', NULL, 85, NULL, NULL),
(865, 'SAN FRANCISCO DE SANGAYAICO', NULL, 85, NULL, NULL),
(866, 'SAN ISIDRO', NULL, 85, NULL, NULL),
(867, 'SANTIAGO DE CHOCORVOS', NULL, 85, NULL, NULL),
(868, 'SANTIAGO DE QUIRAHUARA', NULL, 85, NULL, NULL),
(869, 'SANTO DOMINGO DE CAPILLAS', NULL, 85, NULL, NULL),
(870, 'TAMBO', NULL, 85, NULL, NULL),
(871, 'PAMPAS', NULL, 86, NULL, NULL),
(872, 'ACOSTAMBO', NULL, 86, NULL, NULL),
(873, 'ACRAQUIA', NULL, 86, NULL, NULL),
(874, 'AHUAYCHA', NULL, 86, NULL, NULL),
(875, 'COLCABAMBA', NULL, 86, NULL, NULL),
(876, 'DANIEL HERNANDEZ', NULL, 86, NULL, NULL),
(877, 'HUACHOCOLPA', NULL, 86, NULL, NULL),
(878, 'HUARIBAMBA', NULL, 86, NULL, NULL),
(879, 'ÑAHUIMPUQUIO', NULL, 86, NULL, NULL),
(880, 'PAZOS', NULL, 86, NULL, NULL),
(881, 'QUISHUAR', NULL, 86, NULL, NULL),
(882, 'SALCABAMBA', NULL, 86, NULL, NULL),
(883, 'SALCAHUASI', NULL, 86, NULL, NULL),
(884, 'SAN MARCOS DE ROCCHAC', NULL, 86, NULL, NULL),
(885, 'SURCUBAMBA', NULL, 86, NULL, NULL),
(886, 'TINTAY PUNCU', NULL, 86, NULL, NULL),
(887, 'HUANUCO', NULL, 87, NULL, NULL),
(888, 'AMARILIS', NULL, 87, NULL, NULL),
(889, 'CHINCHAO', NULL, 87, NULL, NULL),
(890, 'CHURUBAMBA', NULL, 87, NULL, NULL),
(891, 'MARGOS', NULL, 87, NULL, NULL),
(892, 'QUISQUI', NULL, 87, NULL, NULL),
(893, 'SAN FRANCISCO DE CAYRAN', NULL, 87, NULL, NULL),
(894, 'SAN PEDRO DE CHAULAN', NULL, 87, NULL, NULL),
(895, 'SANTA MARIA DEL VALLE', NULL, 87, NULL, NULL),
(896, 'YARUMAYO', NULL, 87, NULL, NULL),
(897, 'PILLCO MARCA', NULL, 87, NULL, NULL),
(898, 'AMBO', NULL, 88, NULL, NULL),
(899, 'CAYNA', NULL, 88, NULL, NULL),
(900, 'COLPAS', NULL, 88, NULL, NULL),
(901, 'CONCHAMARCA', NULL, 88, NULL, NULL),
(902, 'HUACAR', NULL, 88, NULL, NULL),
(903, 'SAN FRANCISCO', NULL, 88, NULL, NULL),
(904, 'SAN RAFAEL', NULL, 88, NULL, NULL),
(905, 'TOMAY KICHWA', NULL, 88, NULL, NULL),
(906, 'LA UNION', NULL, 89, NULL, NULL),
(907, 'CHUQUIS', NULL, 89, NULL, NULL),
(908, 'MARIAS', NULL, 89, NULL, NULL),
(909, 'PACHAS', NULL, 89, NULL, NULL),
(910, 'QUIVILLA', NULL, 89, NULL, NULL),
(911, 'RIPAN', NULL, 89, NULL, NULL),
(912, 'SHUNQUI', NULL, 89, NULL, NULL),
(913, 'SILLAPATA', NULL, 89, NULL, NULL),
(914, 'YANAS', NULL, 89, NULL, NULL),
(915, 'HUACAYBAMBA', NULL, 90, NULL, NULL),
(916, 'CANCHABAMBA', NULL, 90, NULL, NULL),
(917, 'COCHABAMBA', NULL, 90, NULL, NULL),
(918, 'PINRA', NULL, 90, NULL, NULL),
(919, 'LLATA', NULL, 91, NULL, NULL),
(920, 'ARANCAY', NULL, 91, NULL, NULL),
(921, 'CHAVIN DE PARIARCA', NULL, 91, NULL, NULL),
(922, 'JACAS GRANDE', NULL, 91, NULL, NULL),
(923, 'JIRCAN', NULL, 91, NULL, NULL),
(924, 'MIRAFLORES', NULL, 91, NULL, NULL),
(925, 'MONZON', NULL, 91, NULL, NULL),
(926, 'PUNCHAO', NULL, 91, NULL, NULL),
(927, 'PUÑOS', NULL, 91, NULL, NULL),
(928, 'SINGA', NULL, 91, NULL, NULL),
(929, 'TANTAMAYO', NULL, 91, NULL, NULL),
(930, 'RUPA-RUPA', NULL, 92, NULL, NULL),
(931, 'DANIEL ALOMIA ROBLES', NULL, 92, NULL, NULL),
(932, 'HERMILIO VALDIZAN', NULL, 92, NULL, NULL),
(933, 'JOSE CRESPO Y CASTILLO', NULL, 92, NULL, NULL),
(934, 'LUYANDO', NULL, 92, NULL, NULL),
(935, 'MARIANO DAMASO BERAUN', NULL, 92, NULL, NULL),
(936, 'HUACRACHUCO', NULL, 93, NULL, NULL),
(937, 'CHOLON', NULL, 93, NULL, NULL),
(938, 'SAN BUENAVENTURA', NULL, 93, NULL, NULL),
(939, 'PANAO', NULL, 94, NULL, NULL),
(940, 'CHAGLLA', NULL, 94, NULL, NULL),
(941, 'MOLINO', NULL, 94, NULL, NULL),
(942, 'UMARI', NULL, 94, NULL, NULL),
(943, 'PUERTO INCA', NULL, 95, NULL, NULL),
(944, 'CODO DEL POZUZO', NULL, 95, NULL, NULL),
(945, 'HONORIA', NULL, 95, NULL, NULL),
(946, 'TOURNAVISTA', NULL, 95, NULL, NULL),
(947, 'YUYAPICHIS', NULL, 95, NULL, NULL),
(948, 'JESUS', NULL, 96, NULL, NULL),
(949, 'BAÑOS', NULL, 96, NULL, NULL),
(950, 'JIVIA', NULL, 96, NULL, NULL),
(951, 'QUEROPALCA', NULL, 96, NULL, NULL),
(952, 'RONDOS', NULL, 96, NULL, NULL),
(953, 'SAN FRANCISCO DE ASIS', NULL, 96, NULL, NULL),
(954, 'SAN MIGUEL DE CAURI', NULL, 96, NULL, NULL),
(955, 'CHAVINILLO', NULL, 97, NULL, NULL),
(956, 'CAHUAC', NULL, 97, NULL, NULL),
(957, 'CHACABAMBA', NULL, 97, NULL, NULL),
(958, 'APARICIO POMARES', NULL, 97, NULL, NULL),
(959, 'JACAS CHICO', NULL, 97, NULL, NULL),
(960, 'OBAS', NULL, 97, NULL, NULL),
(961, 'PAMPAMARCA', NULL, 97, NULL, NULL),
(962, 'CHORAS', NULL, 97, NULL, NULL),
(963, 'ICA', NULL, 98, NULL, NULL),
(964, 'LA TINGUIÑA', NULL, 98, NULL, NULL),
(965, 'LOS AQUIJES', NULL, 98, NULL, NULL),
(966, 'OCUCAJE', NULL, 98, NULL, NULL),
(967, 'PACHACUTEC', NULL, 98, NULL, NULL),
(968, 'PARCONA', NULL, 98, NULL, NULL),
(969, 'PUEBLO NUEVO', NULL, 98, NULL, NULL),
(970, 'SALAS', NULL, 98, NULL, NULL),
(971, 'SAN JOSE DE LOS MOLINOS', NULL, 98, NULL, NULL),
(972, 'SAN JUAN BAUTISTA', NULL, 98, NULL, NULL),
(973, 'SANTIAGO', NULL, 98, NULL, NULL),
(974, 'SUBTANJALLA', NULL, 98, NULL, NULL),
(975, 'TATE', NULL, 98, NULL, NULL),
(976, 'YAUCA DEL ROSARIO', NULL, 98, NULL, NULL),
(977, 'CHINCHA ALTA', NULL, 99, NULL, NULL),
(978, 'ALTO LARAN', NULL, 99, NULL, NULL),
(979, 'CHAVIN', NULL, 99, NULL, NULL),
(980, 'CHINCHA BAJA', NULL, 99, NULL, NULL),
(981, 'EL CARMEN', NULL, 99, NULL, NULL),
(982, 'GROCIO PRADO', NULL, 99, NULL, NULL),
(983, 'PUEBLO NUEVO', NULL, 99, NULL, NULL),
(984, 'SAN JUAN DE YANAC', NULL, 99, NULL, NULL),
(985, 'SAN PEDRO DE HUACARPANA', NULL, 99, NULL, NULL),
(986, 'SUNAMPE', NULL, 99, NULL, NULL),
(987, 'TAMBO DE MORA', NULL, 99, NULL, NULL),
(988, 'NAZCA', NULL, 100, NULL, NULL),
(989, 'CHANGUILLO', NULL, 100, NULL, NULL),
(990, 'EL INGENIO', NULL, 100, NULL, NULL),
(991, 'MARCONA', NULL, 100, NULL, NULL),
(992, 'VISTA ALEGRE', NULL, 100, NULL, NULL),
(993, 'PALPA', NULL, 101, NULL, NULL),
(994, 'LLIPATA', NULL, 101, NULL, NULL),
(995, 'RIO GRANDE', NULL, 101, NULL, NULL),
(996, 'SANTA CRUZ', NULL, 101, NULL, NULL),
(997, 'TIBILLO', NULL, 101, NULL, NULL),
(998, 'PISCO', NULL, 102, NULL, NULL),
(999, 'HUANCANO', NULL, 102, NULL, NULL),
(1000, 'HUMAY', NULL, 102, NULL, NULL),
(1001, 'INDEPENDENCIA', NULL, 102, NULL, NULL),
(1002, 'PARACAS', NULL, 102, NULL, NULL),
(1003, 'SAN ANDRES', NULL, 102, NULL, NULL),
(1004, 'SAN CLEMENTE', NULL, 102, NULL, NULL),
(1005, 'TUPAC AMARU INCA', NULL, 102, NULL, NULL),
(1006, 'HUANCAYO', NULL, 103, NULL, NULL),
(1007, 'CARHUACALLANGA', NULL, 103, NULL, NULL),
(1008, 'CHACAPAMPA', NULL, 103, NULL, NULL),
(1009, 'CHICCHE', NULL, 103, NULL, NULL),
(1010, 'CHILCA', NULL, 103, NULL, NULL),
(1011, 'CHONGOS ALTO', NULL, 103, NULL, NULL),
(1012, 'CHUPURO', NULL, 103, NULL, NULL),
(1013, 'COLCA', NULL, 103, NULL, NULL),
(1014, 'CULLHUAS', NULL, 103, NULL, NULL),
(1015, 'EL TAMBO', NULL, 103, NULL, NULL),
(1016, 'HUACRAPUQUIO', NULL, 103, NULL, NULL),
(1017, 'HUALHUAS', NULL, 103, NULL, NULL),
(1018, 'HUANCAN', NULL, 103, NULL, NULL),
(1019, 'HUASICANCHA', NULL, 103, NULL, NULL),
(1020, 'HUAYUCACHI', NULL, 103, NULL, NULL),
(1021, 'INGENIO', NULL, 103, NULL, NULL),
(1022, 'PARIAHUANCA', NULL, 103, NULL, NULL),
(1023, 'PILCOMAYO', NULL, 103, NULL, NULL),
(1024, 'PUCARA', NULL, 103, NULL, NULL),
(1025, 'QUICHUAY', NULL, 103, NULL, NULL),
(1026, 'QUILCAS', NULL, 103, NULL, NULL),
(1027, 'SAN AGUSTIN', NULL, 103, NULL, NULL),
(1028, 'SAN JERONIMO DE TUNAN', NULL, 103, NULL, NULL),
(1029, 'SAÑO', NULL, 103, NULL, NULL),
(1030, 'SAPALLANGA', NULL, 103, NULL, NULL),
(1031, 'SICAYA', NULL, 103, NULL, NULL),
(1032, 'SANTO DOMINGO DE ACOBAMBA', NULL, 103, NULL, NULL),
(1033, 'VIQUES', NULL, 103, NULL, NULL),
(1034, 'CONCEPCION', NULL, 104, NULL, NULL),
(1035, 'ACO', NULL, 104, NULL, NULL),
(1036, 'ANDAMARCA', NULL, 104, NULL, NULL),
(1037, 'CHAMBARA', NULL, 104, NULL, NULL),
(1038, 'COCHAS', NULL, 104, NULL, NULL),
(1039, 'COMAS', NULL, 104, NULL, NULL),
(1040, 'HEROINAS TOLEDO', NULL, 104, NULL, NULL),
(1041, 'MANZANARES', NULL, 104, NULL, NULL),
(1042, 'MARISCAL CASTILLA', NULL, 104, NULL, NULL),
(1043, 'MATAHUASI', NULL, 104, NULL, NULL),
(1044, 'MITO', NULL, 104, NULL, NULL),
(1045, 'NUEVE DE JULIO', NULL, 104, NULL, NULL),
(1046, 'ORCOTUNA', NULL, 104, NULL, NULL),
(1047, 'SAN JOSE DE QUERO', NULL, 104, NULL, NULL),
(1048, 'SANTA ROSA DE OCOPA', NULL, 104, NULL, NULL),
(1049, 'CHANCHAMAYO', NULL, 105, NULL, NULL),
(1050, 'PERENE', NULL, 105, NULL, NULL),
(1051, 'PICHANAQUI', NULL, 105, NULL, NULL),
(1052, 'SAN LUIS DE SHUARO', NULL, 105, NULL, NULL),
(1053, 'SAN RAMON', NULL, 105, NULL, NULL),
(1054, 'VITOC', NULL, 105, NULL, NULL),
(1055, 'JAUJA', NULL, 106, NULL, NULL),
(1056, 'ACOLLA', NULL, 106, NULL, NULL),
(1057, 'APATA', NULL, 106, NULL, NULL),
(1058, 'ATAURA', NULL, 106, NULL, NULL),
(1059, 'CANCHAYLLO', NULL, 106, NULL, NULL),
(1060, 'CURICACA', NULL, 106, NULL, NULL),
(1061, 'EL MANTARO', NULL, 106, NULL, NULL),
(1062, 'HUAMALI', NULL, 106, NULL, NULL),
(1063, 'HUARIPAMPA', NULL, 106, NULL, NULL),
(1064, 'HUERTAS', NULL, 106, NULL, NULL),
(1065, 'JANJAILLO', NULL, 106, NULL, NULL),
(1066, 'JULCAN', NULL, 106, NULL, NULL),
(1067, 'LEONOR ORDOÑEZ', NULL, 106, NULL, NULL),
(1068, 'LLOCLLAPAMPA', NULL, 106, NULL, NULL),
(1069, 'MARCO', NULL, 106, NULL, NULL),
(1070, 'MASMA', NULL, 106, NULL, NULL),
(1071, 'MASMA CHICCHE', NULL, 106, NULL, NULL),
(1072, 'MOLINOS', NULL, 106, NULL, NULL),
(1073, 'MONOBAMBA', NULL, 106, NULL, NULL),
(1074, 'MUQUI', NULL, 106, NULL, NULL),
(1075, 'MUQUIYAUYO', NULL, 106, NULL, NULL),
(1076, 'PACA', NULL, 106, NULL, NULL),
(1077, 'PACCHA', NULL, 106, NULL, NULL),
(1078, 'PANCAN', NULL, 106, NULL, NULL),
(1079, 'PARCO', NULL, 106, NULL, NULL),
(1080, 'POMACANCHA', NULL, 106, NULL, NULL),
(1081, 'RICRAN', NULL, 106, NULL, NULL),
(1082, 'SAN LORENZO', NULL, 106, NULL, NULL),
(1083, 'SAN PEDRO DE CHUNAN', NULL, 106, NULL, NULL),
(1084, 'SAUSA', NULL, 106, NULL, NULL),
(1085, 'SINCOS', NULL, 106, NULL, NULL),
(1086, 'TUNAN MARCA', NULL, 106, NULL, NULL),
(1087, 'YAULI', NULL, 106, NULL, NULL),
(1088, 'YAUYOS', NULL, 106, NULL, NULL),
(1089, 'JUNIN', NULL, 107, NULL, NULL),
(1090, 'CARHUAMAYO', NULL, 107, NULL, NULL),
(1091, 'ONDORES', NULL, 107, NULL, NULL),
(1092, 'ULCUMAYO', NULL, 107, NULL, NULL),
(1093, 'SATIPO', NULL, 108, NULL, NULL),
(1094, 'COVIRIALI', NULL, 108, NULL, NULL),
(1095, 'LLAYLLA', NULL, 108, NULL, NULL),
(1096, 'MAZAMARI', NULL, 108, NULL, NULL),
(1097, 'PAMPA HERMOSA', NULL, 108, NULL, NULL),
(1098, 'PANGOA', NULL, 108, NULL, NULL),
(1099, 'RIO NEGRO', NULL, 108, NULL, NULL),
(1100, 'RIO TAMBO', NULL, 108, NULL, NULL),
(1101, 'TARMA', NULL, 109, NULL, NULL),
(1102, 'ACOBAMBA', NULL, 109, NULL, NULL),
(1103, 'HUARICOLCA', NULL, 109, NULL, NULL),
(1104, 'HUASAHUASI', NULL, 109, NULL, NULL),
(1105, 'LA UNION', NULL, 109, NULL, NULL),
(1106, 'PALCA', NULL, 109, NULL, NULL),
(1107, 'PALCAMAYO', NULL, 109, NULL, NULL),
(1108, 'SAN PEDRO DE CAJAS', NULL, 109, NULL, NULL),
(1109, 'TAPO', NULL, 109, NULL, NULL),
(1110, 'LA OROYA', NULL, 110, NULL, NULL),
(1111, 'CHACAPALPA', NULL, 110, NULL, NULL),
(1112, 'HUAY-HUAY', NULL, 110, NULL, NULL),
(1113, 'MARCAPOMACOCHA', NULL, 110, NULL, NULL),
(1114, 'MOROCOCHA', NULL, 110, NULL, NULL),
(1115, 'PACCHA', NULL, 110, NULL, NULL),
(1116, 'SANTA BARBARA DE CARHUACAYAN', NULL, 110, NULL, NULL),
(1117, 'SANTA ROSA DE SACCO', NULL, 110, NULL, NULL),
(1118, 'SUITUCANCHA', NULL, 110, NULL, NULL),
(1119, 'YAULI', NULL, 110, NULL, NULL),
(1120, 'CHUPACA', NULL, 111, NULL, NULL),
(1121, 'AHUAC', NULL, 111, NULL, NULL),
(1122, 'CHONGOS BAJO', NULL, 111, NULL, NULL),
(1123, 'HUACHAC', NULL, 111, NULL, NULL),
(1124, 'HUAMANCACA CHICO', NULL, 111, NULL, NULL),
(1125, 'SAN JUAN DE ISCOS', NULL, 111, NULL, NULL),
(1126, 'SAN JUAN DE JARPA', NULL, 111, NULL, NULL),
(1127, 'TRES DE DICIEMBRE', NULL, 111, NULL, NULL),
(1128, 'YANACANCHA', NULL, 111, NULL, NULL),
(1129, 'TRUJILLO', NULL, 112, NULL, NULL),
(1130, 'EL PORVENIR', NULL, 112, NULL, NULL),
(1131, 'FLORENCIA DE MORA', NULL, 112, NULL, NULL),
(1132, 'HUANCHACO', NULL, 112, NULL, NULL),
(1133, 'LA ESPERANZA', NULL, 112, NULL, NULL),
(1134, 'LAREDO', NULL, 112, NULL, NULL),
(1135, 'MOCHE', NULL, 112, NULL, NULL),
(1136, 'POROTO', NULL, 112, NULL, NULL),
(1137, 'SALAVERRY', NULL, 112, NULL, NULL),
(1138, 'SIMBAL', NULL, 112, NULL, NULL),
(1139, 'VICTOR LARCO HERRERA', NULL, 112, NULL, NULL),
(1140, 'ASCOPE', NULL, 113, NULL, NULL),
(1141, 'CHICAMA', NULL, 113, NULL, NULL),
(1142, 'CHOCOPE', NULL, 113, NULL, NULL),
(1143, 'MAGDALENA DE CAO', NULL, 113, NULL, NULL),
(1144, 'PAIJAN', NULL, 113, NULL, NULL),
(1145, 'RAZURI', NULL, 113, NULL, NULL),
(1146, 'SANTIAGO DE CAO', NULL, 113, NULL, NULL),
(1147, 'CASA GRANDE', NULL, 113, NULL, NULL),
(1148, 'BOLIVAR', NULL, 114, NULL, NULL),
(1149, 'BAMBAMARCA', NULL, 114, NULL, NULL),
(1150, 'CONDORMARCA', NULL, 114, NULL, NULL),
(1151, 'LONGOTEA', NULL, 114, NULL, NULL),
(1152, 'UCHUMARCA', NULL, 114, NULL, NULL),
(1153, 'UCUNCHA', NULL, 114, NULL, NULL),
(1154, 'CHEPEN', NULL, 115, NULL, NULL),
(1155, 'PACANGA', NULL, 115, NULL, NULL),
(1156, 'PUEBLO NUEVO', NULL, 115, NULL, NULL),
(1157, 'JULCAN', NULL, 116, NULL, NULL),
(1158, 'CALAMARCA', NULL, 116, NULL, NULL),
(1159, 'CARABAMBA', NULL, 116, NULL, NULL),
(1160, 'HUASO', NULL, 116, NULL, NULL),
(1161, 'OTUZCO', NULL, 117, NULL, NULL),
(1162, 'AGALLPAMPA', NULL, 117, NULL, NULL),
(1163, 'CHARAT', NULL, 117, NULL, NULL),
(1164, 'HUARANCHAL', NULL, 117, NULL, NULL),
(1165, 'LA CUESTA', NULL, 117, NULL, NULL),
(1166, 'MACHE', NULL, 117, NULL, NULL),
(1167, 'PARANDAY', NULL, 117, NULL, NULL),
(1168, 'SALPO', NULL, 117, NULL, NULL),
(1169, 'SINSICAP', NULL, 117, NULL, NULL),
(1170, 'USQUIL', NULL, 117, NULL, NULL),
(1171, 'SAN PEDRO DE LLOC', NULL, 118, NULL, NULL),
(1172, 'GUADALUPE', NULL, 118, NULL, NULL),
(1173, 'JEQUETEPEQUE', NULL, 118, NULL, NULL),
(1174, 'PACASMAYO', NULL, 118, NULL, NULL),
(1175, 'SAN JOSE', NULL, 118, NULL, NULL),
(1176, 'TAYABAMBA', NULL, 119, NULL, NULL),
(1177, 'BULDIBUYO', NULL, 119, NULL, NULL),
(1178, 'CHILLIA', NULL, 119, NULL, NULL),
(1179, 'HUANCASPATA', NULL, 119, NULL, NULL),
(1180, 'HUAYLILLAS', NULL, 119, NULL, NULL),
(1181, 'HUAYO', NULL, 119, NULL, NULL),
(1182, 'ONGON', NULL, 119, NULL, NULL),
(1183, 'PARCOY', NULL, 119, NULL, NULL),
(1184, 'PATAZ', NULL, 119, NULL, NULL),
(1185, 'PIAS', NULL, 119, NULL, NULL),
(1186, 'SANTIAGO DE CHALLAS', NULL, 119, NULL, NULL),
(1187, 'TAURIJA', NULL, 119, NULL, NULL),
(1188, 'URPAY', NULL, 119, NULL, NULL),
(1189, 'HUAMACHUCO', NULL, 120, NULL, NULL),
(1190, 'CHUGAY', NULL, 120, NULL, NULL),
(1191, 'COCHORCO', NULL, 120, NULL, NULL),
(1192, 'CURGOS', NULL, 120, NULL, NULL),
(1193, 'MARCABAL', NULL, 120, NULL, NULL),
(1194, 'SANAGORAN', NULL, 120, NULL, NULL),
(1195, 'SARIN', NULL, 120, NULL, NULL),
(1196, 'SARTIMBAMBA', NULL, 120, NULL, NULL),
(1197, 'SANTIAGO DE CHUCO', NULL, 121, NULL, NULL),
(1198, 'ANGASMARCA', NULL, 121, NULL, NULL),
(1199, 'CACHICADAN', NULL, 121, NULL, NULL),
(1200, 'MOLLEBAMBA', NULL, 121, NULL, NULL),
(1201, 'MOLLEPATA', NULL, 121, NULL, NULL),
(1202, 'QUIRUVILCA', NULL, 121, NULL, NULL),
(1203, 'SANTA CRUZ DE CHUCA', NULL, 121, NULL, NULL),
(1204, 'SITABAMBA', NULL, 121, NULL, NULL),
(1205, 'GRAN CHIMU', NULL, 122, NULL, NULL),
(1206, 'CASCAS', NULL, 122, NULL, NULL),
(1207, 'LUCMA', NULL, 122, NULL, NULL),
(1208, 'MARMOT', NULL, 122, NULL, NULL),
(1209, 'SAYAPULLO', NULL, 122, NULL, NULL),
(1210, 'VIRU', NULL, 123, NULL, NULL),
(1211, 'CHAO', NULL, 123, NULL, NULL),
(1212, 'GUADALUPITO', NULL, 123, NULL, NULL),
(1213, 'CHICLAYO', NULL, 124, NULL, NULL),
(1214, 'CHONGOYAPE', NULL, 124, NULL, NULL),
(1215, 'ETEN', NULL, 124, NULL, NULL),
(1216, 'ETEN PUERTO', NULL, 124, NULL, NULL),
(1217, 'JOSE LEONARDO ORTIZ', NULL, 124, NULL, NULL),
(1218, 'LA VICTORIA', NULL, 124, NULL, NULL),
(1219, 'LAGUNAS', NULL, 124, NULL, NULL),
(1220, 'MONSEFU', NULL, 124, NULL, NULL),
(1221, 'NUEVA ARICA', NULL, 124, NULL, NULL),
(1222, 'OYOTUN', NULL, 124, NULL, NULL),
(1223, 'PICSI', NULL, 124, NULL, NULL),
(1224, 'PIMENTEL', NULL, 124, NULL, NULL),
(1225, 'REQUE', NULL, 124, NULL, NULL),
(1226, 'SANTA ROSA', NULL, 124, NULL, NULL),
(1227, 'SAÑA', NULL, 124, NULL, NULL),
(1228, 'CAYALTI', NULL, 124, NULL, NULL),
(1229, 'PATAPO', NULL, 124, NULL, NULL),
(1230, 'POMALCA', NULL, 124, NULL, NULL),
(1231, 'PUCALA', NULL, 124, NULL, NULL),
(1232, 'TUMAN', NULL, 124, NULL, NULL),
(1233, 'FERREÑAFE', NULL, 125, NULL, NULL),
(1234, 'CAÑARIS', NULL, 125, NULL, NULL),
(1235, 'INCAHUASI', NULL, 125, NULL, NULL),
(1236, 'MANUEL ANTONIO MESONES MURO', NULL, 125, NULL, NULL);
INSERT INTO `distritos` (`id`, `distrito`, `status`, `provincia_id`, `created_at`, `updated_at`) VALUES
(1237, 'PITIPO', NULL, 125, NULL, NULL),
(1238, 'PUEBLO NUEVO', NULL, 125, NULL, NULL),
(1239, 'LAMBAYEQUE', NULL, 126, NULL, NULL),
(1240, 'CHOCHOPE', NULL, 126, NULL, NULL),
(1241, 'ILLIMO', NULL, 126, NULL, NULL),
(1242, 'JAYANCA', NULL, 126, NULL, NULL),
(1243, 'MOCHUMI', NULL, 126, NULL, NULL),
(1244, 'MORROPE', NULL, 126, NULL, NULL),
(1245, 'MOTUPE', NULL, 126, NULL, NULL),
(1246, 'OLMOS', NULL, 126, NULL, NULL),
(1247, 'PACORA', NULL, 126, NULL, NULL),
(1248, 'SALAS', NULL, 126, NULL, NULL),
(1249, 'SAN JOSE', NULL, 126, NULL, NULL),
(1250, 'TUCUME', NULL, 126, NULL, NULL),
(1251, 'LIMA', NULL, 127, NULL, NULL),
(1252, 'ANCON', NULL, 127, NULL, NULL),
(1253, 'ATE', NULL, 127, NULL, NULL),
(1254, 'BARRANCO', NULL, 127, NULL, NULL),
(1255, 'BREÑA', NULL, 127, NULL, NULL),
(1256, 'CARABAYLLO', NULL, 127, NULL, NULL),
(1257, 'CHACLACAYO', NULL, 127, NULL, NULL),
(1258, 'CHORRILLOS', NULL, 127, NULL, NULL),
(1259, 'CIENEGUILLA', NULL, 127, NULL, NULL),
(1260, 'COMAS', NULL, 127, NULL, NULL),
(1261, 'EL AGUSTINO', NULL, 127, NULL, NULL),
(1262, 'INDEPENDENCIA', NULL, 127, NULL, NULL),
(1263, 'JESUS MARIA', NULL, 127, NULL, NULL),
(1264, 'LA MOLINA', NULL, 127, NULL, NULL),
(1265, 'LA VICTORIA', NULL, 127, NULL, NULL),
(1266, 'LINCE', NULL, 127, NULL, NULL),
(1267, 'LOS OLIVOS', NULL, 127, NULL, NULL),
(1268, 'LURIGANCHO', NULL, 127, NULL, NULL),
(1269, 'LURIN', NULL, 127, NULL, NULL),
(1270, 'MAGDALENA DEL MAR', NULL, 127, NULL, NULL),
(1271, 'MAGDALENA VIEJA', NULL, 127, NULL, NULL),
(1272, 'MIRAFLORES', NULL, 127, NULL, NULL),
(1273, 'PACHACAMAC', NULL, 127, NULL, NULL),
(1274, 'PUCUSANA', NULL, 127, NULL, NULL),
(1275, 'PUENTE PIEDRA', NULL, 127, NULL, NULL),
(1276, 'PUNTA HERMOSA', NULL, 127, NULL, NULL),
(1277, 'PUNTA NEGRA', NULL, 127, NULL, NULL),
(1278, 'RIMAC', NULL, 127, NULL, NULL),
(1279, 'SAN BARTOLO', NULL, 127, NULL, NULL),
(1280, 'SAN BORJA', NULL, 127, NULL, NULL),
(1281, 'SAN ISIDRO', NULL, 127, NULL, NULL),
(1282, 'SAN JUAN DE LURIGANCHO', NULL, 127, NULL, NULL),
(1283, 'SAN JUAN DE MIRAFLORES', NULL, 127, NULL, NULL),
(1284, 'SAN LUIS', NULL, 127, NULL, NULL),
(1285, 'SAN MARTIN DE PORRES', NULL, 127, NULL, NULL),
(1286, 'SAN MIGUEL', NULL, 127, NULL, NULL),
(1287, 'SANTA ANITA', NULL, 127, NULL, NULL),
(1288, 'SANTA MARIA DEL MAR', NULL, 127, NULL, NULL),
(1289, 'SANTA ROSA', NULL, 127, NULL, NULL),
(1290, 'SANTIAGO DE SURCO', NULL, 127, NULL, NULL),
(1291, 'SURQUILLO', NULL, 127, NULL, NULL),
(1292, 'VILLA EL SALVADOR', NULL, 127, NULL, NULL),
(1293, 'VILLA MARIA DEL TRIUNFO', NULL, 127, NULL, NULL),
(1294, 'BARRANCA', NULL, 128, NULL, NULL),
(1295, 'PARAMONGA', NULL, 128, NULL, NULL),
(1296, 'PATIVILCA', NULL, 128, NULL, NULL),
(1297, 'SUPE', NULL, 128, NULL, NULL),
(1298, 'SUPE PUERTO', NULL, 128, NULL, NULL),
(1299, 'CAJATAMBO', NULL, 129, NULL, NULL),
(1300, 'COPA', NULL, 129, NULL, NULL),
(1301, 'GORGOR', NULL, 129, NULL, NULL),
(1302, 'HUANCAPON', NULL, 129, NULL, NULL),
(1303, 'MANAS', NULL, 129, NULL, NULL),
(1304, 'CANTA', NULL, 130, NULL, NULL),
(1305, 'ARAHUAY', NULL, 130, NULL, NULL),
(1306, 'HUAMANTANGA', NULL, 130, NULL, NULL),
(1307, 'HUAROS', NULL, 130, NULL, NULL),
(1308, 'LACHAQUI', NULL, 130, NULL, NULL),
(1309, 'SAN BUENAVENTURA', NULL, 130, NULL, NULL),
(1310, 'SANTA ROSA DE QUIVES', NULL, 130, NULL, NULL),
(1311, 'SAN VICENTE DE CAÑETE', NULL, 131, NULL, NULL),
(1312, 'ASIA', NULL, 131, NULL, NULL),
(1313, 'CALANGO', NULL, 131, NULL, NULL),
(1314, 'CERRO AZUL', NULL, 131, NULL, NULL),
(1315, 'CHILCA', NULL, 131, NULL, NULL),
(1316, 'COAYLLO', NULL, 131, NULL, NULL),
(1317, 'IMPERIAL', NULL, 131, NULL, NULL),
(1318, 'LUNAHUANA', NULL, 131, NULL, NULL),
(1319, 'MALA', NULL, 131, NULL, NULL),
(1320, 'NUEVO IMPERIAL', NULL, 131, NULL, NULL),
(1321, 'PACARAN', NULL, 131, NULL, NULL),
(1322, 'QUILMANA', NULL, 131, NULL, NULL),
(1323, 'SAN ANTONIO', NULL, 131, NULL, NULL),
(1324, 'SAN LUIS', NULL, 131, NULL, NULL),
(1325, 'SANTA CRUZ DE FLORES', NULL, 131, NULL, NULL),
(1326, 'ZUÑIGA', NULL, 131, NULL, NULL),
(1327, 'HUARAL', NULL, 132, NULL, NULL),
(1328, 'ATAVILLOS ALTO', NULL, 132, NULL, NULL),
(1329, 'ATAVILLOS BAJO', NULL, 132, NULL, NULL),
(1330, 'AUCALLAMA', NULL, 132, NULL, NULL),
(1331, 'CHANCAY', NULL, 132, NULL, NULL),
(1332, 'IHUARI', NULL, 132, NULL, NULL),
(1333, 'LAMPIAN', NULL, 132, NULL, NULL),
(1334, 'PACARAOS', NULL, 132, NULL, NULL),
(1335, 'SAN MIGUEL DE ACOS', NULL, 132, NULL, NULL),
(1336, 'SANTA CRUZ DE ANDAMARCA', NULL, 132, NULL, NULL),
(1337, 'SUMBILCA', NULL, 132, NULL, NULL),
(1338, 'VEINTISIETE DE NOVIEMBRE', NULL, 132, NULL, NULL),
(1339, 'MATUCANA', NULL, 133, NULL, NULL),
(1340, 'ANTIOQUIA', NULL, 133, NULL, NULL),
(1341, 'CALLAHUANCA', NULL, 133, NULL, NULL),
(1342, 'CARAMPOMA', NULL, 133, NULL, NULL),
(1343, 'CHICLA', NULL, 133, NULL, NULL),
(1344, 'CUENCA', NULL, 133, NULL, NULL),
(1345, 'HUACHUPAMPA', NULL, 133, NULL, NULL),
(1346, 'HUANZA', NULL, 133, NULL, NULL),
(1347, 'HUAROCHIRI', NULL, 133, NULL, NULL),
(1348, 'LAHUAYTAMBO', NULL, 133, NULL, NULL),
(1349, 'LANGA', NULL, 133, NULL, NULL),
(1350, 'LARAOS', NULL, 133, NULL, NULL),
(1351, 'MARIATANA', NULL, 133, NULL, NULL),
(1352, 'RICARDO PALMA', NULL, 133, NULL, NULL),
(1353, 'SAN ANDRES DE TUPICOCHA', NULL, 133, NULL, NULL),
(1354, 'SAN ANTONIO', NULL, 133, NULL, NULL),
(1355, 'SAN BARTOLOME', NULL, 133, NULL, NULL),
(1356, 'SAN DAMIAN', NULL, 133, NULL, NULL),
(1357, 'SAN JUAN DE IRIS', NULL, 133, NULL, NULL),
(1358, 'SAN JUAN DE TANTARANCHE', NULL, 133, NULL, NULL),
(1359, 'SAN LORENZO DE QUINTI', NULL, 133, NULL, NULL),
(1360, 'SAN MATEO', NULL, 133, NULL, NULL),
(1361, 'SAN MATEO DE OTAO', NULL, 133, NULL, NULL),
(1362, 'SAN PEDRO DE CASTA', NULL, 133, NULL, NULL),
(1363, 'SAN PEDRO DE HUANCAYRE', NULL, 133, NULL, NULL),
(1364, 'SANGALLAYA', NULL, 133, NULL, NULL),
(1365, 'SANTA CRUZ DE COCACHACRA', NULL, 133, NULL, NULL),
(1366, 'SANTA EULALIA', NULL, 133, NULL, NULL),
(1367, 'SANTIAGO DE ANCHUCAYA', NULL, 133, NULL, NULL),
(1368, 'SANTIAGO DE TUNA', NULL, 133, NULL, NULL),
(1369, 'SANTO DOMINGO DE LOS OLLEROS', NULL, 133, NULL, NULL),
(1370, 'SURCO', NULL, 133, NULL, NULL),
(1371, 'HUACHO', NULL, 134, NULL, NULL),
(1372, 'AMBAR', NULL, 134, NULL, NULL),
(1373, 'CALETA DE CARQUIN', NULL, 134, NULL, NULL),
(1374, 'CHECRAS', NULL, 134, NULL, NULL),
(1375, 'HUALMAY', NULL, 134, NULL, NULL),
(1376, 'HUAURA', NULL, 134, NULL, NULL),
(1377, 'LEONCIO PRADO', NULL, 134, NULL, NULL),
(1378, 'PACCHO', NULL, 134, NULL, NULL),
(1379, 'SANTA LEONOR', NULL, 134, NULL, NULL),
(1380, 'SANTA MARIA', NULL, 134, NULL, NULL),
(1381, 'SAYAN', NULL, 134, NULL, NULL),
(1382, 'VEGUETA', NULL, 134, NULL, NULL),
(1383, 'OYON', NULL, 135, NULL, NULL),
(1384, 'ANDAJES', NULL, 135, NULL, NULL),
(1385, 'CAUJUL', NULL, 135, NULL, NULL),
(1386, 'COCHAMARCA', NULL, 135, NULL, NULL),
(1387, 'NAVAN', NULL, 135, NULL, NULL),
(1388, 'PACHANGARA', NULL, 135, NULL, NULL),
(1389, 'YAUYOS', NULL, 136, NULL, NULL),
(1390, 'ALIS', NULL, 136, NULL, NULL),
(1391, 'AYAUCA', NULL, 136, NULL, NULL),
(1392, 'AYAVIRI', NULL, 136, NULL, NULL),
(1393, 'AZANGARO', NULL, 136, NULL, NULL),
(1394, 'CACRA', NULL, 136, NULL, NULL),
(1395, 'CARANIA', NULL, 136, NULL, NULL),
(1396, 'CATAHUASI', NULL, 136, NULL, NULL),
(1397, 'CHOCOS', NULL, 136, NULL, NULL),
(1398, 'COCHAS', NULL, 136, NULL, NULL),
(1399, 'COLONIA', NULL, 136, NULL, NULL),
(1400, 'HONGOS', NULL, 136, NULL, NULL),
(1401, 'HUAMPARA', NULL, 136, NULL, NULL),
(1402, 'HUANCAYA', NULL, 136, NULL, NULL),
(1403, 'HUANGASCAR', NULL, 136, NULL, NULL),
(1404, 'HUANTAN', NULL, 136, NULL, NULL),
(1405, 'HUAÑEC', NULL, 136, NULL, NULL),
(1406, 'LARAOS', NULL, 136, NULL, NULL),
(1407, 'LINCHA', NULL, 136, NULL, NULL),
(1408, 'MADEAN', NULL, 136, NULL, NULL),
(1409, 'MIRAFLORES', NULL, 136, NULL, NULL),
(1410, 'OMAS', NULL, 136, NULL, NULL),
(1411, 'PUTINZA', NULL, 136, NULL, NULL),
(1412, 'QUINCHES', NULL, 136, NULL, NULL),
(1413, 'QUINOCAY', NULL, 136, NULL, NULL),
(1414, 'SAN JOAQUIN', NULL, 136, NULL, NULL),
(1415, 'SAN PEDRO DE PILAS', NULL, 136, NULL, NULL),
(1416, 'TANTA', NULL, 136, NULL, NULL),
(1417, 'TAURIPAMPA', NULL, 136, NULL, NULL),
(1418, 'TOMAS', NULL, 136, NULL, NULL),
(1419, 'TUPE', NULL, 136, NULL, NULL),
(1420, 'VIÑAC', NULL, 136, NULL, NULL),
(1421, 'VITIS', NULL, 136, NULL, NULL),
(1422, 'IQUITOS', NULL, 137, NULL, NULL),
(1423, 'ALTO NANAY', NULL, 137, NULL, NULL),
(1424, 'FERNANDO LORES', NULL, 137, NULL, NULL),
(1425, 'INDIANA', NULL, 137, NULL, NULL),
(1426, 'LAS AMAZONAS', NULL, 137, NULL, NULL),
(1427, 'MAZAN', NULL, 137, NULL, NULL),
(1428, 'NAPO', NULL, 137, NULL, NULL),
(1429, 'PUNCHANA', NULL, 137, NULL, NULL),
(1430, 'PUTUMAYO', NULL, 137, NULL, NULL),
(1431, 'TORRES CAUSANA', NULL, 137, NULL, NULL),
(1432, 'BELEN', NULL, 137, NULL, NULL),
(1433, 'SAN JUAN BAUTISTA', NULL, 137, NULL, NULL),
(1434, 'YURIMAGUAS', NULL, 138, NULL, NULL),
(1435, 'BALSAPUERTO', NULL, 138, NULL, NULL),
(1436, 'BARRANCA', NULL, 138, NULL, NULL),
(1437, 'CAHUAPANAS', NULL, 138, NULL, NULL),
(1438, 'JEBEROS', NULL, 138, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documentos`
--

CREATE TABLE `documentos` (
  `id` bigint UNSIGNED NOT NULL,
  `cotizacion_id` bigint UNSIGNED NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `categoria` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `fecha` date NOT NULL,
  `archivo` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `descripcion` text COLLATE utf8mb4_general_ci,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `documentos`
--

INSERT INTO `documentos` (`id`, `cotizacion_id`, `nombre`, `categoria`, `fecha`, `archivo`, `descripcion`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 2, '000', 'Contrato', '2025-04-25', 'documentos/ItfUYtb2ZYrYxNQeUtHQFXSkZ77pZRzoPzin8fi7.jpg', '000', 1, '2025-04-25 21:56:07', '2025-04-25 21:56:07');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documentos_placa`
--

CREATE TABLE `documentos_placa` (
  `id` bigint UNSIGNED NOT NULL,
  `cotizacion_id` bigint UNSIGNED NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `tipo` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `fecha` date NOT NULL,
  `archivo` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `observaciones` text COLLATE utf8mb4_general_ci,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `placa_id` bigint UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documentos_sunarp`
--

CREATE TABLE `documentos_sunarp` (
  `id` bigint UNSIGNED NOT NULL,
  `cotizacion_id` bigint UNSIGNED NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `tipo` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `fecha` date NOT NULL,
  `archivo` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `observaciones` text COLLATE utf8mb4_general_ci,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `documentos_sunarp`
--

INSERT INTO `documentos_sunarp` (`id`, `cotizacion_id`, `nombre`, `tipo`, `fecha`, `archivo`, `observaciones`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 2, '01', 'Contrato de Compra-Venta', '2025-04-25', 'documentos_sunarp/d8CQe6MIWADRi2VSOXgMOPsoYxHBLyNlnqb3o6Q7.pdf', '000', 1, '2025-04-25 21:55:35', '2025-04-25 21:55:35'),
(2, 2, 'OPERACIÓN A', 'Contrato de Compra-Venta', '2025-09-07', 'documentos_sunarp/0erqgE9yAcR3ovy1GyqnRDAtVqfC2WVROnGEfeBn.pdf', NULL, 1, '2025-09-07 13:31:57', '2025-09-07 13:31:57');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `establecimientos`
--

CREATE TABLE `establecimientos` (
  `id` int NOT NULL,
  `nombre` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `direccion` text COLLATE utf8mb4_general_ci NOT NULL,
  `telefono` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `establecimientos`
--

INSERT INTO `establecimientos` (`id`, `nombre`, `direccion`, `telefono`, `created_at`, `updated_at`) VALUES
(1, 'MSA Cajamarca', 'Av. Via de Evitamiento Norte 1233', '98654321', '2025-04-20 09:16:43', '2025-04-20 09:17:26'),
(2, 'MSA Baños del Inca', 'Av. Atahualpa 987654', '987654312', '2025-04-20 09:17:05', '2025-04-20 09:17:05');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estados`
--

CREATE TABLE `estados` (
  `id` bigint UNSIGNED NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `estados`
--

INSERT INTO `estados` (`id`, `nombre`, `created_at`, `updated_at`) VALUES
(1, 'Pendiente', '2025-04-30 06:45:59', '2025-04-30 06:45:59'),
(2, 'Aprobado', '2025-04-30 06:45:59', '2025-04-30 06:45:59'),
(3, 'Rechazado', '2025-04-30 06:45:59', '2025-04-30 06:45:59');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estados_cotizacion`
--

CREATE TABLE `estados_cotizacion` (
  `id` bigint UNSIGNED NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `descripcion` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `color` varchar(255) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'primary',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estados_cotizacion`
--

INSERT INTO `estados_cotizacion` (`id`, `nombre`, `descripcion`, `color`, `created_at`, `updated_at`) VALUES
(1, 'Interesado', 'Cliente interesado en la cotización con campos adicionales para seguimiento', 'info', '2025-04-25 03:42:04', '2025-04-25 03:42:04'),
(2, 'No cumple perfil', 'Cliente que no cumple con el perfil requerido, incluye motivo de rechazo', 'danger', '2025-04-25 03:42:04', '2025-04-25 03:42:04'),
(3, 'Aceptada', 'Cliente ha aceptado la cotización, pendiente de cierre', 'success', '2025-04-25 03:42:04', '2025-04-25 03:42:04'),
(4, 'Cerrado Ganado', 'Cotización que resultó en una venta confirmada', 'primary', '2025-04-25 03:42:04', '2025-04-25 03:42:04'),
(5, 'Rechazada', 'Cliente ha rechazado la cotización', 'warning', '2025-04-25 03:42:04', '2025-04-25 03:42:04'),
(6, 'Emitida', 'Cotización generada y emitida al cliente', 'secondary', '2025-04-25 03:42:04', '2025-04-25 03:42:04'),
(24, 'Nueva', NULL, '#3490dc', '2025-05-28 10:24:11', '2025-05-28 10:24:11');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_requerimientos`
--

CREATE TABLE `estado_requerimientos` (
  `id` bigint UNSIGNED NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `descripcion` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estado_requerimientos`
--

INSERT INTO `estado_requerimientos` (`id`, `nombre`, `descripcion`, `created_at`, `updated_at`) VALUES
(1, 'pendiente', 'Requerimiento pendiente', '2025-04-30 15:31:06', '2025-04-30 15:31:06'),
(2, 'aprobado', 'Requerimiento aprobado', '2025-04-30 15:31:06', '2025-04-30 15:31:06'),
(3, 'rechazado', 'Requerimiento rechazado', '2025-04-30 15:31:06', '2025-04-30 15:31:06');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estandar_mantenimientos`
--

CREATE TABLE `estandar_mantenimientos` (
  `id` bigint UNSIGNED NOT NULL,
  `estandar_mantenimiento` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estandar_mantenimientos`
--

INSERT INTO `estandar_mantenimientos` (`id`, `estandar_mantenimiento`, `created_at`, `updated_at`) VALUES
(1, 'Estandar 1', '2025-03-20 17:57:36', '2025-03-20 17:57:36'),
(2, 'Estandar 2', '2025-03-20 19:35:09', '2025-03-20 19:35:09');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fabricantes`
--

CREATE TABLE `fabricantes` (
  `id` bigint UNSIGNED NOT NULL,
  `nombre_fabricante` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `fabricantes`
--

INSERT INTO `fabricantes` (`id`, `nombre_fabricante`, `created_at`, `updated_at`) VALUES
(1, 'Fabricante A', '2025-03-28 03:22:08', '2025-03-28 03:22:08');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facturas_orden_trabajo`
--

CREATE TABLE `facturas_orden_trabajo` (
  `id` bigint UNSIGNED NOT NULL,
  `orden_trabajo_id` bigint UNSIGNED NOT NULL,
  `numero_factura` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  `fecha_emision` datetime NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `impuestos` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `metodo_pago` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `estado_pago` enum('pendiente','pagado','anulado') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'pendiente',
  `notas` text COLLATE utf8mb4_general_ci,
  `dias_garantia` int DEFAULT '30',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura_orden_trabajos`
--

CREATE TABLE `factura_orden_trabajos` (
  `id` bigint UNSIGNED NOT NULL,
  `orden_trabajo_id` bigint UNSIGNED NOT NULL,
  `numero_factura` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  `fecha_emision` datetime NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `impuestos` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `metodo_pago` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `estado_pago` enum('pendiente','pagado','anulado') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'pendiente',
  `notas` text COLLATE utf8mb4_general_ci,
  `dias_garantia` int DEFAULT '30',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `guias_entrega`
--

CREATE TABLE `guias_entrega` (
  `id` bigint UNSIGNED NOT NULL,
  `numero` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha` date NOT NULL,
  `proveedor_id` bigint UNSIGNED NOT NULL,
  `transportista` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `placa_vehiculo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `conductor` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dni_conductor` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `observaciones` text COLLATE utf8mb4_unicode_ci,
  `estado` enum('pendiente','en_transito','recibida','cancelada') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pendiente',
  `usuario_id` bigint UNSIGNED NOT NULL,
  `recibido_por` bigint UNSIGNED DEFAULT NULL,
  `fecha_recepcion` timestamp NULL DEFAULT NULL,
  `total` decimal(10,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_cotizaciones`
--

CREATE TABLE `historial_cotizaciones` (
  `id` bigint UNSIGNED NOT NULL,
  `cotizacion_id` bigint UNSIGNED NOT NULL,
  `estado_anterior_id` bigint UNSIGNED DEFAULT NULL,
  `estado_nuevo_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `comentario` text COLLATE utf8mb4_general_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `historial_cotizaciones`
--

INSERT INTO `historial_cotizaciones` (`id`, `cotizacion_id`, `estado_anterior_id`, `estado_nuevo_id`, `user_id`, `comentario`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, 1, 1, 'Cotización creada inicialmente en estado Interesado', '2025-04-25 20:08:42', '2025-04-25 20:08:42'),
(2, 1, NULL, 1, 1, 'Cotización creada inicialmente en estado Interesado', '2025-04-25 20:41:29', '2025-04-25 20:41:29'),
(3, 2, NULL, 1, 1, 'Cotización creada inicialmente en estado Interesado', '2025-04-25 20:49:10', '2025-04-25 20:49:10'),
(4, 1, NULL, 1, 1, 'Cotización creada inicialmente en estado Interesado', '2025-04-25 20:56:18', '2025-04-25 20:56:18'),
(5, 2, NULL, 1, 1, 'Cotización creada inicialmente en estado Interesado', '2025-04-25 21:10:50', '2025-04-25 21:10:50'),
(6, 3, NULL, 1, 1, 'Cotización creada inicialmente en estado Interesado', '2025-04-30 10:07:37', '2025-04-30 10:07:37'),
(7, 3, 1, 3, 1, '33', '2025-04-30 10:32:29', '2025-04-30 10:32:29'),
(8, 3, 3, 4, 1, 'aaa', '2025-04-30 10:39:40', '2025-04-30 10:39:40'),
(9, 3, 4, 3, 1, 'aaa', '2025-04-30 10:40:05', '2025-04-30 10:40:05'),
(10, 4, NULL, 1, 1, 'Cotización creada inicialmente en estado Interesado', '2025-04-30 10:46:49', '2025-04-30 10:46:49'),
(11, 4, 1, 4, 1, '12', '2025-04-30 10:48:35', '2025-04-30 10:48:35'),
(12, 4, 4, 4, 1, 'Se generó requerimiento de compra #5', '2025-04-30 20:37:48', '2025-04-30 20:37:48'),
(13, 5, NULL, 1, 1, 'Cotización creada inicialmente en estado Interesado', '2025-04-30 20:41:26', '2025-04-30 20:41:26'),
(14, 3, 3, 1, 1, 'xasx', '2025-06-27 10:55:49', '2025-06-27 10:55:49'),
(15, 49, 24, 3, 1, '32132132', '2025-09-07 12:50:40', '2025-09-07 12:50:40');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_requerimiento_compras`
--

CREATE TABLE `historial_requerimiento_compras` (
  `id` bigint UNSIGNED NOT NULL,
  `requerimiento_compra_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `estado_id` bigint UNSIGNED DEFAULT NULL,
  `estado_nombre` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `estado_color` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `comentario` text COLLATE utf8mb4_general_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `intervalo_plan_mantenimientos`
--

CREATE TABLE `intervalo_plan_mantenimientos` (
  `id` bigint UNSIGNED NOT NULL,
  `plan_mantenimiento_id` bigint UNSIGNED NOT NULL,
  `componente_plan_id` bigint UNSIGNED NOT NULL,
  `kilometraje` int NOT NULL,
  `horas` int DEFAULT NULL,
  `cantidad_especifica` decimal(8,2) DEFAULT NULL,
  `precio_especifico` decimal(10,2) DEFAULT NULL,
  `moneda_precio` enum('USD','PEN') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'PEN',
  `aplica` tinyint(1) NOT NULL DEFAULT '0',
  `notas` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventarios`
--

CREATE TABLE `inventarios` (
  `id` bigint UNSIGNED NOT NULL,
  `parte_id` bigint UNSIGNED NOT NULL,
  `vehiculo_id` bigint UNSIGNED DEFAULT NULL,
  `almacen_id` bigint UNSIGNED NOT NULL,
  `centro_costo_id` bigint UNSIGNED DEFAULT NULL,
  `stock_disponible` decimal(12,3) NOT NULL DEFAULT '0.000',
  `stock_reservado` decimal(12,3) NOT NULL DEFAULT '0.000',
  `stock_minimo` decimal(12,3) NOT NULL DEFAULT '0.000',
  `stock_maximo` decimal(12,3) NOT NULL DEFAULT '0.000',
  `ubicacion` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `inventarios`
--

INSERT INTO `inventarios` (`id`, `parte_id`, `vehiculo_id`, `almacen_id`, `centro_costo_id`, `stock_disponible`, `stock_reservado`, `stock_minimo`, `stock_maximo`, `ubicacion`, `created_at`, `updated_at`) VALUES
(7, 1, NULL, 1, 1, 95.000, 0.000, 10.000, 500.000, NULL, '2025-04-25 18:02:39', '2025-09-07 21:44:41'),
(8, 1, NULL, 2, NULL, 25.000, 0.000, 0.000, 0.000, NULL, '2025-05-27 01:35:29', '2025-09-07 22:20:12'),
(9, 4, NULL, 2, NULL, 31.000, 0.000, 0.000, 0.000, NULL, '2025-05-27 01:35:29', '2025-09-07 22:19:34');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventarios_backup`
--

CREATE TABLE `inventarios_backup` (
  `id` bigint UNSIGNED NOT NULL DEFAULT '0',
  `parte_id` bigint UNSIGNED NOT NULL,
  `almacen_id` bigint UNSIGNED NOT NULL,
  `centro_costo_id` bigint UNSIGNED DEFAULT NULL,
  `stock_disponible` decimal(12,3) NOT NULL DEFAULT '0.000',
  `stock_reservado` decimal(12,3) NOT NULL DEFAULT '0.000',
  `stock_minimo` decimal(12,3) NOT NULL DEFAULT '0.000',
  `stock_maximo` decimal(12,3) NOT NULL DEFAULT '0.000',
  `ubicacion` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `inventarios_backup`
--

INSERT INTO `inventarios_backup` (`id`, `parte_id`, `almacen_id`, `centro_costo_id`, `stock_disponible`, `stock_reservado`, `stock_minimo`, `stock_maximo`, `ubicacion`, `created_at`, `updated_at`) VALUES
(7, 1, 1, 1, 100.000, 0.000, 10.000, 500.000, NULL, '2025-04-25 18:02:39', '2025-04-25 18:03:18');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `kardex`
--

CREATE TABLE `kardex` (
  `id` bigint UNSIGNED NOT NULL,
  `parte_id` bigint UNSIGNED DEFAULT NULL,
  `vehiculo_id` bigint UNSIGNED DEFAULT NULL,
  `almacen_id` bigint UNSIGNED NOT NULL,
  `tipo_movimiento` enum('ENTRADA','SALIDA','AJUSTE') COLLATE utf8mb4_unicode_ci NOT NULL,
  `concepto` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `numero_documento` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cantidad_entrada` decimal(10,2) DEFAULT '0.00',
  `cantidad_salida` decimal(10,2) DEFAULT '0.00',
  `stock_anterior` decimal(10,2) NOT NULL,
  `stock_actual` decimal(10,2) NOT NULL,
  `costo_unitario` decimal(10,4) DEFAULT '0.0000',
  `valor_total` decimal(12,2) DEFAULT '0.00',
  `fecha_movimiento` datetime DEFAULT NULL,
  `usuario_id` bigint UNSIGNED NOT NULL,
  `referencia_id` bigint UNSIGNED DEFAULT NULL,
  `referencia_tipo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `observaciones` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `kardex`
--

INSERT INTO `kardex` (`id`, `parte_id`, `vehiculo_id`, `almacen_id`, `tipo_movimiento`, `concepto`, `numero_documento`, `cantidad_entrada`, `cantidad_salida`, `stock_anterior`, `stock_actual`, `costo_unitario`, `valor_total`, `fecha_movimiento`, `usuario_id`, `referencia_id`, `referencia_tipo`, `observaciones`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, 2, 'ENTRADA', 'COMPRA', 'OC-6', 25.00, 0.00, 0.00, 25.00, 35.0000, 875.00, '2025-05-26 00:00:00', 1, 7, 'App\\Models\\RecepcionOrdenCompra', NULL, '2025-05-27 01:35:29', '2025-05-27 01:35:29'),
(2, 4, NULL, 2, 'ENTRADA', 'COMPRA', 'OC-6', 30.00, 0.00, 0.00, 30.00, 26.0000, 780.00, '2025-05-26 00:00:00', 1, 8, 'App\\Models\\RecepcionOrdenCompra', NULL, '2025-05-27 01:35:29', '2025-05-27 01:35:29'),
(5, 1, NULL, 2, 'ENTRADA', 'COMPRA', 'OC-7', 2.00, 0.00, 24.00, 26.00, 0.0000, 0.00, '2025-09-07 00:00:00', 1, 11, 'App\\Models\\RecepcionOrdenCompra', NULL, '2025-09-07 22:19:34', '2025-09-07 22:19:34'),
(6, 4, NULL, 2, 'ENTRADA', 'COMPRA', 'OC-7', 1.00, 0.00, 30.00, 31.00, 0.0000, 0.00, '2025-09-07 00:00:00', 1, 12, 'App\\Models\\RecepcionOrdenCompra', NULL, '2025-09-07 22:19:34', '2025-09-07 22:19:34'),
(7, 1, NULL, 2, 'SALIDA', 'DEVOLUCION_COMPRA', 'OC-7', 0.00, 1.00, 26.00, 25.00, 0.0000, 0.00, '2025-09-07 00:00:00', 1, 1, 'App\\Models\\DevolucionOrdenCompra', 'sssssssssssssssssssssssssssss', '2025-09-07 22:20:12', '2025-09-07 22:20:12');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `marcas`
--

CREATE TABLE `marcas` (
  `id` bigint UNSIGNED NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `marcas`
--

INSERT INTO `marcas` (`id`, `nombre`, `created_at`, `updated_at`) VALUES
(1, 'Volvo', '2025-03-28 03:16:18', '2025-03-28 03:16:18'),
(2, 'Chevrolet', '2025-04-20 05:06:34', '2025-04-20 05:06:34'),
(3, 'Nissan', '2025-04-20 05:09:40', '2025-04-20 05:09:40');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_03_12_165455_add_two_factor_columns_to_users_table', 1),
(5, '2025_09_06_231154_add_activo_column_to_almacenes_table', 2),
(6, '2025_09_06_232049_create_tipos_cambio_table', 3),
(7, '2025_09_07_002424_update_ventas_table_add_estados_and_pagos', 4),
(8, '2025_09_07_002953_create_pagos_ventas_table', 5),
(9, '2025_09_07_083531_create_reglas_vencimiento_cotizaciones_table', 6),
(10, '2025_09_07_083607_add_vencimiento_fields_to_cotizaciones_table', 7),
(11, '2025_09_07_164013_add_updated_at_to_tipos_movimiento_table', 8),
(12, '2025_09_07_164247_add_documento_columns_to_movimientos_table', 9),
(13, '2025_09_07_171809_update_detalle_orden_compras_estado_recepcion_column', 10),
(14, '2025_09_07_234933_create_vale_devolucions_table', 11),
(15, '2025_09_07_235010_create_detalle_vales_devolucion_table', 12),
(16, '2025_09_07_235620_fix_vale_devolucion_foreign_keys', 13),
(17, '2025_09_08_022329_create_guias_entrega_table', 14),
(18, '2025_09_08_022529_create_detalle_guias_entrega_table', 15),
(19, '2025_09_08_024536_create_plan_mantenimientos_table', 16),
(20, '2025_09_08_024738_create_componente_plan_mantenimientos_table', 17),
(21, '2025_09_08_024740_create_intervalo_plan_mantenimientos_table', 18);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modelos`
--

CREATE TABLE `modelos` (
  `id` bigint UNSIGNED NOT NULL,
  `marca_id` bigint UNSIGNED NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `duracion_garantia` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `cantidad_anos` int NOT NULL,
  `ficha_tecnica` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `modelos`
--

INSERT INTO `modelos` (`id`, `marca_id`, `nombre`, `duracion_garantia`, `cantidad_anos`, `ficha_tecnica`, `created_at`, `updated_at`) VALUES
(1, 1, 'V-100', '500', 10, 'fichas_tecnicas/xe4bC9xONx9DME0BMjLwQyosQH4zkubhL8a4mziI.pdf', '2025-03-28 03:16:52', '2025-03-28 03:16:52'),
(2, 2, '5555', '0', 1, 'fichas_tecnicas/lxzJ63dnYCIHo5u2V0kohcT5J2w88aLbYO7u01Wf.pdf', '2025-04-25 21:59:15', '2025-04-25 21:59:15');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movimientos`
--

CREATE TABLE `movimientos` (
  `id` bigint UNSIGNED NOT NULL,
  `tipo_movimiento_id` bigint UNSIGNED NOT NULL,
  `parte_id` bigint UNSIGNED NOT NULL,
  `almacen_id` bigint UNSIGNED NOT NULL,
  `centro_costo_id` bigint UNSIGNED DEFAULT NULL,
  `cantidad` int NOT NULL,
  `stock_anterior` int DEFAULT '0',
  `stock_resultante` int DEFAULT '0',
  `documento_tipo` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `documento_id` bigint UNSIGNED DEFAULT NULL,
  `documento_referencia` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `fecha_movimiento` datetime NOT NULL,
  `usuario_id` bigint UNSIGNED NOT NULL,
  `observaciones` text COLLATE utf8mb4_general_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `movimientos`
--

INSERT INTO `movimientos` (`id`, `tipo_movimiento_id`, `parte_id`, `almacen_id`, `centro_costo_id`, `cantidad`, `stock_anterior`, `stock_resultante`, `documento_tipo`, `documento_id`, `documento_referencia`, `fecha_movimiento`, `usuario_id`, `observaciones`, `created_at`, `updated_at`) VALUES
(1, 1, 3, 1, 1, 321, 0, 0, NULL, NULL, '222', '2025-04-25 17:40:00', 1, '111', '2025-04-25 22:40:50', '2025-04-25 22:40:50'),
(2, 3, 1, 2, 1, 10, 0, 0, NULL, NULL, '222', '2025-04-26 00:18:00', 1, '1111111111', '2025-04-26 05:18:44', '2025-04-26 05:18:44'),
(10, 4, 1, 1, NULL, 1, 100, 99, NULL, NULL, 'COT-20250005', '2025-05-28 05:24:11', 1, 'Venta generada desde POS. Cotización: COT-20250005', '2025-05-28 10:24:11', '2025-05-28 10:24:11'),
(11, 4, 1, 1, NULL, 1, 99, 98, NULL, NULL, 'COT-20250528073019', '2025-05-28 07:30:19', 1, 'Venta generada desde POS. Cotización: COT-20250528073019', '2025-05-28 12:30:19', '2025-05-28 12:30:19'),
(12, 4, 1, 1, NULL, 1, 98, 97, NULL, NULL, 'COT-20253020', '2025-06-26 06:01:26', 1, 'Venta generada desde POS. Cotización: COT-20253020', '2025-06-26 11:01:26', '2025-06-26 11:01:26'),
(13, 4, 1, 1, NULL, 1, 97, 96, NULL, NULL, 'COT-20250005', '2025-09-07 00:13:47', 1, 'Venta generada desde POS. Cotización: COT-20250005', '2025-09-07 05:13:47', '2025-09-07 05:13:47'),
(14, 6, 1, 1, NULL, 1, 96, 95, 'devolucion_proveedor', 14, 'DEV-202509000001', '2025-09-07 16:44:41', 1, 'Devolución al proveedor: QIPU S.A.C.S', '2025-09-07 21:44:41', '2025-09-07 21:44:41'),
(15, 6, 1, 2, NULL, 1, 25, 24, 'devolucion_proveedor', 15, 'DEV-202509000002', '2025-09-07 16:47:24', 1, 'Devolución al proveedor: QIPU S.A.C.S', '2025-09-07 21:47:24', '2025-09-07 21:47:24');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notas_pedido`
--

CREATE TABLE `notas_pedido` (
  `id` bigint UNSIGNED NOT NULL,
  `cotizacion_id` bigint UNSIGNED NOT NULL,
  `codigo` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `fecha_emision` date NOT NULL,
  `estado` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `observaciones` text COLLATE utf8mb4_general_ci,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `notas_pedido`
--

INSERT INTO `notas_pedido` (`id`, `cotizacion_id`, `codigo`, `fecha_emision`, `estado`, `observaciones`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 2, 'NP-202504000001', '2025-04-25', 'Pendiente', NULL, 1, '2025-04-25 21:55:14', '2025-04-25 21:55:14'),
(2, 5, 'NP-202506000001', '2025-06-03', 'Pendiente', NULL, 1, '2025-06-03 10:21:53', '2025-06-03 10:21:53'),
(3, 49, 'NP-202509000001', '2025-09-07', 'Pendiente', NULL, 1, '2025-09-07 13:27:39', '2025-09-07 13:27:39');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nota_pedido_items`
--

CREATE TABLE `nota_pedido_items` (
  `id` bigint UNSIGNED NOT NULL,
  `nota_pedido_id` bigint UNSIGNED NOT NULL,
  `item_id` bigint UNSIGNED DEFAULT NULL,
  `item_type` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tipo` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `descripcion` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `cantidad` decimal(10,2) NOT NULL,
  `precio_unitario` decimal(12,2) NOT NULL,
  `detalles` text COLLATE utf8mb4_general_ci,
  `subtipo` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `nota_pedido_items`
--

INSERT INTO `nota_pedido_items` (`id`, `nota_pedido_id`, `item_id`, `item_type`, `tipo`, `descripcion`, `cantidad`, `precio_unitario`, `detalles`, `subtipo`, `created_at`, `updated_at`) VALUES
(1, 1, 3, 'App\\Models\\Servicio', 'servicio', 'Camara pantalla - Propios', 1.00, 0.00, NULL, NULL, '2025-04-25 21:55:14', '2025-04-25 21:55:14'),
(2, 3, 2, 'App\\Models\\Servicio', 'servicio', 'Colocación Videro Liquido - Terceros', 1.00, 200.00, NULL, NULL, '2025-09-07 13:30:20', '2025-09-07 13:30:20'),
(3, 3, 2, 'App\\Models\\Parte', 'parte', '000002 - producto 2 ()', 1.00, 1219.80, NULL, NULL, '2025-09-07 13:30:28', '2025-09-07 13:30:28'),
(4, 3, 3, 'App\\Models\\Servicio', 'servicio', 'Camara pantalla - Propios', 1.00, 321.00, NULL, NULL, '2025-09-07 13:30:40', '2025-09-07 13:30:40');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `oportunidades`
--

CREATE TABLE `oportunidades` (
  `id` bigint UNSIGNED NOT NULL,
  `titulo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cliente_id` bigint UNSIGNED NOT NULL,
  `probabilidad` int NOT NULL DEFAULT '50',
  `valor_estimado` decimal(10,2) DEFAULT NULL,
  `moneda` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Soles',
  `descripcion` text COLLATE utf8mb4_unicode_ci,
  `estado` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Activa',
  `user_id` bigint UNSIGNED NOT NULL,
  `fecha_cierre_estimada` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ordenes_trabajo_mantenimiento`
--

CREATE TABLE `ordenes_trabajo_mantenimiento` (
  `id` bigint UNSIGNED NOT NULL,
  `codigo_orden` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `vehiculo_id` bigint UNSIGNED NOT NULL,
  `cliente_id` bigint UNSIGNED NOT NULL,
  `cita_id` bigint UNSIGNED DEFAULT NULL,
  `fecha_ingreso` datetime NOT NULL,
  `fecha_diagnostico` datetime DEFAULT NULL,
  `fecha_aprobacion_cliente` datetime DEFAULT NULL,
  `fecha_inicio_trabajo` datetime DEFAULT NULL,
  `fecha_fin_trabajo` datetime DEFAULT NULL,
  `fecha_entrega` datetime DEFAULT NULL,
  `kilometraje_ingreso` decimal(10,2) DEFAULT NULL,
  `kilometraje_salida` decimal(10,2) DEFAULT NULL,
  `descripcion_problema` text COLLATE utf8mb4_general_ci NOT NULL,
  `diagnostico` text COLLATE utf8mb4_general_ci,
  `recomendaciones` text COLLATE utf8mb4_general_ci,
  `tecnico_asignado_id` bigint UNSIGNED DEFAULT NULL,
  `box` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `estado` enum('diagnostico','cotizacion','aprobado','en_progreso','completado','entregado','cancelado') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'diagnostico',
  `aprobado_por_cliente` tinyint(1) DEFAULT '0',
  `metodo_aprobacion` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `fecha_proxima_revision` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ordenes_trabajo_mantenimiento`
--

INSERT INTO `ordenes_trabajo_mantenimiento` (`id`, `codigo_orden`, `vehiculo_id`, `cliente_id`, `cita_id`, `fecha_ingreso`, `fecha_diagnostico`, `fecha_aprobacion_cliente`, `fecha_inicio_trabajo`, `fecha_fin_trabajo`, `fecha_entrega`, `kilometraje_ingreso`, `kilometraje_salida`, `descripcion_problema`, `diagnostico`, `recomendaciones`, `tecnico_asignado_id`, `box`, `estado`, `aprobado_por_cliente`, `metodo_aprobacion`, `fecha_proxima_revision`, `created_at`, `updated_at`) VALUES
(1, 'OT-20250429155020-1', 1, 1, 1, '2025-04-29 15:50:20', NULL, NULL, NULL, NULL, NULL, 32132.00, NULL, 'SSSS', NULL, NULL, 2, '1', 'completado', 0, NULL, NULL, '2025-04-29 20:50:20', '2025-04-30 09:49:58'),
(2, 'OT-20250429234656-2', 2, 1, 2, '2025-04-29 23:46:56', NULL, NULL, NULL, NULL, NULL, 5000.00, NULL, 'sasasasasasasasasasasasa', NULL, NULL, 2, '2', 'completado', 0, NULL, NULL, '2025-04-30 04:46:56', '2025-09-07 21:21:21');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orden_compras`
--

CREATE TABLE `orden_compras` (
  `id` bigint UNSIGNED NOT NULL,
  `codigo` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `requerimiento_compra_id` bigint UNSIGNED NOT NULL,
  `tipo` varchar(255) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'inventario',
  `estado` varchar(255) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'en espera',
  `estado_recepcion` enum('pendiente','parcial','completo') COLLATE utf8mb4_general_ci DEFAULT 'pendiente',
  `almacen_destino_id` bigint UNSIGNED NOT NULL,
  `requerido_por` bigint UNSIGNED NOT NULL,
  `aprobado_por` bigint UNSIGNED DEFAULT NULL,
  `proveedor_id` bigint UNSIGNED DEFAULT NULL,
  `moneda` varchar(10) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'S/',
  `observaciones` text COLLATE utf8mb4_general_ci,
  `fecha_aprobacion` date DEFAULT NULL,
  `total` decimal(10,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `motivo_faltantes` text COLLATE utf8mb4_general_ci,
  `fecha_completado_faltantes` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `orden_compras`
--

INSERT INTO `orden_compras` (`id`, `codigo`, `requerimiento_compra_id`, `tipo`, `estado`, `estado_recepcion`, `almacen_destino_id`, `requerido_por`, `aprobado_por`, `proveedor_id`, `moneda`, `observaciones`, `fecha_aprobacion`, `total`, `created_at`, `updated_at`, `motivo_faltantes`, `fecha_completado_faltantes`) VALUES
(1, 'OC-1', 1, 'inventario', 'aprobada', 'completo', 2, 1, 1, 2, 'S/', NULL, '2025-04-25', 250000.00, '2025-04-25 22:03:56', '2025-05-26 21:10:40', NULL, NULL),
(2, 'OC-2', 2, 'inventario', 'aprobada', 'completo', 2, 1, 1, 2, 'S/', NULL, '2025-04-25', 500000.00, '2025-04-25 22:16:06', '2025-05-26 21:26:08', NULL, NULL),
(3, 'OC-3', 2, 'inventario', 'aprobada', 'completo', 2, 1, 1, 2, 'S/', '4234234', '2025-04-25', 432340.00, '2025-04-25 22:41:41', '2025-05-26 21:18:35', NULL, NULL),
(5, 'OC-4', 3, 'inventario', 'aprobada', 'completo', 2, 1, 1, 2, 'S/', NULL, '2025-04-25', 250000.00, '2025-04-25 22:56:59', '2025-05-26 21:18:12', NULL, NULL),
(6, 'OC-5', 5, 'inventario', 'aprobada', 'completo', 1, 1, 1, 2, 'S/', NULL, '2025-05-26', 30.00, '2025-05-26 19:18:25', '2025-05-26 21:44:13', NULL, NULL),
(7, 'OC-6', 8, 'inventario', 'aprobada', 'completo', 2, 1, 1, 2, 'S/', NULL, '2025-05-26', 1655.00, '2025-05-27 01:32:07', '2025-05-27 01:35:29', NULL, NULL),
(8, 'OC-7', 8, 'inventario', 'aprobada', 'parcial', 2, 1, 1, 2, 'S/', NULL, '2025-09-07', 0.00, '2025-09-07 22:13:34', '2025-09-07 22:20:12', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orden_trabajos`
--

CREATE TABLE `orden_trabajos` (
  `id` bigint UNSIGNED NOT NULL,
  `cotizacion_id` bigint UNSIGNED NOT NULL,
  `vehiculo_id` bigint UNSIGNED DEFAULT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `fecha_inicio` datetime NOT NULL,
  `fecha_fin_estimada` datetime DEFAULT NULL,
  `fecha_fin_real` datetime DEFAULT NULL,
  `descripcion` text COLLATE utf8mb4_general_ci NOT NULL,
  `estado` enum('pendiente','en_progreso','completado') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'pendiente',
  `observaciones` text COLLATE utf8mb4_general_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `orden_trabajos`
--

INSERT INTO `orden_trabajos` (`id`, `cotizacion_id`, `vehiculo_id`, `user_id`, `fecha_inicio`, `fecha_fin_estimada`, `fecha_fin_real`, `descripcion`, `estado`, `observaciones`, `created_at`, `updated_at`) VALUES
(1, 2, 1, NULL, '2025-04-25 16:53:44', '2025-04-26 10:00:00', NULL, 'aaaaaaaa', 'pendiente', NULL, '2025-04-25 21:53:44', '2025-04-25 21:53:44');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orden_trabajo_historial`
--

CREATE TABLE `orden_trabajo_historial` (
  `id` bigint UNSIGNED NOT NULL,
  `orden_trabajo_id` bigint UNSIGNED NOT NULL,
  `usuario_id` bigint UNSIGNED NOT NULL,
  `accion` varchar(50) COLLATE utf8mb4_general_ci NOT NULL COMMENT 'creado, actualizado, estado_cambiado, completado',
  `descripcion` text COLLATE utf8mb4_general_ci NOT NULL,
  `detalles` text COLLATE utf8mb4_general_ci COMMENT 'JSON con cambios específicos',
  `fecha` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pagos`
--

CREATE TABLE `pagos` (
  `id` bigint UNSIGNED NOT NULL,
  `cotizacion_id` bigint UNSIGNED NOT NULL,
  `concepto` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `monto` decimal(12,2) NOT NULL,
  `moneda` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `fecha_pago` date NOT NULL,
  `tipo` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `medio_pago` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `comprobante` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `observaciones` text COLLATE utf8mb4_general_ci,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pagos`
--

INSERT INTO `pagos` (`id`, `cotizacion_id`, `concepto`, `monto`, `moneda`, `fecha_pago`, `tipo`, `medio_pago`, `comprobante`, `observaciones`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 2, '111', 111.00, 'Dólares', '2025-04-25', 'Inicial', 'Transferencia', 'pagos/iCf71OmcQakCMNljJa04rsrYDS7bgIGQF8YGxFOH.jpg', NULL, 1, '2025-04-25 21:54:47', '2025-04-25 21:54:47'),
(2, 5, 'Pago 01', 1500.00, 'Dólares', '2025-08-18', 'Inicial', 'Transferencia', 'pagos/UXLC9xk5L99jx3xPg8WVBuTF3OZVht5THo2a1yty.png', NULL, 1, '2025-08-19 04:25:26', '2025-08-19 04:25:26'),
(3, 49, 'Combustible motos', 5435.00, 'Soles', '2025-09-07', 'Inicial', 'Efectivo', NULL, NULL, 1, '2025-09-07 13:27:14', '2025-09-07 13:27:14');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pagos_ventas`
--

CREATE TABLE `pagos_ventas` (
  `id` bigint UNSIGNED NOT NULL,
  `venta_id` bigint UNSIGNED NOT NULL,
  `numero_pago` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_pago` date NOT NULL,
  `monto` decimal(10,2) NOT NULL,
  `moneda` enum('PEN','USD') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'PEN',
  `tipo_cambio` decimal(8,4) DEFAULT NULL,
  `monto_convertido` decimal(10,2) DEFAULT NULL,
  `metodo_pago` enum('efectivo','transferencia','cheque','tarjeta_credito','tarjeta_debito','deposito','otro') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'efectivo',
  `referencia_pago` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `banco` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `observaciones` text COLLATE utf8mb4_unicode_ci,
  `usuario_id` bigint UNSIGNED NOT NULL,
  `validado` tinyint(1) NOT NULL DEFAULT '0',
  `validado_por` bigint UNSIGNED DEFAULT NULL,
  `fecha_validacion` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `partes`
--

CREATE TABLE `partes` (
  `id` bigint UNSIGNED NOT NULL,
  `codigo` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `autogenerar_codigo` tinyint(1) NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `unidad_id` bigint UNSIGNED NOT NULL,
  `fabricante_id` bigint UNSIGNED DEFAULT NULL,
  `precio_venta` decimal(10,2) NOT NULL,
  `moneda_venta` enum('SOL','USD') COLLATE utf8mb4_general_ci NOT NULL,
  `precio_compra` decimal(10,2) NOT NULL,
  `moneda_compra` enum('SOL','USD') COLLATE utf8mb4_general_ci NOT NULL,
  `categoria_parte_id` bigint UNSIGNED NOT NULL,
  `proveedor_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `partes`
--

INSERT INTO `partes` (`id`, `codigo`, `autogenerar_codigo`, `nombre`, `unidad_id`, `fabricante_id`, `precio_venta`, `moneda_venta`, `precio_compra`, `moneda_compra`, `categoria_parte_id`, `proveedor_id`, `created_at`, `updated_at`) VALUES
(1, '000001', 1, 'Reten A', 1, 1, 500.00, 'SOL', 300.00, 'SOL', 1, 0, '2025-03-28 03:23:09', '2025-03-28 03:23:09'),
(2, '000002', 1, 'producto 2', 1, 1, 321.00, 'SOL', 123.00, 'SOL', 1, 0, '2025-04-01 22:05:34', '2025-04-01 22:05:34'),
(3, '000003', 1, 'Faros', 1, 1, 321.00, 'SOL', 200.00, 'SOL', 1, 2, '2025-04-13 01:03:21', '2025-04-13 01:03:21'),
(4, '000004', 1, 'Parrillas', 1, 1, 55.00, 'SOL', 40.00, 'SOL', 1, 2, '2025-04-20 02:48:09', '2025-04-20 02:48:09');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `placas`
--

CREATE TABLE `placas` (
  `id` bigint UNSIGNED NOT NULL,
  `cotizacion_id` bigint UNSIGNED NOT NULL,
  `numero_placa` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `fecha_emision` date DEFAULT NULL,
  `estado_placa` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `observaciones_placa` text COLLATE utf8mb4_general_ci,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `tipo_placa` varchar(20) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'definitiva',
  `paso_actual` int NOT NULL DEFAULT '1',
  `observaciones` text COLLATE utf8mb4_general_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `placas`
--

INSERT INTO `placas` (`id`, `cotizacion_id`, `numero_placa`, `fecha_emision`, `estado_placa`, `observaciones_placa`, `user_id`, `created_at`, `updated_at`, `tipo_placa`, `paso_actual`, `observaciones`) VALUES
(1, 2, 'ABC-321', '2025-04-24', 'Pendiente de pago', NULL, 1, '2025-04-25 21:55:46', '2025-04-25 21:55:46', 'rotativa', 1, '000'),
(2, 2, 'CH01-5555', '2025-04-29', 'Pendiente de pago', NULL, 1, '2025-04-25 21:55:58', '2025-04-25 21:55:58', 'definitiva', 1, '00'),
(3, 5, 'ABC-561', '2025-06-02', 'Pendiente de pago', NULL, 1, '2025-06-03 10:22:31', '2025-06-03 10:22:31', 'rotativa', 1, 'QWREWQ'),
(4, 5, 'CH01-5555', '2025-06-18', 'En camino, pendiente de pago', NULL, 1, '2025-06-03 10:22:49', '2025-06-03 10:22:49', 'definitiva', 3, 'ERGER');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `placa_comentarios`
--

CREATE TABLE `placa_comentarios` (
  `id` bigint UNSIGNED NOT NULL,
  `placa_id` bigint UNSIGNED NOT NULL,
  `cotizacion_id` bigint UNSIGNED NOT NULL,
  `comentario` text COLLATE utf8mb4_general_ci NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `plan_mantenimientos`
--

CREATE TABLE `plan_mantenimientos` (
  `id` bigint UNSIGNED NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_unicode_ci,
  `modelo_vehiculo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ano_modelo` year NOT NULL,
  `tipo_transmision` enum('MT','AT','CVT') COLLATE utf8mb4_unicode_ci NOT NULL,
  `tono_vehiculo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `intervalo_base` int NOT NULL,
  `kilometraje_maximo` int NOT NULL,
  `relacion_horas_km` int NOT NULL DEFAULT '250',
  `tarifa_mano_obra` decimal(8,2) NOT NULL DEFAULT '0.00',
  `impuestos` decimal(5,2) NOT NULL DEFAULT '18.00',
  `margen_beneficio` decimal(5,2) NOT NULL DEFAULT '0.00',
  `moneda_principal` enum('USD','PEN') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'PEN',
  `proveedor_predeterminado_id` int UNSIGNED DEFAULT NULL,
  `mostrar_precios` tinyint(1) NOT NULL DEFAULT '1',
  `activo` tinyint(1) NOT NULL DEFAULT '1',
  `user_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE `proveedores` (
  `id` int NOT NULL,
  `tipo_documento` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `numero_documento` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `apellido_paterno` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `apellido_materno` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nombres` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `razon_social` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `direccion` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `departamento` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `provincia` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `distrito` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `categoria_proveedor_id` int NOT NULL,
  `cubre_garantias` enum('Sí','No') COLLATE utf8mb4_general_ci DEFAULT 'No',
  `es_aseguradora` enum('Sí','No') COLLATE utf8mb4_general_ci DEFAULT 'No',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `proveedores`
--

INSERT INTO `proveedores` (`id`, `tipo_documento`, `numero_documento`, `apellido_paterno`, `apellido_materno`, `nombres`, `razon_social`, `direccion`, `departamento`, `provincia`, `distrito`, `categoria_proveedor_id`, `cubre_garantias`, `es_aseguradora`, `created_at`, `updated_at`) VALUES
(2, 'RUC', '20611879777', NULL, NULL, NULL, 'QIPU S.A.C.S', 'AV. SAN MARTIN DE PORRES NRO. 1424 ASC. JULIO CESAR TELLO ET.1 DPTO. 4A', 'CAJAMARCA', 'CAJAMARCA', 'CAJAMARCA', 1, 'No', 'No', '2025-03-28 05:45:57', '2025-03-28 05:45:57');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `provincias`
--

CREATE TABLE `provincias` (
  `id` int UNSIGNED NOT NULL,
  `provincia` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `departamento_id` int UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `provincias`
--

INSERT INTO `provincias` (`id`, `provincia`, `status`, `departamento_id`, `created_at`, `updated_at`) VALUES
(1, 'CHACHAPOYAS', NULL, 1, NULL, NULL),
(2, 'BAGUA', NULL, 1, NULL, NULL),
(3, 'BONGARA', NULL, 1, NULL, NULL),
(4, 'CONDORCANQUI', NULL, 1, NULL, NULL),
(5, 'LUYA', NULL, 1, NULL, NULL),
(6, 'RODRIGUEZ DE MENDOZA', NULL, 1, NULL, NULL),
(7, 'UTCUBAMBA', NULL, 1, NULL, NULL),
(8, 'HUARAZ', NULL, 2, NULL, NULL),
(9, 'AIJA', NULL, 2, NULL, NULL),
(10, 'ANTONIO RAYMONDI', NULL, 2, NULL, NULL),
(11, 'ASUNCION', NULL, 2, NULL, NULL),
(12, 'BOLOGNESI', NULL, 2, NULL, NULL),
(13, 'CARHUAZ', NULL, 2, NULL, NULL),
(14, 'CARLOS FERMIN FITZCARRALD', NULL, 2, NULL, NULL),
(15, 'CASMA', NULL, 2, NULL, NULL),
(16, 'CORONGO', NULL, 2, NULL, NULL),
(17, 'HUARI', NULL, 2, NULL, NULL),
(18, 'HUARMEY', NULL, 2, NULL, NULL),
(19, 'HUAYLAS', NULL, 2, NULL, NULL),
(20, 'MARISCAL LUZURIAGA', NULL, 2, NULL, NULL),
(21, 'OCROS', NULL, 2, NULL, NULL),
(22, 'PALLASCA', NULL, 2, NULL, NULL),
(23, 'POMABAMBA', NULL, 2, NULL, NULL),
(24, 'RECUAY', NULL, 2, NULL, NULL),
(25, 'SANTA', NULL, 2, NULL, NULL),
(26, 'SIHUAS', NULL, 2, NULL, NULL),
(27, 'YUNGAY', NULL, 2, NULL, NULL),
(28, 'ABANCAY', NULL, 3, NULL, NULL),
(29, 'ANDAHUAYLAS', NULL, 3, NULL, NULL),
(30, 'ANTABAMBA', NULL, 3, NULL, NULL),
(31, 'AYMARAES', NULL, 3, NULL, NULL),
(32, 'COTABAMBAS', NULL, 3, NULL, NULL),
(33, 'CHINCHEROS', NULL, 3, NULL, NULL),
(34, 'GRAU', NULL, 3, NULL, NULL),
(35, 'AREQUIPA', NULL, 4, NULL, NULL),
(36, 'CAMANA', NULL, 4, NULL, NULL),
(37, 'CARAVELI', NULL, 4, NULL, NULL),
(38, 'CASTILLA', NULL, 4, NULL, NULL),
(39, 'CAYLLOMA', NULL, 4, NULL, NULL),
(40, 'CONDESUYOS', NULL, 4, NULL, NULL),
(41, 'ISLAY', NULL, 4, NULL, NULL),
(42, 'LA UNION', NULL, 4, NULL, NULL),
(43, 'HUAMANGA', NULL, 5, NULL, NULL),
(44, 'CANGALLO', NULL, 5, NULL, NULL),
(45, 'HUANCA SANCOS', NULL, 5, NULL, NULL),
(46, 'HUANTA', NULL, 5, NULL, NULL),
(47, 'LA MAR', NULL, 5, NULL, NULL),
(48, 'LUCANAS', NULL, 5, NULL, NULL),
(49, 'PARINACOCHAS', NULL, 5, NULL, NULL),
(50, 'PAUCAR DEL SARA SARA', NULL, 5, NULL, NULL),
(51, 'SUCRE', NULL, 5, NULL, NULL),
(52, 'VICTOR FAJARDO', NULL, 5, NULL, NULL),
(53, 'VILCAS HUAMAN', NULL, 5, NULL, NULL),
(54, 'CAJAMARCA', NULL, 6, NULL, NULL),
(55, 'CAJABAMBA', NULL, 6, NULL, NULL),
(56, 'CELENDIN', NULL, 6, NULL, NULL),
(57, 'CHOTA', NULL, 6, NULL, NULL),
(58, 'CONTUMAZA', NULL, 6, NULL, NULL),
(59, 'CUTERVO', NULL, 6, NULL, NULL),
(60, 'HUALGAYOC', NULL, 6, NULL, NULL),
(61, 'JAEN', NULL, 6, NULL, NULL),
(62, 'SAN IGNACIO', NULL, 6, NULL, NULL),
(63, 'SAN MARCOS', NULL, 6, NULL, NULL),
(64, 'SAN PABLO', NULL, 6, NULL, NULL),
(65, 'SANTA CRUZ', NULL, 6, NULL, NULL),
(66, 'CALLAO', NULL, 7, NULL, NULL),
(67, 'CUSCO', NULL, 8, NULL, NULL),
(68, 'ACOMAYO', NULL, 8, NULL, NULL),
(69, 'ANTA', NULL, 8, NULL, NULL),
(70, 'CALCA', NULL, 8, NULL, NULL),
(71, 'CANAS', NULL, 8, NULL, NULL),
(72, 'CANCHIS', NULL, 8, NULL, NULL),
(73, 'CHUMBIVILCAS', NULL, 8, NULL, NULL),
(74, 'ESPINAR', NULL, 8, NULL, NULL),
(75, 'LA CONVENCION', NULL, 8, NULL, NULL),
(76, 'PARURO', NULL, 8, NULL, NULL),
(77, 'PAUCARTAMBO', NULL, 8, NULL, NULL),
(78, 'QUISPICANCHI', NULL, 8, NULL, NULL),
(79, 'URUBAMBA', NULL, 8, NULL, NULL),
(80, 'HUANCAVELICA', NULL, 9, NULL, NULL),
(81, 'ACOBAMBA', NULL, 9, NULL, NULL),
(82, 'ANGARAES', NULL, 9, NULL, NULL),
(83, 'CASTROVIRREYNA', NULL, 9, NULL, NULL),
(84, 'CHURCAMPA', NULL, 9, NULL, NULL),
(85, 'HUAYTARA', NULL, 9, NULL, NULL),
(86, 'TAYACAJA', NULL, 9, NULL, NULL),
(87, 'HUANUCO', NULL, 10, NULL, NULL),
(88, 'AMBO', NULL, 10, NULL, NULL),
(89, 'DOS DE MAYO', NULL, 10, NULL, NULL),
(90, 'HUACAYBAMBA', NULL, 10, NULL, NULL),
(91, 'HUAMALIES', NULL, 10, NULL, NULL),
(92, 'LEONCIO PRADO', NULL, 10, NULL, NULL),
(93, 'MARAÑON', NULL, 10, NULL, NULL),
(94, 'PACHITEA', NULL, 10, NULL, NULL),
(95, 'PUERTO INCA', NULL, 10, NULL, NULL),
(96, 'LAURICOCHA', NULL, 10, NULL, NULL),
(97, 'YAROWILCA', NULL, 10, NULL, NULL),
(98, 'ICA', NULL, 11, NULL, NULL),
(99, 'CHINCHA', NULL, 11, NULL, NULL),
(100, 'NAZCA', NULL, 11, NULL, NULL),
(101, 'PALPA', NULL, 11, NULL, NULL),
(102, 'PISCO', NULL, 11, NULL, NULL),
(103, 'HUANCAYO', NULL, 12, NULL, NULL),
(104, 'CONCEPCION', NULL, 12, NULL, NULL),
(105, 'CHANCHAMAYO', NULL, 12, NULL, NULL),
(106, 'JAUJA', NULL, 12, NULL, NULL),
(107, 'JUNIN', NULL, 12, NULL, NULL),
(108, 'SATIPO', NULL, 12, NULL, NULL),
(109, 'TARMA', NULL, 12, NULL, NULL),
(110, 'YAULI', NULL, 12, NULL, NULL),
(111, 'CHUPACA', NULL, 12, NULL, NULL),
(112, 'TRUJILLO', NULL, 13, NULL, NULL),
(113, 'ASCOPE', NULL, 13, NULL, NULL),
(114, 'BOLIVAR', NULL, 13, NULL, NULL),
(115, 'CHEPEN', NULL, 13, NULL, NULL),
(116, 'JULCAN', NULL, 13, NULL, NULL),
(117, 'OTUZCO', NULL, 13, NULL, NULL),
(118, 'PACASMAYO', NULL, 13, NULL, NULL),
(119, 'PATAZ', NULL, 13, NULL, NULL),
(120, 'SANCHEZ CARRION', NULL, 13, NULL, NULL),
(121, 'SANTIAGO DE CHUCO', NULL, 13, NULL, NULL),
(122, 'GRAN CHIMU', NULL, 13, NULL, NULL),
(123, 'VIRU', NULL, 13, NULL, NULL),
(124, 'CHICLAYO', NULL, 14, NULL, NULL),
(125, 'FERREÑAFE', NULL, 14, NULL, NULL),
(126, 'LAMBAYEQUE', NULL, 14, NULL, NULL),
(127, 'LIMA', NULL, 15, NULL, NULL),
(128, 'BARRANCA', NULL, 15, NULL, NULL),
(129, 'CAJATAMBO', NULL, 15, NULL, NULL),
(130, 'CANTA', NULL, 15, NULL, NULL),
(131, 'CAÑETE', NULL, 15, NULL, NULL),
(132, 'HUARAL', NULL, 15, NULL, NULL),
(133, 'HUAROCHIRI', NULL, 15, NULL, NULL),
(134, 'HUAURA', NULL, 15, NULL, NULL),
(135, 'OYON', NULL, 15, NULL, NULL),
(136, 'YAUYOS', NULL, 15, NULL, NULL),
(137, 'MAYNAS', NULL, 16, NULL, NULL),
(138, 'ALTO AMAZONAS', NULL, 16, NULL, NULL),
(139, 'LORETO', NULL, 16, NULL, NULL),
(140, 'MARISCAL RAMON CASTILLA', NULL, 16, NULL, NULL),
(141, 'REQUENA', NULL, 16, NULL, NULL),
(142, 'UCAYALI', NULL, 16, NULL, NULL),
(143, 'TAMBOPATA', NULL, 17, NULL, NULL),
(144, 'MANU', NULL, 17, NULL, NULL),
(145, 'TAHUAMANU', NULL, 17, NULL, NULL),
(146, 'MARISCAL NIETO', NULL, 18, NULL, NULL),
(147, 'GENERAL SANCHEZ CERRO', NULL, 18, NULL, NULL),
(148, 'ILO', NULL, 18, NULL, NULL),
(149, 'PASCO', NULL, 19, NULL, NULL),
(150, 'DANIEL ALCIDES CARRION', NULL, 19, NULL, NULL),
(151, 'OXAPAMPA', NULL, 19, NULL, NULL),
(152, 'PIURA', NULL, 20, NULL, NULL),
(153, 'AYABACA', NULL, 20, NULL, NULL),
(154, 'HUANCABAMBA', NULL, 20, NULL, NULL),
(155, 'MORROPON', NULL, 20, NULL, NULL),
(156, 'PAITA', NULL, 20, NULL, NULL),
(157, 'SULLANA', NULL, 20, NULL, NULL),
(158, 'TALARA', NULL, 20, NULL, NULL),
(159, 'SECHURA', NULL, 20, NULL, NULL),
(160, 'PUNO', NULL, 21, NULL, NULL),
(161, 'AZANGARO', NULL, 21, NULL, NULL),
(162, 'CARABAYA', NULL, 21, NULL, NULL),
(163, 'CHUCUITO', NULL, 21, NULL, NULL),
(164, 'EL COLLAO', NULL, 21, NULL, NULL),
(165, 'HUANCANE', NULL, 21, NULL, NULL),
(166, 'LAMPA', NULL, 21, NULL, NULL),
(167, 'MELGAR', NULL, 21, NULL, NULL),
(168, 'MOHO', NULL, 21, NULL, NULL),
(169, 'SAN ANTONIO DE PUTINA', NULL, 21, NULL, NULL),
(170, 'SAN ROMAN', NULL, 21, NULL, NULL),
(171, 'SANDIA', NULL, 21, NULL, NULL),
(172, 'YUNGUYO', NULL, 21, NULL, NULL),
(173, 'MOYOBAMBA', NULL, 22, NULL, NULL),
(174, 'BELLAVISTA', NULL, 22, NULL, NULL),
(175, 'EL DORADO', NULL, 22, NULL, NULL),
(176, 'HUALLAGA', NULL, 22, NULL, NULL),
(177, 'LAMAS', NULL, 22, NULL, NULL),
(178, 'MARISCAL CACERES', NULL, 22, NULL, NULL),
(179, 'PICOTA', NULL, 22, NULL, NULL),
(180, 'RIOJA', NULL, 22, NULL, NULL),
(181, 'SAN MARTIN', NULL, 22, NULL, NULL),
(182, 'TOCACHE', NULL, 22, NULL, NULL),
(183, 'TACNA', NULL, 23, NULL, NULL),
(184, 'CANDARAVE', NULL, 23, NULL, NULL),
(185, 'JORGE BASADRE', NULL, 23, NULL, NULL),
(186, 'TARATA', NULL, 23, NULL, NULL),
(187, 'TUMBES', NULL, 24, NULL, NULL),
(188, 'CONTRALMIRANTE VILLAR', NULL, 24, NULL, NULL),
(189, 'ZARUMILLA', NULL, 24, NULL, NULL),
(190, 'CORONEL PORTILLO', NULL, 25, NULL, NULL),
(191, 'ATALAYA', NULL, 25, NULL, NULL),
(192, 'PADRE ABAD', NULL, 25, NULL, NULL),
(193, 'PURUS', NULL, 25, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recepciones_orden_compra`
--

CREATE TABLE `recepciones_orden_compra` (
  `id` bigint UNSIGNED NOT NULL,
  `detalle_orden_compra_id` bigint UNSIGNED NOT NULL,
  `cantidad_recibida` int NOT NULL DEFAULT '0',
  `fecha_recepcion` date NOT NULL,
  `observaciones` text COLLATE utf8mb4_unicode_ci,
  `recibido_por` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `recepciones_orden_compra`
--

INSERT INTO `recepciones_orden_compra` (`id`, `detalle_orden_compra_id`, `cantidad_recibida`, `fecha_recepcion`, `observaciones`, `recibido_por`, `created_at`, `updated_at`) VALUES
(1, 1, 2, '2025-05-26', NULL, 1, '2025-05-26 21:10:40', '2025-05-26 21:10:40'),
(2, 4, 3, '2025-05-26', 'sss', 1, '2025-05-26 21:18:12', '2025-05-26 21:18:12'),
(3, 3, 10, '2025-05-26', NULL, 1, '2025-05-26 21:18:35', '2025-05-26 21:18:35'),
(4, 2, 1, '2025-05-26', NULL, 1, '2025-05-26 21:25:07', '2025-05-26 21:25:07'),
(5, 2, 9, '2025-05-26', NULL, 1, '2025-05-26 21:26:08', '2025-05-26 21:26:08'),
(6, 5, 1, '2025-05-26', NULL, 1, '2025-05-26 21:44:13', '2025-05-26 21:44:13'),
(7, 6, 25, '2025-05-26', NULL, 1, '2025-05-27 01:35:29', '2025-05-27 01:35:29'),
(8, 7, 30, '2025-05-26', NULL, 1, '2025-05-27 01:35:29', '2025-05-27 01:35:29'),
(11, 8, 2, '2025-09-07', NULL, 1, '2025-09-07 22:19:34', '2025-09-07 22:19:34'),
(12, 9, 1, '2025-09-07', NULL, 1, '2025-09-07 22:19:34', '2025-09-07 22:19:34');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reglas_vencimiento_cotizaciones`
--

CREATE TABLE `reglas_vencimiento_cotizaciones` (
  `id` bigint UNSIGNED NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Nombre descriptivo de la regla',
  `descripcion` text COLLATE utf8mb4_unicode_ci COMMENT 'Descripción detallada de la regla',
  `dias_vencimiento` int NOT NULL COMMENT 'Días después de los cuales la cotización vence si no hay seguimiento',
  `dias_alerta` int NOT NULL DEFAULT '0' COMMENT 'Días antes del vencimiento para enviar alerta',
  `estado_vencido_id` bigint UNSIGNED NOT NULL,
  `permite_reasignacion` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Si permite que otro asesor tome la cotización vencida',
  `requiere_aprobacion` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Si requiere aprobación para reasignar',
  `notificar_vencimiento` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Si envía notificaciones de vencimiento',
  `activo` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Si la regla está activa',
  `condiciones` json DEFAULT NULL COMMENT 'Condiciones adicionales (usuarios, roles, canales, etc.)',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `reglas_vencimiento_cotizaciones`
--

INSERT INTO `reglas_vencimiento_cotizaciones` (`id`, `nombre`, `descripcion`, `dias_vencimiento`, `dias_alerta`, `estado_vencido_id`, `permite_reasignacion`, `requiere_aprobacion`, `notificar_vencimiento`, `activo`, `condiciones`, `created_at`, `updated_at`) VALUES
(1, 'Vendedores Junior', 'Regla para vendedores con poca experiencia. Cotizaciones vencen rápidamente para evitar pérdida de oportunidades.', 7, 2, 1, 1, 0, 1, 1, NULL, '2025-09-07 20:46:23', '2025-09-07 20:46:23'),
(2, 'Vendedores Senior', 'Regla para vendedores experimentados. Más tiempo para gestionar cotizaciones complejas.', 15, 3, 1, 1, 1, 1, 1, NULL, '2025-09-07 20:46:23', '2025-09-07 20:46:23'),
(3, 'Cotizaciones de Alto Valor', 'Para cotizaciones importantes que requieren más tiempo de negociación.', 30, 5, 1, 1, 1, 1, 0, NULL, '2025-09-07 20:46:23', '2025-09-07 20:46:23'),
(4, 'Regla Estándar', 'Regla por defecto para la mayoría de cotizaciones.', 10, 2, 1, 1, 0, 1, 1, NULL, '2025-09-07 20:46:23', '2025-09-07 20:46:23');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `requerimientos_compra`
--

CREATE TABLE `requerimientos_compra` (
  `id` bigint UNSIGNED NOT NULL,
  `codigo` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `fecha` date NOT NULL,
  `tipo` enum('inventario') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'inventario',
  `almacen_id` bigint UNSIGNED NOT NULL,
  `comentario` text COLLATE utf8mb4_general_ci,
  `estado_id` bigint UNSIGNED NOT NULL,
  `orden_trabajo` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `cotizacion_id` bigint UNSIGNED DEFAULT NULL,
  `venta_id` bigint UNSIGNED DEFAULT NULL,
  `prioridad` enum('Baja','Normal','Alta','Urgente') COLLATE utf8mb4_general_ci DEFAULT 'Normal',
  `user_id` bigint UNSIGNED NOT NULL,
  `proveedor_id` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `requerimientos_compra`
--

INSERT INTO `requerimientos_compra` (`id`, `codigo`, `fecha`, `tipo`, `almacen_id`, `comentario`, `estado_id`, `orden_trabajo`, `cotizacion_id`, `venta_id`, `prioridad`, `user_id`, `proveedor_id`, `created_at`, `updated_at`) VALUES
(5, 'REQ-5', '2025-04-30', 'inventario', 1, 'Requerimiento generado automáticamente desde cotización COT-202504000003', 1, NULL, 4, NULL, 'Normal', 1, NULL, '2025-04-30 20:37:48', '2025-04-30 20:37:48'),
(6, 'REQ-000006', '2025-05-26', 'inventario', 2, NULL, 1, NULL, NULL, NULL, 'Normal', 1, NULL, '2025-05-26 18:27:13', '2025-05-26 18:27:13'),
(7, 'REQ-000007', '2025-05-26', 'inventario', 2, NULL, 1, NULL, NULL, NULL, 'Normal', 1, 2, '2025-05-26 18:53:08', '2025-05-26 18:53:08'),
(8, 'REQ-000008', '2025-05-26', 'inventario', 2, NULL, 1, NULL, NULL, NULL, 'Normal', 1, 2, '2025-05-27 01:31:28', '2025-05-27 01:31:28');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'Administrador del sistema', '2025-04-23 20:06:47', '2025-04-23 20:06:47'),
(2, 'tecnico', 'Técnico de mantenimiento', '2025-04-23 20:06:47', '2025-04-23 20:06:47'),
(3, 'vendedor', 'Vendedor', '2025-04-23 20:06:47', '2025-04-23 20:06:47'),
(4, 'cliente', 'Cliente', '2025-04-23 20:06:47', '2025-04-23 20:06:47');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `role_user`
--

CREATE TABLE `role_user` (
  `user_id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `role_user`
--

INSERT INTO `role_user` (`user_id`, `role_id`) VALUES
(1, 1),
(2, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `seguimientos_cotizacion`
--

CREATE TABLE `seguimientos_cotizacion` (
  `id` bigint UNSIGNED NOT NULL,
  `cotizacion_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `tipo` enum('nota','llamada','reunion','email','otro') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'nota',
  `contenido` text COLLATE utf8mb4_general_ci,
  `fecha_seguimiento` datetime NOT NULL,
  `recordatorio` tinyint(1) NOT NULL DEFAULT '0',
  `fecha_recordatorio` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `realizado` tinyint(1) DEFAULT '0',
  `datos_adicionales` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin
) ;

--
-- Volcado de datos para la tabla `seguimientos_cotizacion`
--

INSERT INTO `seguimientos_cotizacion` (`id`, `cotizacion_id`, `user_id`, `tipo`, `contenido`, `fecha_seguimiento`, `recordatorio`, `fecha_recordatorio`, `created_at`, `updated_at`, `realizado`, `datos_adicionales`) VALUES
(1, 2, 1, 'nota', '111', '2025-04-25 16:54:00', 0, NULL, '2025-04-25 21:54:17', '2025-04-25 21:54:17', 0, NULL),
(2, 2, 1, 'llamada', '111', '2025-04-25 16:54:00', 1, '2025-04-28 10:00:00', '2025-04-25 21:54:26', '2025-04-25 21:54:26', 0, NULL),
(3, 2, 1, 'nota', '5555', '2025-04-30 02:49:00', 0, NULL, '2025-04-30 07:50:01', '2025-04-30 07:50:01', 0, NULL),
(4, 2, 1, 'nota', '555', '2025-04-30 02:50:00', 0, NULL, '2025-04-30 07:50:34', '2025-04-30 07:50:34', 0, NULL),
(5, 2, 1, 'nota', '777', '2025-04-30 02:50:00', 0, NULL, '2025-04-30 07:50:39', '2025-04-30 07:50:39', 0, NULL),
(6, 3, 1, 'nota', 'Cambio de estado: Interesado → Cerrado Ganado\nComentario: 33', '2025-04-30 05:32:29', 0, NULL, '2025-04-30 10:32:29', '2025-04-30 10:32:29', 0, '[]'),
(7, 3, 1, 'nota', 'Cambio de estado: Cerrado Ganado → Aceptada\nComentario: aaa', '2025-04-30 05:39:40', 0, NULL, '2025-04-30 10:39:40', '2025-04-30 10:39:40', 0, '{\"fecha_aceptacion\":\"2025-04-30\"}'),
(8, 3, 1, 'nota', 'Cambio de estado: Aceptada → Cerrado Ganado\nComentario: aaa', '2025-04-30 05:40:05', 0, NULL, '2025-04-30 10:40:05', '2025-06-27 10:55:13', 1, '[]'),
(9, 4, 1, 'nota', 'Cambio de estado: Interesado → Cerrado Ganado\nComentario: 12', '2025-04-30 05:48:35', 0, NULL, '2025-04-30 10:48:35', '2025-04-30 10:48:35', 0, '[]'),
(10, 4, 1, 'nota', 'Se generó requerimiento de compra #5 ', '2025-04-30 15:37:48', 0, NULL, '2025-04-30 20:37:48', '2025-04-30 20:37:48', 0, NULL),
(11, 5, 1, 'nota', '333333333333', '2025-05-23 17:32:00', 1, '2025-05-26 10:00:00', '2025-05-23 22:35:14', '2025-05-27 03:13:53', 1, NULL),
(12, 5, 1, 'llamada', 'efdfdsf', '2025-06-03 05:21:00', 1, '2025-06-06 10:00:00', '2025-06-03 10:21:24', '2025-06-03 10:21:36', 1, NULL),
(13, 3, 1, 'llamada', 'wrewarew', '2025-06-28 05:53:00', 1, '2025-06-27 10:00:00', '2025-06-27 10:54:43', '2025-06-27 10:55:16', 1, NULL),
(14, 3, 1, 'nota', 'Cambio de estado: Aceptada → Interesado\nComentario: xasx', '2025-06-27 05:55:49', 0, NULL, '2025-06-27 10:55:49', '2025-06-27 10:55:49', 0, '{\"cotizacion_enviada\":\"si\",\"metodo_pago\":\"Cr\\u00e9dito\",\"solicitud_credito\":\"si\",\"estado_credito\":\"En Proceso\"}'),
(15, 5, 1, 'llamada', 'kjhgkjhgjhgjh', '2025-08-19 13:23:00', 0, NULL, '2025-08-19 04:24:02', '2025-08-19 04:24:02', 0, NULL),
(16, 49, 1, 'nota', 'adasdasd', '2025-09-07 07:49:00', 1, '2025-09-10 10:00:00', '2025-09-07 12:49:34', '2025-09-07 12:49:34', 0, NULL),
(17, 49, 1, 'nota', 'Cambio de estado: Nueva → Aceptada\nComentario: 32132132', '2025-09-07 07:50:40', 0, NULL, '2025-09-07 12:50:40', '2025-09-07 12:50:40', 0, '{\"fecha_aceptacion\":\"2025-09-07\"}');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `seguimientos_oportunidades`
--

CREATE TABLE `seguimientos_oportunidades` (
  `id` bigint UNSIGNED NOT NULL,
  `oportunidad_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `tipo` enum('nota','llamada','reunion','email','otro') COLLATE utf8mb4_unicode_ci NOT NULL,
  `contenido` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_seguimiento` datetime NOT NULL,
  `recordatorio` tinyint(1) NOT NULL DEFAULT '0',
  `fecha_recordatorio` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `seguimientos_orden_trabajo`
--

CREATE TABLE `seguimientos_orden_trabajo` (
  `id` bigint UNSIGNED NOT NULL,
  `orden_trabajo_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `tipo` enum('nota','llamada','reunion','email') COLLATE utf8mb4_unicode_ci NOT NULL,
  `contenido` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_seguimiento` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `recordatorio` tinyint(1) NOT NULL DEFAULT '0',
  `fecha_recordatorio` timestamp NULL DEFAULT NULL,
  `realizado` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `seguimientos_orden_trabajo`
--

INSERT INTO `seguimientos_orden_trabajo` (`id`, `orden_trabajo_id`, `user_id`, `tipo`, `contenido`, `fecha_seguimiento`, `recordatorio`, `fecha_recordatorio`, `realizado`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'nota', 'Nota 1', '2025-04-30 03:49:24', 1, '2025-04-28 23:00:00', 0, '2025-04-30 03:49:24', '2025-04-30 03:49:24'),
(2, 1, 1, 'nota', 'Nota 1', '2025-04-30 03:49:34', 0, NULL, 1, '2025-04-30 03:49:34', '2025-04-30 07:33:24'),
(3, 2, 1, 'nota', 'ggggggggggg', '2025-04-30 04:49:10', 0, NULL, 0, '2025-04-30 04:49:10', '2025-04-30 04:49:10'),
(4, 1, 1, 'nota', 'AAA', '2025-04-30 07:31:36', 0, NULL, 0, '2025-04-30 07:31:36', '2025-04-30 07:31:36'),
(5, 1, 1, 'nota', 'AAA', '2025-04-30 07:34:44', 0, NULL, 0, '2025-04-30 07:34:44', '2025-04-30 07:34:44'),
(6, 1, 1, 'nota', 'bbb', '2025-04-30 07:49:18', 0, NULL, 0, '2025-04-30 07:49:18', '2025-04-30 07:49:18'),
(7, 1, 1, 'nota', 'bbb', '2025-04-30 07:49:19', 0, NULL, 0, '2025-04-30 07:49:19', '2025-04-30 07:49:19'),
(8, 1, 1, 'nota', 'ppp', '2025-04-30 07:51:56', 0, NULL, 0, '2025-04-30 07:51:57', '2025-04-30 07:51:57'),
(9, 1, 1, 'nota', 'ppp', '2025-04-30 07:51:57', 0, NULL, 0, '2025-04-30 07:51:57', '2025-04-30 07:51:57'),
(10, 1, 1, 'nota', '6666', '2025-04-30 09:27:13', 0, NULL, 0, '2025-04-30 09:27:13', '2025-04-30 09:27:13'),
(11, 1, 1, 'nota', '333', '2025-04-30 09:29:56', 0, NULL, 0, '2025-04-30 09:29:56', '2025-04-30 09:29:56'),
(12, 2, 1, 'llamada', 'ssss', '2025-09-07 21:11:12', 1, '2025-09-09 16:11:00', 1, '2025-09-07 21:11:12', '2025-09-07 21:11:24');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicios`
--

CREATE TABLE `servicios` (
  `id` bigint UNSIGNED NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `moneda` enum('SOL','USD') COLLATE utf8mb4_general_ci NOT NULL,
  `categoria_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `servicios`
--

INSERT INTO `servicios` (`id`, `nombre`, `precio`, `moneda`, `categoria_id`, `created_at`, `updated_at`) VALUES
(1, 'Inyección', 300.00, 'SOL', 1, '2025-03-28 03:23:43', '2025-04-20 04:09:55'),
(2, 'Colocación Videro Liquido', 200.00, 'SOL', 2, '2025-04-20 03:32:19', '2025-04-20 04:10:00'),
(3, 'Camara pantalla', 321.00, 'SOL', 1, '2025-04-22 03:02:00', '2025-04-22 03:02:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicios_cita`
--

CREATE TABLE `servicios_cita` (
  `id` bigint UNSIGNED NOT NULL,
  `cita_id` bigint UNSIGNED NOT NULL,
  `descripcion` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `servicios_cita`
--

INSERT INTO `servicios_cita` (`id`, `cita_id`, `descripcion`, `created_at`, `updated_at`) VALUES
(3, 1, 'AAAAAA', '2025-04-29 20:39:24', '2025-04-29 20:39:24'),
(4, 1, 'AAA', '2025-04-29 20:39:24', '2025-04-29 20:39:24'),
(5, 2, 'Alineamiento', '2025-04-30 04:46:26', '2025-04-30 04:46:26'),
(6, 2, 'ssssssss', '2025-04-30 04:46:26', '2025-04-30 04:46:26');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('aXpaMKECZsTuzasiQ1IGTerDZcGJD5T9joyxSee5', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiU2ZZNDR1czJEcUlmaGxMYjA5YTltWkFHVlk3VHFaNFNDUGRKWFVObiI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjUwOiJodHRwczovL21zYS50ZXN0L2FkbWluL3BsYW5lcy1tYW50ZW5pbWllbnRvL2NyZWF0ZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7czo0OiJhdXRoIjthOjE6e3M6MjE6InBhc3N3b3JkX2NvbmZpcm1lZF9hdCI7aToxNzU3MzQyMzcwO319', 1757342537),
('ejaxu2bH8Rr4L7vOE5Wt6Xca3Pu0WDLgH6FLfMR8', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiWmtiZXJxbkRVYTNrTFZnN0FQMW9mdkZtdm1kTHExeXJlZVQ0TzJKRCI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjUwOiJodHRwczovL21zYS50ZXN0L2FkbWluL3BsYW5lcy1tYW50ZW5pbWllbnRvL2NyZWF0ZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7czo0OiJhdXRoIjthOjE6e3M6MjE6InBhc3N3b3JkX2NvbmZpcm1lZF9hdCI7aToxNzU3Mjk4MDU5O319', 1757302915),
('GpXLu9NTKMYPgxLHRgA8i1A7eVicoqxRP4CQJcrH', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiQUFHbXU2cUNtamdPSTA0MWl3a1lsRUFGakpvZTlaQUZBQzhRVkJFUiI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjQ5OiJodHRwczovL21zYS50ZXN0L2FkbWluL2NvbmZpZ3VyYWNpb24vdGlwb3MtY2FtYmlvIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjQ6ImF1dGgiO2E6MTp7czoyMToicGFzc3dvcmRfY29uZmlybWVkX2F0IjtpOjE3NTcyNTk5MzA7fX0=', 1757267335),
('ZEWLfD4kfazREmf8MmeR3Cex49ZMAVDLKR0OstXh', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoicE5FRzBQdFQzeDZvM0toT0VqQk8xd0NFNTJTbURYRzgyVTdoNUdOayI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjQzOiJodHRwczovL21zYS50ZXN0L2FkbWluL2NvbXByYXMvZGV2b2x1Y2lvbmVzIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjQ6ImF1dGgiO2E6MTp7czoyMToicGFzc3dvcmRfY29uZmlybWVkX2F0IjtpOjE3NTcyODgyMTQ7fX0=', 1757290141);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `talleres`
--

CREATE TABLE `talleres` (
  `id` bigint UNSIGNED NOT NULL,
  `nombre_taller` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `departamento` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `provincia` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `distrito` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `direccion` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `coordenadas` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `talleres`
--

INSERT INTO `talleres` (`id`, `nombre_taller`, `departamento`, `provincia`, `distrito`, `direccion`, `coordenadas`, `created_at`, `updated_at`) VALUES
(1, 'Taller 1', 'Cajamarca', 'Cajamarca', 'Cajamarca', 'Av. Heroes del Cenepa 556', '-7.178521771238904,-78.49697113037111', '2025-03-20 18:06:57', '2025-03-20 18:06:57'),
(2, 'Taller 2', 'Cajamarca', 'Cajamarca', 'Cajamarca', 'Av. Atahualpa 152, Cajamarca', '-7.165668000034802,-78.50558703877894', '2025-03-20 18:09:57', '2025-03-20 18:09:57'),
(3, 'Taller 2', 'Cajamarca', 'Cajamarca', 'Cajamarca', 'Jiron Amalia Puga 152, Cajamarca', '-7.159174546510783,-78.51525843143465', '2025-03-20 19:36:53', '2025-03-20 19:36:53');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `telefonos`
--

CREATE TABLE `telefonos` (
  `id` bigint UNSIGNED NOT NULL,
  `cliente_id` bigint UNSIGNED NOT NULL,
  `numero` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `tipo` enum('telefono','celular') COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `telefonos`
--

INSERT INTO `telefonos` (`id`, `cliente_id`, `numero`, `tipo`, `created_at`, `updated_at`) VALUES
(1, 1, '912774477', 'telefono', '2025-03-20 17:28:05', '2025-03-20 17:28:05'),
(2, 1, '912774477', 'celular', '2025-03-20 17:28:05', '2025-03-20 17:28:05'),
(3, 2, '987654321', 'telefono', '2025-03-20 19:33:28', '2025-03-20 19:33:28'),
(4, 2, '912774477', 'celular', '2025-03-20 19:33:28', '2025-03-20 19:33:28'),
(5, 3, '912774477', 'telefono', '2025-03-28 23:53:09', '2025-03-28 23:53:09'),
(6, 3, '987654321', 'telefono', '2025-03-28 23:53:09', '2025-03-28 23:53:09'),
(7, 3, '912774477', 'celular', '2025-03-28 23:53:09', '2025-03-28 23:53:09'),
(8, 3, '912774476', 'celular', '2025-03-28 23:53:09', '2025-03-28 23:53:09'),
(9, 4, '912774477', 'telefono', '2025-03-28 23:57:23', '2025-03-28 23:57:23'),
(10, 4, '987654321', 'telefono', '2025-03-28 23:57:23', '2025-03-28 23:57:23'),
(11, 4, '912774477', 'celular', '2025-03-28 23:57:23', '2025-03-28 23:57:23'),
(12, 4, '912774477', 'celular', '2025-03-28 23:57:23', '2025-03-28 23:57:23'),
(13, 5, '5754676765', 'telefono', '2025-03-29 01:16:32', '2025-03-29 01:16:32'),
(14, 5, '765756756765', 'celular', '2025-03-29 01:16:32', '2025-03-29 01:16:32'),
(15, 6, '912774477', 'telefono', '2025-04-30 10:36:22', '2025-04-30 10:36:22'),
(16, 6, '987654987', 'celular', '2025-04-30 10:36:22', '2025-04-30 10:36:22');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos_cambio`
--

CREATE TABLE `tipos_cambio` (
  `id` bigint UNSIGNED NOT NULL,
  `fecha` date NOT NULL,
  `compra` decimal(8,4) NOT NULL COMMENT 'Tipo de cambio compra',
  `venta` decimal(8,4) NOT NULL COMMENT 'Tipo de cambio venta',
  `fecha_inicio` date NOT NULL COMMENT 'Fecha desde cuando es válido',
  `fecha_fin` date DEFAULT NULL COMMENT 'Fecha hasta cuando es válido',
  `origen` enum('sunat','manual') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'sunat' COMMENT 'Origen del tipo de cambio',
  `activo` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Si está activo para usar',
  `observaciones` text COLLATE utf8mb4_unicode_ci COMMENT 'Observaciones adicionales',
  `user_id` bigint UNSIGNED NOT NULL COMMENT 'Usuario que registró/modificó',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `tipos_cambio`
--

INSERT INTO `tipos_cambio` (`id`, `fecha`, `compra`, `venta`, `fecha_inicio`, `fecha_fin`, `origen`, `activo`, `observaciones`, `user_id`, `created_at`, `updated_at`) VALUES
(3, '2025-09-07', 3.5190, 3.5270, '2025-09-07', NULL, 'sunat', 1, NULL, 1, '2025-09-07 12:39:17', '2025-09-07 12:39:17');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos_movimiento`
--

CREATE TABLE `tipos_movimiento` (
  `id` bigint UNSIGNED NOT NULL,
  `nombre` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `operacion` enum('entrada','salida') COLLATE utf8mb4_general_ci NOT NULL,
  `afecta_stock` tinyint(1) DEFAULT '1',
  `descripcion` text COLLATE utf8mb4_general_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipos_movimiento`
--

INSERT INTO `tipos_movimiento` (`id`, `nombre`, `operacion`, `afecta_stock`, `descripcion`, `created_at`, `updated_at`) VALUES
(1, 'Entrada general', 'entrada', 1, 'Movimiento de entrada estándar', '2025-04-17 14:19:06', NULL),
(2, 'Salida a producción', 'salida', 1, 'Movimiento de salid', '2025-04-17 14:19:06', NULL),
(3, 'Ajuste inventario', 'entrada', 0, 'Corrección manual del inventario', '2025-04-17 14:19:06', NULL),
(4, 'Venta POS', 'salida', 1, 'Venta generada desde el Punto de Venta', '2025-05-19 14:01:29', NULL),
(6, 'Devolución a Proveedor', 'entrada', -1, NULL, '2025-09-07 21:44:41', '2025-09-07 21:44:41');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `traslados`
--

CREATE TABLE `traslados` (
  `id` int NOT NULL,
  `almacen_origen_id` int NOT NULL,
  `almacen_destino_id` int NOT NULL,
  `motivo` text COLLATE utf8mb4_general_ci,
  `fecha_traslado` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `estado` varchar(20) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'pendiente',
  `usuario_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `traslado_items`
--

CREATE TABLE `traslado_items` (
  `id` int NOT NULL,
  `traslado_id` int NOT NULL,
  `parte_id` int DEFAULT NULL,
  `vehiculo_id` int DEFAULT NULL,
  `tipo_item` enum('parte','vehiculo') COLLATE utf8mb4_general_ci NOT NULL,
  `cantidad` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `unidades`
--

CREATE TABLE `unidades` (
  `id` bigint UNSIGNED NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_general_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `unidades`
--

INSERT INTO `unidades` (`id`, `nombre`, `descripcion`, `created_at`, `updated_at`) VALUES
(1, 'Unidad', '1', '2025-03-28 00:06:19', '2025-03-28 00:06:19'),
(2, 'Decena', '12', '2025-03-28 00:06:25', '2025-03-28 00:06:25');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `two_factor_secret` text COLLATE utf8mb4_unicode_ci,
  `two_factor_recovery_codes` text COLLATE utf8mb4_unicode_ci,
  `two_factor_confirmed_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `current_team_id` bigint UNSIGNED DEFAULT NULL,
  `profile_photo_path` varchar(2048) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `two_factor_secret`, `two_factor_recovery_codes`, `two_factor_confirmed_at`, `remember_token`, `current_team_id`, `profile_photo_path`, `created_at`, `updated_at`) VALUES
(1, 'Edwin Chávez', 'edwin@qipuh.com', NULL, '$2y$12$f.XM59sZ.gNXINXPxO/1NuR9J4rMY5O1sctKFcLQcLmK0b22CzJzm', NULL, NULL, NULL, 'f0H9mUim9kxvy1AcB0wOVu0jJKyLWxh08Yy56DAAh1d240GLRUZloIQvPh6d', NULL, NULL, '2025-03-12 22:01:15', '2025-04-24 20:13:04'),
(2, 'Tecnico', 'tech@qipuh.com', NULL, '$2y$12$C1P02eSecCey6zY.ZNnNQ.O/oTJle5YPqHrJiy7V7.6SnwsKKMtMe', NULL, NULL, NULL, NULL, NULL, NULL, '2025-04-24 20:13:31', '2025-04-24 20:13:31');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vales_devolucion`
--

CREATE TABLE `vales_devolucion` (
  `id` bigint UNSIGNED NOT NULL,
  `numero` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha` date NOT NULL,
  `proveedor_id` bigint UNSIGNED NOT NULL,
  `motivo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `observaciones` text COLLATE utf8mb4_unicode_ci,
  `estado` enum('pendiente','aprobado','rechazado','procesado') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pendiente',
  `usuario_id` bigint UNSIGNED NOT NULL,
  `aprobado_por` bigint UNSIGNED DEFAULT NULL,
  `fecha_aprobacion` timestamp NULL DEFAULT NULL,
  `total` decimal(10,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vehiculos`
--

CREATE TABLE `vehiculos` (
  `id` bigint UNSIGNED NOT NULL,
  `marca_id` bigint UNSIGNED NOT NULL,
  `modelo_id` bigint UNSIGNED NOT NULL,
  `anio` int NOT NULL,
  `color` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `nro_placa` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `serie_vim` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `motor` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `combustible_id` bigint UNSIGNED NOT NULL,
  `kilometraje` decimal(15,2) NOT NULL,
  `cliente_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `almacen_id` int NOT NULL,
  `estado` varchar(255) COLLATE utf8mb4_general_ci DEFAULT 'disponible'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `vehiculos`
--

INSERT INTO `vehiculos` (`id`, `marca_id`, `modelo_id`, `anio`, `color`, `nro_placa`, `serie_vim`, `motor`, `combustible_id`, `kilometraje`, `cliente_id`, `created_at`, `updated_at`, `almacen_id`, `estado`) VALUES
(1, 2, 1, 2025, 'Azul', 'AAA-1234', 'g435g45g45gdgdf', '300', 1, 5000.00, 3, '2025-04-24 00:38:54', '2025-04-24 00:38:54', 1, 'disponible');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vehiculos_mantenimiento`
--

CREATE TABLE `vehiculos_mantenimiento` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `vehiculo_id` bigint UNSIGNED DEFAULT NULL,
  `marca_id` bigint UNSIGNED DEFAULT NULL,
  `modelo_id` bigint UNSIGNED DEFAULT NULL,
  `anio` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `color` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nro_placa` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `kilometraje` bigint UNSIGNED NOT NULL DEFAULT '0',
  `cliente_id` bigint UNSIGNED DEFAULT NULL,
  `serie_vim` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `motor` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `combustible_id` bigint UNSIGNED DEFAULT NULL,
  `fecha_hora_cita` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `vehiculos_mantenimiento`
--

INSERT INTO `vehiculos_mantenimiento` (`id`, `created_at`, `updated_at`, `vehiculo_id`, `marca_id`, `modelo_id`, `anio`, `color`, `nro_placa`, `kilometraje`, `cliente_id`, `serie_vim`, `motor`, `combustible_id`, `fecha_hora_cita`) VALUES
(1, '2025-04-29 20:37:09', '2025-04-29 20:37:09', NULL, 1, 1, '2000', 'ROJO', 'CCC-321', 32132, 1, '33333333333', '3333333333333', 1, NULL),
(2, '2025-04-30 04:45:22', '2025-04-30 04:45:22', NULL, 1, 1, '2000', 'verde', 'BBB-2222', 5000, 1, '444444444444', '4444444444444', 1, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `id` bigint UNSIGNED NOT NULL,
  `codigo` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `numero_factura` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `fecha` datetime NOT NULL,
  `fecha_vencimiento` date DEFAULT NULL,
  `fecha_despacho` date DEFAULT NULL,
  `cliente_id` bigint UNSIGNED NOT NULL,
  `usuario_id` bigint UNSIGNED NOT NULL,
  `almacen_id` bigint UNSIGNED NOT NULL,
  `subtotal` decimal(10,2) NOT NULL DEFAULT '0.00',
  `igv` decimal(10,2) NOT NULL DEFAULT '0.00',
  `total` decimal(10,2) NOT NULL DEFAULT '0.00',
  `monto_abonado` decimal(10,2) NOT NULL DEFAULT '0.00',
  `saldo_pendiente` decimal(10,2) NOT NULL DEFAULT '0.00',
  `moneda` varchar(10) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Soles',
  `tipo_cambio_usado` decimal(8,4) DEFAULT NULL,
  `tipo_pago` varchar(20) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Contado',
  `estado` enum('pendiente','pagado','no_pagado','en_cotizacion','despachado','para_importacion','pedido_especial','cancelado') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'pendiente',
  `prioridad` enum('baja','media','alta','urgente') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'media',
  `requiere_importacion` tinyint(1) NOT NULL DEFAULT '0',
  `observaciones` text COLLATE utf8mb4_general_ci,
  `notas_internas` text COLLATE utf8mb4_general_ci,
  `detalle_estados` json DEFAULT NULL,
  `cotizacion_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `versiones`
--

CREATE TABLE `versiones` (
  `id` bigint UNSIGNED NOT NULL,
  `marca_id` bigint UNSIGNED NOT NULL,
  `modelo_id` bigint UNSIGNED NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `carroceria` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `cilindrada` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `transmision` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `traccion` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `combustible_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `versiones`
--

INSERT INTO `versiones` (`id`, `marca_id`, `modelo_id`, `nombre`, `carroceria`, `cilindrada`, `transmision`, `traccion`, `combustible_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '5000', 'SUV', '20', 'Automática', '4x2', 1, '2025-03-28 03:20:04', '2025-03-28 03:20:04'),
(2, 2, 2, 'aaa', 'aaa', 'aaaa', 'aaa', 'aaa', 1, '2025-04-25 21:59:33', '2025-04-25 21:59:33');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `actas_entrega`
--
ALTER TABLE `actas_entrega`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `codigo` (`codigo`),
  ADD KEY `cotizacion_id` (`cotizacion_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indices de la tabla `adelantos`
--
ALTER TABLE `adelantos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_adelantos_cita_id` (`cita_id`);

--
-- Indices de la tabla `almacenes`
--
ALTER TABLE `almacenes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`),
  ADD KEY `centro_costo_id` (`centro_costo_id`),
  ADD KEY `fk_almacenes_parent_id` (`parent_id`);

--
-- Indices de la tabla `almacen_items`
--
ALTER TABLE `almacen_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `almacen_id` (`almacen_id`);

--
-- Indices de la tabla `anios_modelo`
--
ALTER TABLE `anios_modelo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `marca_id` (`marca_id`),
  ADD KEY `modelo_id` (`modelo_id`),
  ADD KEY `version_id` (`version_id`);

--
-- Indices de la tabla `bancos`
--
ALTER TABLE `bancos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indices de la tabla `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indices de la tabla `canal_captacion`
--
ALTER TABLE `canal_captacion`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `cargos`
--
ALTER TABLE `cargos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre_cargo` (`nombre_cargo`);

--
-- Indices de la tabla `catalogos`
--
ALTER TABLE `catalogos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `marca_id` (`marca_id`),
  ADD KEY `modelo_id` (`modelo_id`),
  ADD KEY `version_id` (`version_id`),
  ADD KEY `anio_modelo_id` (`anio_modelo_id`);

--
-- Indices de la tabla `categorias_partes`
--
ALTER TABLE `categorias_partes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `categorias_proveedor`
--
ALTER TABLE `categorias_proveedor`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre_categoria_proveedor` (`nombre_categoria_proveedor`);

--
-- Indices de la tabla `categorias_servicios_tercerizados`
--
ALTER TABLE `categorias_servicios_tercerizados`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `categoria_clientes`
--
ALTER TABLE `categoria_clientes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `centros_costos`
--
ALTER TABLE `centros_costos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `codigo` (`codigo`);

--
-- Indices de la tabla `citas_mantenimiento`
--
ALTER TABLE `citas_mantenimiento`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_vehiculo_id` (`vehiculo_id`),
  ADD KEY `idx_cliente_id` (`cliente_id`),
  ADD KEY `idx_tecnico_id` (`tecnico_id`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `documento_identidad` (`documento_identidad`),
  ADD KEY `categoria_cliente_id` (`categoria_cliente_id`),
  ADD KEY `canal_captacion_id` (`canal_captacion_id`);

--
-- Indices de la tabla `colores`
--
ALTER TABLE `colores`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `combustibles`
--
ALTER TABLE `combustibles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `comentarios_seguimiento`
--
ALTER TABLE `comentarios_seguimiento`
  ADD PRIMARY KEY (`id`),
  ADD KEY `seguimiento_id` (`seguimiento_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indices de la tabla `comentarios_seguimiento_orden`
--
ALTER TABLE `comentarios_seguimiento_orden`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comentarios_seguimiento_orden_seguimiento_id_foreign` (`seguimiento_id`),
  ADD KEY `comentarios_seguimiento_orden_user_id_foreign` (`user_id`);

--
-- Indices de la tabla `componente_plan_mantenimientos`
--
ALTER TABLE `componente_plan_mantenimientos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `componente_plan_mantenimientos_parte_id_foreign` (`parte_id`),
  ADD KEY `comp_plan_mant_plan_parte_idx` (`plan_mantenimiento_id`,`parte_id`),
  ADD KEY `componente_plan_mantenimientos_activo_index` (`activo`);

--
-- Indices de la tabla `comprobantes`
--
ALTER TABLE `comprobantes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cotizacion_id` (`cotizacion_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indices de la tabla `contactos_proveedores`
--
ALTER TABLE `contactos_proveedores`
  ADD PRIMARY KEY (`id`),
  ADD KEY `proveedor_id` (`proveedor_id`);

--
-- Indices de la tabla `correos_proveedores`
--
ALTER TABLE `correos_proveedores`
  ADD PRIMARY KEY (`id`),
  ADD KEY `proveedor_id` (`proveedor_id`);

--
-- Indices de la tabla `cotizaciones`
--
ALTER TABLE `cotizaciones`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `codigo` (`codigo`),
  ADD UNIQUE KEY `unique_codigo` (`codigo`),
  ADD KEY `cliente_id` (`cliente_id`),
  ADD KEY `almacen_id` (`almacen_id`),
  ADD KEY `estado_id` (`estado_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `cotizaciones_regla_vencimiento_id_foreign` (`regla_vencimiento_id`);

--
-- Indices de la tabla `cuentas_proveedores`
--
ALTER TABLE `cuentas_proveedores`
  ADD PRIMARY KEY (`id`),
  ADD KEY `proveedor_id` (`proveedor_id`),
  ADD KEY `banco_id` (`banco_id`);

--
-- Indices de la tabla `departamentos`
--
ALTER TABLE `departamentos`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indices de la tabla `detalles_cotizacion`
--
ALTER TABLE `detalles_cotizacion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cotizacion_id` (`cotizacion_id`),
  ADD KEY `vehiculo_catalogo_id` (`vehiculo_catalogo_id`),
  ADD KEY `color_id` (`color_id`),
  ADD KEY `detalles_cotizacion_vehiculo_id_foreign` (`vehiculo_id`),
  ADD KEY `idx_detalles_cotizacion_repuesto` (`repuesto_id`),
  ADD KEY `idx_detalles_cotizacion_servicio` (`servicio_id`);

--
-- Indices de la tabla `detalles_devolucion_proveedor`
--
ALTER TABLE `detalles_devolucion_proveedor`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `detalles_requerimientos_compra`
--
ALTER TABLE `detalles_requerimientos_compra`
  ADD PRIMARY KEY (`id`),
  ADD KEY `requerimiento_compra_id` (`requerimiento_compra_id`),
  ADD KEY `detalles_requerimientos_compra_color_id_foreign` (`color_id`),
  ADD KEY `detalles_requerimientos_compra_cotizacion_detalle_id_foreign` (`cotizacion_detalle_id`);

--
-- Indices de la tabla `detalles_venta`
--
ALTER TABLE `detalles_venta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `venta_id` (`venta_id`),
  ADD KEY `parte_id` (`parte_id`),
  ADD KEY `servicio_id` (`servicio_id`);

--
-- Indices de la tabla `detalles_venta_pos`
--
ALTER TABLE `detalles_venta_pos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_parte` (`parte_id`),
  ADD KEY `fk_detalles_almacen` (`almacen_id`),
  ADD KEY `fk_detalles_usuario` (`user_id`),
  ADD KEY `idx_venta_parte` (`venta_id`,`parte_id`),
  ADD KEY `idx_codigo_parte` (`codigo_parte`);

--
-- Indices de la tabla `detalle_guias_entrega`
--
ALTER TABLE `detalle_guias_entrega`
  ADD PRIMARY KEY (`id`),
  ADD KEY `detalle_guias_entrega_guia_entrega_id_index` (`guia_entrega_id`),
  ADD KEY `detalle_guias_entrega_tipo_producto_producto_id_index` (`tipo_producto`,`producto_id`);

--
-- Indices de la tabla `detalle_orden_compras`
--
ALTER TABLE `detalle_orden_compras`
  ADD PRIMARY KEY (`id`),
  ADD KEY `detalle_orden_compras_orden_compra_id_index` (`orden_compra_id`);

--
-- Indices de la tabla `detalle_orden_trabajo_repuestos`
--
ALTER TABLE `detalle_orden_trabajo_repuestos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `detalle_orden_trabajo_repuestos_orden_trabajo_id_foreign` (`orden_trabajo_id`),
  ADD KEY `detalle_orden_trabajo_repuestos_parte_id_foreign` (`parte_id`);

--
-- Indices de la tabla `detalle_orden_trabajo_servicios`
--
ALTER TABLE `detalle_orden_trabajo_servicios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `detalle_orden_trabajo_servicios_orden_trabajo_id_foreign` (`orden_trabajo_id`),
  ADD KEY `detalle_orden_trabajo_servicios_servicio_id_foreign` (`servicio_id`);

--
-- Indices de la tabla `detalle_vales_devolucion`
--
ALTER TABLE `detalle_vales_devolucion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `detalle_vales_devolucion_vale_devolucion_id_index` (`vale_devolucion_id`),
  ADD KEY `detalle_vales_devolucion_tipo_producto_producto_id_index` (`tipo_producto`,`producto_id`);

--
-- Indices de la tabla `devoluciones_orden_compra`
--
ALTER TABLE `devoluciones_orden_compra`
  ADD PRIMARY KEY (`id`),
  ADD KEY `devoluciones_orden_compra_detalle_id_foreign` (`detalle_orden_compra_id`),
  ADD KEY `devoluciones_orden_compra_devuelto_por_foreign` (`devuelto_por`);

--
-- Indices de la tabla `devoluciones_proveedor`
--
ALTER TABLE `devoluciones_proveedor`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `codigo` (`codigo`);

--
-- Indices de la tabla `distritos`
--
ALTER TABLE `distritos`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `fk_distritos_provincias_1` (`provincia_id`) USING BTREE;

--
-- Indices de la tabla `documentos`
--
ALTER TABLE `documentos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cotizacion_id` (`cotizacion_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indices de la tabla `documentos_placa`
--
ALTER TABLE `documentos_placa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cotizacion_id` (`cotizacion_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `placa_id` (`placa_id`);

--
-- Indices de la tabla `documentos_sunarp`
--
ALTER TABLE `documentos_sunarp`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cotizacion_id` (`cotizacion_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indices de la tabla `establecimientos`
--
ALTER TABLE `establecimientos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `estados`
--
ALTER TABLE `estados`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `estados_cotizacion`
--
ALTER TABLE `estados_cotizacion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `estado_requerimientos`
--
ALTER TABLE `estado_requerimientos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `estandar_mantenimientos`
--
ALTER TABLE `estandar_mantenimientos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `estandar_mantenimiento` (`estandar_mantenimiento`);

--
-- Indices de la tabla `fabricantes`
--
ALTER TABLE `fabricantes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `facturas_orden_trabajo`
--
ALTER TABLE `facturas_orden_trabajo`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `facturas_orden_trabajo_numero_factura_unique` (`numero_factura`),
  ADD KEY `facturas_orden_trabajo_orden_trabajo_id_foreign` (`orden_trabajo_id`);

--
-- Indices de la tabla `factura_orden_trabajos`
--
ALTER TABLE `factura_orden_trabajos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `factura_orden_trabajos_numero_factura_unique` (`numero_factura`),
  ADD KEY `factura_orden_trabajos_orden_trabajo_id_foreign` (`orden_trabajo_id`);

--
-- Indices de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indices de la tabla `guias_entrega`
--
ALTER TABLE `guias_entrega`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `guias_entrega_numero_unique` (`numero`),
  ADD KEY `guias_entrega_numero_index` (`numero`),
  ADD KEY `guias_entrega_fecha_index` (`fecha`),
  ADD KEY `guias_entrega_estado_index` (`estado`),
  ADD KEY `guias_entrega_proveedor_id_fecha_index` (`proveedor_id`,`fecha`);

--
-- Indices de la tabla `historial_cotizaciones`
--
ALTER TABLE `historial_cotizaciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cotizacion_id` (`cotizacion_id`),
  ADD KEY `estado_anterior_id` (`estado_anterior_id`),
  ADD KEY `estado_nuevo_id` (`estado_nuevo_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indices de la tabla `historial_requerimiento_compras`
--
ALTER TABLE `historial_requerimiento_compras`
  ADD PRIMARY KEY (`id`),
  ADD KEY `historial_req_compra_id_foreign` (`requerimiento_compra_id`),
  ADD KEY `historial_user_id_foreign` (`user_id`),
  ADD KEY `historial_estado_id_foreign` (`estado_id`);

--
-- Indices de la tabla `intervalo_plan_mantenimientos`
--
ALTER TABLE `intervalo_plan_mantenimientos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `int_plan_comp_km_unique` (`componente_plan_id`,`kilometraje`),
  ADD KEY `int_plan_plan_km_idx` (`plan_mantenimiento_id`,`kilometraje`);

--
-- Indices de la tabla `inventarios`
--
ALTER TABLE `inventarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `inventarios_parte_almacen_cc_unique` (`parte_id`,`almacen_id`,`centro_costo_id`),
  ADD UNIQUE KEY `inventario_unique_idx` (`parte_id`,`almacen_id`,`centro_costo_id`),
  ADD KEY `almacen_id` (`almacen_id`),
  ADD KEY `inventarios_vehiculo_id_foreign` (`vehiculo_id`);

--
-- Indices de la tabla `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indices de la tabla `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `kardex`
--
ALTER TABLE `kardex`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kardex_parte_id_foreign` (`parte_id`),
  ADD KEY `kardex_vehiculo_id_foreign` (`vehiculo_id`),
  ADD KEY `kardex_almacen_id_foreign` (`almacen_id`),
  ADD KEY `kardex_usuario_id_foreign` (`usuario_id`),
  ADD KEY `kardex_fecha_movimiento_index` (`fecha_movimiento`),
  ADD KEY `kardex_tipo_movimiento_index` (`tipo_movimiento`);

--
-- Indices de la tabla `marcas`
--
ALTER TABLE `marcas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `modelos`
--
ALTER TABLE `modelos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `marca_id` (`marca_id`);

--
-- Indices de la tabla `movimientos`
--
ALTER TABLE `movimientos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tipo_movimiento_id` (`tipo_movimiento_id`),
  ADD KEY `parte_id` (`parte_id`),
  ADD KEY `almacen_id` (`almacen_id`),
  ADD KEY `movimientos_centro_costo_id_foreign` (`centro_costo_id`);

--
-- Indices de la tabla `notas_pedido`
--
ALTER TABLE `notas_pedido`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `codigo` (`codigo`),
  ADD KEY `cotizacion_id` (`cotizacion_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indices de la tabla `nota_pedido_items`
--
ALTER TABLE `nota_pedido_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nota_pedido_id` (`nota_pedido_id`);

--
-- Indices de la tabla `oportunidades`
--
ALTER TABLE `oportunidades`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oportunidades_cliente_id_foreign` (`cliente_id`),
  ADD KEY `oportunidades_user_id_foreign` (`user_id`);

--
-- Indices de la tabla `ordenes_trabajo_mantenimiento`
--
ALTER TABLE `ordenes_trabajo_mantenimiento`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_codigo_orden` (`codigo_orden`),
  ADD KEY `idx_vehiculo_id` (`vehiculo_id`),
  ADD KEY `idx_cliente_id` (`cliente_id`),
  ADD KEY `idx_cita_id` (`cita_id`),
  ADD KEY `idx_tecnico_asignado_id` (`tecnico_asignado_id`);

--
-- Indices de la tabla `orden_compras`
--
ALTER TABLE `orden_compras`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `orden_compras_codigo_unique` (`codigo`);

--
-- Indices de la tabla `orden_trabajos`
--
ALTER TABLE `orden_trabajos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_orden_cotizacion` (`cotizacion_id`),
  ADD KEY `orden_trabajos_user_id_foreign` (`user_id`),
  ADD KEY `fk_orden_trabajos_vehiculo` (`vehiculo_id`);

--
-- Indices de la tabla `orden_trabajo_historial`
--
ALTER TABLE `orden_trabajo_historial`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_historial_orden` (`orden_trabajo_id`),
  ADD KEY `fk_historial_usuario` (`usuario_id`);

--
-- Indices de la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cotizacion_id` (`cotizacion_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indices de la tabla `pagos_ventas`
--
ALTER TABLE `pagos_ventas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pagos_ventas_numero_pago_unique` (`numero_pago`),
  ADD KEY `pagos_ventas_usuario_id_foreign` (`usuario_id`),
  ADD KEY `pagos_ventas_validado_por_foreign` (`validado_por`),
  ADD KEY `pagos_ventas_venta_id_fecha_pago_index` (`venta_id`,`fecha_pago`),
  ADD KEY `pagos_ventas_numero_pago_index` (`numero_pago`),
  ADD KEY `pagos_ventas_metodo_pago_index` (`metodo_pago`);

--
-- Indices de la tabla `partes`
--
ALTER TABLE `partes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `codigo` (`codigo`),
  ADD KEY `unidad_id` (`unidad_id`),
  ADD KEY `fabricante_id` (`fabricante_id`),
  ADD KEY `categoria_parte_id` (`categoria_parte_id`),
  ADD KEY `idx_proveedor_id` (`proveedor_id`);

--
-- Indices de la tabla `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indices de la tabla `placas`
--
ALTER TABLE `placas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cotizacion_id` (`cotizacion_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indices de la tabla `placa_comentarios`
--
ALTER TABLE `placa_comentarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `placa_id` (`placa_id`),
  ADD KEY `cotizacion_id` (`cotizacion_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indices de la tabla `plan_mantenimientos`
--
ALTER TABLE `plan_mantenimientos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `plan_mantenimientos_user_id_foreign` (`user_id`),
  ADD KEY `plan_mantenimientos_modelo_vehiculo_ano_modelo_index` (`modelo_vehiculo`,`ano_modelo`),
  ADD KEY `plan_mantenimientos_activo_index` (`activo`);

--
-- Indices de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `numero_documento` (`numero_documento`),
  ADD KEY `categoria_proveedor_id` (`categoria_proveedor_id`);

--
-- Indices de la tabla `provincias`
--
ALTER TABLE `provincias`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `fk_provincias_departamentos_1` (`departamento_id`) USING BTREE;

--
-- Indices de la tabla `recepciones_orden_compra`
--
ALTER TABLE `recepciones_orden_compra`
  ADD PRIMARY KEY (`id`),
  ADD KEY `recepciones_orden_compra_detalle_orden_compra_id_foreign` (`detalle_orden_compra_id`),
  ADD KEY `recepciones_orden_compra_recibido_por_foreign` (`recibido_por`);

--
-- Indices de la tabla `reglas_vencimiento_cotizaciones`
--
ALTER TABLE `reglas_vencimiento_cotizaciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reglas_vencimiento_cotizaciones_estado_vencido_id_foreign` (`estado_vencido_id`);

--
-- Indices de la tabla `requerimientos_compra`
--
ALTER TABLE `requerimientos_compra`
  ADD PRIMARY KEY (`id`),
  ADD KEY `almacen_id` (`almacen_id`),
  ADD KEY `idx_reqcomp_estado` (`estado_id`),
  ADD KEY `idx_reqcomp_user` (`user_id`),
  ADD KEY `idx_reqcomp_cotizacion` (`cotizacion_id`),
  ADD KEY `idx_requerimientos_venta` (`venta_id`),
  ADD KEY `fk_requerimientos_compra_proveedor` (`proveedor_id`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_unique` (`name`);

--
-- Indices de la tabla `role_user`
--
ALTER TABLE `role_user`
  ADD PRIMARY KEY (`user_id`,`role_id`),
  ADD KEY `role_user_role_id_foreign` (`role_id`);

--
-- Indices de la tabla `seguimientos_cotizacion`
--
ALTER TABLE `seguimientos_cotizacion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cotizacion_id` (`cotizacion_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indices de la tabla `seguimientos_oportunidades`
--
ALTER TABLE `seguimientos_oportunidades`
  ADD PRIMARY KEY (`id`),
  ADD KEY `seguimientos_oportunidades_oportunidad_id_foreign` (`oportunidad_id`),
  ADD KEY `seguimientos_oportunidades_user_id_foreign` (`user_id`);

--
-- Indices de la tabla `seguimientos_orden_trabajo`
--
ALTER TABLE `seguimientos_orden_trabajo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `seguimientos_orden_trabajo_orden_trabajo_id_foreign` (`orden_trabajo_id`),
  ADD KEY `seguimientos_orden_trabajo_user_id_foreign` (`user_id`);

--
-- Indices de la tabla `servicios`
--
ALTER TABLE `servicios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`),
  ADD KEY `fk_categoria_servicio` (`categoria_id`);

--
-- Indices de la tabla `servicios_cita`
--
ALTER TABLE `servicios_cita`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_servicios_cita_cita_id` (`cita_id`);

--
-- Indices de la tabla `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indices de la tabla `talleres`
--
ALTER TABLE `talleres`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `telefonos`
--
ALTER TABLE `telefonos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cliente_id` (`cliente_id`);

--
-- Indices de la tabla `tipos_cambio`
--
ALTER TABLE `tipos_cambio`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_fecha_activa` (`fecha`,`activo`),
  ADD KEY `tipos_cambio_fecha_activo_index` (`fecha`,`activo`),
  ADD KEY `tipos_cambio_fecha_inicio_fecha_fin_index` (`fecha_inicio`,`fecha_fin`),
  ADD KEY `tipos_cambio_user_id_foreign` (`user_id`);

--
-- Indices de la tabla `tipos_movimiento`
--
ALTER TABLE `tipos_movimiento`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `traslados`
--
ALTER TABLE `traslados`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `traslado_items`
--
ALTER TABLE `traslado_items`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `unidades`
--
ALTER TABLE `unidades`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indices de la tabla `vales_devolucion`
--
ALTER TABLE `vales_devolucion`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `vales_devolucion_numero_unique` (`numero`),
  ADD KEY `vales_devolucion_numero_index` (`numero`),
  ADD KEY `vales_devolucion_fecha_index` (`fecha`),
  ADD KEY `vales_devolucion_estado_index` (`estado`);

--
-- Indices de la tabla `vehiculos`
--
ALTER TABLE `vehiculos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nro_placa` (`nro_placa`),
  ADD UNIQUE KEY `serie_vim` (`serie_vim`),
  ADD KEY `marca_id` (`marca_id`),
  ADD KEY `modelo_id` (`modelo_id`),
  ADD KEY `combustible_id` (`combustible_id`),
  ADD KEY `vehiculos_cliente_id_foreign` (`cliente_id`);

--
-- Indices de la tabla `vehiculos_mantenimiento`
--
ALTER TABLE `vehiculos_mantenimiento`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_marca_id` (`marca_id`),
  ADD KEY `idx_modelo_id` (`modelo_id`),
  ADD KEY `idx_cliente_id` (`cliente_id`),
  ADD KEY `vehiculo_id` (`vehiculo_id`),
  ADD KEY `combustible_id` (`combustible_id`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_codigo_venta` (`codigo`),
  ADD KEY `idx_ventas_cliente` (`cliente_id`),
  ADD KEY `idx_ventas_usuario` (`usuario_id`),
  ADD KEY `idx_ventas_almacen` (`almacen_id`),
  ADD KEY `idx_ventas_cotizacion` (`cotizacion_id`);

--
-- Indices de la tabla `versiones`
--
ALTER TABLE `versiones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `marca_id` (`marca_id`),
  ADD KEY `modelo_id` (`modelo_id`),
  ADD KEY `combustible_id` (`combustible_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `actas_entrega`
--
ALTER TABLE `actas_entrega`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `adelantos`
--
ALTER TABLE `adelantos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `almacenes`
--
ALTER TABLE `almacenes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `almacen_items`
--
ALTER TABLE `almacen_items`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `anios_modelo`
--
ALTER TABLE `anios_modelo`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `bancos`
--
ALTER TABLE `bancos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `canal_captacion`
--
ALTER TABLE `canal_captacion`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `cargos`
--
ALTER TABLE `cargos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `catalogos`
--
ALTER TABLE `catalogos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `categorias_partes`
--
ALTER TABLE `categorias_partes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `categorias_proveedor`
--
ALTER TABLE `categorias_proveedor`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `categorias_servicios_tercerizados`
--
ALTER TABLE `categorias_servicios_tercerizados`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `categoria_clientes`
--
ALTER TABLE `categoria_clientes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `centros_costos`
--
ALTER TABLE `centros_costos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `citas_mantenimiento`
--
ALTER TABLE `citas_mantenimiento`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `colores`
--
ALTER TABLE `colores`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `combustibles`
--
ALTER TABLE `combustibles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `comentarios_seguimiento`
--
ALTER TABLE `comentarios_seguimiento`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `comentarios_seguimiento_orden`
--
ALTER TABLE `comentarios_seguimiento_orden`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `componente_plan_mantenimientos`
--
ALTER TABLE `componente_plan_mantenimientos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `comprobantes`
--
ALTER TABLE `comprobantes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `contactos_proveedores`
--
ALTER TABLE `contactos_proveedores`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `correos_proveedores`
--
ALTER TABLE `correos_proveedores`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `cotizaciones`
--
ALTER TABLE `cotizaciones`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT de la tabla `cuentas_proveedores`
--
ALTER TABLE `cuentas_proveedores`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `departamentos`
--
ALTER TABLE `departamentos`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `detalles_cotizacion`
--
ALTER TABLE `detalles_cotizacion`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `detalles_devolucion_proveedor`
--
ALTER TABLE `detalles_devolucion_proveedor`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `detalles_requerimientos_compra`
--
ALTER TABLE `detalles_requerimientos_compra`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `detalles_venta`
--
ALTER TABLE `detalles_venta`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detalles_venta_pos`
--
ALTER TABLE `detalles_venta_pos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detalle_guias_entrega`
--
ALTER TABLE `detalle_guias_entrega`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detalle_orden_compras`
--
ALTER TABLE `detalle_orden_compras`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `detalle_orden_trabajo_repuestos`
--
ALTER TABLE `detalle_orden_trabajo_repuestos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `detalle_orden_trabajo_servicios`
--
ALTER TABLE `detalle_orden_trabajo_servicios`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `detalle_vales_devolucion`
--
ALTER TABLE `detalle_vales_devolucion`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `devoluciones_orden_compra`
--
ALTER TABLE `devoluciones_orden_compra`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `devoluciones_proveedor`
--
ALTER TABLE `devoluciones_proveedor`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `distritos`
--
ALTER TABLE `distritos`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1439;

--
-- AUTO_INCREMENT de la tabla `documentos`
--
ALTER TABLE `documentos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `documentos_placa`
--
ALTER TABLE `documentos_placa`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `documentos_sunarp`
--
ALTER TABLE `documentos_sunarp`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `establecimientos`
--
ALTER TABLE `establecimientos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `estados`
--
ALTER TABLE `estados`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `estados_cotizacion`
--
ALTER TABLE `estados_cotizacion`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `estado_requerimientos`
--
ALTER TABLE `estado_requerimientos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `estandar_mantenimientos`
--
ALTER TABLE `estandar_mantenimientos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `fabricantes`
--
ALTER TABLE `fabricantes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `facturas_orden_trabajo`
--
ALTER TABLE `facturas_orden_trabajo`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `factura_orden_trabajos`
--
ALTER TABLE `factura_orden_trabajos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `guias_entrega`
--
ALTER TABLE `guias_entrega`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `historial_cotizaciones`
--
ALTER TABLE `historial_cotizaciones`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `historial_requerimiento_compras`
--
ALTER TABLE `historial_requerimiento_compras`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `intervalo_plan_mantenimientos`
--
ALTER TABLE `intervalo_plan_mantenimientos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `inventarios`
--
ALTER TABLE `inventarios`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `kardex`
--
ALTER TABLE `kardex`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `marcas`
--
ALTER TABLE `marcas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `modelos`
--
ALTER TABLE `modelos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `movimientos`
--
ALTER TABLE `movimientos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `notas_pedido`
--
ALTER TABLE `notas_pedido`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `nota_pedido_items`
--
ALTER TABLE `nota_pedido_items`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `oportunidades`
--
ALTER TABLE `oportunidades`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ordenes_trabajo_mantenimiento`
--
ALTER TABLE `ordenes_trabajo_mantenimiento`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `orden_compras`
--
ALTER TABLE `orden_compras`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `orden_trabajos`
--
ALTER TABLE `orden_trabajos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `orden_trabajo_historial`
--
ALTER TABLE `orden_trabajo_historial`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pagos`
--
ALTER TABLE `pagos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `pagos_ventas`
--
ALTER TABLE `pagos_ventas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `partes`
--
ALTER TABLE `partes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `placas`
--
ALTER TABLE `placas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `placa_comentarios`
--
ALTER TABLE `placa_comentarios`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `plan_mantenimientos`
--
ALTER TABLE `plan_mantenimientos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `provincias`
--
ALTER TABLE `provincias`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=194;

--
-- AUTO_INCREMENT de la tabla `recepciones_orden_compra`
--
ALTER TABLE `recepciones_orden_compra`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `reglas_vencimiento_cotizaciones`
--
ALTER TABLE `reglas_vencimiento_cotizaciones`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `requerimientos_compra`
--
ALTER TABLE `requerimientos_compra`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `seguimientos_cotizacion`
--
ALTER TABLE `seguimientos_cotizacion`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `seguimientos_oportunidades`
--
ALTER TABLE `seguimientos_oportunidades`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `seguimientos_orden_trabajo`
--
ALTER TABLE `seguimientos_orden_trabajo`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `servicios`
--
ALTER TABLE `servicios`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `servicios_cita`
--
ALTER TABLE `servicios_cita`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `talleres`
--
ALTER TABLE `talleres`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `telefonos`
--
ALTER TABLE `telefonos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `tipos_cambio`
--
ALTER TABLE `tipos_cambio`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tipos_movimiento`
--
ALTER TABLE `tipos_movimiento`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `traslados`
--
ALTER TABLE `traslados`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `traslado_items`
--
ALTER TABLE `traslado_items`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `unidades`
--
ALTER TABLE `unidades`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `vales_devolucion`
--
ALTER TABLE `vales_devolucion`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `vehiculos`
--
ALTER TABLE `vehiculos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `vehiculos_mantenimiento`
--
ALTER TABLE `vehiculos_mantenimiento`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `versiones`
--
ALTER TABLE `versiones`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `actas_entrega`
--
ALTER TABLE `actas_entrega`
  ADD CONSTRAINT `actas_entrega_ibfk_1` FOREIGN KEY (`cotizacion_id`) REFERENCES `cotizaciones` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `actas_entrega_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `adelantos`
--
ALTER TABLE `adelantos`
  ADD CONSTRAINT `adelantos_ibfk_1` FOREIGN KEY (`cita_id`) REFERENCES `citas_mantenimiento` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_adelantos_cita_id` FOREIGN KEY (`cita_id`) REFERENCES `citas_mantenimiento` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `almacenes`
--
ALTER TABLE `almacenes`
  ADD CONSTRAINT `almacenes_ibfk_1` FOREIGN KEY (`centro_costo_id`) REFERENCES `centros_costos` (`id`),
  ADD CONSTRAINT `fk_almacenes_parent_id` FOREIGN KEY (`parent_id`) REFERENCES `almacenes` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `almacen_items`
--
ALTER TABLE `almacen_items`
  ADD CONSTRAINT `almacen_items_ibfk_1` FOREIGN KEY (`almacen_id`) REFERENCES `almacenes` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `anios_modelo`
--
ALTER TABLE `anios_modelo`
  ADD CONSTRAINT `anios_modelo_ibfk_1` FOREIGN KEY (`marca_id`) REFERENCES `marcas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `anios_modelo_ibfk_2` FOREIGN KEY (`modelo_id`) REFERENCES `modelos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `anios_modelo_ibfk_3` FOREIGN KEY (`version_id`) REFERENCES `versiones` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `catalogos`
--
ALTER TABLE `catalogos`
  ADD CONSTRAINT `catalogos_ibfk_1` FOREIGN KEY (`marca_id`) REFERENCES `marcas` (`id`),
  ADD CONSTRAINT `catalogos_ibfk_2` FOREIGN KEY (`modelo_id`) REFERENCES `modelos` (`id`),
  ADD CONSTRAINT `catalogos_ibfk_3` FOREIGN KEY (`version_id`) REFERENCES `versiones` (`id`),
  ADD CONSTRAINT `catalogos_ibfk_4` FOREIGN KEY (`anio_modelo_id`) REFERENCES `anios_modelo` (`id`);

--
-- Filtros para la tabla `citas_mantenimiento`
--
ALTER TABLE `citas_mantenimiento`
  ADD CONSTRAINT `citas_mantenimiento_ibfk_1` FOREIGN KEY (`vehiculo_id`) REFERENCES `vehiculos_mantenimiento` (`id`),
  ADD CONSTRAINT `citas_mantenimiento_ibfk_2` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`),
  ADD CONSTRAINT `citas_mantenimiento_ibfk_3` FOREIGN KEY (`tecnico_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD CONSTRAINT `clientes_ibfk_1` FOREIGN KEY (`categoria_cliente_id`) REFERENCES `categoria_clientes` (`id`),
  ADD CONSTRAINT `clientes_ibfk_2` FOREIGN KEY (`canal_captacion_id`) REFERENCES `canal_captacion` (`id`);

--
-- Filtros para la tabla `comentarios_seguimiento`
--
ALTER TABLE `comentarios_seguimiento`
  ADD CONSTRAINT `comentarios_seguimiento_ibfk_1` FOREIGN KEY (`seguimiento_id`) REFERENCES `seguimientos_cotizacion` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comentarios_seguimiento_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `comentarios_seguimiento_orden`
--
ALTER TABLE `comentarios_seguimiento_orden`
  ADD CONSTRAINT `comentarios_seguimiento_orden_seguimiento_id_foreign` FOREIGN KEY (`seguimiento_id`) REFERENCES `seguimientos_orden_trabajo` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comentarios_seguimiento_orden_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `componente_plan_mantenimientos`
--
ALTER TABLE `componente_plan_mantenimientos`
  ADD CONSTRAINT `componente_plan_mantenimientos_parte_id_foreign` FOREIGN KEY (`parte_id`) REFERENCES `partes` (`id`),
  ADD CONSTRAINT `componente_plan_mantenimientos_plan_mantenimiento_id_foreign` FOREIGN KEY (`plan_mantenimiento_id`) REFERENCES `plan_mantenimientos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `comprobantes`
--
ALTER TABLE `comprobantes`
  ADD CONSTRAINT `comprobantes_ibfk_1` FOREIGN KEY (`cotizacion_id`) REFERENCES `cotizaciones` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comprobantes_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `contactos_proveedores`
--
ALTER TABLE `contactos_proveedores`
  ADD CONSTRAINT `contactos_proveedores_ibfk_1` FOREIGN KEY (`proveedor_id`) REFERENCES `proveedores` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `correos_proveedores`
--
ALTER TABLE `correos_proveedores`
  ADD CONSTRAINT `correos_proveedores_ibfk_1` FOREIGN KEY (`proveedor_id`) REFERENCES `proveedores` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `cotizaciones`
--
ALTER TABLE `cotizaciones`
  ADD CONSTRAINT `cotizaciones_ibfk_1` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`),
  ADD CONSTRAINT `cotizaciones_ibfk_2` FOREIGN KEY (`almacen_id`) REFERENCES `almacenes` (`id`),
  ADD CONSTRAINT `cotizaciones_ibfk_3` FOREIGN KEY (`estado_id`) REFERENCES `estados_cotizacion` (`id`),
  ADD CONSTRAINT `cotizaciones_ibfk_4` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `cotizaciones_regla_vencimiento_id_foreign` FOREIGN KEY (`regla_vencimiento_id`) REFERENCES `reglas_vencimiento_cotizaciones` (`id`);

--
-- Filtros para la tabla `cuentas_proveedores`
--
ALTER TABLE `cuentas_proveedores`
  ADD CONSTRAINT `cuentas_proveedores_ibfk_1` FOREIGN KEY (`proveedor_id`) REFERENCES `proveedores` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cuentas_proveedores_ibfk_2` FOREIGN KEY (`banco_id`) REFERENCES `bancos` (`id`);

--
-- Filtros para la tabla `detalles_cotizacion`
--
ALTER TABLE `detalles_cotizacion`
  ADD CONSTRAINT `detalles_cotizacion_ibfk_1` FOREIGN KEY (`cotizacion_id`) REFERENCES `cotizaciones` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `detalles_cotizacion_ibfk_2` FOREIGN KEY (`vehiculo_catalogo_id`) REFERENCES `catalogos` (`id`),
  ADD CONSTRAINT `detalles_cotizacion_ibfk_3` FOREIGN KEY (`color_id`) REFERENCES `colores` (`id`),
  ADD CONSTRAINT `detalles_cotizacion_vehiculo_id_foreign` FOREIGN KEY (`vehiculo_id`) REFERENCES `vehiculos_mantenimiento` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_detalles_cotizacion_repuesto` FOREIGN KEY (`repuesto_id`) REFERENCES `partes` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_detalles_cotizacion_servicio` FOREIGN KEY (`servicio_id`) REFERENCES `servicios` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `detalles_requerimientos_compra`
--
ALTER TABLE `detalles_requerimientos_compra`
  ADD CONSTRAINT `detalles_requerimientos_compra_color_id_foreign` FOREIGN KEY (`color_id`) REFERENCES `colores` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `detalles_requerimientos_compra_cotizacion_detalle_id_foreign` FOREIGN KEY (`cotizacion_detalle_id`) REFERENCES `detalles_cotizacion` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `detalles_requerimientos_compra_ibfk_1` FOREIGN KEY (`requerimiento_compra_id`) REFERENCES `requerimientos_compra` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_detalles_requerimientos_color` FOREIGN KEY (`color_id`) REFERENCES `colores` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_detalles_requerimientos_cotizacion_detalle` FOREIGN KEY (`cotizacion_detalle_id`) REFERENCES `detalles_cotizacion` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `detalles_venta`
--
ALTER TABLE `detalles_venta`
  ADD CONSTRAINT `detalles_venta_ibfk_1` FOREIGN KEY (`venta_id`) REFERENCES `ventas` (`id`),
  ADD CONSTRAINT `detalles_venta_ibfk_2` FOREIGN KEY (`parte_id`) REFERENCES `partes` (`id`),
  ADD CONSTRAINT `detalles_venta_ibfk_3` FOREIGN KEY (`servicio_id`) REFERENCES `servicios` (`id`);

--
-- Filtros para la tabla `detalles_venta_pos`
--
ALTER TABLE `detalles_venta_pos`
  ADD CONSTRAINT `fk_detalles_almacen` FOREIGN KEY (`almacen_id`) REFERENCES `almacenes` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_detalles_usuario` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_parte` FOREIGN KEY (`parte_id`) REFERENCES `partes` (`id`),
  ADD CONSTRAINT `fk_venta` FOREIGN KEY (`venta_id`) REFERENCES `ventas` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `detalle_guias_entrega`
--
ALTER TABLE `detalle_guias_entrega`
  ADD CONSTRAINT `detalle_guias_entrega_guia_entrega_id_foreign` FOREIGN KEY (`guia_entrega_id`) REFERENCES `guias_entrega` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `detalle_orden_trabajo_repuestos`
--
ALTER TABLE `detalle_orden_trabajo_repuestos`
  ADD CONSTRAINT `detalle_orden_trabajo_repuestos_orden_trabajo_id_foreign` FOREIGN KEY (`orden_trabajo_id`) REFERENCES `ordenes_trabajo_mantenimiento` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `detalle_orden_trabajo_repuestos_parte_id_foreign` FOREIGN KEY (`parte_id`) REFERENCES `partes` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `detalle_orden_trabajo_servicios`
--
ALTER TABLE `detalle_orden_trabajo_servicios`
  ADD CONSTRAINT `detalle_orden_trabajo_servicios_orden_trabajo_id_foreign` FOREIGN KEY (`orden_trabajo_id`) REFERENCES `ordenes_trabajo_mantenimiento` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `detalle_orden_trabajo_servicios_servicio_id_foreign` FOREIGN KEY (`servicio_id`) REFERENCES `servicios` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `detalle_vales_devolucion`
--
ALTER TABLE `detalle_vales_devolucion`
  ADD CONSTRAINT `detalle_vales_devolucion_vale_devolucion_id_foreign` FOREIGN KEY (`vale_devolucion_id`) REFERENCES `vales_devolucion` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `devoluciones_orden_compra`
--
ALTER TABLE `devoluciones_orden_compra`
  ADD CONSTRAINT `devoluciones_orden_compra_detalle_id_foreign` FOREIGN KEY (`detalle_orden_compra_id`) REFERENCES `detalle_orden_compras` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `devoluciones_orden_compra_devuelto_por_foreign` FOREIGN KEY (`devuelto_por`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `distritos`
--
ALTER TABLE `distritos`
  ADD CONSTRAINT `fk_distritos_provincias_1` FOREIGN KEY (`provincia_id`) REFERENCES `provincias` (`id`);

--
-- Filtros para la tabla `documentos`
--
ALTER TABLE `documentos`
  ADD CONSTRAINT `documentos_ibfk_1` FOREIGN KEY (`cotizacion_id`) REFERENCES `cotizaciones` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `documentos_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `documentos_placa`
--
ALTER TABLE `documentos_placa`
  ADD CONSTRAINT `documentos_placa_ibfk_1` FOREIGN KEY (`cotizacion_id`) REFERENCES `cotizaciones` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `documentos_placa_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `documentos_placa_ibfk_3` FOREIGN KEY (`placa_id`) REFERENCES `placas` (`id`);

--
-- Filtros para la tabla `documentos_sunarp`
--
ALTER TABLE `documentos_sunarp`
  ADD CONSTRAINT `documentos_sunarp_ibfk_1` FOREIGN KEY (`cotizacion_id`) REFERENCES `cotizaciones` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `documentos_sunarp_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `facturas_orden_trabajo`
--
ALTER TABLE `facturas_orden_trabajo`
  ADD CONSTRAINT `facturas_orden_trabajo_orden_trabajo_id_foreign` FOREIGN KEY (`orden_trabajo_id`) REFERENCES `ordenes_trabajo_mantenimiento` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `factura_orden_trabajos`
--
ALTER TABLE `factura_orden_trabajos`
  ADD CONSTRAINT `factura_orden_trabajos_orden_trabajo_id_foreign` FOREIGN KEY (`orden_trabajo_id`) REFERENCES `ordenes_trabajo_mantenimiento` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `intervalo_plan_mantenimientos`
--
ALTER TABLE `intervalo_plan_mantenimientos`
  ADD CONSTRAINT `intervalo_plan_mantenimientos_componente_plan_id_foreign` FOREIGN KEY (`componente_plan_id`) REFERENCES `componente_plan_mantenimientos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `intervalo_plan_mantenimientos_plan_mantenimiento_id_foreign` FOREIGN KEY (`plan_mantenimiento_id`) REFERENCES `plan_mantenimientos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `pagos_ventas`
--
ALTER TABLE `pagos_ventas`
  ADD CONSTRAINT `pagos_ventas_usuario_id_foreign` FOREIGN KEY (`usuario_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pagos_ventas_validado_por_foreign` FOREIGN KEY (`validado_por`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `pagos_ventas_venta_id_foreign` FOREIGN KEY (`venta_id`) REFERENCES `ventas` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `plan_mantenimientos`
--
ALTER TABLE `plan_mantenimientos`
  ADD CONSTRAINT `plan_mantenimientos_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `reglas_vencimiento_cotizaciones`
--
ALTER TABLE `reglas_vencimiento_cotizaciones`
  ADD CONSTRAINT `reglas_vencimiento_cotizaciones_estado_vencido_id_foreign` FOREIGN KEY (`estado_vencido_id`) REFERENCES `estados_cotizacion` (`id`);

--
-- Filtros para la tabla `tipos_cambio`
--
ALTER TABLE `tipos_cambio`
  ADD CONSTRAINT `tipos_cambio_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
