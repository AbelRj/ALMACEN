<?php
session_start(); // ¡ESTO ES NECESARIO!
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>EL´ENMOLL</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    html, body {
      height: 100%;
      margin: 0;
    }

    .login-wrapper {
      width: 100%;
      height: 100%;
    }

    .login-card {
      width: 100%;
      height: 100%;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }

    @media (min-width: 576px) {
      .login-card {
        max-width: 400px;
        height: auto;
        margin: auto;
      }
    }
  </style>
</head>
<body class="bg-light">

  <div class="container-fluid login-wrapper d-flex justify-content-center align-items-center">
    <div class="card p-4 shadow login-card mx-2">
      <img src="img/logo.png" alt="" class="p-5">

      <form method="POST" action="procesarSesion.php">
        <div class="mb-3">
          <label for="usuario" class="form-label">Usuario</label>
          <input type="text" class="form-control" id="usuario" name="usuario" required autocomplete="off">
        </div>

        <div class="mb-3">
          <label for="password" class="form-label">Contraseña</label>
          <div class="input-group">
            <input type="password" class="form-control" id="password" name="password" required autocomplete="off">
            <button class="btn btn-outline-secondary" type="button" id="togglePassword">
              <i class="bi bi-eye" id="icono-ojo"></i>
            </button>
          </div>
        </div>

        <button type="submit" class="btn btn-light w-100">Entrar</button>
      </form>

      <?php if (isset($_SESSION["error_login"])): ?>
        <div class="alert alert-danger mt-3" role="alert">
          <?= $_SESSION["error_login"]; ?>
          <?php unset($_SESSION["error_login"]); ?>
        </div>
      <?php endif; ?>

      <a href="restablecer.php" class="mt-2 d-block text-decoration-none">¿Se olvidó su contraseña?</a>
    </div>
  </div>

  <script>
    const togglePassword = document.getElementById("togglePassword");
    const password = document.getElementById("password");
    const icon = document.getElementById("icono-ojo");

    togglePassword.addEventListener("click", function () {
      const tipo = password.getAttribute("type") === "password" ? "text" : "password";
      password.setAttribute("type", tipo);
      icon.classList.toggle("bi-eye");
      icon.classList.toggle("bi-eye-slash");
    });
  </script>

</body>
</html>
