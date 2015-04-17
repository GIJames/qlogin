<?php
session_start();
?>
<!DOCTYPE html>
<html>
	<head>
		<?php
			if($_SESSION["status"] === 'admin'){
				echo '<script src="js/adminpage.js"></script>';				
			}
		?>
		<link rel="stylesheet" href="css/login.css">
	</head>
	<body>
		<?php
			if($_SESSION["status"] === 'admin'){
				echo '<form id="filters">';
				echo '<span>name:</span><input onkeyup="reFilter()" type="text" name="name">';
				echo '<span>email:</span><input onkeyup="reFilter()" type="text" name="email">';
				echo '</form>';
				echo '<table id="users" class="userTable">';
				echo '</table>';
			}
			else{
				echo 'You are: ' . $_SESSION["name"];
			}
		?>
		<br><a href="index.php">Back to login page</i></a>
	</body>
</html>