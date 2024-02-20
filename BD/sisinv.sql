

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Base de datos: `sisinv`
--



CREATE TABLE `rol` (
  `idrol` int(11) NOT NULL,
  `rol` varchar(50) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

ALTER TABLE `rol`
  ADD PRIMARY KEY (`idrol`);

ALTER TABLE `rol`
  MODIFY `idrol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;



  CREATE TABLE `usuario` (
  `idusuario` int(11) NOT NULL,
  `nombre` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `correo` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `usuario` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `clave` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `rol` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idusuario`);

  ALTER TABLE `usuario`
  MODIFY `idusuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

  
DELIMITER $$
CREATE PROCEDURE `data` ()
BEGIN
  DECLARE count_usuario INT;
  DECLARE count_empleados INT;
  DECLARE count_productos INT;
  
  SELECT COUNT(*) INTO count_usuario FROM usuario;
  SELECT COUNT(*) INTO count_empleados FROM empleados;

  SELECT count_usuario, count_empleados ;
END$$
DELIMITER ;


CREATE TABLE `empleados` (
  `id_empleado` int(11) NOT NULL,
  `cedula` int(12) NOT NULL,
  `nombres` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `apellidos` int(50) NOT NULL,
  `proceso` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `usuario_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `cliente`||
--

INSERT INTO `empleados` (`id_empleado`, `cedula`, `nombres`, `apellidos`, `proceso`, `usuario_id`) VALUES
(1, 1031175234, 'kevin','lara', 'projects', 1);


ALTER TABLE `empleados`
  ADD PRIMARY KEY (`id_empleado`);

ALTER TABLE `empleados`
  MODIFY `id_empleado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
