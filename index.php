<?php
$alert = ''; // Variable para almacenar mensajes de alerta

session_start(); // Inicia la sesión

if (!empty($_SESSION['active'])) { // Verifica si ya hay una sesión activa
  header('location: sistema/'); // Redirige al usuario a la página del sistema si ya está logueado
} else {
  if (!empty($_POST)) { // Verifica si se ha enviado el formulario
    if (empty($_POST['usuario']) || empty($_POST['clave'])) { // Verifica si se han ingresado usuario y contraseña
      $alert = '<div class="alert alert-danger" role="alert">
        Ingrese su usuario y su clave
      </div>'; // Mensaje de alerta si falta usuario o contraseña
    } else {
      require_once "conexion.php"; // Incluye el archivo de conexión a la base de datos
      $user = mysqli_real_escape_string($conexion, $_POST['usuario']); // Escapa el usuario para prevenir inyección SQL
      $clave = md5(mysqli_real_escape_string($conexion, $_POST['clave'])); // Encripta la contraseña para compararla con la almacenada en la base de datos
      $query = mysqli_query($conexion, "SELECT u.idusuario, u.nombre, u.correo,u.usuario,r.idrol,r.rol FROM usuario u INNER JOIN rol r ON u.rol = r.idrol WHERE u.usuario = '$user' AND u.clave = '$clave'"); // Consulta para obtener los datos del usuario
      mysqli_close($conexion); // Cierra la conexión a la base de datos
      $resultado = mysqli_num_rows($query); // Obtiene el número de filas resultantes de la consulta
      if ($resultado > 0) { // Si se encontraron resultados, el usuario y contraseña son correctos
        $dato = mysqli_fetch_array($query); // Obtiene los datos del usuario
        $_SESSION['active'] = true; // Inicia la sesión
        $_SESSION['idUser'] = $dato['idusuario']; // Almacena el ID del usuario en la sesión
        $_SESSION['nombre'] = $dato['nombre']; // Almacena el nombre del usuario en la sesión
        $_SESSION['email'] = $dato['correo']; // Almacena el correo del usuario en la sesión
        $_SESSION['user'] = $dato['usuario']; // Almacena el nombre de usuario en la sesión
        $_SESSION['rol'] = $dato['idrol']; // Almacena el ID del rol del usuario en la sesión
        $_SESSION['rol_name'] = $dato['rol']; // Almacena el nombre del rol del usuario en la sesión
        header('location: sistema/'); // Redirige al usuario a la página del sistema
      } else {
        $alert = '<div class="alert alert-danger" role="alert">
          Usuario o Contraseña Incorrecta
        </div>'; // Mensaje de alerta si el usuario o contraseña son incorrectos
        session_destroy(); // Destruye la sesión
      }
    }
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Sistema Epp</title>


<!-- Fuentes personalizadas para esta plantilla-->
  <link href="sistema/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

<!-- Estilos personalizados para esta plantilla-->
  <link href="sistema/css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

  <div class="container">
 
<!-- Fila exterior -->
    <div class="row justify-content-center">

      <div class="col-xl-10 col-lg-12 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
           <!-- Fila anidada dentro del cuerpo de la tarjeta -->
            <div class="row">
              <div class="col-lg-6 d-none d-lg-block   ">
              <img src="sistema/img/logo-pointer.png" width="440" height="300" style="margin:40px;">
               
              </div>
              <div class="col-lg-6">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Iniciar Sesión</h1>
                  </div>
                  <form class="user" method="POST">
                    <?php echo isset($alert) ? $alert : ""; ?>
                    <div class="form-group">
                      <label for="">Usuario</label>
                      <input type="text" class="form-control" placeholder="Usuario" name="usuario"></div>
                      <div class="form-group">
                      <div class="form-group">

          <label for="">Contraseña</label>
          <div class="input-group">
 
        <input type="password" class="form-control" name="clave" id="passwordInput" placeholder="Contraseña">
        <div class="input-group-append">
        <span class="input-group-text">
        <i class="fas fa-eye password-toggle" onclick="togglePasswordVisibility()"></i>
        </span>  
        </div>
        </div>
        </div>

                    <input type="submit" value="Iniciar" class="btn btn-primary">
                    <hr>
                  </form>
                  <hr>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>

  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="sistema/vendor/jquery/jquery.min.js"></script>
  <script src="sistema/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="sistema/vendor/jquery-easing/jquery.easing.min.js"></script>
  <!-- Custom scripts for all pages-->
  <script src="sistema/js/sb-admin-2.min.js"></script>

  <!-- Script para ocultar las alertas después de 2 segundos -->
  <script>
    $(document).ready(function() {
      setTimeout(function() {
        $(".alert").fadeOut();
      }, 2000);
    });
  </script>
  

  <script>
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById("passwordInput");
            const passwordToggle = document.querySelector(".password-toggle");

            if (passwordInput.type === "password") {
                passwordInput.type = "text"; // Mostrar contraseña
                passwordToggle.classList.remove("fa-eye");
                passwordToggle.classList.add("fa-eye-slash");
            } else {
                passwordInput.type = "password"; // Ocultar contraseña
                passwordToggle.classList.remove("fa-eye-slash");
                passwordToggle.classList.add("fa-eye");
            }
        }
    </script>



    <script src="https://kit.fontawesome.com/544c8047fc.js" crossorigin="anonymous"></script> <!-- Font Awesome para iconos -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>

</html>




