<?php
include("../bd.php");
session_start();

$rol = $_SESSION['rol'] ?? null;
$fabricaSesion = $_SESSION['fabrica_id'] ?? null;
$usuarioAdmin = $_SESSION['nombre_apellido'] ?? 'Desconocido';

// Obtener todos los movimientos pendientes según el rol
if ($rol === 'supervisor' && $fabricaSesion) {
    $stmt = $conexion->prepare("SELECT id, herramienta_id, destino FROM movimientos WHERE proceso = 'pendiente' AND destino = :fabrica_id");
    $stmt->execute([':fabrica_id' => $fabricaSesion]);
} else {
    $stmt = $conexion->prepare("SELECT id, herramienta_id, destino FROM movimientos WHERE proceso = 'pendiente'");
    $stmt->execute();
}

$movimientos = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($movimientos as $mov) {
    $idMovimiento  = $mov['id'];
    $herramientaId = $mov['herramienta_id'];
    $nuevoDestinoId = $mov['destino'];

    // Aprobar movimiento
    $stmtUpd = $conexion->prepare("UPDATE movimientos SET proceso = 'enviado', aprobado_por = :aprobado_por WHERE id = :id");
    $stmtUpd->execute([':aprobado_por' => $usuarioAdmin, ':id' => $idMovimiento]);

    // Actualizar fábrica de la herramienta
    $stmtHerr = $conexion->prepare("UPDATE herramientas SET id_fabrica = :nuevo_id WHERE id = :id");
    $stmtHerr->execute([':nuevo_id' => $nuevoDestinoId, ':id' => $herramientaId]);

    // Mantener solo los 3 últimos movimientos enviados por herramienta
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
        $stmtDel = $conexion->prepare("DELETE FROM movimientos WHERE id IN ($placeholders)");
        $stmtDel->execute($idsAEliminar);
    }
}

header("Location: ../proceso_envio.php?editado=ok&tipo=enviado");
exit();
