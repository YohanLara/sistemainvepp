<?php include_once "includes/header.php";
include "../conexion.php";
// if (!empty($_POST)) Este bloque de código verifica si se ha enviado algún dato mediante el método POST. 
//Si es así, el código dentro de este bloque se ejecuta.

if (!empty($_POST)) {
    $alert = "";
    // if (empty($_POST['cedula']) || empty($_POST['nomnbres']) || empty($_POST['proceso'])) 
    // Aquí se valida si alguno de los campos del formulario está vacío. 
    // Si alguno de estos campos está vacío, se asigna un mensaje de alerta a la variable $alert indicando que todos los campos son obligatorios.
    
    if (empty($_POST['cedula']) || empty($_POST['nombres']) ||  empty($_POST['apellidos']) || empty($_POST['proceso'])) {
        $alert = '<div class="alert alert-danger" role="alert">
                                    Todos los campos son obligatorios
                               </div>';

    // else { ... }: Si todos los campos del formulario están llenos, 
   //el código dentro de este bloque se ejecuta.
    } else {

        // Asignación de variables: Se asignan las variables $cedula, $nombres, $apellidos, $proceso y $usuario_id 
        //con los valores enviados desde el formulario y almacenados en la superglobal $_POST.
        // También se obtiene el ID de usuario de la sesión actual.
        $cedula = $_POST['cedula'];
        $nombres = $_POST['nombres'];
        $apellidos = $_POST['apellidos'];
        $proceso = $_POST['proceso'];
        $usuario_id = $_SESSION['idUser'];
        
        //$result = 0;: Se inicializa la variable $result con el valor 0. 
        //Esta variable se utilizará para almacenar el resultado de la consulta que verifica si la cédula ya existe en la base de datos.

        $result = 0;
        if (is_numeric($cedula) and $cedula != 0) {
            $query = mysqli_query($conexion, "SELECT * FROM empleados where cedula = '$cedula'");
            $result = mysqli_fetch_array($query);
        }
        if ($result > 0) {
            $alert = '<div class="alert alert-danger" role="alert">
                                    La cedula ya existe
                                </div>';
        } else {
            $query_insert = mysqli_query($conexion, "INSERT INTO empleados(cedula,nombres,apellidos,proceso, usuario_id) values ('$cedula', '$nombres', '$apellidos', '$proceso', '$usuario_id')");
            if ($query_insert) {
                $alert = '<div class="alert alert-success" role="alert">
                                    Cliente Registrado
                                </div>';
            } else {
                $alert = '<div class="alert alert-danger" role="alert">
                                    Error al Guardar
                            </div>';
            }
        }
    }
    mysqli_close($conexion);
}
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Panel de Administración</h1>
        <a href="lista_empleado.php" class="btn btn-primary">Regresar</a>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-lg-6 m-auto">
            <form action="" method="post" autocomplete="off">
                <?php echo isset($alert) ? $alert : ''; ?>
                <div class="form-group">
                    <label for="cedula">Cedula</label>
                    <input type="number" placeholder="Ingrese Cedula" name="cedula" id="cedula" class="form-control">
                </div>
                <div class="form-group">
                    <label for="nombres">Nombres</label>
                    <input type="text" placeholder="Ingrese Nombres" name="nombres" id="nombres" class="form-control">
                </div>
                <div class="form-group">
                    <label for="apellidos">Apellidos</label>
                    <input type="text" placeholder="Ingrese Apellidos" name="apellidos" id="apellidos" class="form-control">
                </div>
                <div class="form-group">
                    <label for="proceso">Proceso</label>
                    <input type="text" placeholder="Ingrese Proceso" name="proceso" id="proceso" class="form-control">
                </div>
                <input type="submit" value="Guardar" class="btn btn-success">
            </form>
        </div>
    </div>


</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
<?php include_once "includes/footer.php"; ?>