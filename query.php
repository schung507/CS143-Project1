<!DOCTYPE html>
<html>
<head>
	<title>
	</title>
</head>
<body>

<form method="GET">
	<textarea name="query" rows=10 cols=60> </textarea>
	<input type="submit" value="Enter">
</form>	

<?php
	$db_connection = mysql_connect("localhost:3036", "cs143", "");
	
	if(!$db_connection) {
    $errmsg = mysql_error($db_connection);
    print "Connection failed: $errmsg <br />";
    exit(1);
}

	mysql_select_db("CS143", $db_connection);


	$query = $_GET["query"];

	if(!empty($query)){

		$rs = mysql_query($query, $db_connection);
		$field_num = mysql_num_fields($rs);

		print "<h1>Results:</h1>";
		print "<table border='1'><tr>";

		
		for($i = 0; $i < $field_num; $i++){
			$field_name = mysql_fetch_field($rs, $i);

			print "<th>$field_name->name</th>";

		}

		print "</tr>";
		
		while($row = mysql_fetch_row($rs)){
			print "<tr>";

			foreach($row as $field_cell){
				print "<td>$field_cell</td>";
			}

			print "</tr>";
		}

		print "</table>";


	}
	mysql_close($db_connection);

?>

</body>

</html>