<?php
include "includes/header.php";
include "../conexion.php";
if (!empty($_POST)) {
  $alert = "";
  if (empty($_POST['nombre']) || empty($_POST['correo']) || empty($_POST['usuario']) || empty($_POST['rol'])) {
    $alert = '<div class="alert alert-danger" role="alert">
    Todos los campos son obligatorios </div>';
  } else {
    $idusuario = $_GET['id'];
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $usuario = $_POST['usuario'];
      $rol = $_POST['rol'];
      
    // Verificar si se proporcionó una nueva contraseña
    $clave = !empty($_POST['clave']) ? ($_POST['clave']) : ''; // Si se proporciona una nueva contraseña, cifrarla
    
    // Construir la consulta SQL para actualizar los datos del usuario
    $sql_update = "UPDATE usuario SET nombre = '$nombre', correo = '$correo' , usuario = '$usuario', rol = $rol";
    // Si se proporcionó una nueva contraseña, incluirla en la consulta
    if (!empty($clave)) {
      $sql_update .= ", clave = '$clave'";
    }
    $sql_update .= " WHERE idusuario = $idusuario";
    
    // Ejecutar la consulta de actualización
    $result_update = mysqli_query($conexion, $sql_update);
    
    if ($result_update) {
      $alert = '<div class="alert alert-success" role="alert">
      Registro Actualizado
      </div>';
    } else {
      $alert = '<div class="alert alert-danger" role="alert">
      Error al actualizar el registro
      </div>';
    }
  }
}

// Mostrar Datos

if (empty($_REQUEST['id'])) {

}
$idusuario = $_REQUEST['id'];
$sql = mysqli_query($conexion, "SELECT * FROM usuario WHERE idusuario = $idusuario");
$result_sql = mysqli_num_rows($sql);
if ($result_sql == 0) {

} else {
  if ($data = mysqli_fetch_array($sql)) {
    $idcliente = $data['idusuario'];
    $nombre = $data['nombre'];
    $correo = $data['correo'];
    $usuario = $data['usuario'];
    $rol = $data['rol'];
  }
}
?>
<!----------- EDITAR REGISTRO ------------>
<div class="container-fluid">
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Panel de Administración</h1>
    <a href="lista_usuarios.php" class="btn btn-primary">Regresar</a>
  </div>

    <div class="col-lg-6 m-auto">
      <div class="card">
        <div class="card-header bg-primary text-white">
         Editar Usuario
        </div>
        <div class="card-body">
          <form action="" method="post">
            <?php echo isset($alert) ? $alert : ''; ?>
            <input type="hidden" name="idusuario" value="<?php echo $idusuario; ?>">
                <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" placeholder="Ingrese nombre" class="form-control" name="nombre" id="nombre" value="<?php echo $nombre; ?>">
                    </div>
                    <div class="form-group">
                        <label for="correo">Correo</label>
                        <input type="text" placeholder="Ingrese correo" class="form-control" name="correo" id="correo" value="<?php echo $correo; ?>">
                    </div>
                    <div class="form-group">
                        <label for="usuario">Usuario</label>
                        <input type="text" placeholder="Ingrese usuario" class="form-control" name="usuario" id="usuario" value="<?php echo $usuario; ?>">
                    </div>
                    <!-- Campo para ingresar la nueva contraseña -->
                    <div class="form-group">
                        <label for="clave">Nueva Contraseña</label>
                        <input type="password" placeholder="Ingrese nueva contraseña" class="form-control" name="clave" id="clave">
                    </div>
                    <div class="form-group">
                        <label for="rol">Rol</label>
                        <select name="rol" id="rol" class="form-control">
                            <option value="1" <?php if ($rol == 1) echo "selected"; ?>>Administrador</option>
                            <option value="2" <?php if ($rol == 2) echo "selected"; ?>>Asistente Inventario</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success"><i class="fas fa-user-edit"></i> Editar Usuario</button>
                </form>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</div>
<!-- End of Main Content -->
<?php include_once "includes/footer.php"; ?>
