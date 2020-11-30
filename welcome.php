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
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>RecAppEZ Recipe Management</title>
		<link rel="shortcut icon" type="image/x-icon" href="images/icon.png" >
		
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
		<link rel="stylesheet" href='./styles/welcome.css'>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
		
	</head>
	<body>
		<nav class="navbar navbar-default">
			<div class="container-fluid">
				<div class="navbar-header">
					<a class="navbar-brand" href="index.php">RecAppEZ</a>
				</div>
				<ul class="nav navbar-nav">
					<li class="active"><a href="index.php">Home</a></li>
					<li><a href="insertform.php">Add a Recipe</a></li>
			<!--		<li><a href="test.php">Test</a></li> -->
				</ul>
				<ul class="nav navbar-nav navbar-right">
					<li><a href="reset-password.php"><span class="glyphicon glyphicon-wrench"></span> Reset Your Password</a></li>
					<li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Sign out of Your Account</a></li>
				</ul>
			</div>
		</nav>	
	<div id ="page">
		<div id="optcontainer" class="row">
			<div id="searchBar" class="col-sm-3">
				<label for="search">Search</label>
				<input type="search" value="" onkeyup="searchDB(document.getElementById('f').value, 
																	document.getElementById('o').value, this.value,
																	document.getElementById('filter').value)"
					name="search" id="searchBox" placeholder="search..."  autocomplete="off">
				
				<input type="button" value="Clear" onclick="resetSearch()"/>
				
			</div>
			<div id="sortbar" class="col-sm-3">
			<label>Sort</label>
				<select name="f" id="f" onchange="searchDB(this.value, document.getElementById('o').value, 
															document.getElementById('searchBox').value,
															document.getElementById('filter').value)">
					<option value='name'>Name</option>
					<option value='totalTime'>Total Time</option>
				</select>
				<select name='o' id='o' onchange="searchDB(document.getElementById('f').value, this.value, 
															document.getElementById('searchBox').value, 
															document.getElementById('filter').value)">
					<option value='asc'>Ascending</option>
					<option value='desc'>Decending</option>
				</select>
			</div>
			
			<div id="filterbar" class="col-sm-2">
				<label for="filter">Filter</label>
				<select name='filter' id='filter' onchange="searchDB(document.getElementById('f').value, document.getElementById('o').value, 
																	document.getElementById('searchBox').value, this.value)">
					<option value="" selected>Cuisine Type</option>
					<?php
							
							$id = $_SESSION["id"];
							$sql = "SELECT * FROM `Recipes` WHERE userUpload='$id' GROUP BY cuisine;";
							$result = mysqli_query($link, $sql);
							$resultCheck = mysqli_num_rows($result);
						
							if ($resultCheck > 0) 
							{
								while ($row = mysqli_fetch_assoc($result)) 
								{
									$recID = $row['recID'];
									$cuisine = $row['cuisine'];
									echo "<option value='$cuisine'>$cuisine</option>";
								}
							}
							else
							{
								echo "<option value='ERR'>Error</option>";
							} 
						?>
				</select>
				<input type="button" value="Clear" onclick="resetFilter()"/>
			</div>
		</div>
		
		<br>
		<div class="row">
			<div class="container col-sm-2">
			
				<form class="form-inline" action="insertform.php">
				<label for="addNew">Add a new Recipe</label>
					<button id="addNew">+</button>
				</form>
			</div>
			
			<div id="favBar" class="container col-sm-2">
			<label for="tf1">Checked Recipes</label>
				<select name='tf1' id='tf1'>
					<option value="" selected>Select an option</option>
					<option value='delete'>Delete</option>
					<!--<option value='shop'>Generate Shopping List</option>-->
				</select>
				<input type="button" value="go" onclick="dropDown()" />
			</div>
		</div>
		<div id="box" class="row">
			<div id="recipes" class="col-sm-4">
				<h1>Recipes</h1>
				<div id="recipeTitles">
				</div>
			</div>
			<div id="content" class="col-sm-8">
				<h1>Ingredients and Instructions</h1>
				<div id="reset">
					<p>Select a recipe to view</p>
				</div>
			</div>
		</div>
	</div>
		
		
	
		
		
		<script>
		$(document).ready(function() {
			searchDB(document.getElementById('f').value, document.getElementById('o').value, 
				document.getElementById('searchBox').value, document.getElementById('filter').value);
		});
		
		function favoriteChange() {
			let val = this.id;
			let id = val.slice(4);
			let state = this.src;
			//alert(state);
			let fav = "";
			if (state == "https://student2.cs.appstate.edu/lathamjj/cap/images/star.png") {
				fav = "Y"
			} else if (state == "https://student2.cs.appstate.edu/lathamjj/cap/images/greystar.png") {
				fav = "N"
			}
			$.ajax({    
				type: "POST",
				url: "updateFavorite.php",   
				data: {"id":id, "fav":fav},								
				success: function(response){
					//alert("sucess: " + response);	//debug line	
					searchDB(document.getElementById('f').value, 
						document.getElementById('o').value, 
						document.getElementById('searchBox').value, 
						document.getElementById('filter').value);
				},
				error: function(response){
					alert("fail: " + response);	//debug line						
				}
			});
		}
		
		function shopping(id)  {
			
		}
		
		function dropDown() {
			let val = document.getElementById("tf1").value;
			document.getElementById("tf1").value = "";
			
			if (val == "shop") {
				
			} else if (val == "delete") {
				let boxes = document.querySelectorAll(".cBox");
				let string = "";
				for (const el of boxes) {
					if (el.checked) {
						let id = el.value;
						$.ajax({    
							type: "POST",
							url: "delete.php",   
							data: {"id":id},								
							success: function(response){
								//alert("sucess: " + response);	//debug line	
								searchDB(document.getElementById('f').value, 
									document.getElementById('o').value, 
									document.getElementById('searchBox').value, 
									document.getElementById('filter').value);
							},
							error: function(response){
								alert("fail: " + response);	//debug line						
							}
						});
						
					}
				}
			}
		} 
		
		function resetSearch() {
			document.getElementById("searchBox").value = "";
			searchDB(document.getElementById('f').value, document.getElementById('o').value, 
				document.getElementById('searchBox').value, document.getElementById('filter').value);
		}
		
		function resetFilter() {
			document.getElementById("filter").value = "";
			searchDB(document.getElementById('f').value, document.getElementById('o').value, 
				document.getElementById('searchBox').value, document.getElementById('filter').value);
		}
		
		function searchDB(field, order, val, cuisine) {
			resetstr = "<h1>Ingredients and Instructions</h1><p>Select a recipe to view</p>";
			$("#content").html(resetstr);
			//alert(field + "," + order + "," + val + ", " + cuisine); 		//debug line
			$.ajax({    
					type: "GET",
					url: "databaseSearch.php",  
					data: {"field":field, "order":order, "val":val, "cuisine":cuisine},
					dataType: "html",   //expect html to be returned                
					success: function(response){
						//alert("sucess: " + response);			//debug line						
						$("#recipeTitles").html(response); 
						$(".star").on("click", favoriteChange);
					},
					error: function(response){
						alert("fail: " + response);			//debug line
						console.log(response);						
					}
			});
		}
		
		function loadRecipe(clicked) {
			$.ajax({    
					type: "POST",
					url: "getrecipe.php",  
					data: {"clicked":clicked},
					dataType: "html",   //expect html to be returned                
					success: function(response){                    
						$("#content").html(response); 
						//alert(response);	//debug line
					}	
			});
		}
		function selected(clicked) {
			$('.selected').removeClass('selected');
			document.getElementById(clicked).classList.add('selected'); 
		}
		</script>
	</body>
</html>