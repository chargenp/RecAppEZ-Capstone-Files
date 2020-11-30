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
	
	$query_sort = $_GET['field'].' '.$_GET['order'];
	$sval = $_GET['val'];
	$id = $_SESSION["id"];
	$cuisine = $_GET['cuisine'];
	$sql = "";
	if ($cuisine == "") {
		$sql = "SELECT * FROM `Recipes` WHERE name LIKE '%" . $sval . 
			"%' AND userUpload = $id ORDER BY favorite DESC, " . $query_sort;
	} else { 
		$sql = "SELECT * FROM `Recipes` WHERE name LIKE '%" . $sval . 
			"%' AND userUpload = $id AND cuisine = '$cuisine' ORDER BY favorite DESC, " . $query_sort;
	}
	$result = mysqli_query($link, $sql);
	$resultCheck = mysqli_num_rows($result);
	
	
	if ($resultCheck > 0) {
		while ($row = mysqli_fetch_assoc($result)) {
			echo "<div class='RecipeRow'>";
			echo "<div class='boxHolder'>";
			echo "<input type='checkbox' class='cBox' id='testID" . $row['recID'] ."' name='testID" . $row['recID'] ."' 
					value= '" . $row['recID'] ."'>";
			if ($row['favorite'] == 'Y')
			{
				echo "<img class='star' id='star" . $row['recID'] ."' src='./images/star.png'></img>";
			} else {
				echo "<img class='star' id='star" . $row['recID'] ."' src='./images/greystar.png'></img>";
			}
			echo "</div>";
			
			echo "<div class='RecipeItem' onmouseover=\"this.style.background='lightblue';\" 
				onmouseout=\"this.style.background='white';\">";
			echo "<p onClick=\"loadRecipe(this.id); selected(this.id);\" id='" . $row['recID'] ."' >" . $row['name'] . "</p>";
			echo "</div>";		
			echo "</div>";		
		}
	}

?>