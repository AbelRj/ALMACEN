<?php
include("bd.php");

$mostrarModalExito  = false;
$mostrarModalError  = false;
$mensajeError       = '';

if (isset($_GET['token'])) {
  $token = $_GET['token'];

  // ¿Existe el token?
  $stmt = $conexion->prepare("SELECT * FROM usuarios WHERE token_reset = ?");
  $stmt->execute([$token]);
  $user = $stmt->fetch(PDO::FETCH_ASSOC);

  if (!$user) {
    exit("Token no válido o ya usado.");
  }

  // ¿Llegó el formulario?
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $clavePlano = trim($_POST['newPassword'] ?? '');

    // Validación: campo vacío
    if ($clavePlano === '') {
      $mensajeError      = 'Debes introducir una nueva contraseña.';
      $mostrarModalError = true;
    } else {
      $claveHash = password_hash($clavePlano, PASSWORD_DEFAULT);

      // Guardar y limpiar el token
      $sql = "UPDATE usuarios SET password = ?, token_reset = NULL WHERE token_reset = ?";
      $ok  = $conexion->prepare($sql)->execute([$claveHash, $token]);

      if ($ok) {
        $mostrarModalExito = true;
      } else {
        $mensajeError      = 'Error al actualizar la contraseña.';
        $mostrarModalError = true;
      }
    }
  }
} else {
  exit("Token no proporcionado.");
}
?>