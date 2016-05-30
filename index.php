<?php
	require('dbconnect.php');

	if($_POST){		
		$username = $_POST['username'];
		$password = $_POST['password'];

		$query = "SELECT * FROM users";
		$statement = $db->prepare($query); // Returns a PDOStatement object.
    	$statement->execute(); // The query is now executed.
    	$users= $statement->fetchAll();
    	//print_r($users);
    	foreach($users as $user){

    		if($user['username']==$username){
    			if($user['password']==$password){
    				header("Location: home.php");
    			}
    	 	}
    	}



		
	}else{
		echo "Where's your creds, bro?";
	}

?>
<html>
<head>
	<title>League Management System</title>
</head>
<body>
	<form action="index.php" method="post">
		<label>Username<input type="text" id="username" name="username" autofocus /></label><br/>
		<label>Password<input type="password" id="password" name="password" /></label><br/>
		<button type="submit">Submit</button>
	</form>
</body>
</html>