<?php
if (!empty($_GET['codproducto'])) {
    require("../conexion.php");
    $codproducto = $_GET['codproducto'];
    $query_delete = mysqli_query($conexion, "DELETE FROM entradas WHERE codproducto = $codproducto");
    mysqli_close($conexion);
    header("location: entradas.php");
}   
?>



