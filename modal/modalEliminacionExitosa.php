<?php if (isset($_GET['eliminado'])): ?>
  <div class="modal fade" id="modalExito" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-light">
          <h5 class="modal-title">¡Eliminación exitosa!</h5>
        </div>
        <div class="modal-body">
          <?php
            $tipo = $_GET['eliminado'];
            switch ($tipo) {
              case 'herramienta':
                echo "La herramienta ha sido eliminada correctamente.";
                break;
              case 'fabrica':
                echo "La fábrica ha sido eliminada correctamente.";
                break;
              case 'usuario':
                echo "El usuario ha sido eliminado correctamente.";
                break;
              default:
                echo "El elemento ha sido eliminado correctamente.";
            }
          ?>
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
        url.search = ''; // Limpia la URL
        window.history.replaceState({}, document.title, url);
      });
    });
  </script>
<?php endif; ?>
