<?php
    require("dbconnect.php");

    // Fetch all teams
    $locations = "SELECT * FROM locations";
    $state = $db->prepare($locations);
    $state->execute();

    // Sanitize user input to escape HTML entities and filter out dangerous characters.
    if(isset($_POST)){
        $name  = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $address = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        
        // Build the parameterized SQL query and bind to the above sanitized values.
        $query2     = "INSERT INTO locations (name, address) values (:name, :address)";
        $statement2 = $db->prepare($query2);
        $statement2->bindValue(':name', $name);        
        $statement2->bindValue(':address', $address);
        
        // Execute the INSERT.
        $statement2->execute();

        // Determine the primary key of the inserted row.
        $insert_id = $db->lastInsertId();        
    }
?>
<?php include 'header.php' ?>
    <h2>Current Locations</h2>
    <ul>
    <?php while($location = $state->fetch()):?>
        <li><a href="location.php?id=<?= $location['locationid'] ?>"><?= $location['name'] ?></a></li>
    <?php endwhile ?>
    </ul>
    <h2>Add a Location</h2>
    <form action="locations.php" method="post">
        <label>Name<input type="text" name="name" id="name" autofocus /></label>
        <label>Address<input type="text" name="address" id="name" autofocus /></label>
        <button type="submit">Add Location</button>     
    </form>
</body>
</html>
