<?php 
include_once "includes/header.php";
include "../conexion.php";

$modificado = false; // Variable para verificar si se ha realizado alguna modificación

if (!empty($_POST)) {
  $alert = "";
  if (empty($_POST['cedula']) OR empty($_POST['nombres']) OR empty($_POST['apellidos']) OR empty($_POST['proceso']) OR empty($_POST['correo'])) {
    $alert = '<div class="alert alert-danger" role="alert">
    Todos los campos son obligatorios </div>';
  } else {
    $id_empleado = $_POST['id_empleado'];
    $cedula = $_POST['cedula'];
    $nombres = $_POST['nombres'];
    $apellidos = $_POST['apellidos'];
    $proceso = $_POST['proceso'];
    $correo = $_POST['correo'];

    // Realizar actualización
    $sql_update = mysqli_query($conexion, "UPDATE empleados SET cedula = '$cedula', nombres = '$nombres' , apellidos = '$apellidos', proceso = '$proceso', correo = '$correo'  WHERE id_empleado = $id_empleado");

    if ($sql_update) {
      $alert = '<div class="alert alert-success" role="alert">
      Empleado Actualizado correctamente </div>';
      $modificado = true; // Indicar que se ha realizado una modificación
    } else {
      $alert = '<div class="alert alert-danger" role="alert">
      Error al Actualizar el Empleado</div>';
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
    $correo = $data['correo'];
  }
}
?>


<!----------------------------------------- VISTA PARA EDITAR EMPLEADO---------------------------------------->
<div class="container-fluid">
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Panel de Administración</h1>
    <a href="lista_empleado.php" class="btn btn-primary">Regresar</a>
  </div>


      <div class="col-lg-6 m-auto">
      <div class="card">
      <div class="card-header bg-primary text-white">
         Editar Empleado
        </div>
        <div class="card-body">
        <form id="miformulario" action="" method="post">
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

          <div class="form-group">
            <label for="correo">Correo</label>
            <input type="text" placeholder="Ingrese Proceso" name="correo" class="form-control" id="correo" value="<?php echo $correo; ?>">
          </div>

         
          <!-- <button type="submit" id="botonEditar" class="btn btn-primary" // <?php if (!$modificado) echo 'disabled'; ?>//>Editar</button> -->
          <button type="submit" class="btn btn-primary"><i class="fas fa-user-edit"></i> Editar Empleado</button>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- /.container-fluid -->


  



<?php include_once "includes/footer.php"; ?>
