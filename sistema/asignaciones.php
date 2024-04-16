<?php include_once "includes/header.php";?>
<!--******************************************* MODIFICADOOOO*************************************** -->
<!-- Begin Page Content -->
<div class="container-fluid">

	<!-- Page Heading -->
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Panel de Administración</h1>
	</div>
	<div class="row">
		<div class="col-lg-12">
			<div class="table-responsive">
				<table class="table table-striped table-bordered" id="table">
					<thead class="thead-dark">
						<tr>
							<th>Id</th>
							<th>Fecha</th>
							<th>Nombre</th>
							<th>Apellido</th>
							<th>Acciones</th>

						</tr>
					</thead>
					<tbody>
						<?php


						require "../conexion.php";

						$query = mysqli_query($conexion, "SELECT a.noasig, a.fecha, a.codemple, a.estado, emp.nombres, emp.apellidos 
						FROM asignacion a
						INNER JOIN empleados emp ON a.codemple = emp.id_empleado
						ORDER BY a.noasig DESC");




						// $query = mysqli_query($conexion, "SELECT noasig, fecha, codemple,  estado FROM asignacion ORDER BY noasig DESC");
						mysqli_close($conexion);
						$cli = mysqli_num_rows($query);

						if ($cli > 0) {
							while ($dato = mysqli_fetch_array($query)) {
						?>
								<tr>
									<td><?php echo $dato['noasig']; ?></td>
									<td><?php echo $dato['fecha']; ?></td>
									<td><?php echo $dato['nombres']; ?></td>
									<td><?php echo $dato['apellidos']; ?></td>

							            
									<td>
										<button type="button" class=" btn btn-danger view_asig" codemp="<?php echo $dato['codemple'];  ?>" a="<?php echo $dato['noasig']; ?>">PDF</button>
									</td>
								</tr>
						<?php }
						} ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>



</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<?php include_once "includes/footer.php"; ?>