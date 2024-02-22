<?php 
include_once "includes/header.php";
include "../conexion.php";

if (!empty($_POST)) {
    $alert = "";
    if (empty($_POST['descripcion']) || empty($_POST['cantidad']) || $_POST['cantidad'] < 0) {
        $alert = '<div class="alert alert-danger" role="alert">
                    Los campos descripcion y cantidad son obligatorios
                  </div>';
    } else {
        $descripcion = $_POST['descripcion'];
        $cantidad = $_POST['cantidad'];
        $talla = $_POST['talla'];
        $usuario_id = $_SESSION['idUser'];

        $query_insert = mysqli_query($conexion, "INSERT INTO producto(descripcion,cantidad,talla,usuario_id) values ('$descripcion', '$cantidad','$talla','$usuario_id')");
        
        if ($query_insert) {
            $alert = '<div class="alert alert-success" role="alert">
                        Producto Registrado
                      </div>';
        } else {
            $alert = '<div class="alert alert-danger" role="alert">
                        Error al registrar el producto
                      </div>';
        }
    }
}
?>

<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Panel de Administración</h1>
        <a href="lista_productos.php" class="btn btn-primary">Regresar</a>
    </div>
      
    <div class="row">
   
        <div class="col-lg-6 m-auto">
        <?php echo isset($alert) ? $alert : ''; ?>
            <form action="" method="post" autocomplete="off">
                <div class="form-group">
                    <label for="descripcion">Descripcion</label>
                    <input type="text" placeholder="Ingrese nombre del producto" name="descripcion" id="descripcion" class="form-control">
                </div>
                <div class="form-group">
                    <label for="cantidad">Cantidad</label>
                    <input type="number" placeholder="Ingrese cantidad" class="form-control" name="cantidad" id="cantidad">
                </div>
                <div class="form-group">
                    <label for="talla">Talla</label>
                    <input type="text" placeholder="Ingrese talla" class="form-control" name="talla" id="talla">
                </div>
                <input type="submit" value="Guardar producto" class="btn btn-primary">
            </form>
        </div>
    </div>

</div>

<?php include_once "includes/footer.php"; ?>
