<?php

 require_once("../includes/connection.php");

          if(isset($_POST['submit'])){
            $username=$_POST['username'];
            $password=$_POST['password'];
            $email=$_POST['email'];

            $pdo=database_connect();

              if(empty($username) or empty($password) or empty($email)){
              $error="All fields are required";
              }

              else{

             $sth= $pdo->prepare("SELECT 1 FROM login WHERE username=:username");
             $sth->bindvalue(':username', $username);

             $sth->execute();

              $checkrows= $sth->rowCount();
              if($checkrows=1){
                $error="Username already in use";
                  }

              $sth= $pdo->prepare("SELECT 1 FROM login WHERE email=:email");
              $sth->bindvalue(':email', $email);

              $sth->execute();
              
              $checkrows= $sth->rowCount();
              if($checkrows){
                $error="Email Exists";
                }
          
              $salt = dechex(mt_rand(0, 2147483647)) . dechex(mt_rand(0, 2147483647));

                $hpassword = hash('sha256', $password . $salt);

                for($times =0; $times<65536; $times++){
                        $hpassword = hash('sha256', $hpassword . $salt);
                }

                  $sth = $pdo ->prepare("INSERT INTO login(email, username, password, salt) VALUES(:email, :username, :password, :salt)");
                  $sth-> bindValue(':email',$email);
                  $sth-> bindValue(':username', $username);
                  $sth->bindValue(':password', $hpassword);
                  $sth-> bindValue(':salt', $salt);

                  $sth->execute();
           }

           header('Location:sign_up.php');
      } 


?>


<html>
<head><title>sign up</title>
<body>

  <p><?php if(isset($error)){echo $error; } ?></p>

<form action ="sign_up.php" method="post">
e-mail:<br> <input type="email" name="email"/><br/>
username:<br><input type= "text" name="username"/><br/>
password:<br><input type="password" name="password"/><br/>
<br/>
<input type="submit"  name="submit" value="sign up"/>
</form>
</body>
</html>


