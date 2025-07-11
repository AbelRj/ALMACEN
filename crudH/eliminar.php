<?php
include("../bd.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // 1. Obtener los datos de la herramienta antes de eliminarla
    $stmt = $conexion->prepare("SELECT * FROM herramientas WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $herramienta = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($herramienta) {
        // 2. Insertar en la tabla eliminados_herramientas
        $stmtInsert = $conexion->prepare("
            INSERT INTO eliminados_herramientas (nombre_herramienta, descripcion, codigo, fabrica, estado, fecha_eliminacion)
            VALUES (:nombre, :descripcion, :codigo, :fabrica, :estado, NOW())
        ");
        $stmtInsert->execute([
            ':nombre' => $herramienta['nombre_herramienta'],
            ':descripcion' => $herramienta['descripcion'],
            ':codigo' => $herramienta['codigo'],
            ':fabrica' => $herramienta['id_fabrica'],
            ':estado' => $herramienta['estado']
        ]);

        // 3. Eliminar la herramienta
        $stmtDelete = $conexion->prepare("DELETE FROM herramientas WHERE id = :id");
        $stmtDelete->bindParam(':id', $id);
        $stmtDelete->execute();

        header("Location: ../listaHerramientas.php");
        exit();
    } else {
        echo "Herramienta no encontrada.";
    }
} else {
    echo "ID no proporcionado.";
}
?>
