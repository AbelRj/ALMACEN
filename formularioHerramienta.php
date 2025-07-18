<?php
include('templates/header.php'); ?>

<form class="row g-3" id="formHerramienta" method="POST" action="<?= $esEdicion ? 'crudH/editar.php?id=' . $idEditar : 'crudH/agregar.php' ?>">
  <div class="col-12">
    <label for="inputAddress" class="form-label">Nombre</label>
    <input type="text" class="form-control" name="nombreH" placeholder="Nombre de la herramienta"
      value="<?= $herramientaActual['nombre_herramienta'] ?? '' ?>" required>
  </div>
  <div class="col-12">
    <label for="inputAddress2" class="form-label">Descripción</label>
    <input type="text" class="form-control" name="descripcionH" placeholder="Descripción"
      value="<?= $herramientaActual['descripcion'] ?? '' ?>" required>
  </div>
  <div class="col-md-4">
    <label for="inputCity" class="form-label">Codigo</label>
    <input type="text" class="form-control" name="codigoH" placeholder="Codigo"
      value="<?= $herramientaActual['codigo'] ?? '' ?>" required>
  </div>
  <div class="col-md-4">
    <label for="inputState" class="form-label">Estado</label>
    <select class="form-select" name="estadoH" required>
      <option <?= (!isset($herramientaActual['estado'])) ? 'selected' : '' ?>>Seleccionar</option>
      <option <?= (isset($herramientaActual['estado']) && $herramientaActual['estado'] == 'bueno') ? 'selected' : '' ?> value="bueno">Bueno</option>
      <option <?= (isset($herramientaActual['estado']) && $herramientaActual['estado'] == 'malo') ? 'selected' : '' ?> value="malo">Malo</option>
    </select>
  </div>
  <div class="col-md-4">
    <label for="inputState" class="form-label">Fabrica</label>
    <select class="form-select" name="fabricaH" required>
      <option>Seleccionar</option>
      <?php foreach ($fabricas as $fabrica): ?>
        <?php if (strtolower($fabrica['nombre_fabrica']) !== 'persona externa'): ?>
          <option <?= (isset($herramientaActual['nombre_fabrica']) && $fabrica['nombre_fabrica'] == $herramientaActual['nombre_fabrica']) ? 'selected' : '' ?>>
            <?= htmlspecialchars($fabrica['nombre_fabrica'], ENT_QUOTES, 'UTF-8') ?>
          </option>
        <?php endif; ?>
      <?php endforeach; ?>

    </select>
  </div>

  <div class="col-12">
    <button type="submit" class="btn btn-primary" name="<?= $esEdicion ? 'editar' : 'agregar' ?>" value="1">
      <?= $esEdicion ? 'Actualizar' : 'Agregar' ?>
    </button>



    <a href="listaHerramientas.php" class="btn btn-secondary">Cancelar</a>
  </div>
</form>


<?php include('templates/footer.php'); ?>

<script>

</script>