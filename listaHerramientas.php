<?php include('templates/header.php'); ?>
<style>
  body {
  overflow-y: scroll;
}
</style>
<div class="table-responsive" id="contenedorHerramientas" style="visibility: hidden;">
  <table id="tablaHerramientas" class="table table-striped table-bordered nowrap" style="width:100%">
    <thead class="table-dark text-center">
      <tr>
        <th>Nombre</th>
        <th>Descripción</th>
        <th>Código</th>
        <th>Estado</th>
        <th>Fabrica</th>
        <th>Acción</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($herramientas as $herramienta): ?>
      <tr>
        <td><?= htmlspecialchars($herramienta['nombre_herramienta'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
        <td><?= htmlspecialchars($herramienta['descripcion'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
        <td><?= htmlspecialchars($herramienta['codigo'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
        <td><?= htmlspecialchars($herramienta['estado'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
        <td><?= htmlspecialchars($herramienta['nombre_fabrica'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
        <td>

        <?php if (isset($_SESSION["rol"]) && $_SESSION["rol"] === "administrador"): ?>
            <a href="formularioHerramienta.php?id=<?= $herramienta['id']; ?>" type="button" class="btn btn-dark">
              <i class="bi bi-pencil"></i>
            </a>
        <?php endif; ?>

        <?php if ((isset($_SESSION["rol"]) && $_SESSION["rol"] === "administrador") || (isset($_SESSION["rol"], $_SESSION["fabrica_id"]) &&
        $_SESSION["rol"] === "supervisor" && $_SESSION["fabrica_id"] == $herramienta["id_fabrica"])): ?>

          <?php if (in_array($herramienta['id'], $pendientes)): ?>
          <!-- Icono de X si hay movimiento pendiente -->
            <button type="button" class="btn btn-secondary" disabled>
              <i class="bi bi-x-lg"></i>
            </button>
          <?php else: ?>
          <!-- Botón de movimiento si no hay pendiente -->
            <a href="movimientos.php?id=<?= $herramienta['id']; ?>" type="button" class="btn btn-light">
              <i class="bi bi-rocket-takeoff"></i>
            </a>
          <?php endif; ?>
        <?php endif; ?>

        <?php if (isset($_SESSION["rol"]) && $_SESSION["rol"] === "administrador"): ?>

          <!-- BOTÓN ELIMINAR -->
          <button type="button" class="btn btn-danger btnEliminar" data-id="<?= $herramienta['id']; ?>">
            <i class="bi bi-trash3"></i>
          </button>


        <?php endif; ?>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<!-- MODAL DE CONFIRMACIÓN DE ELIMINACIÓN -->
<div class="modal fade" id="modalEliminar" tabindex="-1" aria-labelledby="modalEliminarLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-light">
      <div class="modal-header bg-light ">
        <h5 class="modal-title" id="modalEliminarLabel">Confirmar eliminación</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        ¿Estás seguro que deseas eliminar esta herramienta?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <a id="btnConfirmarEliminar" href="#" class="btn btn-danger">Eliminar</a>
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
        <?= isset($_GET['guardado']) ? 'La herramienta ha sido registrada correctamente.' : 'La herramienta ha sido actualizada correctamente.' ?>
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
  const botonesEliminar = document.querySelectorAll('.btnEliminar');
  const modalEliminar = new bootstrap.Modal(document.getElementById('modalEliminar'));
  const btnConfirmarEliminar = document.getElementById('btnConfirmarEliminar');

  botonesEliminar.forEach(boton => {
    boton.addEventListener('click', function () {
      const idHerramienta = this.getAttribute('data-id');
      btnConfirmarEliminar.href = 'crudH/eliminar.php?id=' + idHerramienta;
      modalEliminar.show();
    });
  });
});
</script>

