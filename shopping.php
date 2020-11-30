<?php
	// Initialize the session
	session_start();
 
	// Check if the user is logged in, if not then redirect to login page
	if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
		header("location: login.php");
		exit;
	}

	// Include config file
	require_once "config.php";
	
	$id = $_SESSION["id"];
	
	$recnum = $_POST['id'];
	$sql = "SELECT * FROM `Recipes` WHERE userUpload='$id' AND recID='$recnum';";
	
	$result = mysqli_query($link, $sql);
	$resultCheck = mysqli_num_rows($result);

	if ($resultCheck > 0) {
		while ($row = mysqli_fetch_assoc($result)) {
			$recID = $row['recID'];
			$sql = "SELECT * FROM `Ingredient` WHERE recID ='$recID';";
			$ingredient_result = mysqli_query($link, $sql);
			while ($ing_row = mysqli_fetch_assoc($ingredient_result)) {
				echo $ing_row['name'] . "(" 
					. $ing_row['measurement'] . "), ";
			}
			
		}
	}
					
	
?>