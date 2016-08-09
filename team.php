<?php
	require('dbconnect.php');

	if(isset($_GET)){
		$teamid = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
		$query = "SELECT * FROM teams WHERE teamid = :id"; 
    	$statement = $db->prepare($query); // Returns a PDOStatement object.
    	$statement->bindValue(':id', $teamid, PDO::PARAM_INT);
    	$statement->execute();
    	$team = $statement->fetch(PDO::FETCH_ASSOC); 
		
		$locationid = $team['location'];

    	$query2 = "SELECT * FROM players WHERE teamid = :id"; 
    	$statement2 = $db->prepare($query2); // Returns a PDOStatement object.
    	$statement2->bindValue(':id', $teamid, PDO::PARAM_INT);
    	$statement2->execute();
    	$players = $statement2->fetchAll(PDO::FETCH_ASSOC);

    	$locationquery = "SELECT * FROM locations WHERE locationid = :locationid";
    	$statement3 = $db->prepare($locationquery);
    	$statement3->bindValue(':locationid', $locationid);
    	$statement3->execute();
    	$location = $statement3->fetchAll(PDO::FETCH_ASSOC); 

	}
?>
<?php include 'header.php' ?>
	<h2>Players on <?= $team['name'] ?></h2>
	<ul>
		<?php foreach($players as $player): ?>
			<li><a href="player.php?id=<?= $player['playerid']?>&amp;teamname=<?= $team['name'] ?>"><?= $player['name'] ?></a> </li>
		<?php endforeach ?> 
	</ul>
	<h2>Location</h2>
	<pre><?= print_r($location);?></pre>
	<p><?= $team['name'] ?> plays at <?= $location[0]['name'] ?>.</p>
</body>
</html>







