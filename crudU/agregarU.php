<?php
include("../bd.php");
/* AGREGAR USUARIO */

if (isset($_POST['agregar'])) {
    $nombreyA = $_POST['nombreyapellidoU'];
    $nombreU = $_POST['nombreU'];
    $passwordU = $_POST['passwordU'];
    $emailU = $_POST['emailU'];
    $rolU = $_POST['rolU'];
    $fabrica_nombreU = $_POST['fabricaU'];

    // Buscar ID de la fábrica por su nombre
    $stmt = $conexion->prepare("SELECT id FROM fabricas WHERE nombre_fabrica = :nombre");
    $stmt->bindParam(':nombre', $fabrica_nombreU);
    $stmt->execute();
    $fabrica = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($fabrica) {
        $id_fabrica = $fabrica['id'];

        // Insertar herramienta
        $insert = $conexion->prepare("
            INSERT INTO usuarios (nombre_apellido, nombre_usuario, password, email, rol, fabrica_id)
            VALUES (:nombre_apellido, :nombre_usuario, :password, :email, :rol, :fabrica_id)
        ");
        $insert->bindParam(':nombre_apellido', $nombreyA);
        $insert->bindParam(':nombre_usuario', $nombreU);
        $insert->bindParam(':password', $passwordU);
        $insert->bindParam(':email', $emailU);
        $insert->bindParam(':rol', $rolU);
        $insert->bindParam(':fabrica_id', $id_fabrica);
        $insert->execute();

        echo "<script>alert('Usuario creado con éxito'); window.location.href='../index.php';</script>";
    } else {
        echo "<script>alert('Error: Fábrica no encontrada');</script>";
    }
}
?>
