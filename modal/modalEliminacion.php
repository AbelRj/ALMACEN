<!-- Modal Reutilizable de Eliminación -->
<div class="modal fade" id="modalEliminar" tabindex="-1" aria-labelledby="modalEliminarLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-light">
      <div class="modal-header bg-light">
        <h5 class="modal-title" id="modalEliminarLabel">Confirmar eliminación</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        ¿Estás seguro que deseas eliminar <strong id="nombreElementoModal"></strong>?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <a id="btnConfirmarEliminar" href="#" class="btn btn-danger">Eliminar</a>
      </div>
    </div>
  </div>
</div>


<script>
  document.addEventListener('DOMContentLoaded', function() {
    const botonesEliminar = document.querySelectorAll('.btnEliminar');
    const modal = new bootstrap.Modal(document.getElementById('modalEliminar'));
    const btnConfirmar = document.getElementById('btnConfirmarEliminar');
    const nombreElemento = document.getElementById('nombreElementoModal');

    botonesEliminar.forEach(boton => {
      boton.addEventListener('click', function() {
        const id = this.getAttribute('data-id');
        const nombre = this.getAttribute('data-nombre') || '';
        const ruta = this.getAttribute('data-url');

        btnConfirmar.href = `${ruta}?id=${id}`;
        nombreElemento.textContent = nombre;
        modal.show();
      });
    });
  });
</script>