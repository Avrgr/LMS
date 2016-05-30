<?php
    define('DB_DSN','mysql:host=localhost;dbname=lms;charset=utf8');
    define('DB_USER','admin');
    define('DB_PASS','bluejays');     

    // Create a PDO object called $db.
    $db = new PDO(DB_DSN, DB_USER, DB_PASS); 
?>