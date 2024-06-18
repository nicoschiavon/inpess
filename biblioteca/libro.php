<?php
include_once 'config/Database.php';
include_once 'class/Miembro.php';
include_once 'class/Libro.php';

$database = new Database();
$db = $database->getConnection();

$miembro = new Miembro($db);

if (!$miembro->loggedIn()) {
	header("Location: index.php");
}
$book = new Libro($db);
include('components/header4.php');
?>
<title>INPESS</title>
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" />
<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" />
<link rel="stylesheet" href="css/dashboard.css" />
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap4.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css" />
<script src="js/libro.js"></script>
</head>

<body>

	<div class="container-fluid">
		<?php include('top_menus.php'); ?>
		<div class="row row-offcanvas row-offcanvas-left">
			<?php include('left_menus.php'); ?>
			<div class="col-md-9 col-lg-10 main">
				<h2>Gestionar Libros</h2>
				<div class="panel-heading">
					<div class="row">
						<div class="col-md-10">
							<h3 class="panel-title"></h3>
						</div>
						<div class="col-md-2" align="right">
							<button type="button" id="addLibro" class="btn btn-info" title="Add book"><span class="glyphicon glyphicon-plus">Agregar Libro</span></button>
						</div>
					</div>
				</div>
				<table id="libroListing" class="table table-striped table-bordered">
					<thead>
						<tr>
							<td></td>
							<th>Titulo</th>
							<th>Editorial</th>
							<th>Resumen</th>
							<th>PDF</th>
							<th>Año Publicacion</th>
							<td></td>
							<td></td>
							
						</tr>
					</thead>
				</table>
			</div>
		</div>
		<div id="libroModal" class="modal fade">
			<div class="modal-dialog">
				<form method="post" id="libroForm">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal"></button>
							<h4 class="modal-title"><i class="fa fa-plus"></i> Editar libro</h4>
						</div>
						<div class="modal-body">

						<div class="form-group">
                                <label for="titulo" class="control-label">Título</label>
                                <input type="text" class="form-control" id="titulo" name="titulo" placeholder="Título" required>
                            </div>
                            <div class="form-group">
                                <label for="pdf" class="control-label">PDF</label>
                                <input type="file" name="pdf" id="pdf" class="form-control" accept="application/pdf" />
                            </div>
                            <div class="form-group">
                                <label for="isbn_issn_acta" class="control-label">ISBN/ISSN/ACTA</label>
                                <input type="number" class="form-control" id="isbn_issn_acta" name="isbn_issn_acta" placeholder="ISBN/ISSN/ACTA">
                            </div>
                            <div class="form-group">
                                <label for="resumen" class="control-label">Resumen</label>
                                <textarea class="form-control" id="resumen" name="resumen" placeholder="Resumen" required></textarea>
                            </div>

							<div class="form-group">
								<label for="libro" class="control-label">Editorial</label>
								<input type="text" name="editorial" id="editorial" autocomplete="off" class="form-control" placeholder="Editorial" />
							</div>

							<div class="form-group">
                                <label for="anioPub" class="control-label">Año de publicación</label>
                                <input type="number" class="form-control" id="anioPub" name="anioPub" placeholder="Año de Publicacion">
                            </div>



						</div>
						<div class="modal-footer">
							<input type="hidden" name="idTextoCientifico" id="idTextoCientifico" />
							<input type="hidden" name="action" id="action" value="" />
							<input type="submit" name="save" id="save" class="btn btn-info" value="Guardar" />
							<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<?php
	include("./footer.php");
	?>
</body>

</html>