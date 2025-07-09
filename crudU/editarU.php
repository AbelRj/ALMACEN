<?php
include("../bd.php");

$nombreyA = $_POST['nombreyapellidoU'];
$fechaU = $_POST['fechaU'];
$nombreU = $_POST['nombreU'];
$passwordPlano = $_POST['passwordU'];

if (!empty($passwordPlano)) {
    // Si el usuario escribió una nueva contraseña
    $passwordU = password_hash($passwordPlano, PASSWORD_DEFAULT);
} else {
    // Si el input está vacío, mantenemos la contraseña actual
    $stmt = $conexion->prepare("SELECT password FROM usuarios WHERE id = :id");
    $stmt->bindParam(':id', $_GET['id']);
    $stmt->execute();
    $passwordU = $stmt->fetchColumn();
}

$emailU = $_POST['emailU'];
$rolU = $_POST['rolU'];
$fabrica_nombreU = $_POST['fabricaU'];

// Buscar ID de la fábrica
$buscarFabrica = $conexion->prepare("SELECT id FROM fabricas WHERE nombre_fabrica = :nombre");
$buscarFabrica->bindParam(':nombre', $fabrica_nombreU);
$buscarFabrica->execute();
$fabricaRow = $buscarFabrica->fetch(PDO::FETCH_ASSOC);
$idFabrica = $fabricaRow['id'] ?? null;

// Comprobamos que venga el botón 'editar' y el parámetro 'id' por GET
if (isset($_POST['editar']) && isset($_GET['id'])) {
    $id = $_GET['id'];

    $sentencia = $conexion->prepare("UPDATE usuarios SET nombre_apellido = :nombreyA, fecha_nacimiento = :fecha_nacimiento, 
    nombre_usuario = :nombre_usuario, password = :password, email = :email, rol = :rol, fabrica_id = :fabrica_id WHERE id = :id");
    $sentencia->bindParam(':nombreyA', $nombreyA);
    $sentencia->bindParam(':fecha_nacimiento', $fechaU);
    $sentencia->bindParam(':nombre_usuario', $nombreU);
    $sentencia->bindParam(':password', $passwordU);
    $sentencia->bindParam(':email', $emailU);
    $sentencia->bindParam(':rol', $rolU);
    $sentencia->bindParam(':fabrica_id', $idFabrica);
    $sentencia->bindParam(':id', $id);
    $sentencia->execute();

    // Redirigir luego de editar
    header("Location: ../listaUsuarios.php?editado=ok&tipo=usuario");
    exit();
}
