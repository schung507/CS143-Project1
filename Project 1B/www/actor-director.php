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
<h1>Add a new Actor/Director to the Database:</h1>

<form method="POST">
	<br>I want to add: <input type="radio" name="type" value="actor" checked> Actor 
						<input type="radio" name="type" value="director"> Director
						<input type="radio" name="type" value="both"> Both
	<p>First name: <input type="text" name="first_name" maxlength="20" required>
	<p>Last name: <input type="text" name="last_name" maxlength="20" required></p>
	<p>Sex: <input type="radio" name="gender" value="Male" checked> Male 
			<input type="radio" name="gender" value="Female"> Female</p>
	<p>Date of birth (mm/dd/yyyy): <input type="text" name="m_dob" style="width: 20px;" required> / 
						<input type="text" name="d_dob" style="width: 20px;" required> / 
						<input type="text" name="y_dob" style="width: 40px;" required></p>
	<p>Is this person still alive?: <input type="radio" name="is_alive" value="yes" checked> Yes
									<input type="radio" name="is_alive" value="no"> No</p>
	<p>Date of death, if applicable: <input type="text" name="m_dod" style="width: 20px;"> / 
										<input type="text" name="d_dod" style="width: 20px;"> / 
										<input type="text" name="y_dod" style="width: 40px;"></p>
	<p><input type="submit" value="Enter" name="submit"> <input type="reset" value="Reset"></p>
</form>	

<?php
	$db_connection = mysql_connect("localhost:3036", "cs143", "");
	
	if(!$db_connection) {
    $errmsg = mysql_error($db_connection);
    print "Connection failed: $errmsg <br />";
    exit(1);
}

	mysql_select_db("CS143", $db_connection);

	//First, get the max ID of the current database.
	$query = "SELECT id FROM MaxPersonID";
	$result = mysql_query($query, $db_connection);
	$row = mysql_fetch_row($result);

	foreach ($row as $cell)
		$maxid = $cell;

	//Next, store the values of the form.
	$type = $_POST["type"];
	$firstname = $_POST["first_name"];
	$lastname = $_POST["last_name"];

	$sex = ($_POST["gender"] == "Male" ? "Male" : "Female");

	$concat_dob = $_POST["m_dob"] . "/" . $_POST["d_dob"] . "/" . $_POST["y_dob"];
	$dob = date("Y-m-d", strtotime($concat_dob));

	$is_alive = $_POST["is_alive"];

	if ($is_alive == "yes")
		$dod = "NULL";
	else {
		$concat_dod = $_POST["m_dod"] . "/" . $_POST["d_dod"] . "/" . $_POST["y_dod"];
		$dod = "'" . date("Y-m-d", strtotime($concat_dod)) . "'";
	}
	
	$id = $maxid + 1;

	//Add the new tuple to the database.
	$insert_a = "INSERT INTO Actor 
				VALUES(" . $id . ", '" . $lastname . "', '" . $firstname . "', '" . $sex . "', '"
						. $dob . "', " . $dod . ");";
	$insert_d = "INSERT INTO Director 
				VALUES(" . $id . ", '" . $lastname . "', '" . $firstname . "', '" . $dob . "', " . $dod . ");";

	//Redundant code - clean up later
	if (isset($_POST['submit'])) {
		if ($type == "actor" && mysql_query($insert_a, $db_connection)) {
	    	echo "New record created successfully!";

	    	$update = "UPDATE MaxPersonID SET id = " . $id . ";";
			mysql_query($update, $db_connection);
		}
		else if ($type == "director" && mysql_query($insert_d, $db_connection)) {
	    	echo "New record created successfully!";

	    	$update = "UPDATE MaxPersonID SET id = " . $id . ";";
			mysql_query($update, $db_connection);
		}
		else if ($type == "both" && mysql_query($insert_a, $db_connection) && mysql_query($insert_d, $db_connection)) {
	    	echo "New record created successfully!";

	    	$update = "UPDATE MaxPersonID SET id = " . $id . ";";
			mysql_query($update, $db_connection);
		}
		else
	    	echo "Oops! Something went wrong.";
	}

	print"</div>";

	mysql_close($db_connection);
?>

</body>

</html>