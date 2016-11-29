<?php
class DBOperation
{
	private $con;

	public function __construct()
	{
		require_once dirname(__FILE__) . '/DBConnect.php';
		$db = new DbConnect();
		$this->con = $db->connect();
	}

	public function createCorazon($pulsaciones, $fecha)
	{
		$stmt = $this->con->prepare("INSERT INTO corazon(pulsaciones, fecha) values(?, ?)");
		$stmt->bind_param("ss", $pulsaciones, $fecha);
		$result = $stmt->execute();
		$stmt->close();
		if($result)
		{
			return 0;
		}
		else
		{
			return 1;
		}
	}

	public function getCorazon($id=null)
	{
		if($id === null)
		{
			$stmt = $this->con->prepare("SELECT * FROM corazon");
		}
		else
		{
			$stmt = $this->con->prepare("SELECT * FROM corazon WHERE id = ?");
			$stmt->bind_param("s", $id);
		}
		$stmt->execute();
		$corazon = $stmt->get_result();
		$stmt->close();
		return $corazon;
	}


	public function createUser($nombre, $apiKey)
	{
		$apikey = $this->generateApiKey();
		$stmt = $this->con->prepare("INSERT INTO api_user (nombre, api_key) values(?, ?)");
		$stmt->bind_param("ss", $nombre, $apiKey);
		$result = $stmt->execute();
		$stmt->close();
		if($result)
		{
			return 0;
		}
		else
		{
			return 1;
		}
	}

	public function isValidUser($apiKey)
	{
		$stmt = $this->con->prepare("SELECT * FROM api_user WHERE api_key = ?");
		$stmt->bind_param("s", $apiKey);
		$stmt->execute();
		$stmt->store_result();
		$num_rows = $stmt->num_rows;
		$stmt->close();
		return $num_rows > 0;
	}

	private function generateApiKey(){
        return md5(uniqid(rand(), true));
    }
}
?>