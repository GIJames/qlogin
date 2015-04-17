<?php
session_start();
?>
<!DOCTYPE html>
<html>
	<body>
		<?php
			if($_SESSION["status"] === 'admin'){
				$user = $_GET["user"];
				$action = $_GET["action"];
				$configPath = 'config/config.txt';
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
				$takeAction = true;
				switch($action){
					case 'ban':
						$update = $conn->prepare("UPDATE Users SET status='banned' WHERE name=?");
						$update->bind_param("s", $user);
					break;
					case 'setadmin':
						$update = $conn->prepare("UPDATE Users SET status='admin' WHERE name=?");
						$update->bind_param("s", $user);
					break;
					case 'delete':
						$update = $conn->prepare("DELETE FROM Users WHERE name=?");
						$update->bind_param("s", $user);
					break;
					case 'reset':
						$update = $conn->prepare("UPDATE Users SET status=NULL WHERE name=?");
						$update->bind_param("s", $user);
					break;
					default:
						$takeAction = false;
						echo "Invalid action " . $_GET["action"];
				}
				if($takeAction){
				$update->execute();
				$update->close();
				}
				$conn->close();
				echo $user . " " . $action . " successful.";
			}
		?>
		<br><a href="admin.php">Back to admin page</i></a>
	</body>
</html>