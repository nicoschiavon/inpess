<?php
include_once 'config/Database.php';
include_once 'class/Miembro.php';
include_once 'class/Administrador.php';

$database = new Database();
$db = $database->getConnection();

$miembro = new Miembro($db);
$administrador = new Administrador($db);

if ($miembro->loggedIn() || $administrador->loggedIn()) {
	header("Location: dashboard.php");
}

$loginMessage = '';
if (!empty($_POST["login"]) && !empty($_POST["correoElec"]) && !empty($_POST["password"])) {
	$miembro->correoElec = $_POST["correoElec"];
	$miembro->password = $_POST["password"];
	$administrador->usuario = $_POST["correoElec"];
	$administrador->password = $_POST["password"];

	if ($miembro->login() || $administrador->login()) {
		header("Location: dashboard.php");
	} else {
		$loginMessage = 'Usuario o Contraseña Inválidos';
	}
}
include('components/header4.php');
?>
<html>
<head>

<link rel="stylesheet" href="../assets/css/fontawesome.css">
<link rel="stylesheet" href="../assets/css/templatemo-scholar.css">
<link rel="stylesheet" href="../assets/css/owl.css">
<link rel="stylesheet" href="../assets/css/animate.css">
<link rel="stylesheet"href="https://unpkg.com/swiper@7/swiper-bundle.min.css"/>

<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" />
<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" />
<link rel="stylesheet" href="css/dashboard.css" />
</head>

<body>

		
  
			<div class="contact-us section" id="contact" style="margin:0px; top:100px">

				<div class="col-lg-6">
					<div class="contact-us-content">
						<form id="contact-form" action="" method="post">
						<div class="row">
							
							<div class="col-lg-12">
							<fieldset>
							<input type="text" class="form-control" id="correoElec" name="correoElec" value="<?php if (!empty($_POST["correoElec"])) { echo $_POST["correoElec"]; } ?>" placeholder="Correo Electrónico"  required>
							</fieldset>
							</div>
							<div class="col-lg-12">
							<fieldset>
							<input type="password" class="form-control" id="password" name="password" value="<?php if (!empty($_POST["password"])) { echo $_POST["password"]; } ?>" placeholder="Contraseña" required>
							</fieldset>
							</div>
							<div class="col-lg-12">
							<fieldset>
							<input type="submit" name="login" value="Acceder" class="btn btn-info">
							</fieldset>
							</div>
						</div>
						</form>
					</div>
				</div>
				

			<?php include("./footer.php"); ?>
		</div>
</body>

</html>
