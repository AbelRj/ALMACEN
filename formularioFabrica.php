<?php 
include('templates/header.php'); ?>
    
        <form class="row g-3" method="POST"  action="<?= $esEdicion ? 'crudF/editarF.php?id=' . $idEditar : 'crudF/agregarF.php' ?>">
  <div class="col-12">
    <label for="inputAddress" class="form-label">Nombre </label>
    <input type="text" class="form-control" name="nombreF" placeholder="Nombre"
    value="<?= $fabricaActual['nombre_fabrica'] ?? '' ?>">
  </div>
  <div class="col-12">
    <label for="inputAddress2" class="form-label">Lugar</label>
    <input type="text" class="form-control" name="lugarF" placeholder="Lugar"
    value="<?= $fabricaActual['lugar'] ?? '' ?>">
  </div>

  <div class="col-12">
        <button type="submit" class="btn btn-primary" name="<?= $esEdicion ? 'editar' : 'agregar' ?>">
      <?= $esEdicion ? 'Actualizar' : 'Agregar' ?>
    </button>
  </div>
</form>
<?php include('templates/footer.php'); ?>