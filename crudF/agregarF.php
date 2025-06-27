<?php
include("../bd.php");

if (isset($_POST['agregar'])) {
   $nombreF = strtoupper($_POST['nombreF']);
    $lugarF = $_POST['lugarF'];

    
    if (!empty($nombreF) && !empty($lugarF)) {
        $insertar = $conexion->prepare("
            INSERT INTO fabricas (nombre_fabrica, lugar)
            VALUES (:nombre, :lugar)
        ");
        $insertar->bindParam(':nombre', $nombreF);
        $insertar->bindParam(':lugar', $lugarF);
        $insertar->execute();

        echo "<script>alert('Fábrica agregada correctamente'); window.location.href='../listaFabricas.php';</script>";
    } else {
        echo "<script>alert('Por favor, complete todos los campos'); window.history.back();</script>";
    }
}
?>
