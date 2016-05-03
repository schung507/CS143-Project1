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

<div class="search">
	<form method="GET">
	<p>Search for a Movie or Actor: <input type="text" name="search" required> 
	<input type="submit" value="Search" name="submit"></p>
	</form>
</div>

<?php 
	$db_connection = mysql_connect("localhost:3036", "cs143", "");
	
	if(!$db_connection) {
	    $errmsg = mysql_error($db_connection);
	    print "Connection failed: $errmsg <br />";
	    exit(1);
	}

	mysql_select_db("CS143", $db_connection);

	if (isset($_GET['submit'])) {

		//Break up the string if it has multiple parts
		$search_words = explode(' ', $_GET['search']);

		//Add additional constraints to the query for multi-word search
		if (sizeof($search_words) > 1) {
			$added_parameters = "";
			$added_title_parameters = "";

			for ($i = 1; $i != sizeof($search_words); $i = $i + 1) {
				$added_parameters = $added_parameters . " AND (last like '%" . $search_words[$i] . "%' OR first like '%" . $search_words[$i] . "%')";
				$added_title_parameters = $added_title_parameters . " AND title like '%" . $search_words[$i] . "%'";
			}
		}			
		else {
			$added_parameters = "";
			$added_title_parameters = "";
		}

		//Query Actor First and Last Names
		$select = "SELECT concat(last, ', ', first), id, dob
					FROM Actor
					WHERE (last like '%" . $search_words[0] . "%' OR first like '%" . $search_words[0] . "%')" . $added_parameters . ";";

		$actor_rs = mysql_query($select, $db_connection);

		echo '<h5>Actors who match your search, ordered alphabetically by last name:</h5><div class="container">';

		//Output clickable links for actors
		while($row = mysql_fetch_row($actor_rs)) {
			echo '<a href="actor.php?id=' . $row[1] . '"><div class="item">' . $row[0] . ' ('.$row[2].')</div></a>';
		}

		echo '</div>';

		//Query Movie Titles
		$select = "SELECT title, id, year
					FROM Movie
					WHERE title like '%" . $search_words[0] . "%'" . $added_title_parameters . ";";	

		$movie_rs = mysql_query($select, $db_connection);

		echo '<h5>Movies that match your search:</h5><div class="container">';

		//Output clickable links for movies
		while($row = mysql_fetch_row($movie_rs)) {
			echo '<a href="movie.php?id=' . $row[1] .  '"><div class="movie-item">' . $row[0] . ' ('.$row[2].')</div></a>';
		}

		echo '</div></div></div>';

	} 

	mysql_close($db_connection);
 ?>

</body>

</html>