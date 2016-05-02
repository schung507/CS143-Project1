<!DOCTYPE html>
<html>
<head>
	<title>
	</title>
</head>
<body>

<p>Rate a movie:</p>

<?php 
	$db_connection = mysql_connect("localhost:3036", "cs143", "");
	
	if(!$db_connection) {
	    $errmsg = mysql_error($db_connection);
	    print "Connection failed: $errmsg <br />";
	    exit(1);
	}

	mysql_select_db("CS143", $db_connection);

	//Query for Movie Titles
	$movies = "SELECT id, title FROM Movie;";

	echo '<form method="POST">
	<p>Which movie would you like to rate?</p><p><select name="title"></p>';

	$rs = mysql_query($movies, $db_connection);
	$row = mysql_fetch_row($rs);

	while($row = mysql_fetch_row($rs))
		print '<option value="' . $row[0] . '">' . $row[1] . '</option>';

	echo '</select>';

	//Display the rest of the form

	echo '<p>Your name: <input type="text" name="name" maxlength="20" required></p>
			<p>Your rating: <input type="number" name="rating" min="0" max="5" required></p>
			<p>Comments:</p>
			<p><textarea rows="5" cols="40" name="comment" maxlength="500"></textarea></p>
			<p><input type="submit" value="Enter" name="submit"> <input type="reset" value="Reset"></p>
			</form>';

	//Take form input

	//if (isset($_POST['submit'])) {

		//store values from the form
		$mid = $_POST["title"];
		$name = $_POST["name"];
		$comment = $_POST["comment"];
		$rating = $_POST["rating"];

		$insert = "INSERT INTO Review
					VALUES('" . $name . "', NOW(), " . $mid . ", " . $rating . ", '" . $comment . "');";

		if (mysql_query($insert, $db_connection))
			echo "Whoo! Your rating was added.";
		else
			echo "Something happened. Sorry about that!";
	//}

	mysql_close($db_connection);
 ?>


</body>

</html>