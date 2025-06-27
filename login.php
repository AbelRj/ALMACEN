<?php
session_start();
include("bd.php");

if (isset($_SESSION["usuario"]) && $_SESSION["usuario"] != null) {
  header("Location: index.php");

  exit();
}
if ($_POST) {
  $usuario = $_POST["usuario"];
  $contrasenia = $_POST["password"];

  $sentencia =$conexion->prepare("SELECT * FROM usuarios WHERE nombre_usuario = :usuario LIMIT 1"); 
  $sentencia->bindParam(":usuario", $usuario);
  $sentencia->execute();
  $user = $sentencia->fetch(PDO::FETCH_ASSOC);

  // Verifica si se encontró el usuario en la base de datos
  if ($user) {
    // Usar password_verify para verificar la contraseña hasheada
    if (password_verify($contrasenia, $user["password"])) {
      $_SESSION["usuario"] = $user["nombre_usuario"];
      $_SESSION["rol"] = $user["rol"]; // Guardar el rol del usuario en la sesión
      $_SESSION["fabrica_id"] = $user["fabrica_id"];
      header("Location: index.php");
      exit();
    }
  }

  // Si no se encontró el usuario o la contraseña no coincide
  echo 'error'; // Devuelve 'error' si falló la autenticación.

  exit();
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

    <form method="POST" action="login.php" >
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
  </div>

  <script>
    const togglePassword = document.getElementById("togglePassword");
    const password = document.getElementById("password");
    const icon = document.getElementById("icono-ojo");

    togglePassword.addEventListener("click", function () {
      const tipo = password.getAttribute("type") === "password" ? "text" : "password";
      password.setAttribute("type", tipo);
      // Cambiar ícono
      icon.classList.toggle("bi-eye");
      icon.classList.toggle("bi-eye-slash");
    });
  </script>

</body>
</html>
