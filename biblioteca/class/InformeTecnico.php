<?php
class InformeTecnico
{
	private $informeTecnicoTable = 'informeTecnico';
	private $conn;

	public function __construct($db)
	{
		$this->conn = $db;
	}

	public function insert()
	{
		if ($this->idTexto && $this->nroInf && $this->centroPub && $this->anioPub && $_SESSION["userid"]) {
			$stmt = $this->conn->prepare("
				INSERT INTO " . $this->informeTecnicoTable . "(`idTexto`, `nroInf`, `centroPub`, `anioPub`)
				VALUES(?, ?, ?, ?)");
			$this->idTexto = htmlspecialchars(strip_tags($this->idTexto));
			$this->nroInf = htmlspecialchars(strip_tags($this->nroInf));
			$this->centroPub = htmlspecialchars(strip_tags($this->centroPub));
			$this->anioPub = htmlspecialchars(strip_tags($this->anioPub));
			$stmt->bind_param("isss", $this->idTexto, $this->nroInf, $this->centroPub, $this->anioPub);

			if ($stmt->execute()) {
				return true;
			}
		}
	}

	public function delete()
	{
		if ($this->idTexto && $this->nroInf && $_SESSION["userid"]) {

			$stmt = $this->conn->prepare("
				DELETE FROM " . $this->informeTecnicoTable . " 
				WHERE idTexto = ? AND nroInf = ?");

			$this->idTexto = htmlspecialchars(strip_tags($this->idTexto));
			$this->nroInf = htmlspecialchars(strip_tags($this->nroInf));

			$stmt->bind_param("is", $this->idTexto, $this->nroInf);

			if ($stmt->execute()) {
				return true;
			}
		}
	}

	public function listInformesTecnicos()
	{
		$sqlQuery = "SELECT idTexto, nroInf, centroPub, anioPub
			FROM " . $this->informeTecnicoTable;

		$stmt = $this->conn->prepare($sqlQuery);
		$stmt->execute();
		$result = $stmt->get_result();
		$records = array();
		while ($informe = $result->fetch_assoc()) {
			$records[] = $informe;
		}
		echo json_encode($records);
	}
}
?>
