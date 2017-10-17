<?php
  require_once('includes/connection.php');

  if(isset($_SESSION['logged_in'])){
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Index</title>
  </head>

<body>
  <ol>
    <li><a style="text-decoration:none;" href="add_article.php">Add Article</a></li>
    <li><a style="text-decoration:none;" href="delete_article.php">Delete Article</a></li>
    <li><a style="text-decoration:none;" href="logout.php">Logout</a></li>
  </ol>
</body>
</html>

<?php
  }
  else{
  
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

          $row= $sth->fetch();

            if($row){
                $cpwd = hash('sha256',$password.$row['salt']);

                for($times=0; $times< 65536; $times++){
                        $cpwd = hash('sha256', $cpwd . $row['salt']);
                }
            }

          if($cpwd === $row['password']){

            $_SESSION['logged_in']=true;//SHOULD BE DEFINED AS TRUE
            unset($row['salt']);
            unset($row['password']);

            header('location:index.php');
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
  </head>
  <body>
    <form method="post" action="">
      <input type="text" name="username" placeholder="Name">
      <input type="password" name="password" placeholder="Password">
      <input type="submit" name="submit" value="login">
    </form>
        <a href="sign_up.php">Sign Up</a>
  </body>
</html>


<?php
  }
?>


