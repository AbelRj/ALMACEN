<?php 
include('templates/header.php'); ?>
    
        <form class="row g-3" method="POST"  action="<?= $esEdicion ? 'crudU/editarU.php?id=' . $idEditar : 'crudU/agregarU.php' ?>">
  <div class="col-12">
    <label for="inputAddress" class="form-label">Nombre y Apellido</label>
    <input type="text" class="form-control" name="nombreyapellidoU" placeholder="Nombre y apellido"
    value="<?= $usuarioActual['nombre_apellido'] ?? '' ?>">
  </div>
   <div class="col-12">
    <label for="inputAddress" class="form-label">Fecha de nacimiento</label>
    <input type="date" class="form-control" name="fechaU" 
    value="<?= $usuarioActual['fecha_nacimiento'] ?? '' ?>">
  </div>
  <div class="col-12">
    <label for="inputAddress2" class="form-label">Nombre de Usuario</label>
    <input type="text" class="form-control" name="nombreU" placeholder="Nombre de usuario"
    value="<?= $usuarioActual['nombre_usuario'] ?? '' ?>">
  </div>
  <div class="col-md-12">
    <label for="inputCity" class="form-label">Contraseña</label>
<input type="password" class="form-control" name="passwordU" placeholder="Dejar en blanco para mantener contraseña actual">

  </div>
    <div class="col-md-12">
    <label for="inputCity" class="form-label">Correo Electronico</label>
    <input type="text" class="form-control" name="emailU" placeholder="Correo electrónico"
    value="<?= $usuarioActual['email'] ?? '' ?>">
  </div>
  <div class="col-md-4">
    <label for="inputState" class="form-label">Fabrica</label>
<select class="form-select" name="fabricaU">
  <option>Seleccionar</option>
<?php foreach ($fabricas as $fabrica): ?>
  <?php if (strtolower($fabrica['nombre_fabrica']) !== 'persona externa'): ?>
    <option <?= (isset($usuarioActual['nombre_fabrica']) && $fabrica['nombre_fabrica'] == $usuarioActual['nombre_fabrica']) ? 'selected' : '' ?>>
      <?= htmlspecialchars($fabrica['nombre_fabrica'], ENT_QUOTES, 'UTF-8') ?>
    </option>
  <?php endif; ?>
<?php endforeach; ?>

</select>
  </div>
    <div class="col-md-4">
    <label for="inputState" class="form-label">Rol</label>
 <select class="form-select" name="rolU">
      <option <?= (!isset($usuarioActual['rol'])) ? 'selected' : '' ?>>Seleccionar</option>
      <option <?= (isset($usuarioActual['rol']) && $usuarioActual['rol'] == 'supervisor') ? 'selected' : '' ?> value="supervisor">Supervisor</option>
      <option <?= (isset($usuarioActual['rol']) && $usuarioActual['rol'] == 'administrador') ? 'selected' : '' ?> value="administrador">Administrador</option>
    </select>
  </div>

  <div class="col-12">
        <button type="submit" class="btn btn-primary" name="<?= $esEdicion ? 'editar' : 'agregar' ?>">
      <?= $esEdicion ? 'Actualizar' : 'Agregar' ?>
    </button>
    <a href="listaUsuarios.php" class="btn btn-secondary">Cancelar</a>
  </div>
</form>
<?php include('templates/footer.php'); ?>