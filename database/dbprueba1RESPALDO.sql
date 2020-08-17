-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 17-08-2020 a las 06:10:17
-- Versión del servidor: 10.1.35-MariaDB
-- Versión de PHP: 7.2.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `dbprueba1`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `cli_id` int(11) NOT NULL,
  `cli_rfc` varchar(20) DEFAULT NULL,
  `cli_nombre` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`cli_id`, `cli_rfc`, `cli_nombre`) VALUES
(1, 'ROPT998800NN1', 'Temolzin Roldan'),
(2, 'MORM910201AA1', 'Monserratt Redonda'),
(3, 'GACE900103EEO', 'Emmanuel Contreras');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facturas`
--

CREATE TABLE `facturas` (
  `fac_id` int(11) NOT NULL,
  `cli_id` int(11) DEFAULT NULL,
  `mon_id` int(11) DEFAULT NULL,
  `fac_fec` date DEFAULT NULL,
  `fac_sub` decimal(9,2) DEFAULT NULL,
  `fac_iva` int(11) DEFAULT NULL,
  `fac_tot` decimal(9,2) DEFAULT NULL,
  `fac_tc` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `facturas`
--

INSERT INTO `facturas` (`fac_id`, `cli_id`, `mon_id`, `fac_fec`, `fac_sub`, `fac_iva`, `fac_tot`, `fac_tc`) VALUES
(1, 1, 1, '2020-08-16', '55.00', 55, '3025.00', '5'),
(6, 3, 2, '2020-08-16', '120.00', 16, '38400.00', '20'),
(7, 2, 2, '2020-08-17', '500.00', 16, '168000.00', '21'),
(8, 2, 2, '2019-08-10', '5200.11', 16, '832017.60', '10'),
(9, 1, 1, '2020-08-17', '7780.20', 16, '124483.20', '20');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facturas_detalle`
--

CREATE TABLE `facturas_detalle` (
  `fac_id` int(11) NOT NULL,
  `fac_det_id` int(11) NOT NULL,
  `fac_det_can` int(11) DEFAULT NULL,
  `fac_det_pun` decimal(9,2) DEFAULT NULL,
  `fac_det_imp` decimal(9,2) DEFAULT NULL,
  `fac_det_con` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `monedas`
--

CREATE TABLE `monedas` (
  `mon_id` int(11) NOT NULL,
  `mon_abr` varchar(20) DEFAULT NULL,
  `mon_nombre` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `monedas`
--

INSERT INTO `monedas` (`mon_id`, `mon_abr`, `mon_nombre`) VALUES
(1, 'MXN', 'Peso Mexicano'),
(2, 'USD', 'Dolar Americano');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`cli_id`);

--
-- Indices de la tabla `facturas`
--
ALTER TABLE `facturas`
  ADD PRIMARY KEY (`fac_id`),
  ADD KEY `cli_id` (`cli_id`),
  ADD KEY `mon_id` (`mon_id`);

--
-- Indices de la tabla `facturas_detalle`
--
ALTER TABLE `facturas_detalle`
  ADD PRIMARY KEY (`fac_id`,`fac_det_id`);

--
-- Indices de la tabla `monedas`
--
ALTER TABLE `monedas`
  ADD PRIMARY KEY (`mon_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `cli_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `facturas`
--
ALTER TABLE `facturas`
  MODIFY `fac_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `monedas`
--
ALTER TABLE `monedas`
  MODIFY `mon_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `facturas`
--
ALTER TABLE `facturas`
  ADD CONSTRAINT `facturas_ibfk_1` FOREIGN KEY (`cli_id`) REFERENCES `clientes` (`cli_id`),
  ADD CONSTRAINT `facturas_ibfk_2` FOREIGN KEY (`mon_id`) REFERENCES `monedas` (`mon_id`);

--
-- Filtros para la tabla `facturas_detalle`
--
ALTER TABLE `facturas_detalle`
  ADD CONSTRAINT `facturas_detalle_ibfk_1` FOREIGN KEY (`fac_id`) REFERENCES `facturas` (`fac_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
