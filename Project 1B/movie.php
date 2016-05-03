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
<h1>Showing Movie Information</h1>

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
		
		//Get Movie Info
		$retrieve_movie = "SELECT * FROM Movie WHERE id=".$id.";";
		$retrieve_directors = "SELECT first,last, dob  FROM MovieDirector, Director
							   WHERE MovieDirector.mid = ".$id." and
							  		MovieDirector.did = Director.id;";
		$retrieve_genre = "SELECT genre FROM MovieGenre WHERE mid= ".$id.";";

		$rs1 = mysql_query($retrieve_movie, $db_connection);
		$rs2 = mysql_query($retrieve_directors, $db_connection);
		$director_num = mysql_num_rows($rs2);
		$rs3 = mysql_query($retrieve_genre, $db_connection);
		$genre_num = mysql_num_rows($rs3);
		$field_num1 = mysql_num_fields($rs1);
		$field_num2 = mysql_num_fields($rs2);
		$field_num3 = mysql_num_fields($rs3);
		$i = 0;

		//Movie Info in table
		print "<table border='1'>";
		
		while($movie_info = mysql_fetch_row($rs1)) {
			
			print "<tr><th>Title</th><td>".$movie_info[1]."(".$movie_info[2].")</td></tr>
			      <tr><th>Producer</th><td>".$movie_info[4]."</td></tr>
			      <tr><th>MPAA Rating</th><td>".$movie_info[3]."</td></tr>
			      <tr><th>Directors</th><td>";
			    
			while($directors = mysql_fetch_row($rs2)) {

				print $directors[0]." ".$directors[1]."(".$directors[2].")";
				$i++;
				if ($i < $director_num){
					print "<br> ";
				}

			}

			$i=0;
			print "</td><tr><th>Genres</th><td>";

			while($genres = mysql_fetch_row($rs3)) {

				print $genres[0];
				$i++;
				if($i < $genre_num)
					print "<br> ";
			}	

			print "</td></tr>";
		}
		print "</table>";
		

		//Get all the Actors in Movie
		$retrieve_actors = "SELECT id, first, last, role FROM MovieActor, Actor 
							WHERE MovieActor.mid= ". $id ." 
								  and MovieActor.aid = Actor.id;";
		
		$rs = mysql_query($retrieve_actors, $db_connection);
		$field_num = mysql_num_fields($rs);

		print "<h1>Actor Results:</h1>";

		//print table of Actor Roles
		print "<table border='1'><tr><th>Actor</th><th>Role</th></tr>";
		
		while($row = mysql_fetch_row($rs)) {
			
			echo '<tr><td><a href="actor.php?id=' . $row[0] . '">' . $row[1]." ".$row[2]. '</a></td>';
			echo "<td>" .$row[3]. "</td>";

		}
		print "</table>";
		

		//Get Reviews
		print "<h1>Reviews:</h1>";
		$retrieve_score = "SELECT AVG(rating), Count(*) FROM Review WHERE mid =" .$id. ";";
		$retrieve_reviews = "SELECT * FROM Review WHERE mid= ".$id.";";
	
		$rs = mysql_query($retrieve_score, $db_connection);
		$field_num = mysql_num_fields($rs);

		while($row = mysql_fetch_row($rs)) {
			
			echo "Average Score:".$row[0]."/5 (5.0 is best) by ".$row[1]. " reviews(s).<a href='review.php'>Add Review!</a>";
		}

		$rs = mysql_query($retrieve_reviews, $db_connection);
		$field_num = mysql_num_fields($rs);

		//print all reviews
		print "<table border='1'><tr><th>Name</th><th>Time</th><th>Rating</th><th>Comment</th></tr>";
		
		while($row = mysql_fetch_row($rs)) {
			print "<tr>";

			print "<td>".$row[0]."</td><td>".$row[1]."</td><td>".$row[3]."</td><td>".$row[4]."</td>";

			print "</tr>";
		}

		print "</table>";
	} 

	print "</div>";
	mysql_close($db_connection);
 ?>


</body>

</html>