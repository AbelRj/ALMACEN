<?php 
include('templates/header.php'); ?>

<form class="row gx-3 gy-3 m-0"  method="POST" action="crudM/agregarM.php">
  <input type="hidden" name="id_herramienta" value="<?= $herramientaActual['id'] ?? '' ?>">
  <div class="col-sm-2">
    <label for="nombreHerramienta" class="form-label">Nombre:</label>
    <input type="text" class="form-control" id="nombreHerramienta" placeholder="Nombre de la herramienta"
      value="<?= $herramientaActual['nombre_herramienta'] ?? '' ?>">
  </div>

  <div class="col-sm-2">
    <label for="codigoHerramienta" class="form-label">Código:</label>
    <input type="text" class="form-control" id="codigoHerramienta" placeholder="Código"
      value="<?= $herramientaActual['codigo'] ?? '' ?>">
  </div>

    <div class="col-sm-1">
    <label for="origenHerramienta" class="form-label">Estado</label>
    <select class="form-select" name="estadoH">
      <option <?= (isset($herramientaActual['estado']) && $herramientaActual['estado'] == 'bueno') ? 'selected' : '' ?> value="bueno">Bueno</option>
      <option <?= (isset($herramientaActual['estado']) && $herramientaActual['estado'] == 'malo') ? 'selected' : '' ?> value="malo">Malo</option>
    </select>
  </div>

  <div class="col-sm-2">
    <label for="origenHerramienta" class="form-label">Origen:</label>
    <input type="text" class="form-control" id="origenHerramienta" placeholder="Origen" 
      value="<?= $herramientaActual['nombre_fabrica'] ?? '' ?>">
    <input type="hidden" name="origen" value="<?= $herramientaActual['id_fabrica'] ?? '' ?>">
  </div>

  <div class="col-sm-2">
    <label for="origenHerramienta" class="form-label">Destino:</label>
      <select class="form-select" name="destino_id" required>
      <option>Seleccionar</option>
      <?php foreach ($fabricas as $fabrica): ?>
      <option value="<?= $fabrica['id'] ?>">
      <?= htmlspecialchars($fabrica['nombre_fabrica'], ENT_QUOTES, 'UTF-8') ?>
      </option>
     <?php endforeach; ?>
      </select>
  </div>


  <div class="col-sm-2" id="campoEnviadoA" style="display:none;">
    <label for="enviado_a" class="form-label">Persona Externa:</label>
    <input type="text" class="form-control" name="enviado_a" id="enviado_a" placeholder="Nombre destino alternativo">
  </div>


<?php
$valorProceso = 'pendiente'; // Valor por defecto
if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'administrador') { $valorProceso = 'enviado';}
?>
<div class="col-sm-1">
  <label for="proceso" class="form-label">Proceso</label>
  <input type="text" class="form-control" name="proceso" value="<?= $valorProceso ?>" readonly>
</div>


<div class="col-12 text-center">
    <button type="submit" class="btn btn-primary mt-2" name="mover">Enviar</button>
</div>
</form>


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


<?php 
include('templates/footer.php'); ?>