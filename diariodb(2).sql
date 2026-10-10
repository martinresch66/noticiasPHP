-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 03-10-2023 a las 22:28:43
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `diariodb`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `noticias`
--

CREATE TABLE `noticias` (
  `id_noticia` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `titulo` text NOT NULL,
  `copete` text NOT NULL,
  `cuerpo` text NOT NULL,
  `imagen` varchar(255) NOT NULL,
  `fecha` date NOT NULL,
  `categoria` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `noticias`
--

INSERT INTO `noticias` (`id_noticia`, `id_usuario`, `titulo`, `copete`, `cuerpo`, `imagen`, `fecha`, `categoria`) VALUES
(19, 1, 'este es un titulo', 'mi copete', 'sdas sad sa dasd \r\n\r\ndas dasd asd sa d\r\n\r\n\r\n\r\nda sd sa dasd sa', '1695687973-P1200008.JPG', '2023-09-26', 'Moda'),
(20, 1, 'dsadsad', 'ddasdasd', '<p>hola</p><p><b>ddddd</b></p><p>gdfgfdg<b><br></b></p><p><br></p>', '1695688718-P1200026.JPG', '2023-09-26', 'Deportes'),
(21, 1, 'dasdas', 'dasdasd sad asd as as dsa assa dsad ads as das sadd asd asd asd as asd as dsa as dsad asd', '<p>dsa as </p><p>&nbsp;das</p><p>d </p><p>d </p><p>asd <br></p>', '1695689521-P1200023.JPG', '2023-09-26', 'Moda'),
(22, 1, 'asdas', 'ddddddddddddddddd ddddddddddddddddddddddddd ddddddddddddddd', '<p>ddddddddddddd<br></p>', '1695689538-P1200085.JPG', '2023-09-26', 'Deportes');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE `proveedores` (
  `Id` int(11) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `apellido` varchar(30) NOT NULL,
  `telefono` varchar(30) NOT NULL,
  `email` varchar(60) NOT NULL,
  `ciudad` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `proveedores`
--

INSERT INTO `proveedores` (`Id`, `nombre`, `apellido`, `telefono`, `email`, `ciudad`) VALUES
(1, '   Juan    ', '   Pérez     ', '  555-123-4567 ', '  juan.perez@example.com     ', '  Ciudad A   '),
(2, '   María   ', '   García    ', '  555-987-6543 ', '  maria.garcia@example.com   ', '  Ciudad B   '),
(3, '   Pedro   ', '   López     ', '  555-234-5678 ', '  pedro.lopez@example.com    ', '  Ciudad C   '),
(4, '  Ana      ', '   Rodríguez ', '  555-876-5432 ', '  ana.rodriguez@example.com  ', '  Ciudad D   '),
(5, '   Luis    ', '   Martínez  ', '  555-345-6789 ', '  luis.martinez@example.com  ', '  Ciudad E   '),
(6, '   Laura   ', '   Hernández ', '  555-765-4321 ', '  laura.hernandez@example.com', '  Ciudad F   '),
(7, '   Carlos  ', '   González  ', '  555-456-7890 ', '  carlos.gonzalez@example.com', '  Ciudad G   '),
(8, '   Sofia   ', '   Díaz      ', '  555-654-3210 ', '  sofia.diaz@example.com     ', '  Ciudad H   '),
(9, '   Andrés  ', '   Pérez     ', '  555-987-1234 ', '  andres.perez@example.com   ', '  Ciudad I   '),
(10, '   Julia   ', '   Smith     ', '  555-234-5678 ', '  julia.smith@example.com    ', '  Ciudad J   '),
(11, '   Diego   ', '   Johnson   ', '  555-876-5432 ', '  diego.johnson@example.com  ', '  Ciudad K   '),
(12, '   Carla   ', '   Williams  ', '  555-345-6789 ', '  carla.williams@example.com ', '  Ciudad L   '),
(13, '   Miguel  ', '   Brown     ', '  555-654-3210 ', '  miguel.brown@example.com   ', '  Ciudad M   '),
(14, '   Marta   ', '   Davis     ', '  555-987-1234 ', '  marta.davis@example.com    ', '  Ciudad N   '),
(15, '   Pablo   ', '   Martinez  ', '  555-234-5678 ', '  pablo.martinez@example.com ', '  Ciudad O   '),
(16, '   Elena   ', '   Johnson   ', '  555-876-5432 ', '  elena.johnson@example.com  ', '  Ciudad P   '),
(17, '   Sergio  ', '   Miller    ', '  555-345-6789 ', '  sergio.miller@example.com  ', '  Ciudad Q   '),
(18, '   Andrea  ', '   Taylor    ', '  555-654-3210 ', '  andrea.taylor@example.com  ', '  Ciudad R   '),
(19, '   Raúl    ', '   Anderson  ', '  555-987-1234 ', '  raul.anderson@example.com  ', '  Ciudad S   '),
(20, '   Sofía   ', '   Jackson   ', '  555-234-5678 ', '  sofia.jackson@example.com  ', '  Ciudad T   '),
(21, '   Marcelo ', '   White     ', '  555-876-5432 ', '  marcelo.white@example.com  ', '  Ciudad U   ');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `apellido` varchar(30) NOT NULL,
  `usuario` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  `tipo_usuario` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre`, `apellido`, `usuario`, `password`, `tipo_usuario`) VALUES
(1, 'Gustavo', 'Lafuente', 'guillermo', 'guE1pk/6waGK2', '');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `noticias`
--
ALTER TABLE `noticias`
  ADD PRIMARY KEY (`id_noticia`);

--
-- Indices de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`Id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `noticias`
--
ALTER TABLE `noticias`
  MODIFY `id_noticia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
