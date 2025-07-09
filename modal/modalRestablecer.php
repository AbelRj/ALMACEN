<?php if (!empty($success) || !empty($error)): ?>
  <div class="modal fade" id="modalMensaje" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header <?= !empty($success) ? 'bg-success' : 'bg-danger' ?>">
          <h5 class="modal-title text-white">
            <?= !empty($success) ? 'Éxito' : 'Error' ?>
          </h5>
        </div>
        <div class="modal-body">
          <p><?= !empty($success) ? $success : $error ?></p>
        </div>
        <div class="modal-footer">
          <?php if (!empty($success)): ?>
            <a href="login.php" class="btn btn-success">Ir al login</a>
          <?php else: ?>
            <button class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
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
