<?php
	if(!empty($_POST){
             //get POST DATA
              $username =$_POST['username'];
              $password =$_POST['password'];


	      require_once("includes/connection.php");
	      $pdo = db_connect();

        $query = "SELECT username, password, salt FROM login where username = :username";
        $query_params = array(':username'=>$username);


        //run the query against database
        try{
              $line = $pdo->prepare($query);
              $result = $line->execute($query_params);
        }catch(PDOException $e){
                die("Failed to run query!".$e->getMessage());
        }


        //setting the initial login status 
        $login_status = false;

        //get user data from database
        $query_data = $line->fetch();


        //comparing the password 
        if($query_data){
                $cpwd = hash('sha256',$password.$query_data['salt']);

                for($times=0; $times< 65536; $times++){
                        $cpwd = hash('sha256', $cpwd . $query_data['salt']);
                }

                if($cpwd === $query_data['password']){ $login_status = true; }
        }



        if($login_status){
             unset($query_data['salt']);
             unset($query_data['password']);

             //storing user data in session varibale
              $_SESSION['user'] = $query_data['username']; 

             header('Location: home.php');
             die("Redirecting to : home.php");
        }else{
             print("login failed ;( Try Again?!");
        }




?>


<html>
	<head>
		<title>login </title>

		<link href="../css/style.css" rel="stylesheet">
	</head>
	<body>
		<form method="post" action="login.php">
			<input type="text" name="username" placeholder="Name">
			<input type="password" name="password" placeholder="Password">
			<input type="submit" value="login">
		</form>
	</body>
</html>
