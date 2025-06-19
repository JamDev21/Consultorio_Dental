-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 20-06-2025 a las 00:34:35
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
-- Base de datos: `dentista`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `actualizarPaciente` (IN `p_id_paciente` INT, IN `p_nombre` VARCHAR(255), IN `p_apellidos` VARCHAR(255), IN `p_correo` VARCHAR(255), IN `p_telefono` VARCHAR(20), IN `p_sexo` VARCHAR(10), IN `p_fecha_nacimiento` DATE, IN `p_contacto_emergencia` VARCHAR(255))   BEGIN
    UPDATE pacientes
    SET 
        nombre = p_nombre,
        apellidos = p_apellidos,
        correo = p_correo,
        telefono = p_telefono,
        sexo = p_sexo,
        fecha_nacimiento = p_fecha_nacimiento,
        contacto_emergencia = p_contacto_emergencia
    WHERE id_paciente = p_id_paciente;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `eliminarPaciente` (IN `p_id_paciente` INT)   BEGIN
    DELETE FROM pacientes WHERE id_paciente = p_id_paciente;
END$$

--
-- Funciones
--
CREATE DEFINER=`root`@`localhost` FUNCTION `actualizar_cita` (`p_id_paciente` INT, `p_fecha` DATE, `p_hora` TIME, `p_tipo_tratamiento` VARCHAR(255), `p_estado` ENUM('Pendiente','Realizada')) RETURNS TINYINT(1)  BEGIN
    DECLARE resultado INT;

    UPDATE citas
    SET 
        fecha = p_fecha,
        hora = p_hora,
        tipo_tratamiento = p_tipo_tratamiento,
        estado = p_estado
    WHERE id_paciente = p_id_paciente;

    SET resultado = ROW_COUNT();  -- Verificar cuántas filas fueron afectadas

    IF resultado > 0 THEN
        RETURN TRUE;  -- Actualización exitosa
    ELSE
        RETURN FALSE;  -- No se actualizó ninguna fila
    END IF;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `citas`
--

CREATE TABLE `citas` (
  `id_cita` int(11) NOT NULL,
  `id_paciente` int(11) DEFAULT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `tipo_tratamiento` varchar(255) NOT NULL,
  `estado` enum('Pendiente','Realizada') DEFAULT 'Pendiente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `citas`
--

INSERT INTO `citas` (`id_cita`, `id_paciente`, `fecha`, `hora`, `tipo_tratamiento`, `estado`) VALUES
(1, 8, '2024-12-05', '10:00:00', 'Consulta General', 'Pendiente'),
(2, 8, '2024-10-02', '20:30:00', 'Limpieza bucal', 'Realizada'),
(3, 8, '2024-05-05', '19:00:00', 'Consulta General', 'Realizada'),
(4, 7, '2024-12-24', '18:30:00', 'Consulta general', 'Pendiente'),
(5, 11, '2024-01-02', '18:20:00', 'Extraccion molar', 'Pendiente'),
(7, 13, '2024-12-06', '20:00:00', 'Resinas', 'Pendiente'),
(8, 14, '2024-12-31', '18:30:00', 'Consulta general', 'Pendiente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pacientes`
--

CREATE TABLE `pacientes` (
  `id_paciente` int(11) NOT NULL,
  `nombre` varchar(250) NOT NULL,
  `apellidos` varchar(250) NOT NULL,
  `correo` varchar(250) NOT NULL,
  `contraseña` varchar(250) NOT NULL,
  `telefono` varchar(10) NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `sexo` varchar(10) NOT NULL,
  `contacto_emergencia` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pacientes`
--

INSERT INTO `pacientes` (`id_paciente`, `nombre`, `apellidos`, `correo`, `contraseña`, `telefono`, `fecha_nacimiento`, `sexo`, `contacto_emergencia`) VALUES
(7, 'Rafael', 'Pacheco', 'rafael@gmail.com', '$2y$10$ngMUirkc14xULLVqxh2Vq.LIsO7zMhfWdwCJEirzkI5aOedSXecgi', '7731435570', '2004-11-08', 'Masculino', '5512678722'),
(8, 'Alan', 'Angeles Martinez ', 'alangael@gmail.com', '$2y$10$s1Sf6XCAkh1zSXqj/4aCj.KuCh8CBz/O2A8GN8yhf199qIJkNynoO', '5615045665', '2004-11-08', 'M', '5615045655'),
(11, 'Jazmin', 'Martinez Cruz', 'jazmin@gmail.com', '$2y$10$v4KPUknL99iyC/bXG9wV1OBdjMqWXZrhVmNHYOgHSifRNVjtkfvXq', '5615045665', '1994-10-08', 'Mujer', '5615045665'),
(13, 'Michel', 'Hernandez Angeles', 'michel@gmail.com', '$2y$10$r3UdAvSzX3sxjENjxANfF.e3KeiMye2YcXnpmnutqCybdYuS4q0Fe', '7297503962', '2006-05-20', 'Hombre', '5615045665'),
(14, 'MARTHA', 'GONZÀLE', 'gonz_martha@yahoo.com.mx', '$2y$10$YOdOwGwe92Q54LRhtfVyHO1uI32cjvgT6jtNSb7mo6SGnAy1U4Mei', '7751392479', '1971-08-18', 'mujer', '7731441821');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personal`
--

CREATE TABLE `personal` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `contraseña` varchar(255) NOT NULL,
  `cargo` varchar(50) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `fecha_registro` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `personal`
--

INSERT INTO `personal` (`id`, `nombre`, `apellido`, `usuario`, `contraseña`, `cargo`, `telefono`, `correo`, `fecha_registro`) VALUES
(1, 'Jonathan ', 'Angeles Martinez', 'jonathan21', '$2y$10$2sqkCFbs.s9ZwIBYJUzTzOi5KnIWDGFO2Of1s7.nkDKjSrBG0fqIa', 'Administrativo', '5615045665', 'angeles@gmail.com', '00:20:24'),
(3, 'Esthepany', 'Aguilar Sosa', 'fany', '$2y$10$WNW9UTewr0498oNcAzoryOiVrI1JMgkGCPxEiQE6xIcpuiE4uPHp6', 'doctor', '5615045665', 'estephany@gmail.com', '00:20:24'),
(4, 'Ricardo', 'Gomez Benitez ', 'richard', '$2y$10$h84.zPqnYeACFBnSm4GHsedF8O9MtCd/YNNe2IJHctL6xfUgu.b82', 'asistente', '5615045665', 'Ricardo@gmail.com', '00:20:24'),
(5, 'Rafael', 'Pacheco ', 'rafa', '$2y$10$s2c4AWmFeT7Vz6TdnpSFjuXdV5/RE1CUPouxFCUECPYcItUSMU4Sq', 'limpieza ', '5615045665', 'rafa@gmail.com', '00:20:24'),
(6, 'Ali', 'Angeles', 'ali', '$2y$10$3BFLQs.PNXMkzJYaCpM2JunGucplkxfX9Ta5JFYuWFLhFveCRDf12', 'asistente', '7297503962', 'ali@gmail.com', '00:20:24'),
(8, 'Ahide', 'Quiroz', 'ahide', '$2y$10$AdrVTE7qpBOC0g70mNsIHOIAebEVEl0qC9/GK6GdLJqlEJFjx6OpK', 'limpieza', '7297503962', 'ahide@gmail.com', '00:20:24'),
(9, 'Gabriel', 'Angeles Martinez', 'gabi', '$2y$10$y3jsoi9nzoYGwHxwEki3cuSNN1I5hTd1s59yP8MCDSjfJXTzVlx.C', 'administrador', '5615045665', 'gabriel@gmail.com', '00:20:24');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `privilegios`
--

CREATE TABLE `privilegios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `privilegios`
--

INSERT INTO `privilegios` (`id`, `nombre`) VALUES
(4, 'agregar_pacientes'),
(3, 'borrar_pacientes'),
(2, 'editar_pacientes'),
(1, 'ver_pacientes'),
(5, 'ver_reportes');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `nombre`) VALUES
(5, 'administrador'),
(3, 'asistente'),
(1, 'doctor'),
(2, 'enfermero'),
(4, 'limpeza');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol_privilegios`
--

CREATE TABLE `rol_privilegios` (
  `rol_id` int(11) NOT NULL,
  `privilegio_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `rol_privilegios`
--

INSERT INTO `rol_privilegios` (`rol_id`, `privilegio_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(2, 1),
(2, 4),
(3, 1),
(3, 4),
(5, 1),
(5, 2),
(5, 3),
(5, 5);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `citas`
--
ALTER TABLE `citas`
  ADD PRIMARY KEY (`id_cita`),
  ADD KEY `id_paciente` (`id_paciente`);

--
-- Indices de la tabla `pacientes`
--
ALTER TABLE `pacientes`
  ADD PRIMARY KEY (`id_paciente`);

--
-- Indices de la tabla `personal`
--
ALTER TABLE `personal`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usuario` (`usuario`),
  ADD UNIQUE KEY `correo` (`correo`);

--
-- Indices de la tabla `privilegios`
--
ALTER TABLE `privilegios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `rol_privilegios`
--
ALTER TABLE `rol_privilegios`
  ADD PRIMARY KEY (`rol_id`,`privilegio_id`),
  ADD KEY `privilegio_id` (`privilegio_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `citas`
--
ALTER TABLE `citas`
  MODIFY `id_cita` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `pacientes`
--
ALTER TABLE `pacientes`
  MODIFY `id_paciente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `personal`
--
ALTER TABLE `personal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `privilegios`
--
ALTER TABLE `privilegios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `citas`
--
ALTER TABLE `citas`
  ADD CONSTRAINT `citas_ibfk_1` FOREIGN KEY (`id_paciente`) REFERENCES `pacientes` (`id_paciente`) ON DELETE CASCADE;

--
-- Filtros para la tabla `rol_privilegios`
--
ALTER TABLE `rol_privilegios`
  ADD CONSTRAINT `rol_privilegios_ibfk_1` FOREIGN KEY (`rol_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `rol_privilegios_ibfk_2` FOREIGN KEY (`privilegio_id`) REFERENCES `privilegios` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
