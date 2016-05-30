<?php
	require("dbconnect.php");
	if(isset($_GET)){
		$league = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
		$query = "SELECT * FROM leagues WHERE leagueid = :id";
		$statement = $db->prepare($query); // Returns a PDOStatement object.
    	$statement->bindValue(':id', $league, PDO::PARAM_INT);
    	$statement->execute();
    	$row = $statement->fetch(PDO::FETCH_ASSOC); 

    	$query2 = "SELECT * FROM teams"; //WHERE leagueid = :id
    	$statement2 = $db->prepare($query2); // Returns a PDOStatement object.
    	// /$statement2->bindValue(':id', $league, PDO::PARAM_INT);
    	$statement2->execute();
    	$teams = $statement2->fetchAll(PDO::FETCH_ASSOC); 
	}
	
?>
<!doctype html>
<html>
<head>
	<title><?= $row['name'] ?></title>
</head>
<body>
	<h2>Teams in <?= $row['name'] ?></h2>
	<ul><pre> <?php print_r($teams) ?></pre>
		<?php foreach($teams as $team): ?>
			<li><?= $team['name'] ?> </li>
		<?php endforeach ?> 
	</ul>
</body>
</html>