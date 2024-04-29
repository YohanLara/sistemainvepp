<?php
$alert = ''; // Variable para almacenar mensajes de alerta

session_start(); // Inicia la sesión

if (!empty($_SESSION['active'])) { // Verifica si ya hay una sesión activa
  header('location: sistema/'); // Redirige al usuario a la página del sistema si ya está logueado
  exit; // Finaliza la ejecución del script después de la redirección
} else {
  if (!empty($_POST)) { // Verifica si se ha enviado el formulario
    if (empty($_POST['correo']) || empty($_POST['clave'])) { // Verifica si se han ingresado usuario y contraseña
      $alert = '<div class="alert alert-danger" role="alert">
        Ingrese su correo y su contraseña
      </div>'; // Mensaje de alerta si falta correo o contraseña
    } else {
      require_once "conexion.php"; // Incluye el archivo de conexión a la base de datos
      $correo = mysqli_real_escape_string($conexion, $_POST['correo']); // Escapa el correo para prevenir inyección SQL
      $clave = mysqli_real_escape_string($conexion, $_POST['clave']); // Escapa la contraseña para prevenir inyección SQL
      $query = mysqli_query($conexion, "SELECT idusuario, nombre, correo, usuario, rol FROM usuario WHERE correo = '$correo' AND clave = '$clave'"); // Consulta para obtener los datos del usuario
      $resultado = mysqli_num_rows($query); // Obtiene el número de filas resultantes de la consulta
      if ($resultado > 0) { // Si se encontraron resultados, el correo y contraseña son correctos
        $dato = mysqli_fetch_array($query); // Obtiene los datos del usuario
        $_SESSION['active'] = true; // Inicia la sesión
        $_SESSION['idUser'] = $dato['idusuario']; // Almacena el ID del usuario en la sesión
        $_SESSION['nombre'] = $dato['nombre']; // Almacena el nombre del usuario en la sesión
        $_SESSION['email'] = $dato['correo']; // Almacena el correo del usuario en la sesión
        $_SESSION['user'] = $dato['usuario']; // Almacena el nombre de usuario en la sesión
        $_SESSION['rol'] = $dato['rol']; // Almacena el ID del rol del usuario en la sesión
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
  <link href="sistema/css/fontawesome.min.css" rel="stylesheet" type="text/css">

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
                    <?php 
    if(isset($_GET['message'])){
     
    ?> 
 <div class="alert <?php echo ($_GET['message'] == 'ok') ? 'alert-success' : ($_GET['message'] == 'success_password' ? 'alert-success' : 'alert-danger'); ?>" role="alert">


        <?php 
        switch ($_GET['message']) {
          case 'ok':
            echo 'Por favor, revisa tu correo';
            break;
          case 'success_password':
            echo 'Inicia sesión con tu nueva contraseña';
            break;
            
          default:
            echo 'Algo salió mal, intenta de nuevo';
            break;
        }
        ?>
      </div>
    <?php
    }
    ?>
                    <div class="form-group">
                      <label for="">Correo Electronico</label>
                      <input type="text" class="form-control" placeholder="Ingrese correo" name="correo"></div>
                    <div class="form-group">
                      <div class="form-group">

                        <label for="">Contraseña</label>
                        <div class="input-group">
                          <input type="password" class="form-control" name="clave" id="passwordInput" placeholder="Ingrese contraseña">
                          <div class="input-group-append">
                            <span class="input-group-text">
                              <i class="fas fa-eye password-toggle" onclick="togglePasswordVisibility()"></i>
                            </span>
                          </div>
                        </div>
                        <a href="recovery.php">¿Olvidaste tu contraseña?</a>
                      </div>

                      <input type="submit" value="Ingresar" class="btn btn-primary">
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
    // Verifica si la alerta está presente antes de iniciar el temporizador
    if ($(".alert").length > 0) {
      setTimeout(function() {
        window.location.href = "index.php";
        $(".alert").fadeOut();
      }, 2000);
    }
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
