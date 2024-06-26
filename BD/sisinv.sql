

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- Create database if not exists sisinv;
-------------------------------------------------TABLA ROL---------------------------------------------------
CREATE TABLE `rol` (
  `idrol` int(11) NOT NULL,
  `rol` varchar(50) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

ALTER TABLE `rol`
  ADD PRIMARY KEY (`idrol`);

ALTER TABLE `rol`
  MODIFY `idrol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

------------------------------------------------TABLA USUARIO------------------------------------------------
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

(2 'Yohan v', 'sistemas@pointeriinstrument.com', 'Klarat', '202cb962ac59075b964b07152d234b70',	2);
(3 'Kevin Lara',	'Lara_9812@hotmail.com', 'larat1', '25f9e794323b453885f5181f1b624d0b',	1);
-- clave usuario 2 es 123  y usuario 3 es 123456789
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idusuario`);

  ALTER TABLE `usuario`
  MODIFY `idusuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
 
-------------------------------------------TABLA EMPLEADOS------------------------------------------------
CREATE TABLE `empleados` (
  `id_empleado` int(11) NOT NULL,
  `cedula` int(12) NOT NULL,
  `nombres` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `apellidos` varchar(50)  COLLATE utf8_spanish_ci NOT NULL,
  `proceso` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `usuario_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO `empleados` (`id_empleado`, `cedula`, `nombres`, `apellidos`, `proceso`, `usuario_id`) VALUES
(1, 1031175234, 'kevin','lara', 'projects', 1);

ALTER TABLE `empleados`
  ADD PRIMARY KEY (`id_empleado`);

ALTER TABLE `empleados`
  MODIFY `id_empleado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

ALTER TABLE empleados
ADD COLUMN correo varchar(100);

--------------------------------------------- TABLA PRODUCTO------------------------------------------------

CREATE TABLE `producto` (
  `codproducto` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `descripcion` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `cantidad` int(11) NOT NULL,
  `talla` varchar(2) NULL,
  `usuario_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO `producto` (`codproducto`, `descripcion`, `cantidad`, `talla`, `usuario_id`) VALUES
(1, 'Tapabocas', 10, 'M', 1),
(2, 'Guantes de látex', 20, 'L', 2),
(3, 'Gafas de seguridad', 15, 'XL', 1),
(4, 'Botas de trabajo', 8, '40', 3),
(5, 'Casco de protección', 12, NULL, 2);

ALTER TABLE `producto`
  ADD PRIMARY KEY (`codproducto`);
--
ALTER TABLE `producto`
  MODIFY `codproducto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

ALTER TABLE `producto`
ADD COLUMN `cod` INT UNIQUE;

---------------------------------------------TABLA DE ENTRADAS-----------------------------------------------
CREATE TABLE `entradas` (
  `correlativo` int(11) NOT NULL,
  `codproducto` int(11) NOT NULL,
  `fecha` datetime NOT NULL DEFAULT current_timestamp(),
  `cantidad` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

ALTER TABLE `entradas`
  ADD PRIMARY KEY (`correlativo`);
  
ALTER TABLE `entradas`
  MODIFY `correlativo` int(11) NOT NULL AUTO_INCREMENT;
----------------------------------------------DETALLE TEMPORAL-----------------------------------------------
CREATE TABLE `detalle_temp` (
  `correlativo` int(11) NOT NULL,
  `token_user` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `codproducto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


ALTER TABLE `detalle_temp`
  ADD PRIMARY KEY (`correlativo`);

  ALTER TABLE `detalle_temp`
  MODIFY `correlativo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

---------------------------------------------PROCEDIMIENTOS--------------------------------------------------
--------------------------------------PARA CONTAR EN EL DASHBOARD--------------------------------------------
CREATE PROCEDURE `data` ()
BEGIN
  DECLARE count_usuario INT;
  DECLARE count_empleados INT;
  DECLARE count_productos INT;
  DECLARE count_asignaciones INT;
  
  SELECT COUNT(*) INTO count_usuario FROM usuario;
  SELECT COUNT(*) INTO count_empleados FROM empleados;
   SELECT COUNT(*) INTO count_productos FROM producto;
   SELECT COUNT(*) INTO count_asignaciones FROM asignacion;


  SELECT count_usuario, count_empleados,count_productos,count_asignaciones ;

END$$
DELIMITER ;

--------------------------------------- ACTUALIZAR CANTIDADES------------------------------------------------ 
DELIMITER $$

CREATE PROCEDURE `actualizar_cantidad_producto`(IN `n_cantidad` INT, IN `codigo` INT)  
BEGIN
    DECLARE nueva_cantidad INT;

    DECLARE actual_cantidad INT;

    -- Obtener la existencia actual del producto
    SELECT cantidad INTO actual_cantidad FROM producto WHERE codproducto = codigo;

    -- Calcular la nueva existencia sumando la cantidad proporcionada
    SET nueva_cantidad = actual_cantidad+ n_cantidad;
    
    -- Actualizar la existencia del producto
    UPDATE producto SET cantidad = nueva_cantidad WHERE codproducto = codigo;

    -- Devolver la nueva existencia
    SELECT nueva_cantidad;
END $$

DELIMITER ;

------------------------------------DETALLE TEMPORAL DE LAS ASIGNACIONES--------------------------------------
-- inserta un nuevo registro en la tabla detalle_temp 
--y luego selecciona información relacionada de esta tabla junto con información adicional de la tabla producto
--basada en el token de usuario proporcionado.

DELIMITER $$
CREATE PROCEDURE add_detalle_temp(codigo INT, cantidad INT, token_user VARCHAR(50))
BEGIN
    INSERT INTO detalle_temp(token_user, codproducto, cantidad)
    VALUES (token_user, codigo, cantidad);
    
    SELECT tmp.correlativo, tmp.codproducto, p.descripcion, tmp.cantidad, p.talla
    FROM detalle_temp tmp
    INNER JOIN producto p ON tmp.codproducto = p.codproducto
    WHERE tmp.token_user = token_user;
END$$
DELIMITER ;

--------------------------------------PARA ELIMINAR LOS EPP SELECCIONADOS-------------------------------------
DELIMITER $$
CREATE PROCEDURE `del_detalle_temp` (`id_detalle` INT, `token` VARCHAR(50))  BEGIN
DELETE FROM detalle_temp WHERE correlativo = id_detalle;
SELECT tmp.correlativo, tmp.codproducto, p.descripcion, p.talla, tmp.cantidad FROM detalle_temp tmp INNER JOIN producto p ON tmp.codproducto = p.codproducto WHERE tmp.token_user = token;
END$$


DELIMITER $$
CREATE PROCEDURE `procesar_asignacion` (IN `cod_usuario` INT, IN `codemple` INT, IN `token` VARCHAR(50))  
 BEGIN

     DECLARE asignacion INT;
     DECLARE registros INT;

 DECLARE nueva_cantidad int;
 DECLARE cantidad_actual int;

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
      
         INSERT INTO tbl_tmp_tokenuser(cod_prod, cant_prod) SELECT codproducto, cantidad FROM detalle_temp WHERE  token_user = token;

         INSERT INTO asignacion (usuario, codemple) VALUES (cod_usuario, codemple);
         SET asignacion = LAST_INSERT_ID();

       
         INSERT INTO detalleasig (noasig, codproducto, cantidad) 
         SELECT (asignacion) as noasig, codproducto,cantidad FROM detalle_temp WHERE token_user = token;


         WHILE a <= registros DO
             SELECT cod_prod, cant_prod INTO tmp_cod_producto, tmp_cant_producto FROM tbl_tmp_tokenuser WHERE id = a;
          
             SELECT cantidad INTO cantidad_actual FROM producto WHERE codproducto = tmp_cod_producto;
             
             SET nueva_cantidad = cantidad_actual - tmp_cant_producto;
             UPDATE producto SET cantidad = nueva_cantidad WHERE codproducto = tmp_cod_producto;
             SET a = a + 1;
         END WHILE;
         
         -- Eliminar detalles temporales
         DELETE FROM detalle_temp WHERE token_user = token;
         	
         -- Limpiar tabla temporal
         TRUNCATE TABLE tbl_tmp_tokenuser;
         
        SELECT * FROM asignacion WHERE noasig = asignacion;
        
        ELSE 
        SELECT 0;
END IF;
END;$$
DELIMITER ;