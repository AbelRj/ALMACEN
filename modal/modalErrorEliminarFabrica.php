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