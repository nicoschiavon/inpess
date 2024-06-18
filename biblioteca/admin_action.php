<?php
include_once 'config/Database.php';
include_once 'class/Administrador.php';

$database = new Database();
$db = $database->getConnection();

$admin = new Administrador($db);

if(!empty($_POST['action']) && $_POST['action'] == 'listAdmins') {
	$admin->listAdmins();
}

if(!empty($_POST['action']) && $_POST['action'] == 'getAedminDetails') {
	$admin->admin_id = $_POST["idAdmin"];
	$admin->getAdminDetails();
}

if(!empty($_POST['action']) && $_POST['action'] == 'addUser') {
	$admin->usuario = $_POST["usuario"];
	$admin->password = $_POST["password"];
	$admin->insert();
}

if(!empty($_POST['action']) && $_POST['action'] == 'updateAdmin') {
	$admin->idAdmin = $_POST["idAdmin"];
	$admin->usuario = $_POST["usuario"];
	$admin->password = $_POST["password"];
	$admin->update();
}

if(!empty($_POST['action']) && $_POST['action'] == 'deleteAdmin') {
	$admin->idAdmin = $_POST["idAdmin"];
	$admin->delete();
}

?>