<?php
include("../bd.php");

if (isset($_POST['editar']) && isset($_GET['id'])) {
    $id = $_GET['id'];

    $nombreF = strtoupper($_POST['nombreF']);
    $lugarF =strtolower($_POST['lugarF']);

    // Preparar y ejecutar la actualización
    $stmt = $conexion->prepare("UPDATE fabricas SET nombre_fabrica = :nombre, lugar = :lugar WHERE id = :id");
    $stmt->bindParam(':nombre', $nombreF);
    $stmt->bindParam(':lugar', $lugarF);
    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {

        header("Location: ../listaFabricas.php?editado=ok&tipo=fabrica");
        exit();
    } else {
        echo "<script>alert('Error al actualizar la fábrica');</script>";
    }
}
