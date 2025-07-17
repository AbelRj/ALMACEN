  <!-- MODAL DE CONFIRMACIÓN DE EXITO -->
<?php include("modal/modalExito.php"); ?>
  <!-- Modal de advertencia -->
<?php include("modal/modalAdvertencia.php"); ?>
<!-- MODAL DE CONFIRMACIÓN DE ELIMINACIÓN -->
 <?php include("modal/modalEliminacionExitosa.php"); ?>
<?php include("modal/modalEliminacion.php"); ?>
  </div>
      <!-- jQuery (requerido por DataTables) -->
    <script src="js/jquery.min.js"></script>
    <!-- DataTables JS -->
    <script src="js/datatables.js"></script>
    <script src="js/datatables.min.js"></script>
    <!-- Bootstrap 5 JS -->
    <script src="js/bootstrap.bundle.min.js"></script>

    <script>
      
      //Para que aparesca el input si hacen click en persona externa, tambien para ver si el usuario es administrador
      //el texto proceso cambia a enviado pero si es supervisor se mantiene en pendiente
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


      //Para que aparesca el menu y oculte el menu cuando este en responsive
      document.addEventListener("DOMContentLoaded", function() {
        const toggleBtn = document.getElementById("toggleNavbar");
        const navbarMenu = document.getElementById("navbarNav");

        toggleBtn.addEventListener("click", function() {
          navbarMenu.classList.toggle("show");
        });
      });


      // Configuración general para tablas DataTables con scroll y traducción
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


      //Validacion formulario usuarios
      document.querySelector("#formUsuario")?.addEventListener("submit", function(e) {
      const nombreyA = document.querySelector('input[name="nombreyapellidoU"]').value.trim();
      const fechaU = document.querySelector('input[name="fechaU"]').value.trim();
      const nombreU = document.querySelector('input[name="nombreU"]').value.trim();
      const passwordU = document.querySelector('input[name="passwordU"]').value.trim();
      const emailU = document.querySelector('input[name="emailU"]').value.trim();
      const fabricaU = document.querySelector('select[name="fabricaU"]').value;
      const rolU = document.querySelector('select[name="rolU"]').value;

      const esEdicion = <?= $esEdicion ? 'true' : 'false' ?>;
      const faltaPassword = !passwordU && !esEdicion;

        if (
          !nombreyA ||
          !fechaU ||
          !nombreU ||
          faltaPassword ||
          !emailU ||
          fabricaU === "Seleccionar" ||
          rolU === "Seleccionar"
        ) {
          e.preventDefault();
          const modal = new bootstrap.Modal(document.getElementById('modalError'));
          modal.show();
        }
      });


      //Validadion herramientas
      document.querySelector("#formHerramienta")?.addEventListener("submit", function(e) {
      const nombre = document.querySelector('input[name="nombreH"]').value.trim();
      const descripcion = document.querySelector('input[name="descripcionH"]').value.trim();
      const codigo = document.querySelector('input[name="codigoH"]').value.trim();
      const estado = document.querySelector('select[name="estadoH"]').value;
      const fabrica = document.querySelector('select[name="fabricaH"]').value;

        if (
          !nombre ||
          !descripcion ||
          !codigo ||
          estado === "Seleccionar" ||
          fabrica === "Seleccionar"
        ) {
          e.preventDefault();
          const modal = new bootstrap.Modal(document.getElementById('modalError'));
          modal.show();
        }
      });

      //Validacion fabricas
      document.querySelector("#formFabrica")?.addEventListener("submit", function(e) {
      const nombre = document.querySelector('input[name="nombreF"]').value.trim();
      const lugar = document.querySelector('input[name="lugarF"]').value.trim();

        if (
          !nombre ||
          !lugar
        ) {
          e.preventDefault();
          const modal = new bootstrap.Modal(document.getElementById('modalError'));
          modal.show();
        }
      });
    </script>


</body>
</html>