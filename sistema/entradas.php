<?php include_once "includes/header.php"; ?>

<!-- Begin Page Content -->
<div class="container-fluid">	

	<!-- Page Heading -->
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Productos</h1>
        <button class="btn btn-success" type="button" onclick="openIndexPag3()">Ventana Productos</button>
	</div>

	<div class="row">
		<div class="col-lg-12">
			<div class="table-responsive">
				<table class="table table-striped table-bordered" id="table">
					<thead class="thead-dark">
						<tr>
							<th>COD.PRODUCTO</th>
							<th>FECHA</th>
							<th>CANTIDAD</th>
							
							<?php if ($_SESSION['rol'] == 1) { ?>
							<th>ACCIONES</th>
							<?php } ?>
						
						</tr>
					</thead>
					<tbody>
					<?php
						include "../conexion.php";

						$query = mysqli_query($conexion, "SELECT * FROM entradas ORDER BY fecha DESC");
						$result = mysqli_num_rows($query);
						if ($result > 0) {
							while ($data = mysqli_fetch_assoc($query)) { ?>
								<tr>
									<td><?php echo $data['codproducto']; ?></td>
									<td><?php echo $data['fecha']; ?></td>
									<td><?php echo $data['cantidad']; ?></td>
										<?php if ($_SESSION['rol'] == 1) { ?>
									<td>
				
										<form action="eliminar_entradas.php?codproducto=<?php echo $data['codproducto']; ?>" method="post" class="confirmar d-inline">
											<button class="btn btn-danger" type="submit"><i class='fas fa-trash-alt'></i> </button>
										</form>
									</td>
										<?php } ?>
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