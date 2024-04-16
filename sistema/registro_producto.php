<?php 
include_once "includes/header.php";
include "../conexion.php";

if (!empty($_POST)) {
    $alert = "";
    if (empty($_POST['descripcion']) || empty($_POST['cantidad']) || empty($_POST['codproducto']) || $_POST['cantidad'] < 0) {
        $alert = '<div class="alert alert-danger" role="alert">
                    Los campos descripción, cantidad y código del producto son obligatorios
                  </div>';
    } else {
        $codproducto = $_POST['codproducto'];
        $descripcion = $_POST['descripcion'];
        $cantidad = $_POST['cantidad'];
        $talla = $_POST['talla'];
        $usuario_id = $_SESSION['idUser'];

        $query = mysqli_query($conexion, "SELECT * FROM producto where codproducto = '$codproducto'");
        $result = mysqli_num_rows($query);

        if ($result > 0) {
            $alert = '<div class="alert alert-danger" role="alert">
                        El código de producto ya existe
                      </div>';
        } else {
            // Insertar el producto en la tabla de productos
            $query_insert = mysqli_query($conexion, "INSERT INTO producto(codproducto, descripcion, cantidad, talla, usuario_id) VALUES ('$codproducto', '$descripcion', '$cantidad', '$talla', '$usuario_id')");

            if ($query_insert) {
                // Insertar la entrada en la tabla de entradas
                $query_insert_entrada = mysqli_query($conexion, "INSERT INTO entradas(codproducto, cantidad, usuario_id) VALUES ('$codproducto', '$cantidad', '$usuario_id')");

                if ($query_insert_entrada) {
                    $alert = '<div class="alert alert-success" role="alert">
                                Producto registrado 
                              </div>';
                } else {
                    $alert = '<div class="alert alert-danger" role="alert">
                                Error al registrar la entrada
                              </div>';
                }
            } else {
                $alert = '<div class="alert alert-danger" role="alert">
                            Error al registrar el producto
                          </div>';
            }
        }
    }
}
?>


<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Panel de Administración</h1>
        <a href="lista_productos.php" class="btn btn-primary">Regresar</a>
    </div>
      
  
   
        <div class="col-lg-6 m-auto">
        <div class="card">
        <div class="card-header bg-primary text-white">
         Registrar Producto
        </div>
        <div class="card-body">
        <form action="" method="post" autocomplete="off">
        <?php echo isset($alert) ? $alert : ''; ?>
          
                <div class="form-group">
                    <label for="codproducto">Codigo De Producto</label>
                    <input type="text" placeholder="Ingrese codigo de producto" class="form-control" name="codproducto" id="codproducto" required>
                </div>
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
</div>

<?php include_once "includes/footer.php"; ?>
