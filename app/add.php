<?php
	require_once('includes/connection.php');

	if(isset($_SESSION['logged_in'])){

if (isset($_POST['submit'])){
		$article_title=$_POST['title'];
		$article_content=$_POST['content'];

		$pdo=database_connect();

		if(empty($article_title) or empty($article_content)){
			$error= "All Fields are required";
		}

		else{
			$sth= $pdo-> prepare("INSERT INTO article (article_title, article_content, article_timestamp) VALUES (:article_title, :article_content, :article_timestamp)");
			$sth->bindValue(':article_title', $article_title);
			$sth->bindValue(':article_content', $article_content);
			$sth->bindValue(':article_timestamp', time());

			$sth->execute();

			header('Loation:add.php');

		}


}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<title>Add Article</title>
</head>

<body>
	<h4>Add Article</h4>
	<p><?php if(isset($error)){ echo $error;} ?></p>
	<form method="post" action="" autocomplete="off">
		<input type="text" name="title" placeholder="Title"><br><br>
		<textarea rows=25 cols=50 name="content" placeholder="Content"></textarea><br><br>
		<input type="submit" name="submit" value="Submit">
	</form>
</body>

</html>

<?php
}
	else{
		header('Location:index.php');
		exit();
	}
?>

