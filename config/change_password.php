<?php 
require_once('../conexion.php');

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar si las variables están definidas
    if (isset($_POST['idusuario'], $_POST['clave'])) {
        $idusuario = $_POST['idusuario'];
        $pass = $_POST['clave'];

       

        // Consulta preparada para evitar SQL injection
        $query = "UPDATE usuario SET clave = ? WHERE idusuario = ?";
        $statement = $conexion->prepare($query);
        $statement->bind_param("si", $pass, $idusuario);
        $statement->execute();

        // Redireccionar después de cambiar la contraseña
        header("Location: ../index.php?message=success_password");
        exit; // Asegura que el script se detenga después de redirigir
    } else {
        // Si las variables no están definidas, manejar el error apropiadamente
        echo "Error: Variables indefinidas.";
    }
} else {
    // Si no se ha enviado el formulario, manejar el error apropiadamente
    echo "Error: Método de solicitud incorrecto.";
}
?>
