<?php
include_once 'config/Database.php';
include_once 'class/Miembro.php';

$database = new Database();
$db = $database->getConnection();

$miembro = new Miembro($db);

if (!empty($_POST['action']) && $_POST['action'] == 'listMiembros') {
    $miembro->listMembers();
}

if (!empty($_POST['action']) && $_POST['action'] == 'getMiembroDetails') {
    $miembro->idMiembro = $_POST["idMiembro"];
    $miembro->getMemberDetails();
}

if (!empty($_POST['action']) && $_POST['action'] == 'addMiembro') {
    $miembro->tipoMiembro = $_POST["tipoMiembro"];
    $miembro->nombre = $_POST["nombre"];
    $miembro->usuario = $_POST["usuario"];
    $miembro->apellido = $_POST["apellido"];
    $miembro->correoElec = $_POST["correoElec"];
    $miembro->password = $_POST["password"];
    $miembro->cuit = $_POST["cuit"];
    $miembro->telefono = $_POST["telefono"];
    $miembro->fechaNac = $_POST["fechaNac"];
    $miembro->estado = $_POST["estado"];
    $miembro->idRevisor = $_POST["idRevisor"];
    $miembro->insert();
}

if (!empty($_POST['action']) && $_POST['action'] == 'updateMiembro') {
    $miembro->idMiembro = $_POST["idMiembro"];
    $miembro->tipoMiembro = $_POST["tipoMiembro"];
    $miembro->nombre = $_POST["nombre"];
    $miembro->apellido = $_POST["apellido"];
    $miembro->correoElec = $_POST["correoElec"];
    $miembro->password = $_POST["password"];
    $miembro->cuit = $_POST["cuit"];
    $miembro->telefono = $_POST["telefono"];
    $miembro->fechaNac = $_POST["fechaNac"];
    $miembro->estado = $_POST["estado"];
    $miembro->idRevisor = $_POST["idRevisor"];
    $miembro->update();
}

if (!empty($_POST['action']) && $_POST['action'] == 'deleteMiembro') {
    $miembro->idMiembro = $_POST["idMiembro"];
    $miembro->delete();
}


?>
