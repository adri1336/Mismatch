-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:8889
-- Tiempo de generación: 03-12-2019 a las 11:05:58
-- Versión del servidor: 5.7.26
-- Versión de PHP: 7.3.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de datos: `mismatch`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(1, 'Apariencia'),
(2, 'Entretenimiento'),
(3, 'Comida'),
(4, 'Gente'),
(5, 'Actividades');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `response`
--

CREATE TABLE `response` (
  `id` int(11) NOT NULL,
  `response` tinyint(4) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_topic` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `response`
--

INSERT INTO `response` (`id`, `response`, `id_user`, `id_topic`) VALUES
(107, 1, 2, 1),
(108, 0, 2, 2),
(109, 0, 1, 1),
(110, 1, 1, 2),
(113, 0, 4, 1),
(114, 1, 4, 7),
(115, 1, 4, 8);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `session`
--

CREATE TABLE `session` (
  `id` int(11) NOT NULL,
  `token` varchar(32) NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `session`
--

INSERT INTO `session` (`id`, `token`, `date`, `id_user`) VALUES
(18, 'JGFSHoeyVxpfPBlCOcquznrdiDtwEbWj', '2019-11-28 22:19:46', 4),
(20, 'WYRFyOmghkMNXIUxlfEwbquaojSPAcVT', '2019-11-28 22:22:59', 5),
(21, 'ncQJaELvFIlBHUWyDXYqAzsuogCiSVwk', '2019-11-28 22:25:31', 6),
(23, 'HzYbuAWyGVJftldCXOxMoqPmBspQNKFe', '2019-12-03 12:01:31', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `topic`
--

CREATE TABLE `topic` (
  `id` int(11) NOT NULL,
  `name` varchar(48) NOT NULL,
  `id_category` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `topic`
--

INSERT INTO `topic` (`id`, `name`, `id_category`) VALUES
(1, 'Tatuajes', 1),
(2, 'Cadenas de oro', 1),
(3, 'Piercings', 1),
(4, 'Botas de vaquero', 1),
(5, 'Pelo largo', 1),
(6, 'Telerrealidad', 2),
(7, 'Lucha libre profesional', 2),
(8, 'Peliculas de terror', 2),
(9, 'Escuchar musica', 2),
(10, 'La opera', 2),
(11, 'Sushi', 3),
(12, 'Spam', 3),
(13, 'Comida picante', 3),
(14, 'Sandwich de platano y crema de cacahuete', 3),
(15, 'Martinis', 3),
(16, 'Howard Stern', 4),
(17, 'Bill Gates', 4),
(18, 'Barbara Streisand', 4),
(19, 'Hugh Hefner', 4),
(20, 'Martha Stewart', 4),
(21, 'Yoga', 5),
(22, 'Halterofilia', 5),
(23, 'Puzles', 5),
(24, 'Karaoke', 5),
(25, 'Viajar', 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(25) NOT NULL,
  `passwd` varchar(255) NOT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT '0',
  `firstname` varchar(20) NOT NULL,
  `lastname` varchar(20) NOT NULL,
  `gender` tinyint(1) DEFAULT NULL,
  `birthdate` datetime DEFAULT NULL,
  `city` varchar(20) DEFAULT NULL,
  `state` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`id`, `email`, `passwd`, `admin`, `firstname`, `lastname`, `gender`, `birthdate`, `city`, `state`) VALUES
(1, 'idiid@elle.es', '2891baceeef1652ee698294da0e71ba78a2a4064', 0, 'Firstname', 'Lastname', NULL, NULL, NULL, NULL),
(2, 'adri1pawn@gmail.com', '2891baceeef1652ee698294da0e71ba78a2a4064', 0, 'Adrián', 'Ortega Rodríguez', 0, '1998-03-29 00:00:00', 'Motril', 'Granada'),
(3, 'wintronix93@gmail.com', '2891baceeef1652ee698294da0e71ba78a2a4064', 0, 'Adrián', 'Ortega Rodríguez', 0, NULL, NULL, NULL),
(4, 'peter@gmail.com', '4b8373d016f277527198385ba72fda0feb5da015', 0, 'Peter', 'Parker', 0, '2019-11-13 00:00:00', 'City of Vice', 'Vice City'),
(5, 'cuervo@gmail.com', 'a0b1f5fd97af1ab919f8e0f5442304b5aca8f83e', 0, 'Cuervo', 'Antonio', 0, NULL, NULL, NULL),
(6, 'demonio@gmail.com', '4523c6bfc1e3a5b396e8f45238509c59bdc0de0a', 0, 'Demonio', 'no tiene', 0, NULL, NULL, NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `response`
--
ALTER TABLE `response`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_topic` (`id_topic`);

--
-- Indices de la tabla `session`
--
ALTER TABLE `session`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`);

--
-- Indices de la tabla `topic`
--
ALTER TABLE `topic`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_category` (`id_category`);

--
-- Indices de la tabla `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `response`
--
ALTER TABLE `response`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=116;

--
-- AUTO_INCREMENT de la tabla `session`
--
ALTER TABLE `session`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `topic`
--
ALTER TABLE `topic`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `response`
--
ALTER TABLE `response`
  ADD CONSTRAINT `response_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `response_ibfk_2` FOREIGN KEY (`id_topic`) REFERENCES `topic` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `session`
--
ALTER TABLE `session`
  ADD CONSTRAINT `session_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `topic`
--
ALTER TABLE `topic`
  ADD CONSTRAINT `topic_ibfk_1` FOREIGN KEY (`id_category`) REFERENCES `category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
