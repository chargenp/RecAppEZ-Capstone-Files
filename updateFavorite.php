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
	$recid = $_POST["id"];
	$fav = $_POST["fav"];
	
	if ($fav == 'N') {
		$sql = "Update `Recipes` SET favorite='Y' WHERE userUpload = $id AND recID = $recid";
	}
	else if ($fav == 'Y') {
		$sql = "Update `Recipes` SET favorite='N' WHERE userUpload = $id AND recID = $recid";
	}
	
	$result = mysqli_query($link, $sql);
?>