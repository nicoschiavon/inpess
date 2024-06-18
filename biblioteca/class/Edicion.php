<?php
class Edicion
{
	private $edicionTable = 'edicion';
	private $conn;

	public function __construct($db)
	{
		$this->conn = $db;
	}

	public function insert()
	{
		if ($this->idNota && $this->idMiembro && $_SESSION["userid"]) {
			$stmt = $this->conn->prepare("
				INSERT INTO " . $this->edicionTable . "(`idNota`, `idMiembro`, `dateTime`, `usuario`)
				VALUES(?, ?, ?, ?)");
			$this->idNota = htmlspecialchars(strip_tags($this->idNota));
			$this->idMiembro = htmlspecialchars(strip_tags($this->idMiembro));
			$this->dateTime = htmlspecialchars(strip_tags($this->dateTime));
			$this->usuario = htmlspecialchars(strip_tags($this->usuario));
			$stmt->bind_param("iiss", $this->idNota, $this->idMiembro, $this->dateTime, $this->usuario);

			if ($stmt->execute()) {
				return true;
			}
		}
	}

	public function delete()
	{
		if ($this->idNota && $this->idMiembro && $_SESSION["userid"]) {

			$stmt = $this->conn->prepare("
				DELETE FROM " . $this->edicionTable . " 
				WHERE idNota = ? AND idMiembro = ?");

			$this->idNota = htmlspecialchars(strip_tags($this->idNota));
			$this->idMiembro = htmlspecialchars(strip_tags($this->idMiembro));

			$stmt->bind_param("ii", $this->idNota, $this->idMiembro);

			if ($stmt->execute()) {
				return true;
			}
		}
	}

	public function listEdiciones()
	{
		$sqlQuery = "SELECT idNota, idMiembro, dateTime, usuario
			FROM " . $this->edicionTable;

		$stmt = $this->conn->prepare($sqlQuery);
		$stmt->execute();
		$result = $stmt->get_result();
		$records = array();
		while ($edicion = $result->fetch_assoc()) {
			$records[] = $edicion;
		}
		echo json_encode($records);
	}
}
?>
