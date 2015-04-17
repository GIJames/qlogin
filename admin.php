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
				echo '<span>status:</span><select onchange="reFilter()" type="text" name="status">';
				echo '<option value="">all</option>';
				echo '<option value="admin">admin</option>';
				echo '<option value="banned">banned</option>';
				echo '</select>';
				echo '</form>';
				echo '<table id="users" class="userTable">';
				echo '</table>';
			}
		?>
		<br><a href="index.php">Back to login page</i></a>
	</body>
</html>