<!DOCTYPE html>
<html>
<head>
	<title>
	</title>
</head>
<body>

<p>Add a new Movie to the Database:</p>

<form method="POST">
	<p>Title: <input type="text" name="title" required></p>
	<p>Year released: <input type="number" name="year" min="1890" max="2016" required></p>
	<p>MPAA Rating: <select name="mpaa_rating">
						<option value="G">G</option>
						<option value="PG">PG</option>
						<option value="PG-13">PG-13</option>
						<option value="R">R</option>
						<option value="NC-17">NC17</option></select></p>
	<p>Company: <input type="text" name="company" required></p>
	<p>Genre:
		<br><input type="checkbox" name="genre[]" value="Action"> Action
		<br><input type="checkbox" name="genre[]" value="Adult"> Adult
		<br><input type="checkbox" name="genre[]" value="Adventure"> Adventure
		<br><input type="checkbox" name="genre[]" value="Animation"> Animation
		<br><input type="checkbox" name="genre[]" value="Comedy"> Comedy
		<br><input type="checkbox" name="genre[]" value="Crime"> Crime
		<br><input type="checkbox" name="genre[]" value="Documentary"> Documentary
		<br><input type="checkbox" name="genre[]" value="Drama"> Drama
		<br><input type="checkbox" name="genre[]" value="Family"> Family
		<br><input type="checkbox" name="genre[]" value="Fantasy"> Fantasy
		<br><input type="checkbox" name="genre[]" value="Fantasy"> Foreign
		<br><input type="checkbox" name="genre[]" value="Horror"> Horror
		<br><input type="checkbox" name="genre[]" value="Musical"> Musical
		<br><input type="checkbox" name="genre[]" value="Romance"> Romance
		<br><input type="checkbox" name="genre[]" value="Sci-Fi"> Sci-Fi
		<br><input type="checkbox" name="genre[]" value="Short"> Short
		<br><input type="checkbox" name="genre[]" value="Thriller"> Thriller
		<br><input type="checkbox" name="genre[]" value="War"> War
		<br><input type="checkbox" name="genre[]" value="Western"> Western
	<p>IMDb Rating (0-100): <input type="number" name="imdb_rating" min="0" max="100"></p>
	<p>Rotten Tomatoes Rating (0-100): <input type="number" name="rotten_rating" min="0" max="100"></p>
	<p><input type="submit" value="Enter" name="submit"> <input type="reset" value="Reset"></p>

<?php 
	$db_connection = mysql_connect("localhost:3036", "cs143", "");
	
	if(!$db_connection) {
    $errmsg = mysql_error($db_connection);
    print "Connection failed: $errmsg <br />";
    exit(1);
	}

	mysql_select_db("CS143", $db_connection);

	//First, get the max ID of the current database.
	$query = "SELECT id FROM MaxMovieID";
	$result = mysql_query($query, $db_connection);
	$row = mysql_fetch_row($result);

	foreach ($row as $cell)
		$maxid = $cell;

	//store the values of the form
	$id = $maxid + 1;
	$title = $_POST["title"];
	$year = $_POST["year"];
	$mpaa_rating = $_POST["mpaa_rating"];
	$company = $_POST["company"];
	$genre = $_POST["genre"];
	$imdb = $_POST["imdb_rating"];
	$rotten = $_POST["rotten_rating"];



	if (isset($_POST['submit'])) {

		//insert into the Movie Relation
		$insert = "INSERT INTO Movie 
					VALUES(" . $id . ", '" . $title . "', " . $year . ", '" . $mpaa_rating . "', '" . $company . "');";

		if (mysql_query($insert, $db_connection)) {
		
			//insert into the MovieGenre Relation
			if (!empty($genre)) {				
				foreach ($genre as $gen) {
					print "poop";
					$insert = "INSERT INTO MovieGenre 
							VALUES(" . $id . ", '" . $gen . "');";

					mysql_query($insert, $db_connection);
				}
			}
		 
			//insert into the MovieRating Relation
			$insert = "INSERT INTO MovieRating 
						VALUES(" . $id . ", " . $imdb . ", " . $rotten . ");";
			mysql_query($insert, $db_connection);

			//update MaxMovieID
			$update = "UPDATE MaxMovieID SET id = " . $id . ";";
			mysql_query($update, $db_connection);
		}
		else
			echo "Oops! Something went wrong adding your movie.";

	}

	mysql_close($db_connection);
 ?>


</body>

</html>