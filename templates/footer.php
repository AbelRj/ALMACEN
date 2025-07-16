    </div>
<script>
  const ROL_USUARIO = "<?= $_SESSION['rol'] ?? '' ?>";

  document.addEventListener('DOMContentLoaded', function() {
    const selectDestino = document.querySelector('[name="destino_id"]');
    const campoEnviadoA = document.getElementById('campoEnviadoA');
    const inputProceso = document.querySelector('[name="proceso"]');

    // Validar si existen los elementos antes de trabajar con ellos
    if (selectDestino && campoEnviadoA && inputProceso) {
      selectDestino.addEventListener('change', function() {
        const textoSeleccionado = this.options[this.selectedIndex].text.toLowerCase().trim();

        if (textoSeleccionado === 'persona externa') {
          campoEnviadoA.style.display = 'block';

          if (ROL_USUARIO === 'administrador') {
            inputProceso.value = 'enviado';
          } else {
            inputProceso.value = 'pendiente';
          }
        } else {
          campoEnviadoA.style.display = 'none';
          inputProceso.value = 'pendiente';
        }
      });
    }
  });
</script>


    <!-- jQuery (requerido por DataTables) -->
    <script src="js/jquery.min.js"></script>
   <!-- DataTables JS -->
    <script src="js/datatables.js"></script>
    <script src="js/datatables.min.js"></script>
    <!-- Bootstrap 5 JS -->
    <script src="js/bootstrap.bundle.min.js"></script>
 <script>
  document.addEventListener("DOMContentLoaded", function () {
    const toggleBtn = document.getElementById("toggleNavbar");
    const navbarMenu = document.getElementById("navbarNav");

    toggleBtn.addEventListener("click", function () {
      navbarMenu.classList.toggle("show");
    });
  });
</script>



    <script>
      $(document).ready(function() {
        const opcionesComun = (idTabla, contenedorId) => ({
          scrollX: true,
          fixedColumns: {
            leftColumns: 1
          },
          language: {
            url: 'js/lenguaje.js'
          },
          pageLength: 5,
          lengthMenu: [5, 10, 25, 50, 100],
          initComplete: function() {
            document.getElementById(contenedorId).style.visibility = "visible";
          }
        });

        $('#tablaHerramientas').DataTable(opcionesComun('#tablaHerramientas', 'contenedorHerramientas'));
        $('#tablaUsuarios').DataTable(opcionesComun('#tablaUsuarios', 'contenedorUsuarios'));
        $('#tablaFabricas').DataTable(opcionesComun('#tablaFabricas', 'contenedorFabricas'));
        $('#tablaMovimientos').DataTable(opcionesComun('#tablaMovimientos', 'contenedorMovimientos'));
      });
    </script>
    </body>

    </html>