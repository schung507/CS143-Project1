<!DOCTYPE html>
<html>
<head>
	<title>
	</title>
</head>
<body>

<p>Showing Actor Information</p>

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

		
		for($i = 0; $i < $field_num; $i++){
			$field_name = mysql_fetch_field($rs, $i);

			print "<th>$field_name->name</th>";

		}

		print "</tr>";
		
		while($row = mysql_fetch_row($rs)) {
			print "<tr>";

			foreach($row as $field_cell)
				print "<td>$field_cell</td>";

			print "</tr>";
		}

		print "</table>";

		//Get all the movies the Actor has been in
		$retrieve = "SELECT title, role, mid FROM Movie, MovieActor WHERE aid= " . $id . " and Movie.id = MovieActor.mid;";
		
		$rs = mysql_query($retrieve, $db_connection);
		$field_num = mysql_num_fields($rs);

		print "<h1>Movie Results:</h1>";
		print "<table border='1'><tr>";

		
		for($i = 0; $i < 2; $i++){
			$field_name = mysql_fetch_field($rs, $i);

			print "<th>$field_name->name</th>";

		}

		print "</tr>";
		
		while($row = mysql_fetch_row($rs)) {
			echo "<tr>";

			echo '<td><a href="movie-info.php?id=' . $row[2] . '">' . $row[0] . '</a></td>';
			echo "<td>" . $row[1] . "</td>";

			echo "</tr>";
		}

		echo "</table>";

	} 

	mysql_close($db_connection);
 ?>


</body>

</html>