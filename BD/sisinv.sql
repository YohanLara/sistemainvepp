

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

INSERT INTO `usuario` (`idusuario`, `nombre`, `correo`, `usuario`, `clave`, `rol`) VALUES
(1, 'Yohan v', 'sistemas@pointerinstrument.vom ','Klarat', '06233bc2fb3e609a065cfc435337cabd', 1);

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
  `apellidos` varchar(50)  COLLATE utf8_spanish_ci NOT NULL,
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

---*-*-*-**-**-**-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*/-*-*-*-*-*-*-*-*-*-*-*-*-*--*+-*-*/-*-*-*-*-*-*-*-*-*-*-**

CREATE PROCEDURE `procesar_asignacion` (IN `cod_usuario` INT, IN `cod_cliente` INT, IN `token` VARCHAR(50))  
BEGIN
    DECLARE asignacion_id INT;
    DECLARE registros INT;
    DECLARE total_productos INT;
    DECLARE nueva_existencia INT;
    DECLARE existencia_actual INT;

    DECLARE tmp_cod_producto INT;
    DECLARE tmp_cant_producto INT;
    DECLARE a INT;
    SET a = 1;

    CREATE TEMPORARY TABLE tbl_tmp_tokenuser(
        id BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
        cod_prod BIGINT,
        cant_prod INT
    );

    SET registros = (SELECT COUNT(*) FROM detalle_temp WHERE token_user = token);
    IF registros > 0 THEN
        -- Insertar detalles en la tabla temporal
        INSERT INTO tbl_tmp_tokenuser(cod_prod, cant_prod) SELECT codproducto, cantidad FROM detalle_temp WHERE token_user = token;

        -- Insertar asignación
        INSERT INTO asignacion (cod_usuario, cod_cliente, fecha_asignacion) VALUES (cod_usuario, cod_cliente, NOW());
        SET asignacion_id = LAST_INSERT_ID();

        -- Insertar detalles de la asignación
        INSERT INTO detalle_asignacion (asignacion_id, cod_producto, cantidad) 
        SELECT asignacion_id, codproducto, cantidad FROM detalle_temp WHERE token_user = token;

        -- Actualizar existencia de productos
        WHILE a <= registros DO
            SELECT cod_prod, cant_prod INTO tmp_cod_producto, tmp_cant_producto FROM tbl_tmp_tokenuser WHERE id = a;
            SELECT existencia INTO existencia_actual FROM producto WHERE codproducto = tmp_cod_producto;
            SET nueva_existencia = existencia_actual - tmp_cant_producto;
            UPDATE producto SET existencia = nueva_existencia WHERE codproducto = tmp_cod_producto;
            SET a = a + 1;
        END WHILE;

        -- Calcular total de productos asignados
        SELECT SUM(cant_prod) INTO total_productos FROM tbl_tmp_tokenuser;

        -- Eliminar detalles temporales
        DELETE FROM detalle_temp WHERE token_user = token;
        -- Limpiar tabla temporal
        TRUNCATE TABLE tbl_tmp_tokenuser;

        -- Mostrar detalles de la asignación
        SELECT asignacion_id AS 'ID Asignación', total_productos AS 'Cantidad Productos Asignados', NOW() AS 'Fecha Asignación', 
               p.nombre AS 'Nombre Producto', CONCAT(u.nombre, ' ', u.apellido) AS 'Empleado Asignado'
        FROM asignacion a
        INNER JOIN detalle_asignacion da ON a.id_asignacion = da.asignacion_id
        INNER JOIN producto p ON da.cod_producto = p.codproducto
        INNER JOIN usuario u ON a.cod_usuario = u.cod_usuario
        WHERE a.id_asignacion = asignacion_id;
    ELSE
        SELECT 0 AS 'Error: No hay productos para asignar';
    END IF;
END$$
