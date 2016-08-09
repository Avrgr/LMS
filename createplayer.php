<?php
    require("dbconnect.php");
    // Fetch data from the DB for the select
    $query = "SELECT name FROM leagues";
    $statement = $db->prepare($query); // Returns a PDOStatement object.
    $statement->execute();
    $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

    //  Grab all players
    $playersquery = "SELECT * FROM players";
    $state = $db->prepare($playersquery);
    $state->execute();

    //  Grab all teams
    $teamsquery = "SELECT * FROM teams";
    $state1 = $db->prepare($teamsquery);
    $state1->execute();
    $teams = $state1->fetchAll(PDO::FETCH_ASSOC);

    // Sanitize user input to escape HTML entities and filter out dangerous characters.
    if(isset($_POST)){
        $name  = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $ranking = filter_input(INPUT_POST, 'ranking', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $team = filter_input(INPUT_POST, 'team', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        
        // Build the parameterized SQL query and bind to the above sanitized values.
        $query     = "INSERT INTO Players (name, rank, teamid) values (:name, :ranking, :team)";
        $statement = $db->prepare($query);
        $statement->bindValue(':name', $name);        
        $statement->bindValue(':ranking', $ranking);
        $statement->bindValue(':team', $team);

        // Execute the INSERT.
        $statement->execute();

        // Determine the primary key of the inserted row.
        $insert_id = $db->lastInsertId();        
    }

?>
<?php include 'header.php' ?>
    <h2>All Players</h2>
    <ul>
        <?php while($players=$state->fetch()): ?>
        <li><?= $players['name']?></li>
        <?php endwhile ?>
    </ul>
    <form action="createplayer.php" method="post">
        <label>Player Name<input type="text" name="name" id="name" autofocus /></label>
        <br/><label>Ranking
            <select name="ranking">
                <?php foreach($rows as $row=>$name): ?>
                <option><?= $name['name'] ?></option>
                <?php endforeach ?>
            </select>
        </label><br/>
        <label>Team
            <select name="team">
                <?php foreach($teams as $team=>$name): ?>
                <option value="<?= $name['teamid'] ?>"><?= $name['name'] ?></option>
                <?php endforeach ?>
            </select>
        </label><br/>
        <button type="submit">Add Player</button>
    </form>
</body>
</html>


















