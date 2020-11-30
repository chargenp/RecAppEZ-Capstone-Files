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
	
	$recnum = $_POST['clicked'];
	$testsql = "SELECT * FROM `Recipes` WHERE userUpload='$id' AND recID='$recnum';";
	
	$sql = "SELECT * FROM `Recipes` WHERE userUpload='$id';";
	$result = mysqli_query($link, $testsql);
	$resultCheck = mysqli_num_rows($result);

	if ($resultCheck > 0) {
		
		echo "<h1>Ingredients and Instructions</h1>";
		while ($row = mysqli_fetch_assoc($result)) {
			echo "<h3>" . $row['name'] . "</h3>";
			$recID = $row['recID'];
			$sql = "SELECT * FROM `Ingredient` WHERE recID ='$recID';";
			$ingredient_result = mysqli_query($link, $sql);
			echo "<h4>Cuisine: " . $row['cuisine'] . "</h4>";
			
			echo "<h4>Times</h4>";
				echo "<p id='Ingredient' style='text-indent: 20px'>Prep Time: " . $row['prepTime'] . "</p><br>";
				echo "<p id='Ingredient' style='text-indent: 20px'>Cook Time: " . $row['cookTime'] . "</p><br>";
				echo "<p id='Ingredient' style='text-indent: 20px'>Total Time: " . $row['totalTime'] . "</p><br>";
			echo "<h4>Ingredients</h4>";
			while ($ing_row = mysqli_fetch_assoc($ingredient_result)) {
				echo "<p id='Ingredient' style='text-indent: 20px'>" . $ing_row['name'] . ": " 
					. $ing_row['measurement'] . "</p><br>";
			}
			echo "<br><h4>Instructions</h4>";
			$sql = "SELECT * FROM `Instructions` WHERE recID ='$recID' ORDER BY stepOrder ASC;";
			$instruction_result = mysqli_query($link, $sql);
			$var = 1;
			while ($ins_row = mysqli_fetch_assoc($instruction_result)) {
				echo "<p class='instruction'> $var. " . $ins_row['step'] . "</p>";
				$var +=1;
			}
			echo "<p> </p><br>";
		}
	}
					
?>