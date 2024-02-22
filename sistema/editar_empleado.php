<?php 
include_once "includes/header.php";
include "../conexion.php";
if (!empty($_POST)) {
  $alert = "";
  if (empty($_POST['cedula']) || empty($_POST['nombres']) || empty($_POST['apellidos']) || empty($_POST['proceso'])) {
    $alert = '<div class="alert alert-danger" role="alert">
    Todos los campos son obligatorios </div>';
  } else {
    $id_empleado = $_POST['id_empleado'];
    $cedula = $_POST['cedula'];
    $nombres = $_POST['nombres'];
    $apellidos = $_POST['apellidos'];
    $proceso = $_POST['proceso'];

    $result = 0;
    if (is_numeric($cedula) and $cedula != 0) {

      $query = mysqli_query($conexion, "SELECT * FROM empleados where (cedula = '$cedula' AND id_empleado != $id_empleado)");
      $result = mysqli_fetch_array($query);
      $resul = mysqli_num_rows($query);
    }

    if ($resul >= 1) {
      $alert = '<div class="alert alert-danger" role="alert">
      La cedula ya existe </div>';
    } else {
      if ($cedula == '') {
        $cedula = 0;
      }
      $sql_update = mysqli_query($conexion, "UPDATE empleados SET cedula = '$cedula', nombres = '$nombres' , apellidos = '$apellidos', proceso = '$proceso' WHERE id_empleado = $id_empleado");

      if ($sql_update) {
        $alert = '<div class="alert alert-success" role="alert">
        Cliente Actualizado correctamente </div>';
      } else {
        $alert = '<p class"error">Error al Actualizar el Cliente</p>';
      }
    }
  }
}
// Mostrar Datos

$id_empleado = $_REQUEST['id_empleado'];
$sql = mysqli_query($conexion, "SELECT * FROM empleados WHERE id_empleado = $id_empleado");
$result_sql = mysqli_num_rows($sql);
if ($result_sql == 0) {

} else {
  while ($data = mysqli_fetch_array($sql)) {
    $id_empleado = $data['id_empleado'];
    $cedula = $data['cedula'];
    $nombres = $data['nombres'];
    $apellidos = $data['apellidos'];
    $proceso = $data['proceso'];
  }
}
?>
<div class="container-fluid">
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Panel de Administración</h1>
    <a href="lista_empleado.php" class="btn btn-primary">Regresar</a>
  </div>

  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-6 m-auto">
        <form class="" action="" method="post">
          <?php echo isset($alert) ? $alert : ''; ?>
          <input type="hidden" name="id_empleado" value="<?php echo $id_empleado; ?>">
          <div class="form-group">
            <label for="cedula">Cedula</label>
            <input type="number" placeholder="Ingrese Cedula" name="cedula" id="cedula" class="form-control" value="<?php echo $cedula; ?>">
          </div>
          <div class="form-group">
            <label for="nombres">Nombres</label>
            <input type="text" placeholder="Ingrese Nombres" name="nombres" class="form-control" id="nombres" value="<?php echo $nombres; ?>">
          </div>
          <div class="form-group">
            <label for="apellidos">Apellidos</label>
            <input type="text" placeholder="Ingrese Apellidos" name="apellidos" class="form-control" id="apellidos" value="<?php echo $apellidos; ?>">
          </div>
          <div class="form-group">
            <label for="proceso">Proceso</label>
            <input type="text" placeholder="Ingrese Proceso" name="proceso" class="form-control" id="proceso" value="<?php echo $proceso; ?>">
          </div>
          <button type="submit" class="btn btn-primary"><i class="fas fa-user-edit"></i> Editar Cliente</button>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- /.container-fluid -->

<?php include_once "includes/footer.php"; ?>
