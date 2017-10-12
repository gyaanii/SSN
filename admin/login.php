<?php
	if(!empty($_POST){
             //get POST DATA
              $username =$_POST['username'];
              $password =$_POST['password'];

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
