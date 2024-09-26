-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 26-09-2024 a las 18:13:52
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
-- Base de datos: `bank5`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `accounts`
--

CREATE TABLE `accounts` (
  `ID` int(11) NOT NULL,
  `IDuser` int(11) NOT NULL,
  `date` date NOT NULL,
  `total` double NOT NULL,
  `incomes` double NOT NULL,
  `expenses` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `accounts`
--

INSERT INTO `accounts` (`ID`, `IDuser`, `date`, `total`, `incomes`, `expenses`) VALUES
(1, 1, '2024-01-15', 300, 600, 200),
(2, 1, '2024-02-01', 600, 700, 300),
(3, 1, '2024-02-02', 900, 750, 350),
(4, 2, '2024-01-16', 500, 800, 250),
(5, 2, '2024-02-03', 850, 900, 400),
(6, 2, '2024-02-04', 1150, 950, 450),
(7, 3, '2024-01-17', 800, 700, 300),
(8, 3, '2024-02-05', 1200, 800, 500),
(9, 3, '2024-02-06', 1850, 850, 550),
(10, 4, '2024-01-18', 1150, 900, 350),
(11, 4, '2024-03-01', 1600, 1000, 600),
(12, 4, '2024-03-02', 2250, 1050, 650),
(13, 5, '2024-01-19', 1500, 1100, 400),
(14, 5, '2024-03-03', 2000, 1200, 700),
(15, 5, '2024-03-04', 2850, 1250, 750),
(16, 6, '2024-01-20', 2000, 1000, 1150),
(17, 6, '2024-03-05', 2550, 1100, 1500),
(18, 6, '2024-03-06', 2850, 1150, 1500),
(19, 7, '2024-04-01', 3800, 1200, 900),
(20, 7, '2024-04-02', 4850, 1250, 950),
(21, 9, '2024-04-18', 700, 900, 400),
(22, 9, '2024-04-19', 1300, 1100, 500),
(23, 9, '2024-04-20', 1900, 1500, 900),
(24, 10, '2024-04-21', 800, 1000, 500),
(25, 10, '2024-04-22', 1300, 1200, 600),
(26, 10, '2024-04-23', 1900, 1500, 700),
(27, 11, '2024-04-24', 900, 1100, 600),
(28, 11, '2024-04-25', 1500, 1300, 800),
(29, 11, '2024-04-26', 2000, 1300, 600),
(30, 13, '2024-04-24', 900, 1100, 600),
(31, 13, '2024-04-27', 1500, 1300, 800),
(32, 13, '2024-04-29', 2000, 1300, 600),
(39, 1, '2024-09-23', 1200, 400, 100),
(40, 6, '2024-09-23', 3200, 200, 750),
(41, 6, '2024-09-23', 3350, 500, 900),
(53, 1, '2024-09-23', 1400, 600, 300),
(54, 1, '2024-09-23', 1800, 700, 200),
(55, 1, '2024-09-23', 2000, 300, 0),
(56, 1, '2024-09-23', 2050, 150, 0),
(57, 1, '2024-09-23', 2100, 150, 0),
(58, 1, '2024-09-23', 2150, 150, 0),
(59, 1, '2024-09-23', 2350, 300, 0),
(60, 1, '2024-09-23', 50, 150, 0),
(61, 1, '2024-09-23', 1050, 1100, 0),
(62, 1, '2024-09-23', 1350, 400, 0),
(63, 1, '2024-09-23', 1700, 450, 0),
(64, 1, '2024-09-23', 3000, 1050, 0),
(65, 1, '2024-09-23', 3300, 700, 300),
(66, 11, '2024-09-23', 2500, 500, 0),
(67, 11, '2024-09-23', 2800, 400, 100),
(68, 11, '2024-09-23', 2800, 200, 0),
(69, 11, '2024-09-23', 2800, 200, 100),
(70, 11, '2024-09-23', 2800, 100, 0),
(71, 11, '2024-09-23', 2800, 100, 0),
(72, 11, '2024-09-23', 2800, 100, 0),
(73, 11, '2024-09-23', 3000, 100, 0),
(74, 11, '2024-09-23', 3200, 100, 0),
(75, 11, '2024-09-23', 3400, 100, 0),
(76, 11, '2024-09-23', 3600, 100, 0),
(77, 11, '2024-09-23', 3800, 100, 0),
(78, 11, '2024-09-23', 4000, 100, 0),
(79, 11, '2024-09-23', 4200, 100, 0),
(80, 11, '2024-09-23', 4400, 100, 0),
(81, 11, '2024-09-23', 4500, 100, 0),
(82, 9, '2024-09-23', 2500, 500, 0),
(83, 9, '2024-09-23', 3000, 500, 0),
(84, 9, '2024-09-23', 3500, 100, 20),
(85, 6, '2024-09-24', 2950, 100, 0),
(86, 6, '2024-09-24', 3050, 0, 100),
(87, 1, '2024-09-24', 3300, 100, 0),
(88, 2, '2024-09-24', 1650, 0, 200),
(89, 6, '2024-09-24', 2950, 200, 0),
(90, 2, '2024-09-24', 1450, 0, 100),
(91, 6, '2024-09-24', 2950, 100, 0),
(92, 6, '2024-09-24', 3050, 0, 50),
(93, 2, '2024-09-24', 1450, 50, 0),
(94, 2, '2024-09-24', 1500, 0, 100),
(95, 6, '2024-09-24', 2950, 100, 0),
(96, 6, '2024-09-24', 3050, 0, 50),
(97, 2, '2024-09-24', 1500, 50, 0),
(98, 6, '2024-09-24', 3000, 0, 1000),
(99, 2, '2024-09-24', 1500, 1000, 0),
(100, 2, '2024-09-24', 2500, 0, 500),
(101, 6, '2024-09-24', 2950, 500, 0),
(102, 5, '2024-09-24', 3350, 0, 350),
(105, 5, '2024-09-24', 4050, 700, 0),
(106, 14, '2024-09-25', 0, 100, 0),
(107, 14, '2024-09-25', 100, 300, 0),
(108, 14, '2024-09-25', 400, 0, 100),
(109, 5, '2024-09-25', 4150, 100, 0),
(110, 5, '2024-09-25', 4250, 0, 200),
(111, 14, '2024-09-25', 600, 200, 0),
(112, 14, '2024-09-25', 4000, 0, 100),
(113, 5, '2024-09-25', 4250, 100, 0),
(114, 14, '2024-09-25', 7900, 0, 2500),
(115, 5, '2024-09-25', 6650, 2500, 0),
(116, 14, '2024-09-25', 5400, 0, 4000),
(117, 5, '2024-09-25', 8150, 4000, 0),
(118, 5, '2024-09-25', 12150, 0, 2000),
(119, 14, '2024-09-25', 7400, 2000, 0),
(120, 14, '2024-09-25', 9400, 0, 1400),
(121, 5, '2024-09-25', 5550, 1400, 0),
(122, 14, '2024-09-25', 8000, 0, 1000),
(123, 5, '2024-09-25', 5150, 1000, 0),
(124, 5, '2024-09-25', 6150, 0, 150),
(125, 14, '2024-09-25', 8150, 150, 0),
(126, 14, '2024-09-25', 8300, 0, 300),
(127, 5, '2024-09-25', 4450, 300, 0),
(128, 5, '2024-09-25', 4750, 0, 250),
(129, 14, '2024-09-25', 8550, 250, 0),
(130, 14, '2024-09-25', 5750, 0, 2800),
(131, 5, '2024-09-25', 6950, 2800, 0),
(132, 14, '2024-09-25', 4800, 0, 950),
(133, 5, '2024-09-25', 5100, 950, 0),
(134, 15, '2024-09-25', 100, 100, 0),
(135, 15, '2024-09-25', -100, 0, 200),
(136, 16, '2024-09-25', 200, 200, 0),
(137, 15, '2024-09-25', 200, 100, 0),
(138, 15, '2024-09-25', 700, 500, 0),
(139, 15, '2024-09-25', 800, 100, 0),
(140, 15, '2024-09-25', 900, 100, 0),
(141, 15, '2024-09-25', 1400, 500, 0),
(142, 15, '2024-09-25', 1500, 100, 0),
(143, 15, '2024-09-25', 1900, 400, 0),
(144, 15, '2024-09-25', 2600, 700, 0),
(145, 15, '2024-09-25', 3000, 400, 0),
(146, 15, '2024-09-25', 3200, 200, 0),
(147, 15, '2024-09-25', 3000, 0, 200),
(148, 15, '2024-09-25', 2950, 150, 200),
(149, 15, '2024-09-25', 2850, 0, 100),
(150, 5, '2024-09-25', 4250, 100, 0),
(151, 14, '2024-09-25', 16800, 12000, 0),
(152, 15, '2024-09-25', 2600, 0, 250),
(153, 16, '2024-09-25', 450, 250, 0),
(154, 16, '2024-09-25', -300, 0, 500),
(155, 15, '2024-09-25', 3100, 500, 0),
(156, 9, '2024-09-25', 3700, 200, 0),
(157, 17, '2024-09-25', 200, 200, 0),
(158, 17, '2024-09-26', 350, 150, 0),
(159, 17, '2024-09-26', 400, 50, 0),
(160, 17, '2024-09-26', 600, 200, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `adminusers`
--

CREATE TABLE `adminusers` (
  `ID` int(11) NOT NULL,
  `username` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `adminusers`
--

INSERT INTO `adminusers` (`ID`, `username`) VALUES
(17, 'benito'),
(4, 'Laura'),
(16, 'cba'),
(10, 'pedro'),
(15, 'abc'),
(13, 'jon'),
(5, 'Fernando'),
(11, 'yow'),
(9, 'Alde'),
(7, 'NombreNuevo'),
(14, 'user');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sharedaccounts`
--

CREATE TABLE `sharedaccounts` (
  `IDuser` int(11) NOT NULL,
  `IDshared` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `sharedaccounts`
--

INSERT INTO `sharedaccounts` (`IDuser`, `IDshared`) VALUES
(5, 3),
(9, 1),
(9, 2),
(2, 3),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(10, 1),
(11, 1),
(13, 6),
(13, 1),
(3, 14),
(1, 3),
(1, 14),
(6, 5),
(14, 1),
(9, 11),
(15, 9),
(9, 3),
(16, 6),
(16, 1),
(16, 2),
(16, 3),
(16, 5),
(16, 7),
(17, 2),
(17, 6),
(17, 11),
(17, 10),
(17, 13),
(17, 14),
(17, 4),
(17, 15),
(17, 16),
(2, 17);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `ID` int(11) NOT NULL,
  `user` varchar(20) NOT NULL,
  `firstname` varchar(20) NOT NULL,
  `surname` varchar(40) NOT NULL,
  `passwrd` varchar(40) NOT NULL,
  `email` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`ID`, `user`, `firstname`, `surname`, `passwrd`, `email`) VALUES
(1, 'jurlezaga123', 'Julen', 'Urlezaga Pascual', 'd41d8cd98f00b204e9800998ecf8427e', 'julenurle@email.com'),
(2, 'gmendez572', 'Gaizka', 'Mendez', '34819d7beeabb9260a5c854bc85b3e44', 'gaizkamend@email.com'),
(3, 'asalazar315', 'Antonio', 'Salazar', '4ecfb11c087ef100ce20de2b67724204', 'antonio.salazar@example.com'),
(4, 'lsmith824', 'Laura', 'Smith', 'c43da384b12a12324c26db1e0f74922d', 'laura.smith@example.com'),
(5, 'fhernandez139', 'Fernando', 'Hernandez', '778306fa236c19d13ecd23510e2171e9', 'fernando.hernandez@example.com'),
(6, 'prueba', 'Nombre', 'Apellido', '827ccb0eea8a706c4c34a16891f84e7b', 'prueba@example.com'),
(7, 'nuevo_usuario', 'NombreNuevo', 'ApellidoNuevo', 'e99a18c428cb38d5f260853678922e03', 'nuevo_usuario@example.com'),
(8, 'userprueba', 'NombrePrueba', 'ApellidoPrueba', 'e99a18c428cb38d5f260853678922e03', 'userprueba@example.com'),
(9, 'aldekoa', 'Alde', 'Koa', 'cdbc21c553f7fa2001b3efeb24ac8233', 'aldekoa@example.com'),
(10, 'pedro', 'pedro', 'pedro', 'c6cc8094c2dc07b700ffcc36d64e2138', 'pedro'),
(11, 'yow', 'yow', 'yow', 'deede17791f436f92a101bc298c0f14c', 'yow@yow.yow'),
(13, 'jon', 'jon', 'jon', '7340b06c59bfc780342aeceeafc09bbc', 'jon@jon.jon'),
(14, 'user1', 'user', 'lehenengarrena', '80ec08504af83331911f5882349af59d', 'user@example.net'),
(15, 'abc', 'abc', 'abc', 'e99a18c428cb38d5f260853678922e03', 'abc@abc.abc'),
(16, 'cba', 'cba', 'cba', '3a8b104885bc60a0b3bf9633b9d9b843', 'cba@cba.cba'),
(17, 'benito', 'benito', 'camelo', 'd57ea85b1ab9b15ab6a0df0f5b41d945', 'benito@benito.benito');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `fk_user_account` (`IDuser`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `accounts`
--
ALTER TABLE `accounts`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=161;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `accounts`
--
ALTER TABLE `accounts`
  ADD CONSTRAINT `fk_user_account` FOREIGN KEY (`IDuser`) REFERENCES `users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
