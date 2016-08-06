<?php	
	session_start();
	error_reporting(E_ALL);
	
	if (!isset($_SESSION['isAdmin'])) {	
		header("HTTP/1.0 403 Forribean");
		exit("Доступ запрещен");		
	}
	
	$dir = "test/";	
	
	if (isset($_GET['filename'])) {
		if (file_exists($dir.$_GET['filename'])) {
			if(unlink($dir.$_GET['filename'])) {
				echo "Тест удален";
			}
			else {
				echo "Тест НЕ удален";
			}
		}
	}	
	
?>
<!DOCTYPE html>
<html>
<head>
	<title>Удаление</title>
	<meta charset="utf-8">
	<link type="text/css" href="style.css" rel="stylesheet" charset="utf-8"> 
</head>
<body>	


<p><a href="list.php">Перейти к полному списку тестов</a></p>
<p><a href="index.php?exit=1">Выход</a></p>
</body>
</html>