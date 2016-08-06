<?php	
	session_start();
	error_reporting(E_ALL);
	$dir = 'test/';	
	
	if (!isset($_SESSION['isAdmin'])) {	
		header("HTTP/1.0 403 Forribean");
		exit("Доступ запрещен");
	}
	
	if (isset($_FILES)&&!empty($_FILES['file'])) {
		$file_name = $_FILES['file']['name'];
		if (preg_match("/\.json$/", $file_name)) {
			if (!in_array($file_name, scandir($dir))) {
					move_uploaded_file($_FILES['file']['tmp_name'], $dir.$file_name);	
					header("Location: list.php"); die;
			} 
			else {
				echo "<p>Файл $file_name уже существует. Загрузите новый файл:</p>";
			}
		}	
		else {
			echo "<p>Неверный формат файла. Выберите файл в формате .json и загрузите его:</p>";
		}
	}
?>	

<!DOCTYPE html>
<html>
<head>
	<title>Загрузка файла с тестом</title>
	<meta charset="utf-8">
	<link type="text/css" href="style.css" rel="stylesheet" charset="utf-8"> 
</head>
<body> 

	<h1>Загрузка файла с тестом</h1>

<form action="" method="post" enctype="multipart/form-data">
	<input type="file" name="file"> 
	<input type="submit" value="Загрузить файл">
</form>	

</body>
</html>

