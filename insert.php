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
	
	// Setup variables and Escape user inputs for security
	$recipe_name = ucwords(mysqli_real_escape_string($link, $_REQUEST['recipeName']));
	$prep_time = mysqli_real_escape_string($link, $_REQUEST['prepTime']);
	$cook_time = mysqli_real_escape_string($link, $_REQUEST['cookTime']);
	$total_time = $prep_time + $cook_time;
	$cuisine = mysqli_real_escape_string($link, $_REQUEST['cuisine']);
	if ($cuisine == '') {
		$cuisine = "Other";
	} else {
		$cuisine = ucfirst($cuisine);
	}
	$cuisine = ucfirst($cuisine);
	$ingredients = mysqli_real_escape_string($link, $_REQUEST['ingredients']);
	$instructions = mysqli_real_escape_string($link, $_REQUEST['instructions']);
	$id = $_SESSION["id"];
	$fav = 'N';
	
	// Attempt insert query execution
	$sql = "INSERT INTO Recipes (userUpload, favorite, name, cuisine, prepTime, cookTime, totalTime) 
		VALUES ('$id', '$fav', '$recipe_name', '$cuisine', '$prep_time', '$cook_time', '$total_time')";
	echo "$sql";
	if(mysqli_query($link, $sql))
	{
		$recID = mysqli_insert_id($link);	
		$number = count($_POST["ingredient"]);
		if($number > 0)
		{
			$success = True;
			for($i=0; $i<$number; $i++)  
			{  
				if(trim($_POST["ingredient"][$i] != ''))
				{  
					$ingname = mysqli_real_escape_string($link, $_POST['ingredient'][$i]);
					$measurement = mysqli_real_escape_string($link, $_POST['quantity'][$i]);
					$sql = "INSERT INTO Ingredient (recID, name, measurement) VALUES('$recID', '" 
							. ucwords($ingname) . "', '$measurement')";  
					if(mysqli_query($link, $sql))
					{
						echo "Ingredient added successfully. <br>";
					}	
					else
					{
						echo " ERROR: Could not execute $sql. " . mysqli_error($link);
		
						// Close connection
						mysqli_close($link);
						
						//Refresh header
						//header("refresh:5;url=insertform.php");
					}							
				}
				else
				{
					$success = False;
					echo "One of the Ingredient or Quantity is missing";
					$id = $_SESSION["id"];
					$sql = "DELETE FROM Recipes WHERE userUpload='$id' AND recID='$recID';";
					mysqli_query($link, $sql);
					$sql = "DELETE FROM Ingredient WHERE recID='$recID';";
					mysqli_query($link, $sql);
			
					// Close connection
					mysqli_close($link);
					break;
				}
			} 
			
			
			$number = count($_POST["instruction"]);
			if($number > 0) {
				$success = True;
				for($i=0; $i<$number; $i++) {  
					if(trim($_POST["instruction"][$i] != '')) {  
						$insname = ucfirst(mysqli_real_escape_string($link, $_POST['instruction'][$i]));
						$measurement = mysqli_real_escape_string($link, $_POST['quantity'][$i]);
						$sql = "INSERT INTO Instructions (recID, step, stepOrder) VALUES('$recID', '$insname', '$i')";  
						if(mysqli_query($link, $sql)) {
							echo "Instruction added successfully. <br>";
						}	
						else {
							echo " ERROR: Could not execute $sql. " . mysqli_error($link);
			
							// Close connection
							mysqli_close($link);
							
							//Refresh header
							//header("refresh:5;url=insertform.php");
						}							
					}
				}
			}
			
			if($success)
			{
				echo "Recipe added successfully. Redirecting";
			}
			
			// Close connection
			mysqli_close($link);
			
			//Refresh header
			header("refresh:0;url=welcome.php");
		}
		else
		{
			echo "Ingredient or Quantity missing";
			$id = $_SESSION["id"];
			$sql = "DELETE FROM Recipes WHERE userUpload='$id' AND recID='$recID';";
			mysqli_query($link, $sql);
			
			// Close connection
			mysqli_close($link);
		}
	}
	else
	{
		echo "ERROR: Could not execute $sql. " . mysqli_error($link);
		
		// Close connection
		mysqli_close($link);

		//Refresh header
		//header("refresh:5;url=insertform.php");
	}
?>