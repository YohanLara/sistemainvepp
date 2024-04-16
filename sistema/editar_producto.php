<?php
include_once "includes/header.php";
include "../conexion.php";

// Verificar si se ha enviado el formulario
if (!empty($_POST)) {
  $alert = "";
  // Verificar si el campo de descripción está vacío
  if (empty($_POST['descripcion'])) {
    $alert = '<div class="alert alert-danger" role="alert">
               La descripción es obligatoria
              </div>';
  } else {
    // Obtener el código de producto de la variable GET
    $codproducto = $_GET['codproducto'];
    // Obtener los datos del formulario
    $descripcion = $_POST['descripcion'];
    $talla = $_POST['talla'];
    // Ejecutar la consulta de actualización
    $query_update = mysqli_query($conexion, "UPDATE producto SET descripcion = '$descripcion', talla = '$talla' WHERE codproducto = $codproducto");
    if ($query_update) {
      $alert = '<div class="alert alert-success" role="alert">
                Producto actualizado correctamente
              </div>';
    } else {
      $alert = '<div class="alert alert-danger" role="alert">
                Error al actualizar el producto
              </div>';
    }
  }
}

// Obtener el código de producto de la variable GET
$codproducto = $_GET['codproducto'];
// Obtener información del producto
$query_producto = mysqli_query($conexion, "SELECT * FROM producto WHERE codproducto = $codproducto");
$data = mysqli_fetch_assoc($query_producto);

// Cerrar conexión
mysqli_close($conexion);
?>


<div class="container-fluid">
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Panel de Administración</h1>
    <a href="lista_productos.php" class="btn btn-primary">Regresar</a>
  </div>     


<!-- Contenido de la página de inicio -->
    <div class="col-lg-6 m-auto">
      <div class="card">
        <div class="card-header bg-primary text-white">
          Modificar producto
        </div>
        <div class="card-body">
          <form action="" method="post">
            <?php echo isset($alert) ? $alert : ''; ?>
            <div class="form-group">
              <label for="descripcion">Descripción del producto</label>
              <input type="text" class="form-control" placeholder="Ingrese descripción del producto" name="descripcion" id="descripcion" value="<?php echo $data['descripcion']; ?>">
            </div>


            <div class="form-group">
              <label for="talla">Talla</label>
              <input type="text" class="form-control" placeholder="Ingrese descripción del producto" name="talla" id="talla" value="<?php echo $data['talla']; ?>">
            </div>


            <input type="submit" value="Actualizar Producto" class="btn btn-primary">
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- /.container-fluid -->

<?php include_once "includes/footer.php"; ?>
