<div class="col-md-3 col-lg-2 sidebar-offcanvas" id="sidebar" role="navigation">
	<ul class="nav flex-column pl-1">
		<?php if ($miembro->loggedIn() ) { ?>
	

			<li class="nav-item">
				<a class="nav-link" href="#submenu1" data-toggle="collapse" data-target="#submenu1"><strong>Documentos</strong> ▾</a>
				<ul class="list-unstyled flex-column pl-3 collapse show" id="submenu1" aria-expanded="false">
				<li class="nav-item"><a class="nav-link" href="textoCientifico.php"><strong>Todos</strong></a></li>
				<li class="nav-item"><a class="nav-link" href="libro.php"><strong>Libros</strong></a></li>
				<li class="nav-item"><a class="nav-link" href="revista.php"><strong>Revista</strong></a></li>

				</ul>
			</li>
			<?php if ($miembro->isAdmin() ) { ?>
				<li class="nav-item"><a class="nav-link" href="textoCientifico.php"><strong>Noticia</strong></a></li>
				<?php } ?>

			<li class="nav-item"><a class="nav-link" href="logout.php"><strong>Cerrar Sesión</strong></a></li>

		<?php } else { ?>
			<?php if ($administrador->loggedIn()) {?>
				<li class="nav-item"><a class="nav-link" href="miembro.php"><strong>Usuarios</strong></a></li>

				<li class="nav-item"><a class="nav-link" href="logout.php"><strong>Cerrar Sesión</strong></a></li>

				<?php } ?>
			
		<?php } ?>
	</ul>
</div>