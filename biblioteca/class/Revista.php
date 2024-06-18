<?php
require_once 'TextoCientifico.php';

class Revista extends TextoCientifico {
    protected $table_name = "revista";
    
    private $conn;
    public $nombRev;
    public $nroRev;
    public $primPag;
    public $ultPag;
    public $mesPub;
    public $anioPub;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function listRevistas() {
        $query = "SELECT r.idTextoCientifico, r.nombRev, r.nroRev, r.primPag, r.ultPag, r.mesPub, r.anioPub, t.titulo, t.pdf, t.resumen, t.isbn_issn_acta, t.tipo
        FROM " . $this->table_name . " r
        INNER JOIN textocientifico t ON r.idTextoCientifico = t.idTextoCientifico";
                $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            return json_encode(array("data" => array(), "error" => $this->conn->error));
        }

        $stmt->execute();
        $result = $stmt->get_result();

        $stmtTotal = $this->conn->prepare($query);
        $stmtTotal->execute();
        $allResult = $stmtTotal->get_result();
        $allRecords = $allResult->num_rows;

        $displayRecords = $result->num_rows;
        $records = array();
        $count = 1;
        while ($textoCientifico = $result->fetch_assoc()) {
            $rows = array();
            $rows[] = $count;
            $rows[] = ucfirst($textoCientifico['titulo']);
            $rows[] = $textoCientifico['isbn_issn_acta'];
            $rows[] = ucfirst($textoCientifico['resumen']);
            $rows[] = ucfirst($textoCientifico['tipo']);
            $rows[] = ucfirst($textoCientifico['nombRev']);
            $rows[] = $textoCientifico['nroRev'];
            $rows[] = $textoCientifico['primPag'];
            $rows[] = $textoCientifico['ultPag'];
            $rows[] = $textoCientifico['mesPub'];
            $rows[] = $textoCientifico['anioPub'];
            $rows[] = '<a href="ver_pdf.php?idTextoCientifico=' . $textoCientifico["idTextoCientifico"] . '" target="_blank">Ver PDF</a>';

            $rows[] = '<button type="button" name="updateTexto" idTextoCientifico="' . $textoCientifico["idTextoCientifico"] . '" class="btn btn-warning btn-xs update"><span class="glyphicon glyphicon-edit" title="Edit">Editar</span></button>';
            $rows[] = '<button type="button" name="deleteTexto" idTextoCientifico="' . $textoCientifico["idTextoCientifico"] . '" class="btn btn-danger btn-xs delete"><span class="glyphicon glyphicon-remove" title="Delete">Eliminar</span></button>';

            $records[] = $rows;
            $count++;
        }

        $output = array(
            "draw" => intval($_POST["draw"]),
            "iTotalRecords" => $displayRecords,
            "iTotalDisplayRecords" => $allRecords,
            "data" => $records
        );

        echo json_encode($output);
    }

    public function listRevistasBiblio() {
        $query = "SELECT r.idTextoCientifico, r.nombRev, r.nroRev, r.primPag, r.ultPag, r.mesPub, r.anioPub, t.titulo, t.pdf, t.resumen, t.isbn_issn_acta, t.tipo
        FROM " . $this->table_name . " r
        INNER JOIN textocientifico t ON r.idTextoCientifico = t.idTextoCientifico";
                $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            return json_encode(array("data" => array(), "error" => $this->conn->error));
        }

        $stmt->execute();
        $result = $stmt->get_result();

        $stmtTotal = $this->conn->prepare($query);
        $stmtTotal->execute();
        $allResult = $stmtTotal->get_result();
        $allRecords = $allResult->num_rows;

        $displayRecords = $result->num_rows;
        $records = array();
        $count = 1;
        while ($textoCientifico = $result->fetch_assoc()) {
            $rows = array();
            $rows[] = $count;
            $rows[] = ucfirst($textoCientifico['titulo']);
            $rows[] = $textoCientifico['isbn_issn_acta'];
            $rows[] = ucfirst($textoCientifico['resumen']);
            $rows[] = ucfirst($textoCientifico['tipo']);
            $rows[] = ucfirst($textoCientifico['nombRev']);
            $rows[] = $textoCientifico['nroRev'];
            $rows[] = $textoCientifico['primPag'];
            $rows[] = $textoCientifico['ultPag'];
            $rows[] = $textoCientifico['mesPub'];
            $rows[] = $textoCientifico['anioPub'];
            $rows[] = '<a href="ver_pdf.php?idTextoCientifico=' . $textoCientifico["idTextoCientifico"] . '" target="_blank">Ver PDF</a>';
            
            $records[] = $rows;
            $count++;
        }

        $output = array(
            "draw" => intval($_POST["draw"]),
            "iTotalRecords" => $displayRecords,
            "iTotalDisplayRecords" => $allRecords,
            "data" => $records
        );

        echo json_encode($output);
    }




    public function getRevistaDetails() {
		$query = "SELECT r.idTextoCientifico, r.nombRev, r.nroRev, r.primPag, r.ultPag, r.mesPub, r.anioPub, t.titulo, t.pdf, t.isbn_issn_acta, t.resumen, t.tipo
				  FROM " . $this->table_name . " r
				  INNER JOIN textocientifico t ON r.idTextoCientifico = t.idTextoCientifico
				  WHERE l.idTextoCientifico = ? ";
				  
		$stmt = $this->conn->prepare($query);
		$stmt->bind_param("i", $this->idTextoCientifico);
		$stmt->execute();
		
		return $stmt;
    }

    public function insert() {
        $query_last_id = "SELECT idTextoCientifico FROM textocientifico ORDER BY idTextoCientifico DESC LIMIT 1";
		$result_last_id = $this->conn->query($query_last_id);
		if ($result_last_id === false) {
			throw new Exception('Error al obtener el último idTextoCientifico: ' . $this->conn->error);
		}
		
		$last_id_row = $result_last_id->fetch_assoc();
		$last_id = $last_id_row['idTextoCientifico'];
        
        $query = "INSERT INTO " . $this->table_name . " (idTextoCientifico, nombRev, nroRev, primPag, ultPag, mesPub, anioPub) VALUES (?, ?, ?, ?, ?, ?, ?)";  
        $stmt = $this->conn->prepare($query);

        if ($stmt === false) {
            throw new Exception('Error al preparar la consulta: ' . $this->conn->error);
        }

        $stmt->bind_param("issssss", $last_id, $this->nombRev, $this->nroRev, $this->primPag, $this->ultPag, $this->mesPub, $this->anioPub);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function update() {
        $query = "UPDATE " . $this->table_name . " SET titulo = ?, pdf = ?, isbn_issn_acta = ?, resumen = ?, tipo = ?, nombRev = ?, nroRev = ?, primPag = ?, ultPag = ?, mesPub = ?, anioPub = ? WHERE idTextoCientifico = ?";
        $stmt = $this->conn->prepare($query);

        if ($stmt === false) {
            throw new Exception('Error al preparar la consulta: ' . $this->conn->error);
        }

        $stmt->bind_param("sssssssssssi", $this->titulo, $this->pdf, $this->isbn_issn_acta, $this->resumen, $this->tipo, $this->nombRev, $this->nroRev, $this->primPag, $this->ultPag, $this->mesPub, $this->anioPub, $this->idTextoCientifico);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE idTextoCientifico = ?";
        $stmt = $this->conn->prepare($query);

        if ($stmt === false) {
            throw new Exception('Error al preparar la consulta: ' . $this->conn->error);
        }

        $stmt->bind_param("i", $this->idTextoCientifico);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
?>
