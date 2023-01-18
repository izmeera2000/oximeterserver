<?php

date_default_timezone_set("Asia/Kuala_Lumpur");
$errors = array();


class DBController
{
	// private $host = "localhost";
	// private $user = "id20052762_user";
	// private $password = "-M*NDuq+Yc~=3=\9";
	// private $database = "id20052762_taipingytf";
	// private $conn;

	private $host = "localhost";
	private $user = "root";
	private $password = "";
	private $database = "oximeter_server";
	private $conn;

	function __construct()
	{
		$this->conn = $this->connectDB();
	}

	function connectDB()
	{
		$conn = mysqli_connect($this->host, $this->user, $this->password, $this->database);
		return $conn;
	}

	function runQuery($query)
	{
		$result = mysqli_query($this->conn, $query);
		while ($row = mysqli_fetch_assoc($result)) {
			$resultset[] = $row;
		}
		if (!empty($resultset))
			return $resultset;


	}
	function runQuery2($query)
	{
		$result = mysqli_query($this->conn, $query);
		return $result;


	}

	function numRows($query)
	{
		$result = mysqli_query($this->conn, $query);
		$rowcount = mysqli_num_rows($result);
		return $rowcount;
	}


	function uploadFOrder($query)
	{

		if (mysqli_query($this->conn, $query)) {
			// echo "New record created successfully";
		} else {
			echo "Error: " . $query . "<br>" . mysqli_error($this->conn);
		}

		$result = mysqli_query($this->conn, $query);
		return $result;
	}

	function getOrder($query)
	{
		$result = mysqli_query($this->conn, $query);

		$orders = mysqli_num_rows($result) > 0;
		return $orders;
	}

	function updateState($query)
	{

		$result = mysqli_query($this->conn, $query);
		return $result;
	}

	function escstring($postvar)
	{

		$resultvar = mysqli_real_escape_string($this->conn, $postvar);

		return $resultvar;

	}

}
?>