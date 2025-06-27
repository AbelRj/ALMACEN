<?php
// Consulta de usuarios
$sentenciaUsuario = $conexion->prepare("
    SELECT u.id, u.nombre_apellido,u.fecha_nacimiento,  u.nombre_usuario, u.rol, u.email, f.nombre_fabrica
    FROM usuarios u
    LEFT JOIN fabricas f ON u.fabrica_id = f.id
");
$sentenciaUsuario->execute(); 
$usuarios = $sentenciaUsuario->fetchAll(PDO::FETCH_ASSOC);


/*TRAER DATOS MEDIANTE EL ID DEL USUARIO*/
      $esEdicion = false;
      $usuarioActual = null;

            if (isset($_GET['id'])) {
          $esEdicion = true;
          $idEditar = $_GET['id'];

          $consulta = $conexion->prepare("
              SELECT u.*, f.nombre_fabrica 
              FROM usuarios u 
              JOIN fabricas f ON u.fabrica_id = f.id 
              WHERE u.id = :id
          ");
          $consulta->bindParam(':id', $idEditar);
          $consulta->execute();
          $usuarioActual = $consulta->fetch(PDO::FETCH_ASSOC);
      }

?>