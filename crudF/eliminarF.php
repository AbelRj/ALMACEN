<?php
include("../bd.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        $sentencia = $conexion->prepare("DELETE FROM fabricas WHERE id = :id");
        $sentencia->bindParam(':id', $id);
        $sentencia->execute();

        header("Location: ../listaFabricas.php?eliminado=fabrica");
        exit();
    } catch (PDOException $e) {
        // Si el error es por restricción de clave foránea
        if ($e->getCode() === '23000') {
            header("Location: ../listaFabricas.php?error=dependencias");
            exit();
        } else {
            echo "Error inesperado: " . $e->getMessage();
        }
    }
} else {
    echo "ID no proporcionado.";
}
