<?php
session_start();
?>
<!DOCTYPE html>
<html>
	<body>
		<?php
			echo "You are " . $_SESSION["name"] . ". Options to change settings may go here eventually.<br>";
		?>
		<br><a href="index.php">Back to login page</i></a>
	</body>
</html>