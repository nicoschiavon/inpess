<?php
class NotaClaves
{
	private $notaClavesTable = 'notaClaves';
	private $conn;

	public function __construct($db)
	{
		$this->conn = $db;
	}

	public function insert()
	{
		if ($this->idNota && $this->notaClaves && $_SESSION["userid"]) {
			$stmt = $this->conn->prepare("
				INSERT INTO " . $this->notaClavesTable . "(`idNota`, `notaClaves`)
				VALUES(?, ?)");
			$this->idNota = htmlspecialchars(strip_tags($this->idNota));
			$this->notaClaves = htmlspecialchars(strip_tags($this->notaClaves));
			$stmt->bind_param("is", $this->idNota, $this->notaClaves);

			if ($stmt->execute()) {
				return true;
			}
		}
	}

	public function delete()
	{
		if ($this->idNota && $this->notaClaves && $_SESSION["userid"]) {

			$stmt = $this->conn->prepare("
				DELETE FROM " . $this->notaClavesTable . " 
				WHERE idNota = ? AND notaClaves = ?");

			$this->idNota = htmlspecialchars(strip_tags($this->idNota));
			$this->notaClaves = htmlspecialchars(strip_tags($this->notaClaves));

			$stmt->bind_param("is", $this->idNota, $this->notaClaves);

			if ($stmt->execute()) {
				return true;
			}
		}
	}

	public function listNotaClaves()
	{
		$sqlQuery = "SELECT idNota, notaClaves
			FROM " . $this->notaClavesTable;

		$stmt = $this->conn->prepare($sqlQuery);
		$stmt->execute();
		$result = $stmt->get_result();
		$records = array();
		while ($notaClave = $result->fetch_assoc()) {
			$records[] = $notaClave;
		}
		echo json_encode($records);
	}
}
?>
