<?php
include_once 'config/Database.php';
include_once 'class/Miembro.php';
include_once 'class/Administrador.php';

$database = new Database();
$db = $database->getConnection();
$administrador = new Administrador($db);
$miembro = new Miembro($db);

if (!$administrador->loggedIn() && !$miembro->loggedIn()) {
    header("Location: index.php");
}
include('components/header4.php');
?>
<title>Gestiones de Miembros</title>
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" />
<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" />
<link rel="stylesheet" href="css/dashboard.css" />
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap4.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css" />
<script src="js/miembro.js"></script>
</head>

<body>

    <div class="container-fluid">
        <?php include('top_menus.php'); ?>
        <div class="row row-offcanvas row-offcanvas-left">
            <?php include('left_menus.php'); ?>
            <div class="col-md-9 col-lg-10 main">
                <h2>Gestiones de Miembros</h2>
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-10">
                            <h3 class="panel-title"></h3>
                        </div>
                        <div class="col-md-2" align="right">
                            <button type="button" id="addMiembro" class="btn btn-info" title="Agregar Miembro"><span class="glyphicon glyphicon-plus">Agregar Miembro</span></button>
                        </div>
                    </div>
                </div>
                <table id="miembroListing" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Correo Electrónico</th>
                            <th>Tipo de Miembro</th>
                            <th>Estado</th>
                            <th>Id Revisor</th>
                            <th></th>
                            
                         
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        <div id="miembroModal" class="modal fade">
            <div class="modal-dialog">
                <form method="post" id="miembroForm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title"><i class="fa fa-plus"></i> Editar Miembro</h4>
                        </div>
                        <div class="modal-body">

                            <div class="form-group">
                                <label for="tipoMiembro" class="control-label">Tipo de Miembro</label>
                                <select class="form-control" id="tipoMiembro" name="tipoMiembro" />
                                <option value="">Seleccionar Tipo</option>
                                <option value="director">Director</option>
                                <option value="secretario">Secretario</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="usuario" class="control-label">Usuario</label>
                                <input type="text" name="usuario" id="usuario" autocomplete="off" class="form-control" placeholder="Usuario" />
                            </div>

                            <div class="form-group">
                                <label for="nombre" class="control-label">Nombre</label>
                                <input type="text" name="nombre" id="nombre" autocomplete="off" class="form-control" placeholder="Nombre" />
                            </div>

                            <div class="form-group">
                                <label for="apellido" class="control-label">Apellido</label>
                                <input type="text" class="form-control" id="apellido" name="apellido" placeholder="Apellido">
                            </div>

                            <div class="form-group">
                                <label for="correoElec" class="control-label">Correo Electrónico</label>
                                <input type="email" class="form-control" id="correoElec" name="correoElec" placeholder="Correo Electrónico">
                            </div>

                            <div class="form-group">
                                <label for="password" class="control-label">Nueva Contraseña</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Contraseña">
                            </div>

                            <div class="form-group">
                                <label for="cuit" class="control-label">CUIT</label>
                                <input type="text" class="form-control" id="cuit" name="cuit" placeholder="CUIT">
                            </div>

                            <div class="form-group">
                                <label for="telefono" class="control-label">Teléfono</label>
                                <input type="text" class="form-control" id="telefono" name="telefono" placeholder="Teléfono">
                            </div>

                            <div class="form-group">
                                <label for="fechaNac" class="control-label">Fecha de Nacimiento</label>
                                <input type="date" class="form-control" id="fechaNac" name="fechaNac" placeholder="Fecha de Nacimiento">
                            </div>

                            <div class="form-group">
                                <label for="estado" class="control-label">Estado</label>
                                <select class="form-control" id="estado" name="estado" />
                                <option value="">Seleccionar Estado</option>
                                <option value="activo">Activo</option>
                                <option value="inactivo">Inactivo</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="idRevisor" class="control-label">ID Revisor</label>
                                <input type="text" class="form-control" id="idRevisor" name="idRevisor" placeholder="ID Revisor">
                            </div>

                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="idMiembro" id="idMiembro" />
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
