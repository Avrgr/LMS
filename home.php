<?php
	require("dbconnect.php");
	$query = "SELECT * FROM leagues";
	$statement = $db->prepare($query); // Returns a PDOStatement object.
    $statement->execute(); // The query is now executed.
?>
<?php include 'header.php' ?>
		<h2>Leagues:</h2>
		<ul>
		<?php while($row = $statement->fetch()):?>
			<li><a href="league.php?id=<?= $row['leagueid'] ?>"><?= $row['name'] ?></a></li>
		<?php endwhile ?>
		</ul>
		<p><a href="addleague.php">Add League</a>
	</div>
</body>
</html>