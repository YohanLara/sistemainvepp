<?php
if (!empty($_GET['codproducto'])) {
    require("../conexion.php");
    $codproducto = $_GET['codproducto'];
    $query_delete = mysqli_query($conexion, "DELETE FROM producto WHERE codproducto = $codproducto");
    mysqli_close($conexion);
    header("location: lista_productos.php");
}   
?>



