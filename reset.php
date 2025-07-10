<!-- PROCESO DE RESET  -->
<?php include("proceso_reset.php"); ?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Cambiar Contraseña | El´enMoll</title>
 <link href="css/bootstrap.min.css" rel="stylesheet">
 <link rel="stylesheet" href="css/bootstrap-icons.css">

</head>

<body class="bg-light d-flex justify-content-center align-items-center" style="height: 100vh;">

  <div class="card p-4 shadow" style="width: 100%; max-width: 400px;">
    <img src="img/logo.png" alt="Logo" class="p-5">

    <form method="POST">
      <div class="mb-3">
        <label for="newPassword" class="form-label">Nueva contraseña</label>
        <div class="input-group">
          <input type="password" class="form-control" id="newPassword" name="newPassword" autocomplete="off">
          <button class="btn btn-outline-secondary" type="button" id="togglePassword">
            <i class="bi bi-eye" id="icono-ojo"></i>
          </button>
        </div>
      </div>
      <button type="submit" class="btn btn-light w-100">Cambiar Contraseña</button>
    </form>
  </div>

  <!-- MODAL DE CONFIRMACIÓN DE EXITO Y DE ERROR -->
  <?php include("modal/modalReset.php"); ?>

  <!-- Ojo para mostrar/ocultar contraseña -->
  <script>
    const btnEye = document.getElementById('togglePassword'),
      pass = document.getElementById('newPassword'),
      icon = document.getElementById('icono-ojo');

    btnEye.addEventListener('click', () => {
      pass.type = pass.type === 'password' ? 'text' : 'password';
      icon.classList.toggle('bi-eye');
      icon.classList.toggle('bi-eye-slash');
    });
  </script>

  <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>