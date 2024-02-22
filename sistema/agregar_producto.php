<?php
include_once "includes/header.php";
include "../conexion.php";


if (empty($_REQUEST['codproducto'])) {
    header("Location: lista_productos.php");
} else {
    $id_producto = $_REQUEST['codproducto'];
    if (!is_numeric($id_producto)) {
        header("Location: lista_productos.php");
    }
    $query_producto = mysqli_query($conexion, "SELECT codproducto, descripcion, cantidad FROM producto WHERE codproducto = $id_producto");
    $result_producto = mysqli_num_rows($query_producto);

    if ($result_producto > 0) {
        $data_producto = mysqli_fetch_assoc($query_producto);
    } else {
        header("Location: lista_productos.php");
    }
}

if (!empty($_POST)) {
    $alert = "";
    if (!empty($_POST['cantidad'])) {
        $cantidad = $_POST['cantidad'];
        $producto_id = $id_producto;
        $usuario_id = $_SESSION['idUser'];

        $query_insert = mysqli_query($conexion, "INSERT INTO entradas(codproducto, cantidad, usuario_id) VALUES ($producto_id, $cantidad, $usuario_id)");
        if ($query_insert) {
        
            $query_upd = mysqli_query($conexion, "CALL actualizar_cantidad_producto($cantidad, $producto_id)");
            if ($query_upd) {
                $alert = '<div class="alert alert-success" role="alert">
                        Producto actualizado con éxito
                    </div>';
            } else {
                $alert = '<div class="alert alert-danger" role="alert">
                        Error al actualizar el producto
                    </div>';
            }
        } else {
            $alert = '<div class="alert alert-danger" role="alert">
                    Error al agregar la entrada del producto
                </div>';
        }
        mysqli_close($conexion);
    } else {
        $alert = '<div class="alert alert-danger" role="alert">
                Debe ingresar una cantidad válida
            </div>';
    }
}
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <div class="row">
        <div class="col-lg-6 m-auto">
            <form action="" method="post">
                <?php echo isset($alert) ? $alert : ''; ?>

                <div class="form-group">
                    <label for="cantidad">Cantidad de productos disponibles</label>
                    <input type="number" class="form-control" value="<?php echo $data_producto['cantidad']; ?>" disabled>
                </div>

                <div class="form-group">
                    <label for="cantidad">Agregar Cantidad</label>
                    <input type="number" placeholder="Ingrese cantidad" name="cantidad" id="cantidad" class="form-control">
                </div>

                <input type="submit" value="Actualizar" class="btn btn-primary">
                <a href="lista_productos.php" class="btn btn-danger">Regresar</a>
            </form>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

<?php include_once "includes/footer.php"; ?>
