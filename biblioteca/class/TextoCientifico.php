<?php
class TextoCientifico {
    private $conn;
    private $table_name = "textocientifico";

    public $idTextoCientifico;
    public $titulo;
    public $pdf;
    public $isbn_issn_acta;
    public $resumen;
    public $tipo;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function listTextos() {
		$query = "SELECT idTextoCientifico, titulo, pdf, isbn_issn_acta, resumen, tipo FROM " . $this->table_name;
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
            $rows[] = '<a href="ver_pdf.php?idTextoCientifico=' . $textoCientifico["idTextoCientifico"] . '" target="_blank">Ver PDF</a>';

			$rows[] = '<button type="button" name="updateTexto" idTextoCientifico="' . $textoCientifico["idTextoCientifico"] . '" class="btn btn-warning btn-xs update"><span class="glyphicon glyphicon-edit" title="Edit">Editar</span></button>';
        $rows[] = '<button type="button" name="deleteTexto" idTextoCientifico="' . $textoCientifico["idTextoCientifico"] . '" class="btn btn-danger btn-xs delete"><span class="glyphicon glyphicon-remove" title="Delet">Eliminar</span></button>';

			$records[] = $rows;
			$count++;
		}

		$output = array(
			"draw"	=>	intval($_POST["draw"]),
			"iTotalRecords"	=> 	$displayRecords,
			"iTotalDisplayRecords"	=>  $allRecords,
			"data"	=> 	$records
		);

		echo json_encode($output);
    }


    public function listTextosBiblio() {
		$query = "SELECT idTextoCientifico, titulo, pdf, isbn_issn_acta, resumen, tipo FROM " . $this->table_name;
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
            $rows[] = '<a href="ver_pdf.php?idTextoCientifico=' . $textoCientifico["idTextoCientifico"] . '" target="_blank">Ver PDF</a>';

			$records[] = $rows;
			$count++;
		}

		$output = array(
			"draw"	=>	intval($_POST["draw"]),
			"iTotalRecords"	=> 	$displayRecords,
			"iTotalDisplayRecords"	=>  $allRecords,
			"data"	=> 	$records
		);

		echo json_encode($output);
    }

    public function getTextoDetails() {
        $query = "SELECT idTextoCientifico, titulo, pdf, isbn_issn_acta, resumen, tipo FROM " . $this->table_name . " WHERE idTextoCientifico = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $this->idTextoCientifico);
        $stmt->execute();
        return $stmt;
    }

    public function insert() {
        $query = "INSERT INTO " . $this->table_name . " (titulo, pdf, isbn_issn_acta, resumen, tipo) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);

        if ($stmt === false) {
            throw new Exception('Error al preparar la consulta: ' . $this->conn->error);
        }

        $stmt->bind_param("sssss", $this->titulo, $this->pdf, $this->isbn_issn_acta, $this->resumen, $this->tipo);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function update() {
        $query = "UPDATE " . $this->table_name . " SET titulo = ?, pdf = ?, isbn_issn_acta = ?, resumen = ?, tipo = ? WHERE idTextoCientifico = ?";
        $stmt = $this->conn->prepare($query);

        if ($stmt === false) {
            throw new Exception('Error al preparar la consulta: ' . $this->conn->error);
        }

        $stmt->bind_param("sssssi", $this->titulo, $this->pdf, $this->isbn_issn_acta, $this->resumen, $this->tipo, $this->idTextoCientifico);

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
