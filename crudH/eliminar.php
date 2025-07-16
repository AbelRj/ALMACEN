<?php
session_start();
include("../bd.php");
$usuarioEliminador = $_SESSION['usuario'] ?? 'desconocido';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'], $_POST['motivo'])) {
    $id = $_POST['id'];
    $motivo = trim($_POST['motivo']);

    // Obtener los datos antes de eliminar
    $stmt = $conexion->prepare("SELECT * FROM herramientas WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $herramienta = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($herramienta) {
        // Insertar en la tabla de eliminados
        $stmtInsert = $conexion->prepare("
            INSERT INTO eliminados_herramientas 
            (nombre_herramienta, descripcion, codigo, fabrica, estado, motivo, fecha_eliminacion, eliminado_por)
            VALUES (:nombre, :descripcion, :codigo, :fabrica, :estado, :motivo, NOW(), :eliminado_por)
        ");
        $stmtInsert->execute([
            ':nombre' => $herramienta['nombre_herramienta'],
            ':descripcion' => $herramienta['descripcion'],
            ':codigo' => $herramienta['codigo'],
            ':fabrica' => $herramienta['id_fabrica'],
            ':estado' => $herramienta['estado'],
            ':motivo' => $motivo,
            ':eliminado_por' => $usuarioEliminador
        ]);

        // Eliminar de herramientas
        $stmtDelete = $conexion->prepare("DELETE FROM herramientas WHERE id = :id");
        $stmtDelete->bindParam(':id', $id);
        $stmtDelete->execute();

        header("Location: ../listaHerramientas.php?eliminado=herramienta");
        exit();
    } else {
        echo "Herramienta no encontrada.";
    }
} else {
    echo "Datos incompletos.";
}
