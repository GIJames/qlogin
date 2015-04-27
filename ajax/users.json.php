<?php
session_start();
?>
<?php
	if($_SESSION["status"] === 'admin'){
		//list users
		include '../config/db_credentials.php';
		$conn = mysqli_connect($dbhost , $dbuser, $dbpassword, $dbname);
		if (!$conn) {
			die("Connection failed: " . mysqli_connect_error());
		}
		$query = "SELECT name, email, status FROM Users";
		$result = $conn->query($query);
		$rows = array();
		while($row = $result->fetch_assoc()){
			array_push($rows, $row);
		}
		$conn->close();
		echo json_encode($rows);
	}
?>