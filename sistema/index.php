<?php include_once "includes/header.php"; ?>


<!-- Contenido de la página de inicio -->
<div class="container-fluid">

<!-- Encabezado de página -->
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Panel de Administración</h1>
	</div>
<!-- Fila de contenido -->
	<div class="row">

		<!-- contador usuarios -->
		<a class="col-xl-3 col-md-6 mb-4" href="lista_usuarios.php">
			<div class="card border-left-primary shadow h-100 py-2">
				<div class="card-body">
					<div class="row no-gutters align-items-center">
						<div class="col mr-2">
							<div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Usuarios</div>
							<div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $data['count_usuario']; ?></div>
						</div>
						<div class="col-auto">
							<i class="fas fa-user fa-2x text-gray-300"></i>
						</div>
					</div>
				</div>
			</div>
		</a>

		<!-- contador empleados-->
		<a class="col-xl-3 col-md-6 mb-4" href="lista_empleado.php">
			<div class="card border-left-success shadow h-100 py-2">
				<div class="card-body">
					<div class="row no-gutters align-items-center">
						<div class="col mr-2">
							<div class="text-xs font-weight-bold text-success text-uppercase mb-1">Empleados</div>
							<div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $data['count_empleados']; ?></div>
						</div>
						<div class="col-auto">
							<i class="fas fa-users fa-2x text-gray-300"></i>
						</div>
					</div>
				</div>
			</div>
		</a>

		<!-- Contador productos-->
		<a class="col-xl-3 col-md-6 mb-4" href="lista_productos.php">
			<div class="card border-left-info shadow h-100 py-2">
				<div class="card-body">
					<div class="row no-gutters align-items-center">
						<div class="col mr-2">
							<div class="text-xs font-weight-bold text-info text-uppercase mb-1">Productos</div>
							<div class="row no-gutters align-items-center">
								<div class="col-auto">
									<div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo $data ['count_productos'];?></div>
								</div>
								<div class="col">
									<div class="progress progress-sm mr-2">
										<div class="progress-bar bg-info" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-auto">
							<i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
						</div>
					</div>
				</div>
			</div>
		</a>

	
<!--contador asignaciones-->
		<a class="col-xl-3 col-md-6 mb-4" href="ventas.php">
			<div class="card border-left-warning shadow h-100 py-2">
				<div class="card-body">
					<div class="row no-gutters align-items-center">
						<div class="col mr-2">
							<div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Asignaciones</div>
							<div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $data ['count_asignaciones'];?></div>
						</div>
						<div class="col-auto">
							<i class=""></i>
						</div>
					</div>
				</div>
			</div>
		</a>
	</div>
	
<!-- Encabezado de página -->
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Configuración</h1>
	</div>
	<div class="row">
    
<!-- Tarjeta inicial -->
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header bg-primary text-white">
                Información Personal
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label>Nombre: <strong><?php echo $_SESSION['nombre']; ?></strong></label>
                </div>
                <div class="form-group">
                    <label>Correo: <strong><?PHP echo $_SESSION['email'];?></strong></label>
                </div>
                <div class="form-group">
                    <label>Rol: <strong><?php echo $_SESSION['rol_name'];?></strong></label>
                </div>
                <div class="form-group">
                    <label>Usuario: <strong><?php echo $_SESSION['user']; ?></strong></label>
                </div>
            </div>
        </div>
    </div>


	<?php if ($_SESSION['rol'] == 1) { ?>
    <div class="col-lg-6">
        <div class="card">
    
		<li class="list-group-item active">Cambiar Contraseña</li>
		<form action="" method=" post" name="frmChangePass" id="frmChangePass" class="p-3">
		<div class="form-group">
		<label>Contraseña Actual</label>
		<input type="password" name="actual" id="actual" placeholder="Clave Actual" required class="form-control">
		</div>
		<div class="form-group">
		<label>Nueva Contraseña</label>
		<input type="password" name="nueva" id="nueva" placeholder="Nueva Clave" required class="form-control">
		</div>
		<div class="form-group">
		<label>Confirmar Contraseña</label>
		<input type="password" name="confirmar" id="confirmar" placeholder="Confirmar clave" required class="form-control">
		</div>
		<div class="alertChangePass" style="display:none;">
		</div>
		<div>
		<button type="submit" class="btn btn-primary btnChangePass">Cambiar Contraseña</button>
		</div>
	    </form>
		</ul>
		</div>
	</div>
		</div>
		
		<?php } ?>

</div>

<!-- /.contenedor-fluido -->

</div>
<!-- End of Main Content -->


<?php include_once "includes/footer.php"; ?>