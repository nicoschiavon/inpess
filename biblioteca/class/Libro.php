<?php
class Libro {
    private $conn;
    private $table_name = "libro";

    public $idTextoCientifico;
    public $editorial;
    public $anioPub;

    public function __construct($db) {
        $this->conn = $db;
    }

	public function listLibros() {
		$query = "SELECT l.idTextoCientifico, l.editorial, l.anioPub, t.titulo, t.pdf, t.resumen
				  FROM " . $this->table_name . " l
				  INNER JOIN textocientifico t ON l.idTextoCientifico = t.idTextoCientifico";
				  
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
		while ($libro = $result->fetch_assoc()) {
			$rows = array();
			$rows[] = $count;
			$rows[] = $libro['titulo']; // Mostrar el título de textocientifico
			$rows[] = ucfirst($libro['editorial']);
			$rows[] = $libro['resumen']; // Mostrar el resumen de textocientifico
			$rows[] = '<a href="ver_pdf.php?idTextoCientifico=' . $libro["idTextoCientifico"] . '" target="_blank">Ver PDF</a>';

			$rows[] = $libro['anioPub'];
			$rows[] = '<button type="button" name="updateLibro" idTextoCientifico="' . $libro["idTextoCientifico"] . '" class="btn btn-warning btn-xs update"><span class="glyphicon glyphicon-edit" title="Edit">Editar</span></button>';
			$rows[] = '<button type="button" name="deleteLibro" idTextoCientifico="' . $libro["idTextoCientifico"] . '" class="btn btn-danger btn-xs delete"><span class="glyphicon glyphicon-remove" title="Delete">Eliminar</span></button>';
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

	public function listLibrosbiblio() {
		$query = "SELECT l.idTextoCientifico, l.editorial, l.anioPub, t.titulo, t.pdf, t.resumen
				  FROM " . $this->table_name . " l
				  INNER JOIN textocientifico t ON l.idTextoCientifico = t.idTextoCientifico";
				  
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
		while ($libro = $result->fetch_assoc()) {
			$rows = array();
			$rows[] = $count;
			$rows[] = $libro['titulo']; // Mostrar el título de textocientifico
			$rows[] = ucfirst($libro['editorial']);
			$rows[] = $libro['resumen']; // Mostrar el resumen de textocientifico
			$rows[] = '<a href="ver_pdf.php?idTextoCientifico=' . $libro["idTextoCientifico"] . '" target="_blank">Ver PDF</a>';

			$rows[] = $libro['anioPub'];
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




	public function getLibroDetails() {
		$query = "SELECT l.idTextoCientifico, l.editorial, l.anioPub, t.titulo, t.pdf, t.isbn_issn_acta, t.resumen, t.tipo
				  FROM " . $this->table_name . " l
				  INNER JOIN textocientifico t ON l.idTextoCientifico = t.idTextoCientifico
				  WHERE l.idTextoCientifico = ? ";
				  
		$stmt = $this->conn->prepare($query);
		$stmt->bind_param("i", $this->idTextoCientifico);
		$stmt->execute();
		
		return $stmt;
    }

	public function insert() {
		// Obtener el último idTextoCientifico ingresado en la tabla textocientifico
		$query_last_id = "SELECT idTextoCientifico FROM textocientifico ORDER BY idTextoCientifico DESC LIMIT 1";
		$result_last_id = $this->conn->query($query_last_id);
		if ($result_last_id === false) {
			throw new Exception('Error al obtener el último idTextoCientifico: ' . $this->conn->error);
		}
		
		$last_id_row = $result_last_id->fetch_assoc();
		$last_id = $last_id_row['idTextoCientifico'];
		
		// Verificar si se obtuvo un último idTextoCientifico válido
		if ($last_id === null) {
			return false; // O mostrar un mensaje de error
		}
		
		// Proceder con la inserción en la tabla libro utilizando el último idTextoCientifico obtenido
		$query_insert = "INSERT INTO " . $this->table_name . " (idTextoCientifico, editorial, anioPub) VALUES (?, ?, ?)";
		$stmt_insert = $this->conn->prepare($query_insert);
	
		if ($stmt_insert === false) {
			throw new Exception('Error al preparar la consulta: ' . $this->conn->error);
		}
	
		// Utilizar el último idTextoCientifico obtenido
		$stmt_insert->bind_param("iss", $last_id, $this->editorial, $this->anioPub);
	
		if ($stmt_insert->execute()) {
			return true;
		} else {
			return false;
		}
	}

    public function update() {
        $query = "UPDATE " . $this->table_name . " SET anioPub = ? WHERE idTextoCientifico = ? AND editorial = ?";
        $stmt = $this->conn->prepare($query);

        if ($stmt === false) {
            throw new Exception('Error al preparar la consulta: ' . $this->conn->error);
        }

        $stmt->bind_param("sis", $this->anioPub, $this->idTextoCientifico, $this->editorial);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE idTextoCientifico = ? ";
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
