<?php
if (!empty($_GET['id_empleado'])) {
    require("../conexion.php");
    $id_empleado = $_GET['id_empleado'];
    $query_delete = mysqli_query($conexion, "DELETE FROM empleados WHERE id_empleado = $id_empleado");
    mysqli_close($conexion);
    header("location: lista_empleado.php");
}
?>