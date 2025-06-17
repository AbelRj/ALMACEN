    </div>

    <!-- jQuery (requerido por DataTables) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

    <script>
      $(document).ready(function () {
        $('#tablaHerramientas').DataTable({
          language: {
            url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json'
          },
          pageLength: 5,
          lengthMenu: [5, 10, 25, 50, 100]
        });
      });
    </script>
  </body>
</html>
