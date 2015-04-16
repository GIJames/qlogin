<?php
session_start();
?>
<!DOCTYPE html>
<html>
	<body>
		<?php
			echo ($_SESSION["status"] === 'admin' ? "Admin panel goes here." : "User control panel goes here." );
		?>
		<br><a href="javascript:history.back()">Back to login page</i></a>
	</body>
</html>