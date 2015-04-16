<?php
session_start();
?>
<?php
	if($_SESSION["status"] === 'admin'){
		//list users
		$configPath = '../config/config.txt';
		if (!file_exists($configPath)) {
			die('Database configuration file not found.');
		}
		$credentials = fopen($configPath, 'r') or die("Unable to access database configuration.");
		$dbhost = trim(fgets($credentials));
		$dbname = trim(fgets($credentials));
		$dbuser = trim(fgets($credentials));
		$dbpassword = trim(fgets($credentials));
		fclose($credentials);
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