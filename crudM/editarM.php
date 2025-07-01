<?php
include("../bd.php");
session_start(); // Asegúrate de tener la sesión iniciada

if (isset($_GET['id'])) {
    $idMovimiento = $_GET['id'];

    // 1. Obtener los datos del movimiento
    $stmtDatos = $conexion->prepare("SELECT herramienta_id, destino FROM movimientos WHERE id = :id");
    $stmtDatos->bindParam(':id', $idMovimiento, PDO::PARAM_INT);
    $stmtDatos->execute();
    $movimiento = $stmtDatos->fetch(PDO::FETCH_ASSOC);

    if ($movimiento) {
        $herramientaId = $movimiento['herramienta_id'];
        $nuevoDestinoId = $movimiento['destino'];

        // 2. Obtener el nombre del administrador
        $usuarioAdmin = $_SESSION['nombre_apellido'] ?? 'Desconocido';

        // 3. Actualizar el movimiento (proceso + aprobado_por)
        $stmt = $conexion->prepare("
            UPDATE movimientos 
            SET proceso = 'enviado', aprobado_por = :aprobado_por 
            WHERE id = :id
        ");
        $stmt->execute([
            ':aprobado_por' => $usuarioAdmin,
            ':id' => $idMovimiento
        ]);

        // 4. Actualizar la fábrica actual de la herramienta
        $stmtActualizar = $conexion->prepare("
            UPDATE herramientas 
            SET id_fabrica = :nuevo_id 
            WHERE id = :id
        ");
        $stmtActualizar->execute([
            ':nuevo_id' => $nuevoDestinoId,
            ':id' => $herramientaId
        ]);

        // 5. Eliminar movimientos antiguos (mantener solo los 3 últimos con proceso = 'enviado')
        $stmtIds = $conexion->prepare("
            SELECT id FROM movimientos
            WHERE herramienta_id = :herramienta_id AND proceso = 'enviado'
            ORDER BY fecha_envio DESC
            LIMIT 18446744073709551615 OFFSET 3
        ");
        $stmtIds->execute([':herramienta_id' => $herramientaId]);
        $idsAEliminar = $stmtIds->fetchAll(PDO::FETCH_COLUMN);

        if (!empty($idsAEliminar)) {
            $placeholders = implode(',', array_fill(0, count($idsAEliminar), '?'));
            $stmtDelete = $conexion->prepare("DELETE FROM movimientos WHERE id IN ($placeholders)");
            $stmtDelete->execute($idsAEliminar);
        }

        // 6. Redirigir
        header("Location: ../index.php?proceso=1");
        exit();
    } else {
        echo "Movimiento no encontrado.";
    }
} else {
    echo "ID no proporcionado.";
}
?>
