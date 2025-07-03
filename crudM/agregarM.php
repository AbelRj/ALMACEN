<?php
session_start();
include("../bd.php");

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

  $esMismoDestino = ($origenId == $nuevoDestinoId);
  $esOtros = false;

  // Consultar si el ID destino es "persona externa"
  $stmtOtros = $conexion->prepare("SELECT nombre_fabrica FROM fabricas WHERE id = :id");
  $stmtOtros->execute([':id' => $nuevoDestinoId]);
  $nombreDestino = strtolower($stmtOtros->fetchColumn() ?? '');

  if ($nombreDestino === 'persona externa') {
    $esOtros = true;
  }

  // Validación: destino diferente o persona externa con nombre
  if (!$esMismoDestino || ($esMismoDestino && $esOtros && !empty($enviadoA))) {
    // Obtener aprobador (solo si es admin o supervisor)
    $usuarioAprobador = null;
    if (isset($_SESSION['rol']) && in_array($_SESSION['rol'], ['administrador', 'supervisor'])) {
      $usuarioAprobador = $_SESSION['nombre_apellido'] ?? $_SESSION['usuario'] ?? null;
    }

    // Insertar movimiento
    $stmtMovimiento = $conexion->prepare("
      INSERT INTO movimientos (herramienta_id, origen, destino, persona_destino, fecha_envio, proceso, aprobado_por)
      VALUES (:herramienta_id, :origen, :destino, :persona_destino, NOW(), :proceso, :aprobado_por)
    ");
    $stmtMovimiento->execute([
      ':herramienta_id' => $herramientaId,
      ':origen' => $origen,
      ':destino' => $nuevoDestinoId,
      ':persona_destino' => $enviadoA,
      ':proceso' => $proceso,
      ':aprobado_por' => $usuarioAprobador
    ]);

    // Actualizar estado siempre
    $stmtActualizarEstadoH = $conexion->prepare("
      UPDATE herramientas SET estado = :estado WHERE id = :id
    ");
    $stmtActualizarEstadoH->execute([
      ':estado' => $estadoH,
      ':id' => $herramientaId
    ]);

    // ✅ Si es administrador y destino es "persona externa", actualizar también la fábrica
    if ($esOtros && isset($_SESSION['rol']) && $_SESSION['rol'] === 'administrador') {
      $stmtActualizarFabrica = $conexion->prepare("
        UPDATE herramientas SET id_fabrica = :nuevo_id WHERE id = :id
      ");
      $stmtActualizarFabrica->execute([
        ':nuevo_id' => $nuevoDestinoId,
        ':id' => $herramientaId
      ]);
    }

    // Limpiar movimientos antiguos (dejar solo 3 últimos 'enviado')
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
