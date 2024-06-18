<?php
class Noticia
{
	private $noticiaTable = 'noticia';
	private $conn;

	public function __construct($db)
	{
		$this->conn = $db;
	}

	public function insert()
	{
		if ($this->idNota  && $_SESSION["idMiembro"]) {
			$stmt = $this->conn->prepare("
				INSERT INTO " . $this->noticiaTable . "(`titulo`, `subtitulo`, `cuerpo`, `imagen`, `notaClave`)
				VALUES(?, ?, ?)");
			$this->titulo = htmlspecialchars(strip_tags($this->titulo));
			$this->subtitulo = htmlspecialchars(strip_tags($this->subtitulo));
			$this->cuerpo = htmlspecialchars(strip_tags($this->cuerpo));
			$this->imagen = htmlspecialchars(strip_tags($this->imagen));
			$this->notaClave = htmlspecialchars(strip_tags($this->notaClave));
			$stmt->bind_param("sssss", $this->titulo, $this->subtitulo, $this->cuerpo, $this->imagen, $this->notaClave);

			if ($stmt->execute()) {
				return true;
			}
		}
	}

	public function update()
	{
		if ($this->idNota && $_SESSION["idMiembro"]) {
			$stmt = $this->conn->prepare("
				UPDATE " . $this->noticiaTable . " 
				SET titulo = ?, subtitulo = ?, cuerpo = ?, imagen = ?, notaClave = ?
				WHERE idNota = ?");

			$this->titulo = htmlspecialchars(strip_tags($this->titulo));
			$this->subtitulo = htmlspecialchars(strip_tags($this->subtitulo));
			$this->cuerpo = htmlspecialchars(strip_tags($this->cuerpo));
			$this->imagen = htmlspecialchars(strip_tags($this->imagen));
			$this->notaClave = htmlspecialchars(strip_tags($this->notaClave));
			$this->idNota = htmlspecialchars(strip_tags($this->idNota));

			$stmt->bind_param("sssssi", $this->titulo, $this->subtitulo, $this->cuerpo, $this->imagen, $this->notaClave, $this->idNota);

			if ($stmt->execute()) {
				return true;
			}
		}
	}

	public function delete()
	{
		if ($this->idNota && $_SESSION["idMiembro"]) {

			$stmt = $this->conn->prepare("
				DELETE FROM " . $this->noticiaTable . " 
				WHERE idNota = ?");

			$this->idNota = htmlspecialchars(strip_tags($this->idNota));

			$stmt->bind_param("i", $this->idNota);

			if ($stmt->execute()) {
				return true;
			}
		}
	}

	public function listNoticias()
	{
		$sqlQuery = "SELECT idNota, titulo, subtitulo, cuerpo, imagen, notaClave
			FROM " . $this->noticiaTable;

		$stmt = $this->conn->prepare($sqlQuery);
		$stmt->execute();
		$result = $stmt->get_result();
		$records = array();
		while ($noticia = $result->fetch_assoc()) {
			$records[] = $noticia;
		}
		echo json_encode($records);
	}
}
?>
