<?php
/* TRAER DATOS MEDIANTE EL ID DE LA FÁBRICA */
$esEdicion = false;
$fabricaActual = null;

if (isset($_GET['id'])) {
    $esEdicion = true;
    $idEditar = $_GET['id'];

    $consulta = $conexion->prepare("
        SELECT * FROM fabricas WHERE id = :id
    ");
    $consulta->bindParam(':id', $idEditar, PDO::PARAM_INT);
    $consulta->execute();
    $fabricaActual = $consulta->fetch(PDO::FETCH_ASSOC);
}

?>