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

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>EL´ENMOLL</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    html, body {
      height: 100%;
      margin: 0;
    }

    .reset-wrapper {
      width: 100%;
      height: 100%;
    }

    .reset-card {
      width: 100%;
      height: 100%;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }

    @media (min-width: 576px) {
      .reset-card {
        max-width: 400px;
        height: auto;
        margin: auto;
      }
    }
  </style>
</head>
<body class="bg-light">

  <div class="container-fluid reset-wrapper d-flex justify-content-center align-items-center">
    <div class="card p-4 shadow reset-card mx-2">
      <img src="img/logo.png" alt="" class="p-5">

      <form method="POST">
        <div class="mb-3">
          <label for="email" class="form-label">Correo Electrónico</label>
          <input type="email" class="form-control" id="email" name="email">
        </div>
        <button type="submit" class="btn btn-light w-100">Restablecer contraseña</button>
      </form>
    </div>
  </div>

  <!-- Modal de éxito -->
  <div class="modal fade" id="successModal" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-light text-white">
          <h5 class="modal-title text-black">Éxito</h5>
        </div>
        <div class="modal-body">
          <p><?= $success ?></p>
        </div>
        <div class="modal-footer">
          <a href="login.php" class="btn btn-light">Ir al login</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal de error -->
  <div class="modal fade" id="errorModal" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-light text-white">
          <h5 class="modal-title text-black">Error</h5>
        </div>
        <div class="modal-body">
          <p><?= $error ?></p>
        </div>
        <div class="modal-footer">
          <button class="btn btn-light" data-bs-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    <?php if ($success): ?>
      const modalSuccess = new bootstrap.Modal(document.getElementById('successModal'));
      modalSuccess.show();
    <?php elseif ($error): ?>
      const modalError = new bootstrap.Modal(document.getElementById('errorModal'));
      modalError.show();
    <?php endif; ?>
  </script>
</body>
</html>
