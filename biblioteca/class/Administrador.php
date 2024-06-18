<?php
class Administrador
{

	private $administradorTable = 'administrador';
	private $conn;

	public function __construct($db)
	{
		$this->conn = $db;
	}

	public function login()
	{
		if ($this->usuario && $this->password) {
			$sqlQuery = "
				SELECT * FROM " . $this->administradorTable . " 
				WHERE usuario = ? AND password = ?";
			$stmt = $this->conn->prepare($sqlQuery);
			$password = md5($this->password);
			$stmt->bind_param("ss", $this->usuario, $password);
			$stmt->execute();
			$result = $stmt->get_result();
			if ($result->num_rows > 0) {
				$admin = $result->fetch_assoc();
				$_SESSION["idAdmin"] = $admin['idAdmin'];
				$_SESSION["nombre"] = $admin['usuario'];
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
		if (!empty($_SESSION["idAdmin"])) {
			return 1;
		} else {
			return 0;
		}
	}

	

	

	public function listUsers()
	{

		$sqlQuery = "SELECT idAdmin, usuario, password
			FROM " . $this->administradorTable . " ";

		if (!empty($_POST["search"]["value"])) {
			$sqlQuery .= ' WHERE (id LIKE "%' . $_POST["search"]["value"] . '%" ';
			$sqlQuery .= ' OR usuario LIKE "%' . $_POST["search"]["value"] . '%" ';
			$sqlQuery .= ' OR password LIKE "%' . $_POST["search"]["value"] . '%" ';
		}

		if (!empty($_POST["order"])) {
			$sqlQuery .= 'ORDER BY ' . $_POST['order']['0']['column'] . ' ' . $_POST['order']['0']['dir'] . ' ';
		} else {
			$sqlQuery .= 'ORDER BY id DESC ';
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
		while ($administrador = $result->fetch_assoc()) {
			$rows = array();
			$rows[] = $count;
			$rows[] = ucfirst($administrador['usuario']);
			
			$rows[] = '<button type="button" name="update" id="' . $administrador["id"] . '" class="btn btn-warning btn-xs update"><span class="glyphicon glyphicon-edit" title="Edit">Modificar</span></button>';
			$rows[] = '<button type="button" name="delete" id="' . $administrador["id"] . '" class="btn btn-danger btn-xs delete" ><span class="glyphicon glyphicon-remove" title="Delete">Desactivar</span></button>';
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
		if ($this->usuario && $this->password && $_SESSION["idAdmin"]) {
			$stmt = $this->conn->prepare("
				INSERT INTO " . $this->administradorTable . "(`usuario`, `password`)
				VALUES(?, ?)");
			
			$this->usuario = htmlspecialchars(strip_tags($this->usuario));
			$this->password = md5($this->password);
			$stmt->bind_param("ss", $this->usuario, $this->password);

			if ($stmt->execute()) {
				return true;
			}
		}
	}

	public function update()
	{

		if ($this->usuario && $_SESSION["idAdmin"]) {

			$updatePass = '';
			if ($this->password) {
				$this->password = md5($this->password);
				$updatePass = ", password = '" . $this->password . "'";
			}

			$stmt = $this->conn->prepare("
				UPDATE " . $this->administradorTable . " 
				SET usuario = ? $updatePass
				WHERE idAdmin = ?");

			$this->usuario = htmlspecialchars(strip_tags($this->usuario));

			$stmt->bind_param("si", $this->usuario, $this->id);

			if ($stmt->execute()) {
				return true;
			}
		}
	}

	public function delete()
	{
		if ($this->idAdmin && $_SESSION["idAdmin"]) {

			$stmt = $this->conn->prepare("
				DELETE FROM " . $this->administradorTable . " 
				WHERE idAdmin = ?");

			$this->idadmin = htmlspecialchars(strip_tags($this->idAdmin));

			$stmt->bind_param("i", $this->idAdmin);

			if ($stmt->execute()) {
				return true;
			}
		}
	}

	public function getAdminDetails()
	{
		if ($this->admin_id && $_SESSION["idAdmin"]) {

			$sqlQuery = "
				SELECT idAdmin, usuario, password
				FROM " . $this->administradorTable . "			
				WHERE id = ? ";

			$stmt = $this->conn->prepare($sqlQuery);
			$stmt->bind_param("i", $this->admin_id);
			$stmt->execute();
			$result = $stmt->get_result();
			$records = array();
			while ($admin = $result->fetch_assoc()) {
				$rows = array();
				$rows['idAdmin'] = $admin['idAdmin'];
				$rows['usuario'] = $admin['usuario'];
				$records[] = $rows;
			}
			$output = array(
				"data"	=> 	$records
			);
			echo json_encode($output);
		}
	}

	function getAdminsList()
	{
		$stmt = $this->conn->prepare("
		SELECT idAdmin, usuario 
		FROM " . $this->adminTable );
		$stmt->execute();
		$result = $stmt->get_result();
		return $result;
	}
}
