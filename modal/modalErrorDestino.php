<?php if (isset($_GET['error']) && in_array($_GET['error'], ['destino_igual', 'sin_destino', 'persona_externa_vacia'])): ?>
  <div class="modal fade" id="modalErrorMovimiento" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog">
      <div class="modal-content border-light">
        <div class="modal-header bg-light">
          <h5 class="modal-title">¡Error en el movimiento!</h5>
        </div>
        <div class="modal-body">
          <?php
          switch ($_GET['error']) {
            case 'destino_igual':
              echo 'El destino no puede ser igual al origen.';
              break;
            case 'sin_destino':
              echo 'Selecciona una fábrica de destino.';
              break;
            case 'persona_externa_vacia':
              echo 'Ingresa el nombre del destinatario externo.';
              break;
          }
          ?>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-light" data-bs-dismiss="modal" id="cerrarModalError">Cerrar</button>
        </div>
      </div>
    </div>
  </div>

  <script>
    window.addEventListener('DOMContentLoaded', () => {
      const modal = new bootstrap.Modal(document.getElementById('modalErrorMovimiento'));
      modal.show();

      document.getElementById('cerrarModalError').addEventListener('click', () => {
        const url = new URL(window.location.href);
        url.searchParams.delete('error');
        window.history.replaceState({}, document.title, url.toString());
      });
    });
  </script>
<?php endif; ?>
