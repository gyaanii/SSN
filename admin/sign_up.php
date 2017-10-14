<?php
session_start();
 require_once("includes/connection.php");

          if(!empty($_POST)){
            $username=$_POST['username'];
            $password=$_POST['password'];
            $email=$_POST['email'];

              if(empty($username) or empty($password) or empty($email)){
              $error="All fields are required";
              }
              
              else{

             $sth= $pdo->prepare("SELECT 1 FROM login WHERE username=:username");

              $sth->bindvalue(':username', $username);
              $sth->execute();

              $row=$sth->fetch();
              if($row){
                $error="Username already in use";
                  }

              $sth= $pdo->prepare("SELECT 1 FROM login WHERE email=:email");

              $sth->bindvalue(':email', $email);
              $sth->execute();

              $row=$sth->fetch();
              if($row){
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
<input type="submit" value="sign up"/>
</form>
</body>
</html>


