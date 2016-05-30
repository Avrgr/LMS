<?php
	require("dbconnect.php");
	$query = "SELECT * FROM leagues";
	$statement = $db->prepare($query); // Returns a PDOStatement object.
    $statement->execute(); // The query is now executed.
?>
<!doctype html>
<html>
<head>
	<title>League Management System</title>
</head>
<body>
	<h2>Leagues:</h2>
	<ul>
	<?php while($row = $statement->fetch()):?>
		<li><a href="league.php?id=<?= $row['leagueid'] ?>"><?= $row['name'] ?></a></li>
	<?php endwhile ?>
	</ul>
</body>
</html>