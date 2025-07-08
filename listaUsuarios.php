<?php
include('templates/header.php');
include('bd.php');


?>
<div class="table-responsive" id="contenedorUsuarios" style="visibility: hidden;">
  <table id="tablaUsuarios" class="table table-striped table-bordered nowrap" style="width:100%">
    <thead class="table-dark text-center">
      <tr>
        <th>Nombre</th>
        <th>Fecha de nacimiento</th>
        <th>Usuario</th>
        <th>Rol</th>
        <th>Email</th>
        <th>Fábrica</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($usuarios as $usuario): ?>
      <tr>
        <td><?= htmlspecialchars($usuario['nombre_apellido'] ?: '---', ENT_QUOTES, 'UTF-8'); ?></td>
<td>
  <?= $usuario['fecha_nacimiento'] && $usuario['fecha_nacimiento'] !== '0000-00-00'
      ? date('d-m-Y', strtotime($usuario['fecha_nacimiento']))
      : '---'; ?>
</td>
        <td><?= htmlspecialchars($usuario['nombre_usuario'] ?: '---', ENT_QUOTES, 'UTF-8'); ?></td>
        <td><?= htmlspecialchars($usuario['rol'] ?: '---', ENT_QUOTES, 'UTF-8'); ?></td>
        <td><?= htmlspecialchars($usuario['email'] ?: '---', ENT_QUOTES, 'UTF-8'); ?></td>
        <td><?= htmlspecialchars($usuario['nombre_fabrica'] ?: '---', ENT_QUOTES, 'UTF-8'); ?></td>

        <td>
          <a href="formularioUsuario.php?id=<?= $usuario['id']; ?>" class="btn btn-dark">
            <i class="bi bi-pencil"></i>
          </a>
<!-- Botón eliminar con modal -->
<button type="button" class="btn btn-danger btnEliminarUsuario"
        data-id="<?= $usuario['id']; ?>"
        data-nombre="<?= htmlspecialchars($usuario['nombre_apellido'], ENT_QUOTES, 'UTF-8'); ?>">
  <i class="bi bi-trash3"></i>
</button>

        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>


<!-- Modal de Confirmación para Usuario -->
<div class="modal fade" id="modalEliminarUsuario" tabindex="-1" aria-labelledby="modalEliminarUsuarioLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-light">
      <div class="modal-header bg-light">
        <h5 class="modal-title" id="modalEliminarUsuarioLabel">Confirmar eliminación</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        ¿Estás seguro que deseas eliminar al usuario <strong id="nombreUsuarioModal"></strong>?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <a id="btnConfirmarEliminarUsuario" href="#" class="btn btn-danger">Eliminar</a>
      </div>
    </div>
  </div>
</div>




<?php if (isset($_GET['guardado']) || isset($_GET['editado'])): ?>
<!-- Modal de éxito -->
<div class="modal fade" id="modalExito" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-light">
        <h5 class="modal-title">¡Proceso exitoso!</h5>
      </div>
      <div class="modal-body">
        <?= isset($_GET['guardado']) ? 'La usuario ha sido registrada correctamente.' : 'La usuario ha sido actualizada correctamente.' ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-light" data-bs-dismiss="modal" id="cerrarModal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<script>
  window.addEventListener('DOMContentLoaded', () => {
    const modal = new bootstrap.Modal(document.getElementById('modalExito'));
    modal.show();

    // Cuando se cierra el modal, limpiamos los parámetros de la URL
    document.getElementById('cerrarModal').addEventListener('click', () => {
      const url = new URL(window.location.href);
      url.search = ''; // Elimina los parámetros
      window.history.replaceState({}, document.title, url);
    });
  });
</script>
<?php endif; ?>


<?php include('templates/footer.php'); ?>



<script>
document.addEventListener('DOMContentLoaded', function () {
  const botones = document.querySelectorAll('.btnEliminarUsuario');
  const modal = new bootstrap.Modal(document.getElementById('modalEliminarUsuario'));
  const btnConfirmar = document.getElementById('btnConfirmarEliminarUsuario');
  const nombreUsuario = document.getElementById('nombreUsuarioModal');

  botones.forEach(boton => {
    boton.addEventListener('click', function () {
      const id = this.getAttribute('data-id');
      const nombre = this.getAttribute('data-nombre');

      btnConfirmar.href = 'crudU/eliminarU.php?id=' + id;
      nombreUsuario.textContent = nombre;

      modal.show();
    });
  });
});
</script>

