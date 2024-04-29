<?php
if (!empty($_GET['noasig'])) {
    require("../conexion.php");
    $noasig = $_GET['noasig'];
    $query_delete = mysqli_query($conexion, "DELETE FROM asignacion WHERE noasig = $noasig");
    mysqli_close($conexion);
    header("location: asignaciones.php");
}
?>