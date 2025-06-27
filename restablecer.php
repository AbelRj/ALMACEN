<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include("bd.php");
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php'; // Asegúrate de haber ejecutado `composer install` antes
$error = '';
$success = '';

if ($_POST) {
  $email = $_POST['email'];

  // Consulta para verificar si el correo existe
  $sql = "SELECT * FROM usuarios WHERE email = ?";
  $stmt = $conexion->prepare($sql);
  $stmt->bindParam(1, $email);
  $stmt->execute();
  $user = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($user) {
    
    $token = bin2hex(random_bytes(50));

    $sql = "UPDATE usuarios SET token_reset = ? WHERE email = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(1, $token);
    $stmt->bindParam(2, $email);
    $stmt->execute();

    // Configurar PHPMailer
    $mail = new PHPMailer(true);
    // Configuración del servidor SMTP
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com'; // Servidor SMTP de Gmail
    $mail->SMTPAuth = true;
    $mail->Username = 'abel.250.96@gmail.com'; // Tu dirección de correo
    $mail->Password = 'ooxd dpjx bqhz badq'; // Tu contraseña o token de aplicación de Gmail
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    // Remitente y destinatario
    $mail->setFrom('tu_correo@gmail.com', 'El´enMoll');
    $mail->addAddress($email);

    // Contenido del correo
    $mail->isHTML(true);
    $mail->CharSet = 'UTF-8';
    $mail->Subject = 'Restablecimiento de contraseña';
    // Cargar el archivo del correo y reemplazar el token
    $correoBody = file_get_contents('correo.php');
    $correoBody = str_replace('{{token}}', $token, $correoBody);
    $mail->Body = $correoBody;

    $mail->send();
    
    // Mensaje de éxito
    $success = 'Correo enviado para restablecer contraseña.';
  } else {
    // Manejar el error de correo no encontrado
    $error = 'Correo electrónico incorrecto.';
  }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>EL´ENMOLL</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light d-flex justify-content-center align-items-center" style="height: 100vh;">

  <div class="card p-4 shadow" style="width: 100%; max-width: 400px;">
    <img src="img/logo.png" alt="" class="p-5">

    <form method="POST"   novalidate>
      <div class="mb-3">
        <label for="usuario" class="form-label">Correo Electronico</label>
        <input type="email" class="form-control" id="email" name="email" required autocomplete="off">
      </div>

      <button type="submit" class="btn btn-light w-100">Restablecer contraseña</button>
    </form>
  </div>
</body>
</html>
