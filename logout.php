<?php
session_start();
?>
<!DOCTYPE html>
<html>
	<body>
		<?php
			session_unset();
			session_destroy();
			echo "You have logged out.";
		?>
		<br><a href="javascript:history.back()">Back to login page</i></a>
	</body>
</html>