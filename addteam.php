<?php
    require("dbconnect.php");
    // Fetch data from the DB for the select
    $query = "SELECT * FROM leagues";
    $statement = $db->prepare($query); // Returns a PDOStatement object.
    $statement->execute();
    $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

    // Fetch all teams
    $teamsquery = "SELECT * FROM teams";
    $state = $db->prepare($teamsquery);
    $state->execute();

    // Fetch all locations
    $locations = "SELECT * FROM locations";
    $statelocations = $db->prepare($locations);
    $statelocations->execute();
    $locationrows = $statelocations->fetchAll(PDO::FETCH_ASSOC);

    // Sanitize user input to escape HTML entities and filter out dangerous characters.
    if(isset($_POST)){
        $name  = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $league = filter_input(INPUT_POST, 'league', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $location = filter_input(INPUT_POST, 'location', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        
        // Build the parameterized SQL query and bind to the above sanitized values.
        $query2     = "INSERT INTO teams (name, location, leagueid) values (:name, :location, :league)";
        $statement2 = $db->prepare($query2);
        $statement2->bindValue(':name', $name); 
        $statement2->bindValue(':location', $location);       
        $statement2->bindValue(':league', $league);
        
        // Execute the INSERT.
        $statement2->execute();

        // Determine the primary key of the inserted row.
        $insert_id = $db->lastInsertId();        
    }
?>
<?php include 'header.php' ?>
    <h2>Current Teams</h2>
    <ul>
    <?php while($team = $state->fetch()):?>
        <li><a href="team.php?id=<?= $team['teamid'] ?>"><?= $team['name'] ?></a></li>
    <?php endwhile ?>
    </ul>
    <h2>Add a Team</h2>
    <form action="addteam.php" method="post">
        <label>Team Name<input type="text" name="name" id="name" autofocus /></label>
        <br/><label>League
            <select name="league">
                <?php foreach($rows as $row=>$name): ?>
                <option value="<?= $name['leagueid']?>"><?= $name['name'] ?></option>
                <?php endforeach ?>
            </select>
        </label><br/>
        <label>Location
            <select name="location">
                <?php foreach($locationrows as $location=>$place): ?>
                <option value = "<?= $place['locationid'] ?>"><?= $place['name'] ?></option>
                <?php endforeach ?>
            </select>
        </label><br/>
        <button type="submit">Add Team</button>     
    </form>
</body>
</html>
