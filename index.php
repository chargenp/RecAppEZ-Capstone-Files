<?php
// Implement user redirect if still logged in
// Initialize the session
	session_start();
	 
	// Check if the user is logged in, if not then redirect to login page
	if(!(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true)){
		header("location: welcome.php");
		exit;
	}

	// Include config file
	require_once "config.php";
	
?>

<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width", initial-scale-1, shrink-to-fit=no">
		<title>RecAppEZ Recipe Management</title>
		
		<link rel="shortcut icon" type="image/x-icon" href="images/icon.png" >
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
		<link rel="stylesheet" href='./styles/index.css'>
		
	</head>
	<body>
	<nav class="navbar navbar-default">
		<div class="container-fluid">
			<div class="navbar-header">
				<a class="navbar-brand" href="index.php">RecAppEZ</a>
			</div>
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<li><a href="login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
				<li><a href="register.php"><span class="glyphicon glyphicon-user"></span> Register</a></li>
			</ul>
		</div>
	</nav>
	
	<div id="welcome">
		<p>
		Welcome to RecAppEZ, the recipe storage and management tool.
		</p>
	</div>

		
		<!-- Library Optional JavaScript -->
		<!-- jQuery first, then Popper.js, then Bootstrap JS -->
		
	</body>
</html>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
