<?php
if (isset($herramientaActual['id'])) {
  $idHerramienta = $herramientaActual['id'];

  $stmtMovimientos = $conexion->prepare("
    SELECT 
        m.*, 
        h.nombre_herramienta,
        f1.nombre_fabrica AS origen_nombre,
        f2.nombre_fabrica AS destino_nombre
    FROM movimientos m
    LEFT JOIN herramientas h ON m.herramienta_id = h.id
    LEFT JOIN fabricas f1 ON m.origen = f1.id
    LEFT JOIN fabricas f2 ON m.destino = f2.id
    WHERE m.herramienta_id = :id
    ORDER BY m.fecha_envio DESC
");
  $stmtMovimientos->execute([':id' => $idHerramienta]);
  $movimientosHerramienta = $stmtMovimientos->fetchAll(PDO::FETCH_ASSOC);

  if ($movimientosHerramienta):
?>
    <hr>
    <h5 class="mt-4">Historial de Movimientos de la Herramienta: <?= htmlspecialchars($herramientaActual['nombre_herramienta'] ?? '') ?></h5>
    <div class="table-responsive">
      <table class="table table-bordered table-striped table-sm">
        <thead class="table-dark text-center">
          <tr>
            <th>Herramienta</th>
            <th>Origen</th>
            <th>Destino</th>
            <th>Fecha de Envío</th>
            <th>Aprobado por</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($movimientosHerramienta as $mov): ?>
            <tr>
              <td><?= htmlspecialchars($mov['nombre_herramienta'] ?? '---') ?></td>
              <td><?= htmlspecialchars($mov['origen_nombre'] ?? '---') ?></td>
              <td>
                <?php
                $nombreDestino = strtolower($mov['destino_nombre'] ?? '');
                if ($nombreDestino === 'persona externa' && !empty($mov['persona_destino'])) {
                  echo htmlspecialchars($mov['persona_destino']);
                } else {
                  echo htmlspecialchars($mov['destino_nombre'] ?? '---');
                }
                ?>
              </td>

              <td><?= htmlspecialchars($mov['fecha_envio'] ?? '---') ?></td>
              <td><?= htmlspecialchars($mov['aprobado_por'] ?? '---') ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
<?php
  else:
    echo "<p class='text-muted mt-4'>Esta herramienta aún no tiene movimientos registrados.</p>";
  endif;
}
?>