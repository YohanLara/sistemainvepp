<?php
require_once "../conexion.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require '../PHPMailer/Exception.php';
require '../PHPMailer/PHPMailer.php';
require '../PHPMailer/SMTP.php';



$email = $_POST['correo'];
$query = "SELECT idusuario, nombre FROM usuario WHERE correo = '$email'";
$result = $conexion->query($query);
$row = $result->fetch_assoc();
if($result->num_rows > 0){
    $nombre = $row['nombre'];
    $idusuario = $row['idusuario'];
    $mail = new PHPMailer(true);

    try {
      
        $mail->isSMTP();   
        $mail->Host       = 'smtp-mail.outlook.com';                                         
        $mail->SMTPAuth   = true;                                   
        $mail->Username   = 'lara_9812@hotmail.com';                
        $mail->Password   = 'larita9852';                             
        $mail->Port       = 587;                               
    



        $mail->setFrom('lara_9812@hotmail.com', 'Yohan Lara');
        //Recipients
        $mail->setFrom('lara_9812@hotmail.com', 'Sispoint');
        $mail->addAddress($email, $nombre);  
                 

    
        //Content
        $mail->isHTML(true);                                  
        $mail->Subject = 'Recuperación de contraseña';
        $mail->Body = '
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Recuperación de Contraseña</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f3f3f3;
      margin: 0;
      padding: 0;
    }
    .container {
      max-width: 600px;
      margin: 50px auto;
      padding: 20px;
      background-color: #ffffff;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    .header {
      text-align: center;
      margin-bottom: 30px;
    }
    .header h1 {
      color: #333333;
      margin: 0;
    }
    .content {
      text-align: left;
    }
    .content p {
      color: #666666;
      margin-bottom: 20px;
    }
    .btn {
      display: inline-block;
      padding: 10px 20px;
      background-color: #007bff;
      color: #ffffff;
      text-decoration: none;
      border-radius: 5px;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="header">
      <h1>Recuperación de Contraseña</h1>
    </div>
    <div class="content">
      <p>Hola ' . $nombre . ',</p>
      <p>Has solicitado recuperar tu contraseña. Por favor, haz clic en el siguiente botón para restablecer tu contraseña:</p>
      <a href="http://localhost/sistemainvepp-main/change_password.php?idusuario='.$row['idusuario'].'" class="btn">Restablecer Contraseña</a>
      <p>Si no has solicitado este cambio, puedes ignorar este correo.</p>
    </div>
  </div>
</body>
</html>';
$mail->CharSet = 'UTF-8'; // Establece la codificación de caracteres
        

        $mail->send();
        header("Location: ../index.php?message=ok");
    } catch (Exception $e) {
      header("Location: ../index.php?message=error");
    }
    
    }else{
      header("Location: ../index.php?message=not_found");
      exit();
    
    }
    
    
    ?>
    


