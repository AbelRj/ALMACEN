<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include("bd.php");
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$error = '';
$success = '';

if ($_POST) {
  $email = trim($_POST['email']);

  if (empty($email)) {
    $error = 'Debe ingresar un correo electrónico.';
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $error = 'Debe ingresar un correo electrónico válido.';
  } else {
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

      $mail = new PHPMailer(true);
      $mail->isSMTP();
      $mail->Host = 'smtp.gmail.com';
      $mail->SMTPAuth = true;
      $mail->Username = 'abel.250.96@gmail.com';
      $mail->Password = 'ooxd dpjx bqhz badq';
      $mail->SMTPSecure = 'tls';
      $mail->Port = 587;

      $mail->setFrom('tu_correo@gmail.com', 'El´enMoll');
      $mail->addAddress($email);
      $mail->isHTML(true);
      $mail->CharSet = 'UTF-8';
      $mail->Subject = 'Restablecimiento de contraseña';

      $correoBody = file_get_contents('correo.php');
      $correoBody = str_replace('{{token}}', $token, $correoBody);
      $mail->Body = $correoBody;

      $mail->send();
      $success = 'Correo de restablecimiento enviado.';
    } else {
      $error = 'No se encontró ninguna cuenta asociada a este correo.';
    }
  }
}
?>