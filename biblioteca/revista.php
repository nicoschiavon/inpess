<?php
include_once 'config/Database.php';
include_once 'class/Revista.php';
include_once 'class/Administrador.php';
include_once 'class/Miembro.php';

$database = new Database();
$db = $database->getConnection();
$administrador = new Administrador($db);
$revista = new Revista($db);
$miembro = new Miembro($db);

if (!$miembro->loggedIn()) {
    header("Location: index.php");
}
include('components/header4.php');
?>
<title>Gestión de Revistas</title>
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" />
<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" />
<link rel="stylesheet" href="css/dashboard.css" />
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap4.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css" />
<script src="js/revista.js"></script>
</head>

<body>

    <div class="container-fluid">
        <?php include('top_menus.php'); ?>
        <div class="row row-offcanvas row-offcanvas-left">
            <?php include('left_menus.php'); ?>
            <div class="col-md-9 col-lg-10 main">
                <h2>Gestión de Revistas</h2>
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-10">
                            <h3 class="panel-title"></h3>
                        </div>
                        <div class="col-md-2" align="right">
                            <button type="button" id="addRevista" class="btn btn-info" title="Agregar Revista"><span class="glyphicon glyphicon-plus">Agregar Revista</span></button>
                        </div>
                    </div>
                </div>
                <table id="revistaListing" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Título</th>
                            <th>ISBN/ISSN/ACTA</th>
                            <th>Resumen</th>
                            <th>Tipo</th>
                            <th>Nombre de la Revista</th>
                            <th>Número de la Revista</th>
                            <th>Primera Página</th>
                            <th>Última Página</th>
                            <th>Mes de Publicación</th>
                            <th>Año de Publicación</th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                </table>
				
            </div>
        </div>
        <div id="revistaModal" class="modal fade">
            <div class="modal-dialog">
                <form method="post" id="revistaForm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title"><i class="fa fa-plus"></i> Editar Revista</h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="titulo" class="control-label">Título</label>
                                <input type="text" class="form-control" id="titulo" name="titulo" placeholder="Título" required>
                            </div>
                            <div class="form-group">
                                <input type="file" name="pdf" accept=".pdf"/>
                                <input type="hidden" name="MAX_FILE_SIZE" value="67108864"/> <!--64 MB's worth in bytes-->
                            </div>
                            <div class="form-group">
                                <label for="isbn_issn_acta" class="control-label">ISBN/ISSN/ACTA</label>
                                <input type="text" class="form-control" id="isbn_issn_acta" name="isbn_issn_acta" placeholder="ISBN/ISSN/ACTA">
                            </div>
                            <div class="form-group">
                                <label for="resumen" class="control-label">Resumen</label>
                                <textarea class="form-control" id="resumen" name="resumen" placeholder="Resumen" required></textarea>
                            </div>

                            <div class="form-group">
                                <label for="nombRev" class="control-label">Nombre de la Revista</label>
                                <input type="text" class="form-control" id="nombRev" name="nombRev" placeholder="Nombre de la Revista" required>
                            </div>
                            <div class="form-group">
                                <label for="nroRev" class="control-label">Número de la Revista</label>
                                <input type="number" class="form-control" id="nroRev" name="nroRev" placeholder="Número de la Revista" required>
                            </div>
                            <div class="form-group">
                                <label for="primPag" class="control-label">Primera Página</label>
                                <input type="number" class="form-control" id="primPag" name="primPag" placeholder="Primera Página" required>
                            </div>
                            <div class="form-group">
                                <label for="ultPag" class="control-label">Última Página</label>
                                <input type="number" class="form-control" id="ultPag" name="ultPag" placeholder="Última Página" required>
                            </div>
                            <div class="form-group">
                                <label for="mesPub" class="control-label">Mes de Publicación</label>
                                <input type="number" class="form-control" id="mesPub" name="mesPub" placeholder="Mes de Publicación" required>
                            </div>
                            <div class="form-group">
                                <label for="anioPub" class="control-label">Año de Publicación</label>
                                <input type="number" class="form-control" id="anioPub" name="anioPub" placeholder="Año de Publicación" required>
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
</body>
</html>
