<?php
	session_start();
	
	if (!isset($_SESSION['isAdmin'])) {	
		header("HTTP/1.0 403 Forribean");
		exit("Доступ запрещен");		
	}	
	
?>
<!DOCTYPE html>
<html>
<head>
	<title>Список тестов</title>
	<meta charset="utf-8">
	<link type="text/css" href="style.css" rel="stylesheet" charset="utf-8"> 
</head>
<body> 

	<h1>Список тестов</h1>
<ol>
<?php

	error_reporting(E_ALL);

	$dir = "test/";
	$files = scandir($dir);
	
	foreach ($files as $key=>$filename) {
		if (is_file($dir.$filename) && file_exists($dir.$filename)) {
			$test = file_get_contents($dir.$filename);
			$test = json_decode($test, true);
			if (isset($test[0]['Test Name'])) {
			$testName = $test[0]['Test Name'];
			
				if ($_SESSION['isAdmin']==1) {
				echo <<<HTML
					<li><a href="test.php?test=$filename">$testName</a> <a href="del.php?filename=$filename">Удалить</a></li>
HTML;
			
				}
				else {
				echo <<<HTML
					<li><a href="test.php?test=$filename">$testName</a></li>
HTML;
							
				}
			}
			else {
				echo "<li>Неправильный формат теста в файле</li>";
			}
		}
	}
?>
</ol>

<?php
	if (isset($_SESSION['isAdmin'])&&$_SESSION['isAdmin']==1) {
		echo "<p><a href=\"admin.php\">Добавить тест</a></p>";
	}
	echo "<p><a href=\"index.php?exit=1\">Выход</a></p>";
?>

</body> 
</html>