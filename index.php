<?php
session_start();
?>
<!DOCTYPE html>
<html>
	<head>
		<?php
			//ini_set('display_errors', 1); error_reporting(E_ALL);
			if($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['name']) && !empty($_POST['password'])){
				if(!empty($_POST['email'])){
					//register new user
					$email = clean($_POST['email']);
					if($email !== $_POST['email'] || !filter_var($email, FILTER_VALIDATE_EMAIL)){
						$emailerr = "Please enter a valid email address.<br>";
					}
					elseif(strlen($email) > 50){
						$emailerr = "Please use an email address under 50 characters.<br>";
					}
				}
				$name = clean($_POST['name']);
				if($name !== $_POST['name']){
					$nameerr = "Please enter a valid username.<br>";
				}
				elseif(strlen($name) > 50){
					$nameerr = "Please use a user name under 30 characters.<br>";
				}
				$password = $_POST['password'];
				if(strlen($password) > 255){
					$pwerr = "Please use a password under 255 characters.<br>";
				}
				if(!isset($emailerr) && !isset($nameerr) && !isset($pwerr)){
					include 'config/db_credentials.php';
					$conn = mysqli_connect($dbhost , $dbuser, $dbpassword, $dbname);
					if (!$conn) {
						die("Connection failed: " . mysqli_connect_error());
					}
					//TABLE Users ( name VARCHAR(30) PRIMARY KEY, password VARCHAR(255) NOT NULL, email VARCHAR(50) NOT NULL, status VARCHAR(10))
					//TABLE IPLog ( name VARCHAR(30), ip VARCHAR(16))
					if(isset($email)){
						//register new user
						$searchName = $conn->prepare("SELECT name FROM Users WHERE name=?");
						$searchName->bind_param("s", $name);
						$searchName->execute();
						$nameFind = $searchName->get_result();
						$searchName->close();
						if($nameFind->num_rows > 0){
							$nameerr = "A user with that name already exists.<br>";
						}
						$searchEmail = $conn->prepare("SELECT name FROM Users WHERE email=?");
						$searchEmail->bind_param("s", $email);
						$searchEmail->execute();
						$emailFind = $searchEmail->get_result();
						$searchEmail->close();
						if($emailFind->num_rows > 0){
							$emailerr = "A user with that email address already exists.<br>";
						}
						if(!isset($emailerr) && !isset($nameerr)){
							//user does not exist; continue
							$publicIP = clean($_POST['publicIP']);
							$port = clean($_POST['port']);
							$allowPublic = (strlen($port) > 0);
							$insertUser = $conn->prepare("INSERT INTO Users (name, password, email, publicIP, port, allowPublic) VALUES (?, ?, ?, ?, ?, ?)");
							$insertUser->bind_param("ssssss", $name, $pwhash, $email, $publicIP, $port, $allowPublic);
							$pwhash = password_hash($password, PASSWORD_DEFAULT);
							$insertUser->execute();
							$insertUser->close();
							$err = "Registration successful.<br>";
							$_SESSION["name"] = $name;
						}
					}
					else{
						//log in existing user
						$searchUser = $conn->prepare("SELECT password, status FROM Users WHERE name=?");
						$searchUser->bind_param("s", $name);
						$searchUser->execute();
						$userFind = $searchUser->get_result();
						$searchUser->close();
						if($userFind->num_rows === 0){
							$nameerr = "A user with that name was not found.<br>";
						}
						else{
							$userResult = $userFind->fetch_assoc();
							$pwhash = $userResult['password'];
							if(password_verify($password, $pwhash)){
								$userStatus = $userResult['status'];
								if($userStatus === 'banned'){
									$err = "You are banned<br>";
								}
								else{
									$err = "Logged in successfully<br>";
									$_SESSION["name"] = $name;
									$_SESSION["status"] = $userStatus;
								}
								//log IP address here
							}
							else{
								$pwerr = "Incorrect password.";
							}
						}
					}
					$conn->close();
				}
				else{
					$err = "Problems were found with your input:<br>";
				}
			}
			function clean($input){
				return htmlspecialchars(stripslashes(trim($input)));
			}
		?>
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="css/login.css">
		<script src="js/login.js"></script>
	</head>
	<body>
		<?php
		if(isset($_SESSION["name"])){
			echo '<a href="controlpanel.php">Control Panel</a><br>';
			echo '<a href="logout.php">Log Out</a><br>';
		}
		if($_SESSION["status"] === 'admin') echo '<a href="admin.php">Admin Control Panel</a><br>';
		?>
		Register here to have your OracleNet games listed as Direct Connect-enabled at <a href="http://browser.crdnl.me/">http://browser.crdnl.me/</a>!<br>
		NOTICE: If you are registering as a host, this must be EXACTLY the same as your game username.<br>
		You also must make sure you have CoolRanch running, and this port as well as 11774 forwarded properly.<br>
		<form method="POST">
			<span><?php if($userStatus === 'admin') echo "You are an administrator.<br>"?></span>
			<span class="error"><?php if(isset($err)) echo $err;?></span>
			<span>username:</span><input type="text" name="name" required><span class="error"><?php if(isset($nameerr)) echo $nameerr; ?></span><br>
			<span>password:</span><input type="password" name="password" required><span class="error"><?php if(isset($pwerr)) echo $pwerr; ?></span><br>
			<span>enter email to register:</span><input onkeyup="checkButton(this.value)" type="text" name="email"><span class="error"><?php if(isset($emailerr)) echo $emailerr;?></span><br>
			<span>IP address:</span><input type="text" name="publicIP">
			<span>Port:</span><input type="text" name="port" value="11770">
			<input type="submit" id="button" value="Log In">
		</form>
	</body>
</html>