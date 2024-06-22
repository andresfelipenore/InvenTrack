-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 22-06-2024 a las 05:45:20
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
-- Base de datos: `ferreteria`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `id` int(11) NOT NULL,
  `nombre` varchar(10) NOT NULL,
  `apellido` varchar(20) NOT NULL,
  `direccion` varchar(30) NOT NULL,
  `contraseña` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `despacho`
--

CREATE TABLE `despacho` (
  `id` int(11) NOT NULL,
  `num_despacho` int(11) DEFAULT NULL,
  `nombre_cliente` varchar(100) DEFAULT NULL,
  `num_cliente` int(11) DEFAULT NULL,
  `direccion_cliente` varchar(100) DEFAULT NULL,
  `fecha_entrega` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `despacho_producto`
--

CREATE TABLE `despacho_producto` (
  `id` int(11) NOT NULL,
  `num_despacho` int(11) DEFAULT NULL,
  `id_producto` int(11) DEFAULT NULL,
  `estado` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura_producto`
--

CREATE TABLE `factura_producto` (
  `id` int(11) NOT NULL,
  `id_producto` int(11) DEFAULT NULL,
  `num_factura` int(250) DEFAULT NULL,
  `precio_venta` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura_producto_temp`
--

CREATE TABLE `factura_producto_temp` (
  `id` int(11) NOT NULL,
  `id_producto` int(11) DEFAULT NULL,
  `num_factura` int(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura_temp`
--

CREATE TABLE `factura_temp` (
  `id` int(11) NOT NULL,
  `num_factura` int(250) NOT NULL,
  `descuento` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orden`
--

CREATE TABLE `orden` (
  `id` int(11) NOT NULL,
  `num_orden` int(100) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `total_venta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `id` int(11) NOT NULL,
  `codigo` int(11) NOT NULL,
  `nombre` varchar(250) NOT NULL,
  `precio` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`id`, `codigo`, `nombre`, `precio`) VALUES
(32, 1, 'cepillo de diente', 1500);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `stock_productos`
--

CREATE TABLE `stock_productos` (
  `id` int(11) NOT NULL,
  `id_producto` int(11) DEFAULT NULL,
  `fecha_ingreso` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `stock_productos`
--

INSERT INTO `stock_productos` (`id`, `id_producto`, `fecha_ingreso`) VALUES
(3637, 32, '2024-06-21'),
(3638, 32, '2024-06-21'),
(3639, 32, '2024-06-21'),
(3640, 32, '2024-06-21'),
(3641, 32, '2024-06-21'),
(3642, 32, '2024-06-21'),
(3643, 32, '2024-06-21'),
(3644, 32, '2024-06-21'),
(3645, 32, '2024-06-21'),
(3646, 32, '2024-06-21'),
(3647, 32, '2024-06-21'),
(3648, 32, '2024-06-21'),
(3649, 32, '2024-06-21'),
(3650, 32, '2024-06-21'),
(3651, 32, '2024-06-21'),
(3652, 32, '2024-06-21'),
(3653, 32, '2024-06-21'),
(3654, 32, '2024-06-21'),
(3655, 32, '2024-06-21'),
(3656, 32, '2024-06-21'),
(3657, 32, '2024-06-21'),
(3658, 32, '2024-06-21'),
(3659, 32, '2024-06-21'),
(3660, 32, '2024-06-21'),
(3661, 32, '2024-06-21'),
(3662, 32, '2024-06-21'),
(3663, 32, '2024-06-21'),
(3664, 32, '2024-06-21'),
(3665, 32, '2024-06-21'),
(3666, 32, '2024-06-21'),
(3667, 32, '2024-06-21'),
(3668, 32, '2024-06-21'),
(3669, 32, '2024-06-21'),
(3670, 32, '2024-06-21'),
(3671, 32, '2024-06-21'),
(3672, 32, '2024-06-21'),
(3673, 32, '2024-06-21'),
(3674, 32, '2024-06-21'),
(3675, 32, '2024-06-21'),
(3676, 32, '2024-06-21'),
(3677, 32, '2024-06-21'),
(3678, 32, '2024-06-21'),
(3679, 32, '2024-06-21'),
(3680, 32, '2024-06-21'),
(3681, 32, '2024-06-21'),
(3682, 32, '2024-06-21'),
(3683, 32, '2024-06-21'),
(3684, 32, '2024-06-21'),
(3685, 32, '2024-06-21'),
(3686, 32, '2024-06-21'),
(3687, 32, '2024-06-21'),
(3688, 32, '2024-06-21'),
(3689, 32, '2024-06-21'),
(3690, 32, '2024-06-21'),
(3691, 32, '2024-06-21'),
(3692, 32, '2024-06-21'),
(3693, 32, '2024-06-21'),
(3694, 32, '2024-06-21'),
(3695, 32, '2024-06-21'),
(3696, 32, '2024-06-21'),
(3697, 32, '2024-06-21'),
(3698, 32, '2024-06-21'),
(3699, 32, '2024-06-21'),
(3700, 32, '2024-06-21'),
(3701, 32, '2024-06-21'),
(3702, 32, '2024-06-21'),
(3703, 32, '2024-06-21'),
(3704, 32, '2024-06-21'),
(3705, 32, '2024-06-21'),
(3706, 32, '2024-06-21'),
(3707, 32, '2024-06-21'),
(3708, 32, '2024-06-21'),
(3709, 32, '2024-06-21'),
(3710, 32, '2024-06-21'),
(3711, 32, '2024-06-21'),
(3712, 32, '2024-06-21'),
(3713, 32, '2024-06-21'),
(3714, 32, '2024-06-21'),
(3715, 32, '2024-06-21'),
(3716, 32, '2024-06-21'),
(3717, 32, '2024-06-21'),
(3718, 32, '2024-06-21'),
(3719, 32, '2024-06-21'),
(3720, 32, '2024-06-21'),
(3721, 32, '2024-06-21'),
(3722, 32, '2024-06-21'),
(3723, 32, '2024-06-21'),
(3724, 32, '2024-06-21'),
(3725, 32, '2024-06-21'),
(3726, 32, '2024-06-21'),
(3727, 32, '2024-06-21'),
(3728, 32, '2024-06-21'),
(3729, 32, '2024-06-21'),
(3730, 32, '2024-06-21'),
(3731, 32, '2024-06-21'),
(3732, 32, '2024-06-21'),
(3733, 32, '2024-06-21'),
(3734, 32, '2024-06-21'),
(3735, 32, '2024-06-21'),
(3736, 32, '2024-06-21');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `usuario` varchar(250) NOT NULL,
  `pass` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `usuario`, `pass`) VALUES
(6, 'david', '4dff4ea340f0a823f15d3f4f01ab62eae0e5da579ccb851f8db9dfe84c58b2b37b89903a740e1ee172da793a6e79d560e5f7f9bd058a12a280433ed6fa46510a');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `despacho`
--
ALTER TABLE `despacho`
  ADD PRIMARY KEY (`id`),
  ADD KEY `num_despacho` (`num_despacho`);

--
-- Indices de la tabla `despacho_producto`
--
ALTER TABLE `despacho_producto`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `factura_producto`
--
ALTER TABLE `factura_producto`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_id_producto` (`id_producto`),
  ADD KEY `FK_num_factura` (`num_factura`);

--
-- Indices de la tabla `factura_producto_temp`
--
ALTER TABLE `factura_producto_temp`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_producto` (`id_producto`),
  ADD KEY `num_factura` (`num_factura`);

--
-- Indices de la tabla `factura_temp`
--
ALTER TABLE `factura_temp`
  ADD PRIMARY KEY (`id`),
  ADD KEY `num_factura` (`num_factura`);

--
-- Indices de la tabla `orden`
--
ALTER TABLE `orden`
  ADD PRIMARY KEY (`id`),
  ADD KEY `num_orden` (`num_orden`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `codigo` (`codigo`),
  ADD UNIQUE KEY `nombre_2` (`nombre`);
ALTER TABLE `producto` ADD FULLTEXT KEY `nombre` (`nombre`);

--
-- Indices de la tabla `stock_productos`
--
ALTER TABLE `stock_productos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `despacho`
--
ALTER TABLE `despacho`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `despacho_producto`
--
ALTER TABLE `despacho_producto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT de la tabla `factura_producto`
--
ALTER TABLE `factura_producto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108;

--
-- AUTO_INCREMENT de la tabla `factura_producto_temp`
--
ALTER TABLE `factura_producto_temp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `factura_temp`
--
ALTER TABLE `factura_temp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `orden`
--
ALTER TABLE `orden`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de la tabla `stock_productos`
--
ALTER TABLE `stock_productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3737;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `stock_productos`
--
ALTER TABLE `stock_productos`
  ADD CONSTRAINT `stock_productos_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
