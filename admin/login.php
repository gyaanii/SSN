<?php

    require_once("includes/connection.php");

  if(!empty($_POST)){
             //get POST DATA
              $username =$_POST['username'];
              $password =$_POST['password'];

        $pdo = database_connect();

        $query = "SELECT * FROM login where username = :username";
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
    }

/*

  require_once('includes/connection.php');

      if(isset($_POST['username'], $_POST['password'])){
        $username=$_POST['username'];
        $password=$_POST['password'];

        $pdo= database_connect();

        if(empty($username) or empty($password)){
          $error="All fields are required!!";
        }

        else{
          $sth= $pdo-> prepare("SELECT * FROM login where username=:username");
          $sth->bindValue(':username', $username);
          $sth->execute();
          
          $logged_in=false;

          $row= $sth->fetch();

        
            if($row){
                $cpwd = hash('sha256',$password.$row['salt']);

                for($times=0; $times< 65536; $times++){
                        $cpwd = hash('sha256', $cpwd . $row['salt']);
                }

                if($cpwd === $_POST['password']){ 
                  $logged_in= true; 
                }
            }

          if($logged_in){

            $_SESSION['logged_in'];
            unset($row['salt']);
            unset($row['password']);

            header('Location:index.php');
            exit();
          }

          else{
            $error="Incorrect Details";
          }
       }
    }
*/
?>


<html>
	<head>
		<title>login </title>
    <p><?php if(isset($error)){echo $error; } ?></p>
		<link href="../css/style.css" rel="stylesheet">
	</head>
	<body>
		<form method="post" action="login.php">
			<input type="text" name="username" placeholder="Name">
			<input type="password" name="password" placeholder="Password">
			<input type="submit" name="submit" value="login">
		</form>
        <a href="sign_up.php">Sign Up</a>
	</body>
</html>
