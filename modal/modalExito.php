<?php if (isset($_GET['guardado']) || isset($_GET['editado'])): ?>
  <?php
  $tipo = $_GET['tipo'] ?? '';
  $entidad = match ($tipo) {
    'herramienta' => 'La herramienta',
    'usuario' => 'El usuario',
    'fabrica' => 'La fábrica',
    'movimiento' => 'El proceso de envio',
    'enviado' => 'El envio',
    default => 'El registro'
  };
  ?>
  <div class="modal fade" id="modalExito" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-light">
          <h5 class="modal-title">¡Proceso exitoso!</h5>
        </div>
        <div class="modal-body">
          <?= isset($_GET['guardado']) ? "$entidad ha sido guardado correctamente." : "$entidad ha sido actualizado correctamente." ?>
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
      document.getElementById('cerrarModal').addEventListener('click', () => {
        const url = new URL(window.location.href);
        url.search = ''; // Borra ?guardado o ?editado de la URL
        window.history.replaceState({}, document.title, url);
      });
    });
  </script>
<?php endif; ?>