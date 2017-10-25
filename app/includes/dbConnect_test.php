<?php
	$db_host="localhost";
	$db_user="root";
	$db_pass="";
	$db_name="vidhyalaya";

	//Create a database connection
	$dbConnected=mysqli_connect($db_host, $db_user, $db_pass);

	//Select a database to use
	$dbSelected=mysqli_select_db($dbConnected, $db_name);

	if($dbConnected){
			echo "MySQL connected Ok <br><br>";

	if($dbSelected){
			echo "Database connected OK <br><br>";
	}

	else{
			echo "Database connected Failed.";
		}
	}

	else{
		echo "MySQL connected Failed.";
	}
?>