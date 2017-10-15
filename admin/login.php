<?php
  require_once('includes/connection.php');

      if(isset($_POST['submit'])){
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

                if($cpwd === $row['password']){ 
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
