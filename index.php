<!DOCTYPE html>
<html>
	<head>
		<?php
			if(isset($_POST['name']) && isset($_POST['password']) && isset($_POST['email'])){

				$credentials = fopen('config/config.txt');
				$dbhost = trim(fgets($credentials));
				$dbname = trim(fgets($credentials));
				$dbuser = trim(fgets($credentials));
				$dbpassword = trim(fgets($credentials));
				fclose($credentials);
				$conn = new mysqli($dbhost, $dbuser, $dbpassword, $dbname);
				
				
				
				$passwordHash = password_hash($_POST['password']);
			}
		?>
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="css/login.css">
		<script src="js/login.js"></script>
	</head>
	<body>
		<form method="POST">
			<span>username:</span><input type="text" name="name" required><br>
			<span>password:</span><input type="password" name="password" required><br>
			<span>enter email to register:</span><input type="text" name="email"><br>
		</form>
	</body>
</html>