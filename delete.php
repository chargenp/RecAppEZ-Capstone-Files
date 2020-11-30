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


	// Setup variables
	$id = $_SESSION["id"];
	$opt = $_POST['id'];

	if ($opt == "")
	{
		echo "No Recipe selected. Directing you back.";
		header("refresh:3;url=deleteform.php");
	}
	else 
	{
		//echo "The selection is: $opt";  //debugging line
		
		$sql = "DELETE FROM Recipes WHERE userUpload='$id' AND recID='$opt';";
		if(mysqli_query($link, $sql))
		{	
			$sql = "DELETE FROM Ingredient WHERE recID='$opt';";
			mysqli_query($link, $sql);
			$sql = "DELETE FROM Instructions WHERE recID='$opt';";
			mysqli_query($link, $sql);
			
			// Close connection
			mysqli_close($link);

			//Refresh header
			header("refresh:0;url=welcome.php");
		} 
		else
		{
			echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
			
			// Close connection
			mysqli_close($link);

			//Refresh header
			header("refresh:5;url=deleteform.php");
		}
	}
?>