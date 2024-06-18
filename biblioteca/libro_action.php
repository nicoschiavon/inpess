<?php
include_once 'config/Database.php';
include_once 'class/Libro.php';
include_once 'class/TextoCientifico.php';

$database = new Database();
$db = $database->getConnection();

$libro = new Libro($db);
$textoCientifico = new TextoCientifico($db);

header('Content-Type: application/json');

if (!empty($_POST['action'])) {
    $action = $_POST['action'];
    switch ($action) {
        case 'listLibros':
            echo $libro->listLibros();
            break;

        case 'listLibrosbiblio':
            echo $libro->listLibrosbiblio();
            break;

        case 'getLibroDetails':
            if (isset($_POST["idTextoCientifico"])) {
                $libro->idTextoCientifico = $_POST["idTextoCientifico"];
               
                $stmt = $libro->getLibroDetails();
                if ($stmt === false) {
                    echo json_encode(['error' => 'Error en la consulta']);
                    exit;
                }
                $stmt->store_result();
                $stmt->bind_result($idTextoCientifico, $titulo, $pdf, $isbn_issn_acta, $resumen, $tipo, $editorial, $anioPub);
                $data = array();
                while ($stmt->fetch()) {
                    $data[] = array(
                        'l.idTextoCientifico' => $idTextoCientifico,
                        't.titulo' => $titulo,
                        't.pdf' => $pdf,
                        't.isbn_issn_acta' => $isbn_issn_acta,
                        't.resumen' => $resumen,
                        't.tipo' => $tipo,
                        'l.editorial' => $editorial,
                        'l.anioPub' => $anioPub
                    );
                }
                $stmt->close();
                echo json_encode($data);
            } else {
                echo json_encode(['error' => 'idTextoCientifico no especificado']);
            }
            break;

        case 'addLibro':
            if (isset($_FILES["pdf"])) {
                $file = $_FILES["pdf"]["tmp_name"];
                $textoCientifico->pdf = file_get_contents($file);
            }
            $textoCientifico->titulo = $_POST["titulo"];
            $textoCientifico->isbn_issn_acta = $_POST["isbn_issn_acta"];
            $textoCientifico->resumen = $_POST["resumen"];
            $textoCientifico->tipo = 'libro';
            
            if ($textoCientifico->insert() ) {
                echo json_encode(['success' => 'Libro agregado correctamente']);
            } else {
                echo json_encode(['error' => 'Error al agregar el libro']);
            }


            $libro->editorial = $_POST["editorial"];
            $libro->anioPub = $_POST["anioPub"];
            
            if ( $libro->insert()) {
                echo json_encode(['success' => 'Libro agregado correctamente']);
            } else {
                echo json_encode(['error' => 'Error al agregar el libro']);
            }
            break;

        case 'updateLibro':
            if (isset($_FILES["pdf"])) {
                $file = $_FILES["pdf"]["tmp_name"];
                $textoCientifico->pdf = file_get_contents($file);
            }
            
            $textoCientifico->idTextoCientifico = $_POST["idTextoCientifico"];
            $textoCientifico->titulo = $_POST["titulo"];
            $textoCientifico->isbn_issn_acta = $_POST["isbn_issn_acta"];
            $textoCientifico->resumen = $_POST["resumen"];
            $textoCientifico->tipo = $_POST["tipo"];
            


            $libro->idTextoCientifico = $_POST["idTextoCientifico"];
            $libro->editorial = $_POST["editorial"];
            $libro->anioPub = $_POST["anioPub"];
            
            if ($textoCientifico->update() && $libro->update()) {
                echo json_encode(['success' => 'Libro actualizado correctamente']);
            } else {
                echo json_encode(['error' => 'Error al actualizar el libro']);
            }
            break;

        case 'deleteLibro':
            $textoCientifico->idTextoCientifico = $_POST["idTextoCientifico"];
            $libro->idTextoCientifico = $_POST["idTextoCientifico"];
            if ($libro->delete()) {
                echo json_encode(['success' => 'Libro eliminado correctamente']);
            } else {
                echo json_encode(['error' => 'Error al eliminar el libro']);
            }
            if ($textoCientifico->delete()) {
                echo json_encode(['success' => 'Libro eliminado correctamente']);
            } else {
                echo json_encode(['error' => 'Error al eliminar el libro']);
            }
            break;

        default:
            echo json_encode(['error' => 'Acción no válida']);
    }
} else {
    echo json_encode(['error' => 'Acción no especificada']);
}
?>
