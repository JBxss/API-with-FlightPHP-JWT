-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 04-08-2023 a las 06:57:33
-- Versión del servidor: 10.4.27-MariaDB
-- Versión de PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `api`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_contactos`
--

CREATE TABLE `tbl_contactos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `primerapellido` varchar(255) NOT NULL,
  `segundoapellido` varchar(255) NOT NULL,
  `correo` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_contactos`
--

INSERT INTO `tbl_contactos` (`id`, `nombre`, `primerapellido`, `segundoapellido`, `correo`, `created_at`, `updated_at`) VALUES
(15, 'david', 'makinox', 'bosssa', 'makinox@gimail', '2023-08-01 20:54:21', '2023-08-02 03:54:21'),
(16, 'Jose', 'BOT', 'Alv', 'sebjuan@gmail.com', '2023-08-01 19:17:08', '2023-08-01 19:17:08'),
(17, 'holaaaa', 'holii', 'uwuuu', 'hola@xd.com', '2023-08-02 03:20:49', '2023-08-02 03:20:49'),
(18, 'inuJAJA', 'ORM', 'uwuuu', 'hola@xd.com', '2023-08-02 03:21:43', '2023-08-02 03:21:43');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_usuarios`
--

CREATE TABLE `tbl_usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `correo` varchar(255) NOT NULL,
  `contraseña` varchar(255) NOT NULL,
  `telefono` varchar(255) NOT NULL,
  `rol_id` int(11) NOT NULL DEFAULT 2,
  `status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_usuarios`
--

INSERT INTO `tbl_usuarios` (`id`, `nombre`, `correo`, `contraseña`, `telefono`, `rol_id`, `status`) VALUES
(1, 'AAAAAAAA', 'pr@OOOOOO.com', 'HOLA', '3222222', 1, 1),
(2, 'David Bossa', 'makinox@gmail.com', 'hola123', '30223948', 1, 1),
(7, 'test', 'test', 'test', '1234', 2, 0),
(8, 'AAAAAAAA', 'pr@OOOOOO.com', 'HOLA', '3222222', 2, 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tbl_contactos`
--
ALTER TABLE `tbl_contactos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tbl_usuarios`
--
ALTER TABLE `tbl_usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tbl_contactos`
--
ALTER TABLE `tbl_contactos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `tbl_usuarios`
--
ALTER TABLE `tbl_usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
