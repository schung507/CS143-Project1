<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="style.css">

	<title>
	</title>
</head>
<body>

<div class="nav">
<nav>
	<li><a href="actor-director.php">+Add Actors/Directors</a></li>
	<li><a href="add-movie.php">+Add Movies</a></li>
	<li><a href="movie-actor.php">+Add Actors to Movies</a></li>
	<li><a href="movie-director.php">+Add Directors to Movies</a></li>
	<li><a href="actor.php">+View Actor Info</a></li>
	<li><a href="movie.php">+View Movie Info</a></li>
	<li><a href="review.php">+Add Review</a></li>
	<li><a href="search.php">+Search</a></li>
</nav>
</div>

<div class="content">
<h1>Add an Actor to a Movie:</h1>

<?php 

	$db_connection = mysql_connect("localhost:3036", "cs143", "");
	
	if(!$db_connection) {
    $errmsg = mysql_error($db_connection);
    print "Connection failed: $errmsg <br />";
    exit(1);
	}

	mysql_select_db("CS143", $db_connection);

	//Get a list of all Movie names
	$movies = "SELECT id, title FROM Movie;";

	echo '<form method="POST">
	<p>Movie Title: <select name="title"></p>';

	$rs = mysql_query($movies, $db_connection);

	while($row = mysql_fetch_row($rs))
		print '<option value="' . $row[0] . '">' . $row[1] . '</option>';

	echo '</select>';

	//Get a list of all Actor names
	$actors = "SELECT concat(first, ' ', last), id FROM Actor;";
	echo '<p>Add New Actor: <select name="name"></p>';

	$result = mysql_query($actors, $db_connection);

	while($row = mysql_fetch_row($result))
		print '<option value="' . $row[1] . '">' . $row[0] . '</option>';

	echo '</select><p>Role: <input type="text" name="role" maxlength="50" required></p><p><input type="submit" value="Add Actor!" name="submit"></p></form>';

	if (isset($_POST['submit'])) {

		//store values from the form
		$mid = $_POST["title"];
		$aid = $_POST["name"];
		$role = $_POST["role"];


		$insert = "INSERT INTO MovieActor
					VALUES(" . $mid . ", " . $aid . ", '" . $role . "');";

		if (!mysql_query($insert, $db_connection))
			echo "Oops! Something went wrong.";
	}
		
	print "</div>";
	mysql_close($db_connection);
 ?>

</body>
</html>