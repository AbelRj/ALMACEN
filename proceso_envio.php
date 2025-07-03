<?php include('templates/header.php'); ?>

  <!-- TABLA DE MOVIMIENTOS -->
  <div class="table-responsive" id="contenedorMovimientos" style="visibility: hidden;">
    <table id="tablaMovimientos" class="table table-striped table-bordered nowrap" style="width:100%">
      <thead class="table-dark text-center">
        <tr>
          <th>Herramienta</th>
          <th>Estado</th>
          <th>Origen</th>
          <th>Destino</th>
          <th>Fecha de envío</th>
          <th>Proceso</th>
          <th>Acción</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($movimientos as $mov): ?>
        <tr>
          <td><?= htmlspecialchars($mov['nombre_herramienta'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
          <td><?= htmlspecialchars($mov['estado'] ?? '---', ENT_QUOTES, 'UTF-8'); ?></td>
          <td><?= htmlspecialchars($mov['origen_nombre'] ?? '---', ENT_QUOTES, 'UTF-8'); ?></td>
          <td><?= htmlspecialchars($mov['destino_nombre'] ?? '---', ENT_QUOTES, 'UTF-8'); ?></td>
          <td><?= htmlspecialchars($mov['fecha_envio'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
          <td><?= htmlspecialchars($mov['proceso'] ?? '---', ENT_QUOTES, 'UTF-8'); ?></td>
          <td>
              <a href="crudM/editarM.php?id=<?= $mov['id']; ?>" type="button" class="btn btn-primary">
                <i class="bi bi-check-lg"></i>
              </a>
          
<!-- Botón eliminar con modal -->
<button type="button" class="btn btn-danger btnEliminarMovimiento"
        data-id="<?= $mov['id']; ?>"
        data-herramienta="<?= htmlspecialchars($mov['nombre_herramienta'], ENT_QUOTES, 'UTF-8'); ?>">
  <i class="bi bi-trash3"></i>
</button>

          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>


<!-- Modal de Confirmación para Movimiento -->
<div class="modal fade" id="modalEliminarMovimiento" tabindex="-1" aria-labelledby="modalEliminarMovimientoLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-light">
      <div class="modal-header bg-light">
        <h5 class="modal-title" id="modalEliminarMovimientoLabel">Confirmar eliminación</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        ¿Estás seguro que deseas eliminar el movimiento de la herramienta <strong id="nombreMovimientoModal"></strong>?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <a id="btnConfirmarEliminarMovimiento" href="#" class="btn btn-danger">Eliminar</a>
      </div>
    </div>
  </div>
</div>



  <?php include('templates/footer.php'); ?>






  <script>
document.addEventListener('DOMContentLoaded', function () {
  const botones = document.querySelectorAll('.btnEliminarMovimiento');
  const modal = new bootstrap.Modal(document.getElementById('modalEliminarMovimiento'));
  const btnConfirmar = document.getElementById('btnConfirmarEliminarMovimiento');
  const nombreHerramienta = document.getElementById('nombreMovimientoModal');

  botones.forEach(boton => {
    boton.addEventListener('click', function () {
      const id = this.getAttribute('data-id');
      const nombre = this.getAttribute('data-herramienta');

      btnConfirmar.href = 'crudM/eliminarM.php?id=' + id;
      nombreHerramienta.textContent = nombre;

      modal.show();
    });
  });
});
</script>
