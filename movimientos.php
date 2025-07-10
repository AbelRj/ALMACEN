<?php
include('templates/header.php'); ?>

<form class="row gx-3 gy-3 m-0" method="POST" action="crudM/agregarM.php">
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

  <div class="col-sm-2">
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
  //if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'administrador') { $valorProceso = 'enviado';}
  ?>
  <div class="col-sm-2">
    <label for="proceso" class="form-label">Proceso</label>
    <input type="text" class="form-control" name="proceso" value="<?= $valorProceso ?>" readonly>
  </div>

  <div class="col-12 text-center">
    <button type="submit" class="btn btn-primary mt-2" name="mover">Enviar</button>
  </div>
</form>


<?php include('historialMH.php'); ?>

<?php include('templates/footer.php'); ?>