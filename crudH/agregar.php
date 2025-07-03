<?php
include("../bd.php");
/* AGREGAR HERRAMIENTA */

if (isset($_POST['agregar'])) {
    $nombre = $_POST['nombreH'];
    $descripcion = $_POST['descripcionH'];
    $codigo = $_POST['codigoH'];
    $estado = $_POST['estadoH'];
    $fabrica_nombre = $_POST['fabricaH'];

    // Buscar ID de la fábrica por su nombre
    $stmt = $conexion->prepare("SELECT id FROM fabricas WHERE nombre_fabrica = :nombre");
    $stmt->bindParam(':nombre', $fabrica_nombre);
    $stmt->execute();
    $fabrica = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($fabrica) {
        $id_fabrica = $fabrica['id'];

        // Insertar herramienta
        $insert = $conexion->prepare("
            INSERT INTO herramientas (nombre_herramienta, descripcion, codigo, estado, id_fabrica)
            VALUES (:nombre, :descripcion, :codigo, :estado, :id_fabrica)
        ");
        $insert->bindParam(':nombre', $nombre);
        $insert->bindParam(':descripcion', $descripcion);
        $insert->bindParam(':codigo', $codigo);
        $insert->bindParam(':estado', $estado);
        $insert->bindParam(':id_fabrica', $id_fabrica);
        $insert->execute();

       header("Location: ../listaHerramientas.php?guardado=ok");

exit();
    } else {
        echo "<script>alert('Error: Fábrica no encontrada');</script>";
    }
}
?>
