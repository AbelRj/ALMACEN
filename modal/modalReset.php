<?php if (!empty($mostrarModalExito) || !empty($mostrarModalError)): ?>
  <div class="modal fade" id="modalMensaje" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header <?= !empty($mostrarModalExito) ? 'bg-success' : 'bg-danger' ?>">
          <h5 class="modal-title text-white">
            <?= !empty($mostrarModalExito) ? '¡Contraseña cambiada!' : 'Error' ?>
          </h5>
        </div>
        <div class="modal-body">
          <?= !empty($mostrarModalExito)
            ? 'Tu contraseña ha sido actualizada correctamente.<br>Puedes cerrar esta pestaña e iniciar sesión en la anterior.'
            : htmlspecialchars($mensajeError)
          ?>
        </div>
        <div class="modal-footer">
          <?php if (!empty($mostrarModalExito)): ?>
            <button type="button" class="btn btn-success" onclick="window.close()">Cerrar</button>
          <?php else: ?>
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>

  <script>
    window.addEventListener('DOMContentLoaded', () => {
      const modal = new bootstrap.Modal(document.getElementById('modalMensaje'));
      modal.show();
    });
  </script>
<?php endif; ?>
