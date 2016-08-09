<?php
	require("dbconnect.php");
	$query = "SELECT * FROM leagues";
	$statement = $db->prepare($query);
	$statement->execute();

    // Sanitize user input to escape HTML entities and filter out dangerous characters.
    if(isset($_POST)){
        $name  = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $format = filter_input(INPUT_POST, 'format', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        
        // Build the parameterized SQL query and bind to the above sanitized values.
        $query2     = "INSERT INTO leagues (name, format) values (:name, :format)";
        $statement2 = $db->prepare($query);
        $statement2->bindValue(':name', $name);        
        $statement2->bindValue(':format', $format);
        
        // Execute the INSERT.
        $statement2->execute();

        // Determine the primary key of the inserted row.
        $insert_id = $db->lastInsertId();        
    }
?>
<?php include 'header.php' ?>
	<h2>Current Leagues</h2>
	<ul>
	<?php while($row = $statement->fetch()):?>
		<li><a href="league.php?id=<?= $row['leagueid'] ?>"><?= $row['name'] ?></a></li>
	<?php endwhile ?>
	</ul>
	<form action="addleague.php" method="post">
		<label>League Name<input type="text" name="name" autofocus /></label><br/>
		<label>Format
			<select name="format">
				<option>16 Games</option>
				<option>20 Games</option>
				<option>25 Games</option>
			</select>
		</label><br/>
		<button type="submit">Add League</button>
	</form>
</body>
</html>