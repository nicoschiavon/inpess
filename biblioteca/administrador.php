<?php
include_once 'config/Database.php';
include_once 'class/Administrador.php';

$database = new Database();
$db = $database->getConnection();

$admin = new Administrador($db);

if (!$admin->loggedIn()) {
	header("Location: index.php");
}
include('inc/header4.php');
?>
<title>INPESS</title>
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" />
<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" />
<link rel="stylesheet" href="css/dashboard.css" />
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap4.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css" />
<script src="js/administrador.js"></script>
</head>

<body>

	<div class="container-fluid">
		<?php include('top_menus.php'); ?>
		<div class="row row-offcanvas row-offcanvas-left">
			<?php include('left_menus.php'); ?>
			<div class="col-md-9 col-lg-10 main">
				<h2>Gestiones de Usuario</h2>
				<div class="panel-heading">
					<div class="row">
						<div class="col-md-10">
							<h3 class="panel-title"></h3>
						</div>
						<div class="col-md-2" align="right">
							<button type="button" id="addAdmin" class="btn btn-info" title="Agregar Usuario"><span class="glyphicon glyphicon-plus">Agregar Usuario</span></button>
						</div>
					</div>
				</div>
				<table id="adminListing" class="table table-striped table-bordered">
					<thead>
						<tr>
							<th>ID</th>
							<th>Usuario</th>
							
							<th></th>
							<th></th>
						</tr>
					</thead>
				</table>
			</div>
		</div>
		
	</div>
	<?php
	include("./footer.php");
	?>

</body>

</html>