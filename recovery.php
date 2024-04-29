
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Sistema Epp</title>

 
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
                    <h1 class="h4 text-gray-900 mb-4">Recuperar Contraseña</h1>
                  </div>
                  <form action="config/recovery.php" class="user" method="POST">
                    <?php echo isset($alert) ? $alert : ""; ?>
                    <div class="form-group">
                      <label for="">Correo Electronico</label>
                      <input type="email" class="form-control" placeholder="Ingrese su correo electronico" name="correo"></div>
                    <div class="form-group">
                      <div class="form-group">
                        
                      <input type="submit" value="Enviar Enlace" class="btn btn-primary">
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
  <script src="https://kit.fontawesome.com/544c8047fc.js" crossorigin="anonymous"></script> <!-- Font Awesome para iconos -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>

</html>
  