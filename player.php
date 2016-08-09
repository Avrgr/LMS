<?php
	require('dbconnect.php');

	if(isset($_GET)){
		$playerid = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
		$query = "SELECT * FROM players WHERE playerid = :id"; 
    	$statement = $db->prepare($query); // Returns a PDOStatement object.
    	$statement->bindValue(':id', $playerid, PDO::PARAM_INT);
    	$statement->execute();
    	$player = $statement->fetch(PDO::FETCH_ASSOC); 
	}
?>
<?php include 'header.php' ?>
	<h2><?= $player['name'] ?></h2>
	<p><?= $player['name'] ?> plays for <?= $_GET['teamname'] ?> and is ranked <?= $player['rank'] ?>.</p>
</body>
</html>