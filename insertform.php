<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>

<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>RecAppEZ Recipe Management</title>
		<link rel="shortcut icon" type="image/x-icon" href="images/icon.png" >		
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
		<link rel="stylesheet" href="styles/insertform.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

		<!--
		<style type="text/css">
			body{ font: 14px sans-serif; }
			.wrapper{ width: 350px; padding: 20px; }
		</style>
		-->
	</head>
	<body>
		<nav class="navbar navbar-default">
			<div class="container-fluid">
				<div class="navbar-header">
					<a class="navbar-brand" href="index.php">RecAppEZ</a>
				</div>
				<ul class="nav navbar-nav">
					<li><a href="welcome.php">Home</a></li>
					<li class="active"><a href="insertform.php">Add a Recipe</a></li>
				</ul>
				<ul class="nav navbar-nav navbar-right">
					<li><a href="reset-password.php"><span class="glyphicon glyphicon-wrench"></span> Reset Your Password</a></li>
					<li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Sign out of Your Account</a></li>
				</ul>
			</div>
		</nav>
		
		<div class="container-fluid">  
			<h2 align="center">Submit your recipe</h2>		
			<div class="wrapper container-fluid">
				<form action="insert.php" method="post">
					<div class="form-group">
						<div class="row">
							<div class="col-lg-12">
								<label for="recipeName">Recipe Name:</label>
								<input type="text" name="recipeName" class="form-control" id="recipeName"  autocomplete="off"/>
							</div>
						</div>
					</div>
					<div class="form-group row">
						<div class="col-xs-4">
							<label for="prepTime">Prep Time:</label>
							<input type="text" name="prepTime" class="form-control" id="prepTime"  autocomplete="off"/>
						</div>
						<div class="col-xs-4">
							<label for="cookTime">Cook Time:</label>
							<input type="text" name="cookTime" class="form-control" id="cookTime"  autocomplete="off"/>
						</div>
						<div class="col-xs-4">
							<label for="cuisine">Cuisine Type</label>
							<input type="text" placeholder="Default: other" name="cuisine" class="form-control" id="cuisine"/>
						</div>
					</div>
					  
					<h3>Add Ingredients</h3>
					<div class="form-group">
                     <div name="add_ingredient" id="add_ingredient">  
                          <div class="table-responsive">  
                               <table class="table table-bordered" id="dynamic_field">  
                                    <tr>  
                                        <td class="col-xs-8"><input type="text" name="ingredient[]" placeholder="Ingredient" class="form-control name_list" /></td>
										<td class="col-xs-3"><input type="text" name="quantity[]" placeholder="Quantity" class="form-control name_list" /></td>										 
                                        <td class="col-lg-1"><button type="button" name="add" id="add" class="btn btn-primary">Add More</button></td>  
                                    </tr>  
                               </table>    
                          </div>  
                     </div>  
					</div>
					
					
					<h3>Add Instructions</h3>  
					<p>Step numbers will be automatically added.</p>
					<div class="form-group">  
                    <div name="add_ingredient" id="add_ingredient">  
                        <div class="table-responsive">  
                            <table class="table table-bordered" id="dynamic_field2">  
                                <tr>  
									<td class="col-xs-11"><textarea rows="2" autocomplete="off" type="text" name="instruction[]" placeholder="Instruction" class="form-control"></textarea></td>										 
									<td class="col-xs-1"><button type="button" name="add2" id="add2" class="btn btn-primary">Add More</button></td>  
                                </tr>  
                            </table>    
                        </div>  
                    </div>  
					</div>
					
					<div class="form-group">
						<input type="submit" class="btn btn-primary" value="Submit" />
						<a class="btn btn-link" href="welcome.php">Cancel</a>
					</div>					
				</form>
			</div> 
		</div>  
	</body>
</html>

<script>  
 $(document).ready(function(){  
      var i=1;  
      $('#add').click(function(){  
           i++;  
           $('#dynamic_field').append('<tr id="row'+i+'"><td><input type="text" name="ingredient[]" placeholder="Ingredient" ' +
				'class="form-control name_list" /></td><td><input type="text" name="quantity[]" placeholder="Quantity" ' +
				'class="form-control"/></td><td><button type="button" name="remove" id="'+i
				+'" class="btn btn-danger btn_remove">X</button></td></tr>');  
      });  
      $(document).on('click', '.btn_remove', function(){  
           var button_id = $(this).attr("id");   
           $('#row'+button_id+'').remove();  
      });  
	    
      $('#add2').click(function(){  
           i++;  
           $('#dynamic_field2').append('<tr id="row'+i+'"><td><textarea rows="2" type="text" autocomplete="off" name="instruction[]" placeholder="Instruction" ' +
				'class="form-control name_list"></textarea></td><td><button type="button" name="remove" id="'+i
				+'" class="btn btn-danger btn_remove">X</button></td></tr>');  
      });  
      $(document).on('click', '.btn_remove', function(){  
           var button_id = $(this).attr("id");   
           $('#row'+button_id+'').remove();  
      });  
 });  
 </script>