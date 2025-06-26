<?php
include("../bd.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Eliminar la herramienta por su ID
    $sentencia = $conexion->prepare("DELETE FROM herramientas WHERE id = :id");
    $sentencia->bindParam(':id', $id);
    $sentencia->execute();

    // Redirigir de vuelta al listado
    header("Location: ../index.php");
    exit();
} else {
    echo "ID no proporcionado.";
}
?>
