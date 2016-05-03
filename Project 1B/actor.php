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
<h1>Showing Actor Information</h1>

<?php 
	$db_connection = mysql_connect("localhost:3036", "cs143", "");
	
	if(!$db_connection) {
	    $errmsg = mysql_error($db_connection);
	    print "Connection failed: $errmsg <br />";
	    exit(1);
	}

	mysql_select_db("CS143", $db_connection);

	if (isset($_GET['id'])) {
		$id = $_GET['id'];
		
		//Get Actor Info
		$retrieve = "SELECT * FROM Actor WHERE id= " . $id . ";";

		$rs = mysql_query($retrieve, $db_connection);
		$field_num = mysql_num_fields($rs);

		print "<table border='1'><tr>";

		while($row = mysql_fetch_row($rs)) {
			print "<tr><th>Name</th><td>".$row[2]." ".$row[1]."</td></tr>";
			print "<tr><th>Sex</th><td>".$row[3]."</td></tr>";
			print "<tr><th>Date of Birth</th><td>".$row[4]."</td></tr>";
			if(is_null($row[5]))
				print "<tr><th>Date of Death</th><td>Still Alive</td></tr>";
			else
				print "<tr><th>Date of Death</th><td>".$row[5]."</td></tr>";


		}

		print "</table>";

		//Get all the movies the Actor has been in
		$retrieve = "SELECT title, role, mid FROM Movie, MovieActor WHERE aid= " . $id . " and Movie.id = MovieActor.mid;";
		
		$rs = mysql_query($retrieve, $db_connection);
		$field_num = mysql_num_fields($rs);

		print "<h1>Movie Results:</h1>";
		print "<table border='1'><tr><th>Title</th><th>Role</th></tr>";

		
		while($row = mysql_fetch_row($rs)) {
			echo "<tr>";

			echo '<td><a href="movie.php?id=' . $row[2] . '">' . $row[0] . '</a></td>';
			echo "<td>" . $row[1] . "</td>";

			echo "</tr>";
		}

		echo "</table>";

	} 

	print"</div>";

	mysql_close($db_connection);
 ?>


</body>

</html>