-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 17-02-2022 a las 14:59:46
-- Versión del servidor: 10.4.20-MariaDB
-- Versión de PHP: 8.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `examline`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tabla_alumnos`
--

CREATE TABLE `tabla_alumnos` (
  `idalumno` int(11) NOT NULL,
  `nombrealumno` varchar(50) NOT NULL,
  `contraseñaalumno` varchar(32) NOT NULL,
  `emailalumno` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tabla_alumnos`
--

INSERT INTO `tabla_alumnos` (`idalumno`, `nombrealumno`, `contraseñaalumno`, `emailalumno`) VALUES
(11, 'Martin Coronel', '78184372fefa9d88f3f20f3b8c53512', 'tincho.cool.live@gmail.com'),
(12, 'Juan Perez', '78184372fefa9d88f3f20f3b8c53512', 'juanperez@gmail.com'),
(14, 'Thiago Fantino', '2002', 'thiagofl20@hotmail.com'),
(15, 'Cristiano Ronaldo', 'Bicho7', 'ronaldo@gmail.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tabla_examenes`
--

CREATE TABLE `tabla_examenes` (
  `idexamen` int(11) NOT NULL,
  `id_profe` int(11) NOT NULL,
  `materia` text NOT NULL,
  `tema` text NOT NULL,
  `publicado_si_o_no` tinyint(1) NOT NULL,
  `fechadecreacion` datetime NOT NULL DEFAULT '1000-01-01 00:00:00',
  `duracion` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tabla_examenes`
--

INSERT INTO `tabla_examenes` (`idexamen`, `id_profe`, `materia`, `tema`, `publicado_si_o_no`, `fechadecreacion`, `duracion`) VALUES
(1, 11, 'Ciencias de la Computacion', 'Conceptos basicos', 1, '2021-11-17 11:30:00', '02:00:00'),
(2, 11, 'Algebra', 'Vectores', 0, '2022-02-09 11:20:42', '02:00:00'),
(141, 11, 'Futbol', 'Datos de Messi', 1, '2022-02-11 15:10:48', '00:01:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tabla_examenesalumnos`
--

CREATE TABLE `tabla_examenesalumnos` (
  `id` int(11) NOT NULL,
  `id_examen` int(11) NOT NULL,
  `id_alumno` int(11) NOT NULL,
  `correctas` int(11) NOT NULL,
  `incorrectas` int(11) NOT NULL,
  `notafinal` int(11) NOT NULL,
  `horadefinalizacion` time NOT NULL,
  `diaderealizacion` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tabla_examenesalumnos`
--

INSERT INTO `tabla_examenesalumnos` (`id`, `id_examen`, `id_alumno`, `correctas`, `incorrectas`, `notafinal`, `horadefinalizacion`, `diaderealizacion`) VALUES
(79, 141, 14, 1, 2, 33, '16:34:31', '2022-02-10');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tabla_preguntaexamenesalumnos`
--

CREATE TABLE `tabla_preguntaexamenesalumnos` (
  `id` int(11) NOT NULL,
  `id_examen` int(11) NOT NULL,
  `id_alumno` int(11) NOT NULL,
  `id_pregunta` int(11) NOT NULL,
  `respuesta_del_alumno` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tabla_preguntaexamenesalumnos`
--

INSERT INTO `tabla_preguntaexamenesalumnos` (`id`, `id_examen`, `id_alumno`, `id_pregunta`, `respuesta_del_alumno`) VALUES
(169, 141, 14, 127, 216),
(170, 141, 14, 129, 220),
(171, 141, 14, 187, 366);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tabla_preguntas`
--

CREATE TABLE `tabla_preguntas` (
  `idpreg` int(11) NOT NULL,
  `idexamen` int(11) NOT NULL,
  `preg` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tabla_preguntas`
--

INSERT INTO `tabla_preguntas` (`idpreg`, `idexamen`, `preg`) VALUES
(40, 1, '¿Qué es Windows?'),
(41, 1, '¿Para que sirve el icono \"Papelera de Reciclaje\"?'),
(42, 1, '¿La aplicación de Windows \"Block de Notas\" o \" Notepad\" es?'),
(43, 1, '¿Qué atajo de teclas usamos para cerrar una ventana en Windows?'),
(44, 1, '¿Cuál de los siguientes periféricos es de entrada/salida?'),
(45, 1, 'Sobre las impresoras de inyección, ¿qué afirmación es falsa?'),
(127, 141, 'Cuantos balones de oro tiene?'),
(129, 141, 'Cuantas veces fue MVP de la Copa America?'),
(187, 141, 'Cuantos titulos gano?');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tabla_profes`
--

CREATE TABLE `tabla_profes` (
  `idprofe` int(11) NOT NULL,
  `nombreprofe` varchar(50) NOT NULL,
  `contraseñaprofe` varchar(32) NOT NULL,
  `emailprofe` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tabla_profes`
--

INSERT INTO `tabla_profes` (`idprofe`, `nombreprofe`, `contraseñaprofe`, `emailprofe`) VALUES
(11, 'Thiago Fantino', '2002', 'thiagofl20@hotmail.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tabla_respuestas`
--

CREATE TABLE `tabla_respuestas` (
  `idresp` int(11) NOT NULL,
  `idpreg` int(11) NOT NULL,
  `respCorr` tinyint(1) NOT NULL DEFAULT 0,
  `resp` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tabla_respuestas`
--

INSERT INTO `tabla_respuestas` (`idresp`, `idpreg`, `respCorr`, `resp`) VALUES
(128, 40, 1, 'Un sistema operativo'),
(129, 40, 0, 'No recibido'),
(130, 40, 0, 'Un utilitario'),
(131, 40, 0, 'Un disco rigido'),
(132, 41, 0, 'Para almacenar los virus detectados por el Anti-virus.'),
(133, 41, 1, 'Para recuperar archivos borrados'),
(134, 41, 0, 'Para almacenar archivos temporales'),
(135, 41, 0, 'Para limpiar el sistema operativo.'),
(136, 42, 0, 'Un editor de textos con grandes funciones para darle formato al texto '),
(137, 42, 1, 'Un editor de textos extremadamente simple'),
(138, 42, 0, 'Un lugar de almacenamiento temporario para la transferencia de información entre aplicaciones'),
(139, 42, 0, 'Un sector de la memoria que no permite guardar en disco la información contenida'),
(140, 43, 0, 'Shift + F4 '),
(141, 43, 0, 'Crtl + F4 '),
(142, 43, 1, 'Alt + F4'),
(143, 43, 0, 'Ctrl + S'),
(144, 44, 0, 'Teclado'),
(145, 44, 0, 'Escáner '),
(146, 44, 1, 'Módem de Internet'),
(147, 44, 0, 'Impresora'),
(148, 45, 0, 'Se llaman también de chorro de tinta.'),
(149, 45, 1, 'Son impresoras de impacto.'),
(150, 45, 0, 'Al igual que en las matriciales, los caracteres están formadas por puntos.'),
(151, 45, 0, 'Pueden imprimir en blanco y negro y en color.'),
(216, 127, 0, '6'),
(217, 127, 0, '5'),
(218, 127, 0, '8'),
(220, 129, 0, 'Ninguna'),
(221, 129, 1, '2'),
(366, 187, 1, '38'),
(406, 187, 0, '36'),
(407, 127, 1, '7');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tabla_alumnos`
--
ALTER TABLE `tabla_alumnos`
  ADD PRIMARY KEY (`idalumno`);

--
-- Indices de la tabla `tabla_examenes`
--
ALTER TABLE `tabla_examenes`
  ADD PRIMARY KEY (`idexamen`),
  ADD KEY `id_profe` (`id_profe`);

--
-- Indices de la tabla `tabla_examenesalumnos`
--
ALTER TABLE `tabla_examenesalumnos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_examen` (`id_examen`),
  ADD KEY `id_alumno` (`id_alumno`);

--
-- Indices de la tabla `tabla_preguntaexamenesalumnos`
--
ALTER TABLE `tabla_preguntaexamenesalumnos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_examen` (`id_examen`),
  ADD KEY `id_alumno` (`id_alumno`),
  ADD KEY `id_pregunta` (`id_pregunta`),
  ADD KEY `respuesta_del_alumno` (`respuesta_del_alumno`);

--
-- Indices de la tabla `tabla_preguntas`
--
ALTER TABLE `tabla_preguntas`
  ADD PRIMARY KEY (`idpreg`),
  ADD KEY `FK` (`idexamen`);

--
-- Indices de la tabla `tabla_profes`
--
ALTER TABLE `tabla_profes`
  ADD PRIMARY KEY (`idprofe`);

--
-- Indices de la tabla `tabla_respuestas`
--
ALTER TABLE `tabla_respuestas`
  ADD PRIMARY KEY (`idresp`),
  ADD KEY `idpreg` (`idpreg`),
  ADD KEY `respCorr` (`respCorr`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tabla_alumnos`
--
ALTER TABLE `tabla_alumnos`
  MODIFY `idalumno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `tabla_examenes`
--
ALTER TABLE `tabla_examenes`
  MODIFY `idexamen` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=145;

--
-- AUTO_INCREMENT de la tabla `tabla_examenesalumnos`
--
ALTER TABLE `tabla_examenesalumnos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT de la tabla `tabla_preguntaexamenesalumnos`
--
ALTER TABLE `tabla_preguntaexamenesalumnos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=184;

--
-- AUTO_INCREMENT de la tabla `tabla_preguntas`
--
ALTER TABLE `tabla_preguntas`
  MODIFY `idpreg` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=192;

--
-- AUTO_INCREMENT de la tabla `tabla_profes`
--
ALTER TABLE `tabla_profes`
  MODIFY `idprofe` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `tabla_respuestas`
--
ALTER TABLE `tabla_respuestas`
  MODIFY `idresp` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=421;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `tabla_examenes`
--
ALTER TABLE `tabla_examenes`
  ADD CONSTRAINT `tabla_examenes_ibfk_1` FOREIGN KEY (`id_profe`) REFERENCES `tabla_profes` (`idprofe`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tabla_examenesalumnos`
--
ALTER TABLE `tabla_examenesalumnos`
  ADD CONSTRAINT `tabla_examenesalumnos_ibfk_1` FOREIGN KEY (`id_alumno`) REFERENCES `tabla_alumnos` (`idalumno`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tabla_examenesalumnos_ibfk_2` FOREIGN KEY (`id_examen`) REFERENCES `tabla_examenes` (`idexamen`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tabla_preguntaexamenesalumnos`
--
ALTER TABLE `tabla_preguntaexamenesalumnos`
  ADD CONSTRAINT `tabla_preguntaexamenesalumnos_ibfk_1` FOREIGN KEY (`id_examen`) REFERENCES `tabla_examenes` (`idexamen`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tabla_preguntaexamenesalumnos_ibfk_2` FOREIGN KEY (`id_alumno`) REFERENCES `tabla_alumnos` (`idalumno`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tabla_preguntaexamenesalumnos_ibfk_3` FOREIGN KEY (`id_pregunta`) REFERENCES `tabla_preguntas` (`idpreg`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tabla_preguntaexamenesalumnos_ibfk_4` FOREIGN KEY (`respuesta_del_alumno`) REFERENCES `tabla_respuestas` (`idresp`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tabla_preguntas`
--
ALTER TABLE `tabla_preguntas`
  ADD CONSTRAINT `tabla_preguntas_ibfk_1` FOREIGN KEY (`idexamen`) REFERENCES `tabla_examenes` (`idexamen`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tabla_respuestas`
--
ALTER TABLE `tabla_respuestas`
  ADD CONSTRAINT `tabla_respuestas_ibfk_2` FOREIGN KEY (`idpreg`) REFERENCES `tabla_preguntas` (`idpreg`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
