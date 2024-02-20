<!-- Footer -->
<footer class="sticky-footer bg-white">
  <div class="container my-auto">
    <div class="copyright text-center my-auto">
    <span>Copyright &copy; KYLT Pointer Instrument <?php echo date("Y"); ?></span>


    </div>
  </div>
</footer>

<!-- Fin del pie de página -->

</div>
<!-- Fin del contenedor de contenido -->
</div>

<!-- Contenedor de fin de página -->

<!-- Desplácese hasta el botón superior-->
<a class="scroll-to-top rounded" href="#page-top">
  <i class="fas fa-angle-up"></i>
</a>

<!-- Modal de cierre de sesión-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
      <div class="modal-footer">
        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
        <a class="btn btn-primary" href="login.html">Logout</a>
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap core JavaScript-->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="vendor/jquery-easing/jquery.easing.min.js"></script>
<script src="js/all.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="js/sb-admin-2.min.js"></script>
<script src="js/jquery.dataTables.min.js"></script>
<script src="js/dataTables.bootstrap4.min.js"></script>
<script src="js/sweetalert2@10.js"></script>
<script type="text/javascript" src="js/producto.js"></script>
<script type="text/javascript">
 
 $(document).ready(function() {
  // Inicializa la tabla con DataTables
  $('#table').DataTable({
    language: {
      // Configuración de idioma
      "decimal": "", // Separador decimal
      "emptyTable": "No hay datos", // Mensaje cuando la tabla está vacía
      "info": "Mostrando _START_ a _END_ de _TOTAL_ registros", // Información sobre registros mostrados
      "infoEmpty": "Mostrando 0 a 0 de 0 registros", // Información cuando no hay registros para mostrar
      "infoFiltered": "(Filtro de _MAX_ total registros)", // Información sobre registros después de aplicar un filtro
      "infoPostFix": "", // Texto adicional después de la información
      "thousands": ",", // Separador de miles
      "lengthMenu": "Mostrar _MENU_ registros", // Texto del menú para seleccionar cantidad de registros a mostrar
      "loadingRecords": "Cargando...", // Mensaje mientras se cargan registros
      "processing": "Procesando...", // Mensaje mientras se procesan datos
      "search": "Buscar:", // Texto del campo de búsqueda
      "zeroRecords": "No se encontraron coincidencias", // Mensaje cuando no hay registros coincidentes
      "paginate": { // Configuración para la paginación
        "first": "Primero", // Botón para ir a la primera página
        "last": "Ultimo", // Botón para ir a la última página
        "next": "Siguiente", // Botón para ir a la siguiente página
        "previous": "Anterior" // Botón para ir a la página anterior
      },
      "aria": { // Configuración para accesibilidad
        "sortAscending": ": Activar orden de columna ascendente", // Mensaje para ordenar ascendente
        "sortDescending": ": Activar orden de columna desendente" // Mensaje para ordenar descendente
      }
    }
  });

  var usuarioid = '<?php echo $_SESSION['idUser']; ?>'; // Variable para almacenar el ID de usuar

  // Llama a una función para buscar detalles relacionados con el usuario
  searchForDetalle(usuarioid);
});

</script>

</body>

</html>