<?php
class Imagenes
{
	private $imagenesTable = 'imagenes';
	private $conn;

	public function __construct($db)
	{
		$this->conn = $db;
	}

	public function insert()
	{
		if ($this->idNota && $this->imagenes && $_SESSION["userid"]) {
			$stmt = $this->conn->prepare("
				INSERT INTO " . $this->imagenesTable . "(`idNota`, `imagenes`)
				VALUES(?, ?)");
			$this->idNota = htmlspecialchars(strip_tags($this->idNota));
			$this->imagenes = htmlspecialchars(strip_tags($this->imagenes));
			$stmt->bind_param("is", $this->idNota, $this->imagenes);

			if ($stmt->execute()) {
				return true;
			}
		}
	}

	public function delete()
	{
		if ($this->idNota && $this->imagenes && $_SESSION["userid"]) {

			$stmt = $this->conn->prepare("
				DELETE FROM " . $this->imagenesTable . " 
				WHERE idNota = ? AND imagenes = ?");

			$this->idNota = htmlspecialchars(strip_tags($this->idNota));
			$this->imagenes = htmlspecialchars(strip_tags($this->imagenes));

			$stmt->bind_param("is", $this->idNota, $this->imagenes);

			if ($stmt->execute()) {
				return true;
			}
		}
	}

	public function listImagenes()
	{
		$sqlQuery = "SELECT idNota, imagenes
			FROM " . $this->imagenesTable;

		$stmt = $this->conn->prepare($sqlQuery);
		$stmt->execute();
		$result = $stmt->get_result();
		$records = array();
		while ($imagen = $result->fetch_assoc()) {
			$records[] = $imagen;
		}
		echo json_encode($records);
	}
}
?>
