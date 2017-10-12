<?php session_start(); ?>

<html>
<head><title>sign up</title>
<body>

<?php
     if(!empty($_POST)){

             if(empty($_POST['email'])){ die("Please enter your email address!");}
             if(empty($_POST['username'])){ die("Please enter your username!");}
             if(empty($_POST['password'])){ die("Please enter your password!");}

             require_once("/includes/connection.php");
             $pdo = db_connect();


             $email = $_POST['email'];
             $username = $_POST['username'];
             $password = $_POST['password'];

      //check if the email exists
             $query01 = "SELECT 1 from login where email = :email";

             $query01_params = array(':email' => $email);
              try{
                      $line01 = $pdo->prepare($query01);

                      $result01 = $line01->execute($query01_params);

              }catch(PDOException $e){
                die("failed to run query!".$e->getMessage());
              }

             $row01 = $line01->fetch();
                if($row01){die("this email is already in use!");}

      //check if the username exists

                $query02 = "SELECT 1 from login where username = :username";

                $query02_params = array(':username' => $username);
                try{
                        $line02 = $pdo->prepare($query02);
                        $result02 = $line02->execute($query02_params);          
                }catch(PDOException $e){
                        die("failed to run query!".$e->getMessage());   
                }
                $row02 = $line02->fetch();
                if($row02){die("username already exists!");}
 
        //preparing db statement
             $query = "INSERT INTO login(email, username, password, salt) VALUES(:email, :username, :password, :salt)";

        //creating salt vairable and using it on hash function
              $salt = dechex(mt_rand(0, 2147483647)) . dechex(mt_rand(0, 2147483647));

                $hpassword = hash('sha256', $password . $salt);

        //increasing hash frequency
                for($times =0; $times<65536; $times++){
                        $hpassword = hash('sha256', $hpassword . $salt);
                }

          $query_params = array(':email'=> $email,':username' => $username,':password' => $hpassword, ':salt' => $salt);

            try{
                  $line = $pdo->prepare($query);
                 $result= $line->execute($query_params);

                 print "sign_up successful!"; 
            }catch(PDOException $e){
               $pdo->rollBack();
            die("Failed to run query!".$e->getMessage());
            }

          header("Location: login.php");
          die("Redirecting to login page.");
          exit; 
      }

?>

<form action ="sign_up.php" method="post">
e-mail: <input type="text" name="email"/><br/>
username: <input type= "text" name="username"/><br/>
password: <input type="password" name="password"/><br/>
<br/><br/>
<input type="submit" value="sign up"/>
</form>

</body>
</html>


