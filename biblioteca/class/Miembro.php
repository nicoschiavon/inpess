<?php
class Miembro
{

	private $miembroTable = 'miembro';
	private $conn;

	public function __construct($db)
	{
		$this->conn = $db;
	}

	public function login()
	{
		if ($this->correoElec && $this->password) {
			$sqlQuery = "
				SELECT * FROM " . $this->miembroTable . " 
				WHERE correoElec = ? AND password = ? AND estado = 'activo'";
			$stmt = $this->conn->prepare($sqlQuery);
			$password = md5($this->password);
			$stmt->bind_param("ss", $this->correoElec, $password);
			$stmt->execute();
			$result = $stmt->get_result();
			if ($result->num_rows > 0) {
				$miembro = $result->fetch_assoc();
				$_SESSION["idMiembro"] = $miembro['idMiembro'];
				$_SESSION["tipoMiembro"] = $miembro['tipoMiembro'];
				$_SESSION["nombre"] = $miembro['nombre'];
				return 1;
			} else {
				return 0;
			}
		} else {
			return 0;
		}
	}

	public function loggedIn()
	{
		if (!empty($_SESSION["idMiembro"])) {
			return 1;
		} else {
			return 0;
		}
	}

	public function isAdmin()
	{
		if (!empty($_SESSION["idMiembro"]) && $_SESSION["tipoMiembro"] == 'director') {
			return 1;
		} else {
			return 0;
		}
	}

	public function listMembers()
	{

		$sqlQuery = "SELECT idMiembro, usuario, password, apellido, nombre, cuit, telefono, correoElec, fechaNac, tipoMiembro, estado, idRevisor
			FROM " . $this->miembroTable . " ";

		if (!empty($_POST["search"]["value"])) {
			$sqlQuery .= ' WHERE (idMiembro LIKE "%' . $_POST["search"]["value"] . '%" ';
			$sqlQuery .= ' OR usuario LIKE "%' . $_POST["search"]["value"] . '%" ';
			$sqlQuery .= ' OR apellido LIKE "%' . $_POST["search"]["value"] . '%" ';
			$sqlQuery .= ' OR nombre LIKE "%' . $_POST["search"]["value"] . '%" ';
			$sqlQuery .= ' OR cuit LIKE "%' . $_POST["search"]["value"] . '%" ';
			$sqlQuery .= ' OR telefono LIKE "%' . $_POST["search"]["value"] . '%" ';
			$sqlQuery .= ' OR correoElec LIKE "%' . $_POST["search"]["value"] . '%" ';
			$sqlQuery .= ' OR fechaNac LIKE "%' . $_POST["search"]["value"] . '%" ';
			$sqlQuery .= ' OR tipoMiembro LIKE "%' . $_POST["search"]["value"] . '%" ';
			$sqlQuery .= ' OR estado LIKE "%' . $_POST["search"]["value"] . '%" ';
			$sqlQuery .= ' OR idRevisor LIKE "%' . $_POST["search"]["value"] . '%") ';
		}

		if (!empty($_POST["order"])) {
			$sqlQuery .= 'ORDER BY ' . $_POST['order']['0']['column'] . ' ' . $_POST['order']['0']['dir'] . ' ';
		} else {
			$sqlQuery .= 'ORDER BY idMiembro DESC ';
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
		while ($miembro = $result->fetch_assoc()) {
			$rows = array();
			$rows[] = $count;
			$rows[] = ucfirst($miembro['nombre']);
			$rows[] = ucfirst($miembro['apellido']);
			$rows[] = $miembro['correoElec'];
			$rows[] = ucfirst($miembro['tipoMiembro']);
			$rows[] = ucfirst($miembro['estado']);
			$rows[] = $miembro['idRevisor'];
			$rows[] = '<button type="button" name="update" idMiembro="' . $miembro["idMiembro"] . '" class="btn btn-warning btn-xs update"><span class="glyphicon glyphicon-edit" title="Edit">Editar</span></button>';
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
		
			$stmt = $this->conn->prepare("
				INSERT INTO " . $this->miembroTable . "(`usuario`, `password`, `apellido`, `nombre`, `cuit`, `telefono`, `correoElec`, `fechaNac`, `tipoMiembro`, `estado`, `idRevisor`)
				VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
			$this->usuario = htmlspecialchars(strip_tags($this->usuario));
			$this->password = md5($this->password);
			$this->apellido = htmlspecialchars(strip_tags($this->apellido));
			$this->nombre = htmlspecialchars(strip_tags($this->nombre));
			$this->cuit = htmlspecialchars(strip_tags($this->cuit));
			$this->telefono = htmlspecialchars(strip_tags($this->telefono));
			$this->correoElec = htmlspecialchars(strip_tags($this->correoElec));
			$this->fechaNac = htmlspecialchars(strip_tags($this->fechaNac));
			$this->tipoMiembro = htmlspecialchars(strip_tags($this->tipoMiembro));
			$this->estado = htmlspecialchars(strip_tags($this->estado));
			$this->idRevisor = htmlspecialchars(strip_tags($this->idRevisor));
			$stmt->bind_param("sssssssssss", $this->usuario, $this->password, $this->apellido, $this->nombre, $this->cuit, $this->telefono, $this->correoElec, $this->fechaNac, $this->tipoMiembro, $this->estado, $this->idRevisor);

			if ($stmt->execute()) {
				return true;
			}
		
	}

	public function update()
	{

		if ($this->correoElec && $this->idMiembro && $_SESSION["idAdmin"]) {

			$updatePass = '';
			if ($this->password) {
				$this->password = md5($this->password);
				$updatePass = ", password = '" . $this->password . "'";
			}

			$stmt = $this->conn->prepare("
				UPDATE " . $this->miembroTable . " 
				SET usuario = ?, apellido = ?, nombre = ?, cuit = ?, telefono = ?, correoElec = ?, fechaNac = ?, tipoMiembro = ?, estado = ?, idRevisor = ? $updatePass
				WHERE idMiembro = ?");

			$this->usuario = htmlspecialchars(strip_tags($this->usuario));
			$this->apellido = htmlspecialchars(strip_tags($this->apellido));
			$this->nombre = htmlspecialchars(strip_tags($this->nombre));
			$this->cuit = htmlspecialchars(strip_tags($this->cuit));
			$this->telefono = htmlspecialchars(strip_tags($this->telefono));
			$this->correoElec = htmlspecialchars(strip_tags($this->correoElec));
			$this->fechaNac = htmlspecialchars(strip_tags($this->fechaNac));
			$this->tipoMiembro = htmlspecialchars(strip_tags($this->tipoMiembro));
			$this->estado = htmlspecialchars(strip_tags($this->estado));
			$this->idRevisor = htmlspecialchars(strip_tags($this->idRevisor));

			$stmt->bind_param("ssssssssssi", $this->usuario, $this->apellido, $this->nombre, $this->cuit, $this->telefono, $this->correoElec, $this->fechaNac, $this->tipoMiembro, $this->estado, $this->idRevisor, $this->idMiembro);

			if ($stmt->execute()) {
				return true;
			}
		}
	}

	public function delete()
	{
		if ($this->idMiembro) {

			$stmt = $this->conn->prepare("
				DELETE FROM " . $this->miembroTable . " 
				WHERE idMiembro = ?");

			$this->idMiembro = htmlspecialchars(strip_tags($this->idMiembro));

			$stmt->bind_param("i", $this->idMiembro);

			if ($stmt->execute()) {
				return true;
			}
		}
	}

	public function getMemberDetails()
	{
		if ($this->idMiembro && $_SESSION["idAdmin"]) {

			$sqlQuery = "
				SELECT idMiembro, usuario, password, apellido, nombre, cuit, telefono, correoElec, fechaNac, tipoMiembro, estado, idRevisor
				FROM " . $this->miembroTable . "			
				WHERE idMiembro = ? ";

			$stmt = $this->conn->prepare($sqlQuery);
			$stmt->bind_param("i", $this->idMiembro);
			$stmt->execute();
			$result = $stmt->get_result();
			$records = array();
			while ($miembro = $result->fetch_assoc()) {
				$rows = array();
				$rows['idMiembro'] = $miembro['idMiembro'];
				$rows['usuario'] = $miembro['usuario'];
				$rows['apellido'] = $miembro['apellido'];
				$rows['nombre'] = $miembro['nombre'];
				$rows['cuit'] = $miembro['cuit'];
				$rows['telefono'] = $miembro['telefono'];
				$rows['correoElec'] = $miembro['correoElec'];
				$rows['fechaNac'] = $miembro['fechaNac'];
				$rows['tipoMiembro'] = $miembro['tipoMiembro'];
				$rows['estado'] = $miembro['estado'];
				$rows['idRevisor'] = $miembro['idRevisor'];
				$records[] = $rows;
			}
			$output = array(
				"data"	=> 	$records
			);
			echo json_encode($output);
		}
	}

	function getMembersList()
	{
		$stmt = $this->conn->prepare("
		SELECT idMiembro, usuario, apellido, nombre 
		FROM " . $this->miembroTable . " 
		WHERE tipoMiembro = 'user'");
		$stmt->execute();
		$result = $stmt->get_result();
		return $result;
	}

	public function updateEstado()
	{
		
			$this->estado = "desactivado";

			$stmt = $this->conn->prepare("
				UPDATE " . $this->miembroTable . " 
				SET estado = ?
				WHERE idMiembro = ?");

			$stmt->bind_param("si", $this->estado, $this->idMiembro);

			if ($stmt->execute()) {
				return true;
			} else {
				return false;
			}
		
	}

	
}
?>
