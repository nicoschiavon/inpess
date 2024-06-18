<?php
class Autor
{
	private $autorTable = 'autor';
	private $conn;

	public function __construct($db)
	{
		$this->conn = $db;
	}

    public function listAuthor()
	{

		$sqlQuery = "SELECT idTextoCientifico, autor 
			FROM " . $this->autorTable . " ";

		if (!empty($_POST["search"]["value"])) {
			$sqlQuery .= ' WHERE (idTextoCientifico LIKE "%' . $_POST["search"]["value"] . '%" ';
			$sqlQuery .= ' OR autor LIKE "%' . $_POST["search"]["value"] . '%" ';
			
		}

		if (!empty($_POST["order"])) {
			$sqlQuery .= 'ORDER BY ' . $_POST['order']['0']['column'] . ' ' . $_POST['order']['0']['dir'] . ' ';
		} else {
			$sqlQuery .= 'ORDER BY idTextoCientifico DESC ';
		}

		if ($_POST["length"] != -1) {
			$sqlQuery .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
		}

		$stmt = $this->conn->prepare($sqlQuery);
		$stmt->execute();
		$result = $stmt->get_result();

		$stmtTotal = $this->conn->prepare($sqlQuery);
		$stmtTotal->execute();
		$allResult = $stmtTotal->get_result();
		$allRecords = $allResult->num_rows;

		$displayRecords = $result->num_rows;
		$records = array();
		$count = 1;
		while ($autor = $result->fetch_assoc()) {
			$rows = array();
			$rows[] = $count;
			$rows[] = ucfirst($autor['autor']);
			$rows[] = '<button type="button" name="update" id="' . $autor["autor"] . '" class="btn btn-warning btn-xs update"><span class="glyphicon glyphicon-edit" title="Edit">Editar</span></button>';
			$rows[] = '<button type="button" name="delete" id="' . $autor["autor"] . '" class="btn btn-danger btn-xs delete" ><span class="glyphicon glyphicon-remove" title="Delete">Eliminar</span></button>';
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


	public function insert()
	{
		if ($this->autor && $_SESSION["idMiembro"]) {
			$stmt = $this->conn->prepare("
				INSERT INTO " . $this->autorTable . "(`autor`)
				VALUES(?, ?)");

			$this->autor = htmlspecialchars(strip_tags($this->autor));
			$stmt->bind_param("s",$this->autor;

			if ($stmt->execute()) {
				return true;
			}
		}
	}

	public function delete()
	{
		if ($this->idTextoCientifico && $this->autor && $_SESSION["idMiembro"]) {

			$stmt = $this->conn->prepare("
				DELETE FROM " . $this->autorTable . " 
				WHERE idTextoCientifico = ? AND autor = ?");

			$this->idTextoCientifico = htmlspecialchars(strip_tags($this->idTextoCientifico));
			$this->autor = htmlspecialchars(strip_tags($this->autor));

			$stmt->bind_param("is", $this->idTextoCientifico, $this->autor);

			if ($stmt->execute()) {
				return true;
			}
		}
	}

	
}
?>
