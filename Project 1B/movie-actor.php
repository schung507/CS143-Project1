<!DOCTYPE html>
<html>
<head>
	<title>
	</title>
</head>
<body>

<p>Add an Actor to a Movie:</p>

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
	$row = mysql_fetch_row($rs);

	while($row = mysql_fetch_row($rs))
		print '<option value="' . $row[0] . '">' . $row[1] . '</option>';

	echo '</select>';

	//Get a list of all Actor names
	$actors = "SELECT concat(first, ' ', last), id FROM Actor;";
	echo '<p>Add New Actor: <select name="name"></p>';

	$result = mysql_query($actors, $db_connection);
	$row = mysql_fetch_row($result);

	while($row = mysql_fetch_row($result))
		print '<option value="' . $row[1] . '">' . $row[0] . '</option>';

	echo '</select><p>Role: <input type="text" name="role" required></p><p><input type="submit" value="Add Actor!" name="submit"></p></form>';

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
		

	mysql_close($db_connection);
 ?>

</body>
</html>