<?php
include_once 'config/Database.php';
include_once 'class/TextoCientifico.php';

$database = new Database();
$db = $database->getConnection();

$textoCientifico = new TextoCientifico($db);

if (isset($_GET['idTextoCientifico'])) {
    $textoCientifico->idTextoCientifico = $_GET['idTextoCientifico'];
    $stmt = $textoCientifico->getTextoDetails();
    $stmt->store_result();
    $stmt->bind_result($idTextoCientifico, $titulo, $pdf, $isbn_issn_acta, $resumen, $tipo);
    $stmt->fetch();

    if ($pdf) {
        header('Content-Type: application/pdf');
        header('Content-Disposition: inline; filename="' . $titulo . '.pdf"');
        var_dump($pdf); // Esto te permitirá ver el contenido del PDF
        echo $pdf;
    } else {
        echo 'PDF no encontrado.';
    }
} else {
    echo 'ID no especificado.';
}
?>
