<!-- Barra lateral -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

<!-- Barra lateral - Marca -->
	<a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
		<div class="sidebar-brand-icon rotate-n-15">
		<img src="./img/logo-pointer.png" class="img-thumbnail" width="60">

		</div>
		<div class="sidebar-brand-text mx-3">Pointer</div>
	</a>
	<!-- Divisor -->
	<hr class="sidebar-divider my-0">

	<!-- Divisor -->
	<hr class="sidebar-divider">


<!-- Encabezado -->
	<div class="sidebar-heading">
		Interfaz
	</div>


<!-- Elemento de navegación - Menú contraer páginas -->
	<li class="nav-item">
		<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
			<i class="fas fa-fw fa-cog"></i>
			<span>Asignar</span>
		</a>
		<div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
			<div class="bg-white py-2 collapse-inner rounded">
				<a class="collapse-item" href="nueva_asig.php">Nueva Asignacion</a>
				<a class="collapse-item" href="asignaciones.php">Asignaciones</a>
			</div>
		</div>
	</li>

	<!-- Nav Item - Productos Collapse Menu -->
	<li class="nav-item">
		<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
			<i class="fas fa-fw fa-wrench"></i>
			<span>Productos</span>
		</a>
		<div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
			<div class="bg-white py-2 collapse-inner rounded">
				<a class="collapse-item" href="registro_producto.php">Nuevo Producto</a>
				<a class="collapse-item" href="lista_productos.php">Productos</a>
			</div>
		</div>
	</li>

	<!-- Nav Item - Clientes Collapse Menu -->
	<li class="nav-item">
		<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseClientes" aria-expanded="true" aria-controls="collapseUtilities">
			<i class="fas fa-users"></i>
			<span>Empleados</span>
		</a>
		<div id="collapseClientes" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
			<div class="bg-white py-2 collapse-inner rounded">
				<a class="collapse-item" href="registro_empleado.php">Nuevo empleado</a>
				<a class="collapse-item" href="lista_empleado.php">Lista de empleados</a>
			</div>
		</div>
	</li>
	
		<li class="nav-item">
			<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUsuarios" aria-expanded="true" aria-controls="collapseUtilities">
				<i class="fas fa-user"></i>
				<span>Usuarios</span>
			</a>
			<div id="collapseUsuarios" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
				<div class="bg-white py-2 collapse-inner rounded">
					<a class="collapse-item" href="registro_usuario.php">Nuevo usuario</a>
					<a class="collapse-item" href="lista_usuarios.php">Lista de usuarios</a>
				</div>
			</div>
		</li>
</ul>