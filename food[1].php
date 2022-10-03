<?php
/*Connect to the database*/
$dbcon = mysqli_connect("localhost", "ameliechowworn", "HMa2Kgw", "ameliechowworn_assessment");

if(isset($_GET['food_sel'])){
	$id = $_GET['food_sel'];
}else{
	$id = 1;
}

$food_query = "SELECT food_name, availability, price, dietary FROM food WHERE food_id = '"  .  $id  .  "'";
$food_result = mysqli_query($dbcon, $food_query);
$food_record = mysqli_fetch_assoc($food_result);

/*Food query - Dropdown menu */
$all_food_query = "SELECT food_id, food_name FROM food";
$all_food_result = mysqli_query($dbcon, $all_food_query);
$food_rows = mysqli_num_rows($all_food_result);

/*Query to gather all food items*/
$query_all_items = "SELECT * FROM food ORDER BY food_name";
$all_items_results = mysqli_query($dbcon,$query_all_items);

?>

<!DOCTYPE html>

<html lang="en">
<head>
	<title> Cafe Food Items</title>
	<meta charset="utf-8">
	<link rel='stylesheet' type='text/css' href='style.css'>
	<link href="https://fonts.googleapis.com/css2?family=Fjord+One&display=swap" rel="stylesheet">
</head>
	
<main>
	<body>
	<div class="grid-container">
		<div class="item1">
		<header>
			<h1>Food :)</h1>
		</header>
		</div>
		
		<div class="item2">
		<nav>
			<ul>
				<li><a href = "index.php">Home</a></li>
				<li><a href = "drinks.php">Drinks</a></li>
				<li><a href = "food.php">Food</a></li>	
				<li><a href = "weekly_specials.php">Weekly specials</a></li>
			</ul>
		</nav>
		</div>

		<div class="item3">
			Intro intro intro
		</div>
		
		<div class="item5">
			<h2>Food information</h2>
			<?php
			echo "<p> Food item: " . $food_record['food_name'] . "<br>";
			echo "<p> Status: " . $food_record['availability'] . "<br>";
			echo "<p> Cost: $" . $food_record['price'] . "<br>";
			?>

			<!-- Dropdown food form -->
			<h2>Select Another Food</h2>
			<form name='food_form' id='food_form' method='get' action='food.php'>
				<!-- Dropdown menu -->
				<select id='food_sel' name='food_sel'>
					<!-- Options -->
					<?php
					while($all_food_record = mysqli_fetch_assoc($all_food_result)){
						echo "<option value = '". $all_food_record['food_id'] . "'>";
						echo $all_food_record['food_name'];
						echo "</option>";
					}
					?>
				</select>

				<input type='submit' name='food_button' value='See the food information'>
			</form>	
					
		</div>
		
		<div class="item4">
			<h2>All Food items</h2>
			<?php
			echo "All food items are in alphabetical order.". "<br>" . "<br>";
			while($row = mysqli_fetch_array($all_items_results))
				echo $row['food_name'] . "<br>";
			?>

			<!--Search for a food -->
			<h2> Search for a food</h2>
			<form action="" method="post">
				<input type="text" name ='search'>
				<input type="submit" name="submit" value="Search">
			</form>

			<?php
			if(isset($_POST['search'])) {
				$search = $_POST['search'];

				$query1 = "SELECT * FROM food WHERE food_name LIKE '%$search%'";
				$query = mysqli_query($dbcon, $query1);
				$count = mysqli_num_rows($query);

				if ($count == 0){
					echo "There was no search results returned.";

				}else{

					while ($row = mysqli_fetch_array($query)) {
						echo $row ['food_name'];
						echo "<br>";
					}
				}
			}
			?>
		</div>

		<div class="item6">
			<footer>
				<p>&copy; 2022 A Chow Worn.</p>
			</footer>
		</div>
		
	</div>
	</body>
</main>
</html>