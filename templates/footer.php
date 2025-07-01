    </div>

    <!-- jQuery (requerido por DataTables) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <!-- FixedColumns -->
<script src="https://cdn.datatables.net/fixedcolumns/4.3.0/js/dataTables.fixedColumns.min.js"></script>

<script>
  $(document).ready(function () {
    const opcionesComun = (idTabla, contenedorId) => ({
      scrollX: true,
      fixedColumns: {
        leftColumns: 1
      },
      language: {
        url: 'https://cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json'
      },
      pageLength: 5,
      lengthMenu: [5, 10, 25, 50, 100],
      initComplete: function () {
        document.getElementById(contenedorId).style.visibility = "visible";
      }
    });

    $('#tablaHerramientas').DataTable(opcionesComun('#tablaHerramientas', 'contenedorHerramientas'));
    $('#tablaUsuarios').DataTable(opcionesComun('#tablaUsuarios', 'contenedorUsuarios'));
    $('#tablaFabricas').DataTable(opcionesComun('#tablaFabricas', 'contenedorFabricas'));
    $('#tablaMovimientos').DataTable(opcionesComun('#tablaMovimientos', 'contenedorMovimientos'));
  });
</script>


<script>
document.querySelector('[name="destino_id"]').addEventListener('change', function () {
  const valor = this.options[this.selectedIndex].text.toLowerCase();
  document.getElementById('campoEnviadoA').style.display = valor === 'persona externa' ? 'block' : 'none';
});
</script>
  </body>
</html>
