<?php
class TextoPalClaves
{
	private $textoPalClavesTable = 'textoPalClaves';
	private $conn;

	public function __construct($db)
	{
		$this->conn = $db;
	}

	public function insert()
	{
		if ($this->idTexto && $this->textoPalClaves && $_SESSION["userid"]) {
			$stmt = $this->conn->prepare("
				INSERT INTO " . $this->textoPalClavesTable . "(`idTexto`, `textoPalClaves`)
				VALUES(?, ?)");
			$this->idTexto = htmlspecialchars(strip_tags($this->idTexto));
			$this->textoPalClaves = htmlspecialchars(strip_tags($this->textoPalClaves));
			$stmt->bind_param("is", $this->idTexto, $this->textoPalClaves);

			if ($stmt->execute()) {
				return true;
			}
		}
	}

	public function delete()
	{
		if ($this->idTexto && $this->textoPalClaves && $_SESSION["userid"]) {

			$stmt = $this->conn->prepare("
				DELETE FROM " . $this->textoPalClavesTable . " 
				WHERE idTexto = ? AND textoPalClaves = ?");

			$this->idTexto = htmlspecialchars(strip_tags($this->idTexto));
			$this->textoPalClaves = htmlspecialchars(strip_tags($this->textoPalClaves));

			$stmt->bind_param("is", $this->idTexto, $this->textoPalClaves);

			if ($stmt->execute()) {
				return true;
			}
		}
	}

	public function listTextoPalClaves()
	{
		$sqlQuery = "SELECT idTexto, textoPalClaves
			FROM " . $this->textoPalClavesTable;

		$stmt = $this->conn->prepare($sqlQuery);
		$stmt->execute();
		$result = $stmt->get_result();
		$records = array();
		while ($clave = $result->fetch_assoc()) {
			$records[] = $clave;
		}
		echo json_encode($records);
	}
}
?>
