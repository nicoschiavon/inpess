<?php
include_once 'config/Database.php';
include_once 'class/TextoCientifico.php';

$database = new Database();
$db = $database->getConnection();

$textoCientifico = new TextoCientifico($db);

header('Content-Type: application/json');

if (!empty($_POST['action'])) {
    $action = $_POST['action'];
    switch ($action) {
		case 'listTextos':
			echo $textoCientifico->listTextos();
			break;
        case 'listTextosBiblio':
            echo $textoCientifico->listTextosBiblio();
            break;

        case 'getTextoDetails':
            if (isset($_POST["idTextoCientifico"])) {
                $textoCientifico->idTextoCientifico = $_POST["idTextoCientifico"];
                $stmt = $textoCientifico->getTextoDetails();
                if ($stmt === false) {
                    echo json_encode(['error' => 'Error en la consulta']);
                    exit;
                }
                $stmt->store_result();
                $stmt->bind_result($idTextoCientifico, $titulo, $pdf, $isbn_issn_acta, $resumen, $tipo);
                $data = array();
                while ($stmt->fetch()) {
                    $data[] = array(
                        'idTextoCientifico' => $idTextoCientifico,
                        'titulo' => $titulo,
                        'pdf' => $pdf,
                        'isbn_issn_acta' => $isbn_issn_acta,
                        'resumen' => $resumen,
                        'tipo' => $tipo
                    );
                }
                $stmt->close();
                echo json_encode($data);
            } else {
                echo json_encode(['error' => 'idTextoCientifico no especificado']);
            }
            break;

        case 'addTexto':
            if (isset($_FILES["pdf"])) {
                $file = $_FILES["pdf"]["tmp_name"];
                $textoCientifico->pdf = file_get_contents($file);
            }
            $textoCientifico->titulo = $_POST["titulo"];
            $textoCientifico->isbn_issn_acta = $_POST["isbn_issn_acta"];
            $textoCientifico->resumen = $_POST["resumen"];
            $textoCientifico->tipo = $_POST["tipo"];
            if ($textoCientifico->insert()) {
                echo json_encode(['success' => 'Texto Científico agregado correctamente']);
            } else {
                echo json_encode(['error' => 'Error al agregar el texto científico']);
            }
            break;

        case 'updateTexto':
            if (isset($_FILES["pdf"])) {
                $file = $_FILES["pdf"]["tmp_name"];
                $textoCientifico->pdf = file_get_contents($file);
            } else {
                // Mantener el PDF existente si no se sube uno nuevo
                //$existingTexto = $textoCientifico->getTextoDetails()->fetch_assoc();
                //$textoCientifico->pdf = $existingTexto['pdf'];
            }
            
            $textoCientifico->idTextoCientifico = $_POST["idTextoCientifico"];
            $textoCientifico->titulo = $_POST["titulo"];
            $textoCientifico->isbn_issn_acta = $_POST["isbn_issn_acta"];
            $textoCientifico->resumen = $_POST["resumen"];
            $textoCientifico->tipo = $_POST["tipo"];
            if ($textoCientifico->update()) {
                echo json_encode(['success' => 'Texto Científico actualizado correctamente']);
            } else {
                echo json_encode(['error' => 'Error al actualizar el texto científico']);
            }
            break;

        case 'deleteTexto':
            $textoCientifico->idTextoCientifico = $_POST["idTextoCientifico"];
            if ($textoCientifico->delete()) {
                echo json_encode(['success' => 'Texto Científico eliminado correctamente']);
            } else {
                echo json_encode(['error' => 'Error al eliminar el texto científico']);
            }
            break;

        default:
            echo json_encode(['error' => 'Acción no válida']);
    }
} else {
    echo json_encode(['error' => 'Acción no especificada']);
}
?>
