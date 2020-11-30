<?php
// Initialize the session
session_start();
 
// Unset all of the session variables
$_SESSION = array();
 
// Destroy the session.
session_destroy();
 
// Redirect to login page
header("location: index.php");
exit;
?>

<!doctype html>
<html>
	<head>
		<meta http-equiv="refresh" content="3;url=student2.cs.appstate.edu/lathamjj/cap/welcome.php
	</head>
	<body>
	</body>
</html>