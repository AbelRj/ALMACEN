<?php
include('templates/header.php');
include('bd.php');
?>
<div class="table-responsive" id="contenedorFabricas" style="visibility: hidden;">
  <table id="tablaFabricas" class="table table-striped table-bordered nowrap" style="width:100%">
    <thead class="table-dark text-center">
      <tr>
        <th>Nombre</th>
        <th>Lugar</th>
        <th>Acciones</th>
      </tr>
    </thead>
<tbody>
  <?php foreach ($fabricas as $usuario): ?>
    <?php if (strtolower(trim($usuario['nombre_fabrica'])) === 'persona externa') continue; ?>
    <tr>
      <td><?= htmlspecialchars($usuario['nombre_fabrica'] ?: '---', ENT_QUOTES, 'UTF-8'); ?></td>
      <td><?= htmlspecialchars($usuario['lugar'] ?: '---', ENT_QUOTES, 'UTF-8'); ?></td>

      <td>
        <a href="formularioFabrica.php?id=<?= $usuario['id']; ?>" class="btn btn-dark">
          <i class="bi bi-pencil"></i>
        </a>
<!-- Botón Eliminar con Modal -->
<button type="button" class="btn btn-danger btnEliminarFabrica"
        data-id="<?= $usuario['id']; ?>"
        data-nombre="<?= htmlspecialchars($usuario['nombre_fabrica'], ENT_QUOTES, 'UTF-8'); ?>">
  <i class="bi bi-trash3"></i>
</button>

      </td>
    </tr>
  <?php endforeach; ?>
</tbody>

  </table>
</div>


<!-- Modal de Confirmación para Fabricas -->
<div class="modal fade" id="modalEliminarFabrica" tabindex="-1" aria-labelledby="modalEliminarFabricaLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-light">
      <div class="modal-header bg-light">
        <h5 class="modal-title" id="modalEliminarFabricaLabel">Confirmar eliminación</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        ¿Estás seguro que deseas eliminar la fábrica <strong id="nombreFabricaModal"></strong>?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <a id="btnConfirmarEliminarFabrica" href="#" class="btn btn-danger">Eliminar</a>
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
        <?= isset($_GET['guardado']) ? 'La fabrica ha sido registrada correctamente.' : 'La fabrica ha sido actualizada correctamente.' ?>
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


<?php if (isset($_GET['error']) && $_GET['error'] === 'dependencias'): ?>
<!-- Modal de error por dependencia -->
<div class="modal fade" id="modalErrorDependencias" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
  <div class="modal-dialog">
    <div class="modal-content border-light">
      <div class="modal-header bg-light">
        <h5 class="modal-title">Error al eliminar</h5>
      </div>
      <div class="modal-body">
        No se puede eliminar la fábrica porque tiene herramientas asociadas.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-light" data-bs-dismiss="modal" id="cerrarModalError">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<script>
  window.addEventListener('DOMContentLoaded', () => {
    const modal = new bootstrap.Modal(document.getElementById('modalErrorDependencias'));
    modal.show();

    // Limpiar parámetros al cerrar
    document.getElementById('cerrarModalError').addEventListener('click', () => {
      const url = new URL(window.location.href);
      url.search = '';
      window.history.replaceState({}, document.title, url);
    });
  });
</script>
<?php endif; ?>





<?php include('templates/footer.php'); ?>


<script>
document.addEventListener('DOMContentLoaded', function () {
  const botonesEliminar = document.querySelectorAll('.btnEliminarFabrica');
  const modal = new bootstrap.Modal(document.getElementById('modalEliminarFabrica'));
  const btnConfirmar = document.getElementById('btnConfirmarEliminarFabrica');
  const nombreFabrica = document.getElementById('nombreFabricaModal');

  botonesEliminar.forEach(boton => {
    boton.addEventListener('click', function () {
      const id = this.getAttribute('data-id');
      const nombre = this.getAttribute('data-nombre');

      btnConfirmar.href = 'crudF/eliminarF.php?id=' + id;
      nombreFabrica.textContent = nombre;

      modal.show();
    });
  });
});
</script>

