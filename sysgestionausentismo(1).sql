-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 27-12-2018 a las 18:34:02
-- Versión del servidor: 10.1.37-MariaDB
-- Versión de PHP: 7.3.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `sysgestionausentismo`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administrador`
--

CREATE TABLE `administrador` (
  `IDAdmin` int(11) NOT NULL,
  `Usuario` varchar(30) NOT NULL,
  `Contrasena` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `administrador`
--

INSERT INTO `administrador` (`IDAdmin`, `Usuario`, `Contrasena`) VALUES
(1, 'DeJesus', '19b448c071141c254836bc1bfb101d5a');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aviso`
--

CREATE TABLE `aviso` (
  `IDAviso` int(11) NOT NULL,
  `HashAviso` varchar(30) COLLATE latin1_bin NOT NULL,
  `usuario_fk` int(11) NOT NULL,
  `pasantia_fk` int(11) NOT NULL,
  `Asunto` varchar(300) COLLATE latin1_bin NOT NULL,
  `FechaEvento` date NOT NULL,
  `FechaAviso` date NOT NULL,
  `RutaArchivoCert` varchar(60) COLLATE latin1_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_bin;

--
-- Volcado de datos para la tabla `aviso`
--

INSERT INTO `aviso` (`IDAviso`, `HashAviso`, `usuario_fk`, `pasantia_fk`, `Asunto`, `FechaEvento`, `FechaAviso`, `RutaArchivoCert`) VALUES
(1, '6e9b6c0ea4a4dd92ad5eeaecbc6c48', 425738375, 4, 'Prueba', '2018-12-21', '2018-12-21', '../ArchivosCertif/Certificado-425738375-2018-12-21.jpg'),
(2, 'b9d51dda31a7a47902f4d6013fd894', 43897283, 2, 'Me quede dormido.', '2018-12-27', '2018-12-27', '../ArchivosCertif/Certificado-43897283-2018-12-27.jpg'),
(3, '40314eca7977da127459135a62f0a0', 43897283, 2, 'Me sentia mal.', '2018-12-26', '2018-12-27', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `coordinador`
--

CREATE TABLE `coordinador` (
  `DNI` int(10) NOT NULL,
  `Usuario` varchar(30) COLLATE latin1_bin NOT NULL,
  `Contrasena` varchar(50) COLLATE latin1_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_bin;

--
-- Volcado de datos para la tabla `coordinador`
--

INSERT INTO `coordinador` (`DNI`, `Usuario`, `Contrasena`) VALUES
(32145667, 'Lamar', '202cb962ac59075b964b07152d234b70'),
(43237322, 'HectorF', 'f7cb72400bd7fb19294e1f9692c48cd9');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cursos`
--

CREATE TABLE `cursos` (
  `IDCurso` int(11) NOT NULL,
  `NombreCurso` varchar(20) COLLATE latin1_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_bin;

--
-- Volcado de datos para la tabla `cursos`
--

INSERT INTO `cursos` (`IDCurso`, `NombreCurso`) VALUES
(1, 'Electronica'),
(2, 'Informatica'),
(3, 'Multimedios');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pasantias`
--

CREATE TABLE `pasantias` (
  `IDPasantia` int(11) NOT NULL,
  `NombrePasantia` varchar(30) COLLATE latin1_bin NOT NULL,
  `cursoPasantia_fk` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_bin;

--
-- Volcado de datos para la tabla `pasantias`
--

INSERT INTO `pasantias` (`IDPasantia`, `NombrePasantia`, `cursoPasantia_fk`) VALUES
(1, 'UNLAM-Soporte', 2),
(2, 'San Juan XXIII', 2),
(3, 'San Martin', 1),
(4, 'Imprenta lalala', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `DNI` int(10) NOT NULL,
  `Usuario` varchar(40) COLLATE latin1_bin NOT NULL,
  `Contrasena` varchar(50) COLLATE latin1_bin NOT NULL,
  `Token` varchar(10) COLLATE latin1_bin NOT NULL,
  `CambioMail` int(11) NOT NULL,
  `Mail` varchar(40) COLLATE latin1_bin NOT NULL,
  `Nombre` varchar(30) COLLATE latin1_bin NOT NULL,
  `Apellido` varchar(20) COLLATE latin1_bin NOT NULL,
  `curso_fk` int(11) NOT NULL,
  `pasantia_fk` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_bin;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`DNI`, `Usuario`, `Contrasena`, `Token`, `CambioMail`, `Mail`, `Nombre`, `Apellido`, `curso_fk`, `pasantia_fk`) VALUES
(42789123, 'Melillo', 'f688ae26e9cfa3ba6235477831d5122e', 'GicJqhzo3', 1, 'Mail2@localhost', 'Franco', 'Melillo', 2, 2),
(43897283, 'JuanPerez', '92eaf3719159c372f3d50337e0a14f57', '!1P*WCo3Ne', 0, 'Mail@gmail.com', 'Juan', 'Perez', 2, 2),
(425738375, 'Orona', 'd2104a400c7f629a197f33bb33fe80c0', 'VxF!gPYafO', 1, 'agustinquiroga1706@gmail.com', 'Facundo', 'Orona', 3, 4);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `administrador`
--
ALTER TABLE `administrador`
  ADD PRIMARY KEY (`IDAdmin`);

--
-- Indices de la tabla `aviso`
--
ALTER TABLE `aviso`
  ADD PRIMARY KEY (`IDAviso`),
  ADD UNIQUE KEY `HashAviso` (`HashAviso`),
  ADD KEY `usuario_fk` (`usuario_fk`),
  ADD KEY `pasantia_fk` (`pasantia_fk`);

--
-- Indices de la tabla `coordinador`
--
ALTER TABLE `coordinador`
  ADD PRIMARY KEY (`DNI`);

--
-- Indices de la tabla `cursos`
--
ALTER TABLE `cursos`
  ADD PRIMARY KEY (`IDCurso`);

--
-- Indices de la tabla `pasantias`
--
ALTER TABLE `pasantias`
  ADD PRIMARY KEY (`IDPasantia`),
  ADD KEY `FK_Pasantia_Curso` (`cursoPasantia_fk`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`DNI`),
  ADD KEY `curso_fk` (`curso_fk`),
  ADD KEY `pasantia_fk` (`pasantia_fk`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `administrador`
--
ALTER TABLE `administrador`
  MODIFY `IDAdmin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `aviso`
--
ALTER TABLE `aviso`
  MODIFY `IDAviso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `cursos`
--
ALTER TABLE `cursos`
  MODIFY `IDCurso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `pasantias`
--
ALTER TABLE `pasantias`
  MODIFY `IDPasantia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `aviso`
--
ALTER TABLE `aviso`
  ADD CONSTRAINT `FK_Aviso_Pasantia` FOREIGN KEY (`pasantia_fk`) REFERENCES `pasantias` (`IDPasantia`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_Aviso_Usuario` FOREIGN KEY (`usuario_fk`) REFERENCES `usuarios` (`DNI`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `pasantias`
--
ALTER TABLE `pasantias`
  ADD CONSTRAINT `FK_Pasantia_Curso` FOREIGN KEY (`cursoPasantia_fk`) REFERENCES `cursos` (`IDCurso`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `FK_Usuarios_Curso` FOREIGN KEY (`curso_fk`) REFERENCES `cursos` (`IDCurso`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_Usuarios_Pasantia` FOREIGN KEY (`pasantia_fk`) REFERENCES `pasantias` (`IDPasantia`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
