<?php


         if(!empty($_POST['submit'])){
        	$username=$_POST['username'];
        	$password=$_POST['password'];
	
		require_once("../includes/connecion.php");
        	$pdo= database_connect();

       
          	$sth= $pdo-> prepare("SELECT * FROM login where username=:username");
          	$sth->bindValue(':username', $username);
          	$sth->execute();

          	$row= $sth->fetch();

         	if($row){
                	$cpwd = hash('sha256',$password.$row['salt']);
			
			for($times=0; $times< 65536; $times++)  {$cpwd = hash('sha256', $cpwd . $row['salt']); }	

           		 if($cpwd === $row['password']){

           			 $_SESSION['logged_in']=true;   //SHOULD BE DEFINED AS TRUE
            			unset($row['salt']);
            			unset($row['password']);

            			header('location:../index.php');
            			exit();
              		}else { $error = "Incorrect Details!"; }
           	 }
     
        }
      
        else {  $error="All fields are required!"; }

?>
  <html>
  <head>
    <title>login </title>
  </head>
  <body>
    <form method="post" action="login.php">
      <input type="text" name="username" placeholder="Name">
      <input type="password" name="password" placeholder="Password">
      <input type="submit" name="submit" value="login">
    </form>
        <a href="../auth/sign_up.php">not member? Sign Up</a>
  </body>
</html>


