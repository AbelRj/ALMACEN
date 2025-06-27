<?php
include("bd.php");
//session_start();

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Verifica si el token es válido
    $sql = "SELECT * FROM usuarios WHERE token_reset = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(1, $token);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nueva_contrasenia = password_hash($_POST['newPassword'], PASSWORD_DEFAULT);

            // Actualizar la contraseña en la base de datos
            $sql = "UPDATE usuarios SET password = ?, token_reset = NULL WHERE token_reset = ?";
            $stmt = $conexion->prepare($sql);
            $stmt->bindParam(1, $nueva_contrasenia);
            $stmt->bindParam(2, $token);
            if ($stmt->execute()) {
                // Mostrar modal de éxito con Tabler
                echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        let modal = document.getElementById('successModal');
                        let backdrop = document.getElementById('modalBackdrop');
                        backdrop.style.display = 'block';  // Mostrar fondo opaco
                        modal.style.display = 'block';    // Mostrar modal
                    });
                </script>";
            } else {
                echo "Error al actualizar la contraseña.";
            }
        }
    } else {
        echo "Token no válido o ya usado.";
    }
} else {
    echo "Token no válido.";
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
        <label for="usuario" class="form-label">Nueva contraseña</label>
        <input type="email" class="form-control" id="newPassword" name="newPassword" required autocomplete="off">
      </div>

      <button type="submit" class="btn btn-light w-100">Cambiar Contraseña</button>
    </form>
  </div>
</body>
</html>