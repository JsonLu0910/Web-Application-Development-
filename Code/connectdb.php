<?php
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "assignment";

	try 
	{
		//Create a connection object. The PDO class represents the connection between PHP and the database server.
        $connection = new PDO("mysql:host=$servername;dbname=$dbname", $username,$password);
        
        //set the PDO error mode to exception
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	} 
	catch(PDOException $e) 
	{
		echo $sql . "<br>" . $e->getMessage();
	}

	$conn = null;
?>
		
