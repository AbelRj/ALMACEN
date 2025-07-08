<?php
include("../bd.php");

if (isset($_POST['editar']) && isset($_GET['id'])) {
    $id = $_GET['id'];

    $nombreF = $_POST['nombreF'];
    $lugarF = $_POST['lugarF'];

    // Preparar y ejecutar la actualización
    $stmt = $conexion->prepare("UPDATE fabricas SET nombre_fabrica = :nombre, lugar = :lugar WHERE id = :id");
    $stmt->bindParam(':nombre', $nombreF);
    $stmt->bindParam(':lugar', $lugarF);
    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {
        echo "<script>alert('Fábrica actualizada correctamente'); window.location.href='../listaFabricas.php';</script>";

        header("Location: ../listaFabricas.php?editado=ok");
        exit();
    } else {
        echo "<script>alert('Error al actualizar la fábrica');</script>";
    }
}
?>
