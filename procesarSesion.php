<?php
session_start();
include("bd.php");

// Redirigir si ya está logueado
if (isset($_SESSION["usuario"]) && $_SESSION["usuario"] != null) {
  header("Location: index.php");
  exit();
}

// Si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $usuario = $_POST["usuario"];
  $contrasenia = $_POST["password"];

  $sentencia = $conexion->prepare("SELECT * FROM usuarios WHERE nombre_usuario = :usuario LIMIT 1");
  $sentencia->bindParam(":usuario", $usuario);
  $sentencia->execute();
  $user = $sentencia->fetch(PDO::FETCH_ASSOC);

  if ($user) {
    if (password_verify($contrasenia, $user["password"])) {
      $_SESSION["usuario"] = $user["nombre_usuario"];
      $_SESSION["nombre_apellido"] = $user["nombre_apellido"];
      $_SESSION["rol"] = $user["rol"];
      $_SESSION["fabrica_id"] = $user["fabrica_id"];
      header("Location: index.php");
      exit();
    } else {
      $_SESSION["error_login"] = "Error en la contraseña.";
      $_SESSION["error_tipo"] = "password";
      $_SESSION["login_usuario"] = $usuario;
    }
  } else {
    $_SESSION["error_login"] = "Usuario y contraseña incorrecta.";
    $_SESSION["error_tipo"] = "usuario";
  }

  // Redirigir para evitar reenviar formulario al actualizar
  header("Location: login.php");
  exit();
}
