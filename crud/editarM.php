<?php
include("../bd.php");

if (isset($_GET['id'])) {
    $idMovimiento = $_GET['id'];

    // 1. Obtener los datos del movimiento: herramienta_id y destino
    $stmtDatos = $conexion->prepare("SELECT herramienta_id, destino FROM movimientos WHERE id = :id");
    $stmtDatos->bindParam(':id', $idMovimiento, PDO::PARAM_INT);
    $stmtDatos->execute();
    $movimiento = $stmtDatos->fetch(PDO::FETCH_ASSOC);

    if ($movimiento) {
        $herramientaId = $movimiento['herramienta_id'];
        $nuevoDestinoId = $movimiento['destino'];

        // 2. Actualizar el estado del proceso
        $stmt = $conexion->prepare("UPDATE movimientos SET proceso = 'enviado' WHERE id = :id");
        $stmt->bindParam(':id', $idMovimiento, PDO::PARAM_INT);
        $stmt->execute();

        // 3. Actualizar la fábrica de la herramienta
        $stmtActualizar = $conexion->prepare("UPDATE herramientas SET id_fabrica = :nuevo_id WHERE id = :id");
        $stmtActualizar->execute([
            ':nuevo_id' => $nuevoDestinoId,
            ':id' => $herramientaId
        ]);

        // 4. Redirigir
        header("Location: ../index.php?proceso=1");
        exit();
    } else {
        echo "Movimiento no encontrado.";
    }
} else {
    echo "ID no proporcionado.";
}
?>
