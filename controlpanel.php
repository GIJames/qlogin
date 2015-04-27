<?php
session_start();
?>
<!DOCTYPE html>
<html>
	<head>
		<?php
		if($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['publicIP']) && !empty($_POST['port'])){
			$publicIP = clean($_POST['publicIP']);
			$port = clean($_POST['port']);
			$name = $_SESSION["name"];
			include 'config/db_credentials.php';
			$conn = mysqli_connect($dbhost , $dbuser, $dbpassword, $dbname);
			if (!$conn) {
				die("Connection failed: " . mysqli_connect_error());
			}
			$updateUser = $conn->prepare("UPDATE Users SET publicIP = ?, port = ?, allowPublic = 1 WHERE name = ?");
			$updateUser->bind_param("sss", $publicIP, $port, $name);
			$updateUser->execute();
			$updateUser->close();
			$err = "Changes successful.<br>";
		}
		function clean($input){
				return htmlspecialchars(stripslashes(trim($input)));
		}
		?>
	</head>
	<body>
		<?php
			echo "You are " . $_SESSION["name"] . ". Change your IP address and port:<br>";
			echo $err;
		?>
		<form method="POST">
		<span>IP address:</span><input type="text" name="publicIP" required>
		<span>Port:</span><input type="text" name="port" value="11770" required>
		<input type="submit" id="button" value="Submit Changes">
		</form>
		<br><a href="index.php">Back to login page</i></a>
	</body>
</html>