<?php
session_start();

include("../bd.php");
/*Insertar Datos del movimiento de la herramienta*/
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['mover'])) {
  $herramientaId = $_POST['id_herramienta'];
  $nuevoDestinoId = $_POST['destino_id'];
  $proceso = $_POST['proceso'];
  $estadoH = $_POST['estadoH'];
  $origen = $_POST['origen'];
  $enviadoA = $_POST['enviado_a'] ?? null;


  // Obtener el ID de fábrica actual (origen)
  $stmtOrigen = $conexion->prepare("SELECT id_fabrica FROM herramientas WHERE id = :id");
  $stmtOrigen->bindParam(':id', $herramientaId, PDO::PARAM_INT);
  $stmtOrigen->execute();
  $origenId = $stmtOrigen->fetchColumn();

  // Validar que el destino es diferente del origen
  // Validar condiciones especiales para "Otros"
$esMismoDestino = ($origenId == $nuevoDestinoId);
$esOtros = false;

// Consultar si el ID destino es la fábrica "Otros"
$stmtOtros = $conexion->prepare("SELECT nombre_fabrica FROM fabricas WHERE id = :id");
$stmtOtros->execute([':id' => $nuevoDestinoId]);
$nombreDestino = strtolower($stmtOtros->fetchColumn() ?? '');

if ($nombreDestino === 'persona externa') {
    $esOtros = true;
}

// Si no es el mismo destino o es "otros" pero con persona distinta
if (!$esMismoDestino || ($esMismoDestino && $esOtros && !empty($enviadoA))) {
    $esAdmin = isset($_SESSION['rol']) && $_SESSION['rol'] === 'administrador';

    if ($esAdmin) {
        $usuarioAdmin = $_SESSION['nombre_apellido'];

        $stmtMovimiento = $conexion->prepare("
            INSERT INTO movimientos (herramienta_id, origen, destino, persona_destino, fecha_envio, proceso, aprobado_por)
            VALUES (:herramienta_id, :origen, :destino, :persona_destino, NOW(), :proceso, :aprobado_por)
        ");
        $stmtMovimiento->execute([
            ':herramienta_id' => $herramientaId,
            ':destino' => $nuevoDestinoId,
            ':proceso' => $proceso,
            ':aprobado_por' => $usuarioAdmin,
            ':origen' => $origen,
            ':persona_destino' => $enviadoA
        ]);

        $stmtActualizarFabrica = $conexion->prepare("
            UPDATE herramientas SET id_fabrica = :nuevo_id WHERE id = :id
        ");
        $stmtActualizarFabrica->execute([
            ':nuevo_id' => $nuevoDestinoId,
            ':id' => $herramientaId
        ]);
    } else {
        $stmtMovimiento = $conexion->prepare("
            INSERT INTO movimientos (herramienta_id, origen, destino, persona_destino, fecha_envio, proceso)
            VALUES (:herramienta_id, :origen, :destino, :persona_destino, NOW(), :proceso)
        ");
        $stmtMovimiento->execute([
            ':herramienta_id' => $herramientaId,
            ':destino' => $nuevoDestinoId,
            ':proceso' => $proceso,
            ':origen' => $origen,
            ':persona_destino' => $enviadoA
        ]);
    }

    $stmtActualizarEstadoH = $conexion->prepare("
        UPDATE herramientas SET estado = :estado WHERE id = :id
    ");
    $stmtActualizarEstadoH->execute([
        ':estado' => $estadoH,
        ':id' => $herramientaId
    ]);

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
        $stmtEliminar = $conexion->prepare("DELETE FROM movimientos WHERE id IN ($placeholders)");
        $stmtEliminar->execute($idsAEliminar);
    }

    echo "<script>alert('Herramienta movida correctamente'); window.location='../listaHerramientas.php';</script>";
} else {
    echo "<script>alert('La fábrica de destino debe ser diferente a la de origen');</script>";
}
}
?>