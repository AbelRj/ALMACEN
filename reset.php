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
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Cambiar Contraseña | El´enMoll</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light d-flex justify-content-center align-items-center" style="height: 100vh;">

  <div class="card p-4 shadow" style="width: 100%; max-width: 400px;">
    <img src="img/logo.png" alt="Logo" class="p-5">

    <form method="POST">
      <div class="mb-3">
        <label for="newPassword" class="form-label">Nueva contraseña</label>
        <div class="input-group">
          <input type="password" class="form-control" id="newPassword" name="newPassword"  autocomplete="off">
          <button class="btn btn-outline-secondary" type="button" id="togglePassword">
            <i class="bi bi-eye" id="icono-ojo"></i>
          </button>
        </div>
      </div>
      <button type="submit" class="btn btn-light w-100">Cambiar Contraseña</button>
    </form>
  </div>

  <!-- Modal Éxito -->
  <div class="modal fade" id="successModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog ">
      <div class="modal-content">
        <div class="modal-header bg-light text-black">
          <h5 class="modal-title">¡Contraseña cambiada!</h5>
        </div>
        <div class="modal-body">
          Tu contraseña ha sido actualizada correctamente.<br>
          Puedes cerrar esta pestaña e iniciar sesión en la anterior.
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-light" onclick="window.close()">Cerrar</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Error -->
  <div class="modal fade" id="errorModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog ">
      <div class="modal-content">
        <div class="modal-header bg-light text-black">
          <h5 class="modal-title">Error</h5>
        </div>
        <div class="modal-body">
          <?= htmlspecialchars($mensajeError) ?>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Mostrar el modal correspondiente -->
  <?php if ($mostrarModalExito): ?>
    <script>new bootstrap.Modal('#successModal').show();</script>
  <?php elseif ($mostrarModalError): ?>
    <script>new bootstrap.Modal('#errorModal').show();</script>
  <?php endif; ?>

  <!-- Ojo para mostrar/ocultar contraseña -->
  <script>
    const btnEye = document.getElementById('togglePassword'),
          pass   = document.getElementById('newPassword'),
          icon   = document.getElementById('icono-ojo');

    btnEye.addEventListener('click', () => {
      pass.type = pass.type === 'password' ? 'text' : 'password';
      icon.classList.toggle('bi-eye');
      icon.classList.toggle('bi-eye-slash');
    });
  </script>
</body>
</html>
