<?php
session_start();
?>
<!DOCTYPE html>
<html>
	<body>
		<br><a href="javascript:history.back()">Back to login page</i></a>
		<?php
			if($_SESSION["status"] === 'admin'){
				//admin control panel
				
			}
		?>
	</body>
</html>