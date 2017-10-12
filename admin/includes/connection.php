<?php 

	try{
		$pdo= new PDO('mysql:host=localhost;dbname=vidhyalaya', 'root' '');
	}

	catch(PDOException $e){
		die("Database Connection Failed");
	}

?>