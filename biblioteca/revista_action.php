<?php
include_once 'config/Database.php';
include_once 'class/Revista.php';
include_once 'class/TextoCientifico.php';

$database = new Database();
$db = $database->getConnection();

$revista = new Revista($db);
$textoCientifico = new TextoCientifico($db);

header('Content-Type: application/json');

if (!empty($_POST['action'])) {
    $action = $_POST['action'];
    switch ($action) {
        case 'listRevistas':
            echo $revista->listRevistas();
            break;
        case 'listRevistasBiblio':
            echo $revista->listRevistasBiblio();
            break;

        case 'getRevistaDetails':
            if (isset($_POST["idTextoCientifico"])) {
                $revista->idTextoCientifico = $_POST["idTextoCientifico"];
                $stmt = $revista->getRevistaDetails();
                if ($stmt === false) {
                    echo json_encode(['error' => 'Error en la consulta']);
                    exit;
                }
                $stmt->store_result();
                $stmt->bind_result($idTextoCientifico, $titulo, $pdf, $isbn_issn_acta, $resumen, $tipo, $nombRev, $nroRev, $primPag, $ultPag, $mesPub, $anioPub);
                $data = array();
                while ($stmt->fetch()) {
                    $data[] = array(
                        'idTextoCientifico' => $idTextoCientifico,
                        'titulo' => $titulo,
                        'pdf' => $pdf,
                        'isbn_issn_acta' => $isbn_issn_acta,
                        'resumen' => $resumen,
                        'tipo' => $tipo,
                        'nombRev' => $nombRev,
                        'nroRev' => $nroRev,
                        'primPag' => $primPag,
                        'ultPag' => $ultPag,
                        'mesPub' => $mesPub,
                        'anioPub' => $anioPub
                    );
                }
                $stmt->close();
                echo json_encode($data);
            } else {
                echo json_encode(['error' => 'idTextoCientifico no especificado']);
            }
            break;

        case 'addRevista':
            if (isset($_FILES["pdf"])) {
                $file = $_FILES["pdf"]["tmp_name"];
                $revista->pdf = file_get_contents($file);
            }
            $textoCientifico->titulo = $_POST["titulo"];
            $textoCientifico->isbn_issn_acta = $_POST["isbn_issn_acta"];
            $textoCientifico->resumen = $_POST["resumen"];
            $textoCientifico->tipo = 'revista';
            
            if ($textoCientifico->insert() ) {
                echo json_encode(['success' => 'Libro agregado correctamente']);
            } else {
                echo json_encode(['error' => 'Error al agregar el libro']);
            }
            $revista->nombRev = $_POST["nombRev"];
            $revista->nroRev = $_POST["nroRev"];
            $revista->primPag = $_POST["primPag"];
            $revista->ultPag = $_POST["ultPag"];
            $revista->mesPub = $_POST["mesPub"];
            $revista->anioPub = $_POST["anioPub"];
            if ($revista->insert()) {
                echo json_encode(['success' => 'Revista agregada correctamente']);
            } else {
                echo json_encode(['error' => 'Error al agregar la revista']);
            }
            break;

        case 'updateRevista':
            if (isset($_FILES["pdf"])) {
                $file = $_FILES["pdf"]["tmp_name"];
                $revista->pdf = file_get_contents($file);
            }
            
            $revista->idTextoCientifico = $_POST["idTextoCientifico"];
            $revista->titulo = $_POST["titulo"];
            $revista->isbn_issn_acta = $_POST["isbn_issn_acta"];
            $revista->resumen = $_POST["resumen"];
            $revista->tipo = $_POST["tipo"];
            $revista->nombRev = $_POST["nombRev"];
            $revista->nroRev = $_POST["nroRev"];
            $revista->primPag = $_POST["primPag"];
            $revista->ultPag = $_POST["ultPag"];
            $revista->mesPub = $_POST["mesPub"];
            $revista->anioPub = $_POST["anioPub"];
            if ($revista->update()) {
                echo json_encode(['success' => 'Revista actualizada correctamente']);
            } else {
                echo json_encode(['error' => 'Error al actualizar la revista']);
            }
            break;

        case 'deleteRevista':
            $revista->idTextoCientifico = $_POST["idTextoCientifico"];
            if ($revista->delete()) {
                echo json_encode(['success' => 'Revista eliminada correctamente']);
            } else {
                echo json_encode(['error' => 'Error al eliminar la revista']);
            }
            break;

        default:
            echo json_encode(['error' => 'Acción no válida']);
    }
} else {
    echo json_encode(['error' => 'Acción no especificada']);
}
?>
