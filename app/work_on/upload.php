<html>
<title>file upload</title>
<body>


<?php

//specify dir to store files
$file_dir='./storage/';

//specify path of storage
$file_path = $file_dir.$_FILES["upload_file"]["name"];

/*other uses of $_FILES
$file_type = $file_dir.$_FILES["upload_file"]["type"];
$file_size = $file_dir.$_FILES["upload_file"]["size"];
$file_tmp_name = $file_dir.$_FILES["upload_file"]["tmp_name"];
$file_error = $file_dir.$_FILES["upload_file"]["error"];
 */


if(move_uploaded_file($_FILES["upload_file"]["tmp_name"],$file_path)){
 
	 $img_dir ="/storage/";
	 $img_path = $img_dir.$_FILES["upload_file"]["name"];
	 $size = getimagesize($file_path);

?>
Upload complete!<br>
<img src="<?=$img_path?>"<?=$size[3]?>> <br>
<b> <?=$_POST["comment"]?> </b><br>

<?php

}else{

?>
 SOMETHING WENT WRONG! <br>

<?php
}
?>

</body>
</html>
