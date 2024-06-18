<?php
class ActaCongreso
{
	private $actaCongresoTable = 'actaCongreso';
	private $conn;

	public function __construct($db)
	{
		$this->conn = $db;
	}

	public function insert()
	{
		if ($this->idTexto && $this->nombCong && $this->ediCong && $this->fecInic && $this->fecFin && $this->paisCong && $this->ciudad && $_SESSION["userid"]) {
			$stmt = $this->conn->prepare("
				INSERT INTO " . $this->actaCongresoTable . "(`idTexto`, `nombCong`, `ediCong`, `fecInic`, `fecFin`, `paisCong`, `ciudad`)
				VALUES(?, ?, ?, ?, ?, ?, ?)");
			$this->idTexto = htmlspecialchars(strip_tags($this->idTexto));
			$this->nombCong = htmlspecialchars(strip_tags($this->nombCong));
			$this->ediCong = htmlspecialchars(strip_tags($this->ediCong));
			$this->fecInic = htmlspecialchars(strip_tags($this->fecInic));
			$this->fecFin = htmlspecialchars(strip_tags($this->fecFin));
			$this->paisCong = htmlspecialchars(strip_tags($this->paisCong));
			$this->ciudad = htmlspecialchars(strip_tags($this->ciudad));
			$stmt->bind_param("issssss", $this->idTexto, $this->nombCong, $this->ediCong, $this->fecInic, $this->fecFin, $this->paisCong, $this->ciudad);

			if ($stmt->execute()) {
				return true;
			}
		}
	}

	public function delete()
	{
		if ($this->idTexto && $this->nombCong && $_SESSION["userid"]) {

			$stmt = $this->conn->prepare("
				DELETE FROM " . $this->actaCongresoTable . " 
				WHERE idTexto = ? AND nombCong = ?");

			$this->idTexto = htmlspecialchars(strip_tags($this->idTexto));
			$this->nombCong = htmlspecialchars(strip_tags($this->nombCong));

			$stmt->bind_param("is", $this->idTexto, $this->nombCong);

			if ($stmt->execute()) {
				return true;
			}
		}
	}

	public function listActasCongreso()
	{
		$sqlQuery = "SELECT idTexto,
