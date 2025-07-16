<!-- MODAL DE CONFIRMACIÓN DE ELIMINACIÓN CON INPUT DE MOTIVO (solo para herramientas) -->
<div class="modal fade" id="modalEliminar" tabindex="-1" aria-labelledby="modalEliminarLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
  <div class="modal-dialog modal-dialog-centered">
    <form id="formEliminar" method="POST" action="">
      <div class="modal-content border-light">
        <div class="modal-header bg-light">
          <h5 class="modal-title" id="modalEliminarLabel">Confirmar eliminación</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          ¿Estás seguro que deseas eliminar <strong id="nombreElementoModal"></strong>?
          <input type="hidden" name="id" id="idHerramientaEliminar">

          <!-- Campo motivo (solo visible para herramientas) -->
          <div class="form-group mt-3" id="motivoGroup" style="display: none;">
            <label for="motivo">Motivo de eliminación:</label>
            <input type="text" class="form-control" name="motivo" id="motivo" placeholder="Ej: Se perdió, se rompió, etc.">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-danger">Eliminar</button>
        </div>
      </div>
    </form>
  </div>
</div>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const botonesEliminar = document.querySelectorAll('.btnEliminar');
    const modal = new bootstrap.Modal(document.getElementById('modalEliminar'));
    const nombreElemento = document.getElementById('nombreElementoModal');
    const idInput = document.getElementById('idHerramientaEliminar');
    const formEliminar = document.getElementById('formEliminar');
    const motivoGroup = document.getElementById('motivoGroup');
    const inputMotivo = document.getElementById('motivo');

    botonesEliminar.forEach(boton => {
      boton.addEventListener('click', function () {
        const id = this.getAttribute('data-id');
        const nombre = this.getAttribute('data-nombre') || '';
        const ruta = this.getAttribute('data-url');
        const tipo = this.getAttribute('data-tipo') || '';

        // ✅ Rellenar input oculto con ID
        idInput.value = id;

        // ✅ Mostrar nombre en el modal
        nombreElemento.textContent = nombre;

        // ✅ Asignar acción del formulario con ID incluido en la URL
        formEliminar.action = `${ruta}?id=${id}`;

        // ✅ Mostrar input de motivo solo para herramientas
        if (tipo === 'herramienta') {
          motivoGroup.style.display = 'block';
          inputMotivo.setAttribute('required', 'required');
        } else {
          motivoGroup.style.display = 'none';
          inputMotivo.removeAttribute('required');
          inputMotivo.value = '';
        }

        // ✅ Mostrar modal
        modal.show();
      });
    });
  });
</script>
