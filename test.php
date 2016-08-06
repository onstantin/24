<?php	
	session_start();
	error_reporting(E_ALL);
	
	if (!isset($_SESSION['isAdmin'])) {	
		header("HTTP/1.0 403 Forribean");
		exit("Доступ запрещен");		
	}
	
	$dir = "test/";	
	$html = <<<HTML
			<!DOCTYPE html>
			<html>
			<head>
				<title>Тест</title>
				<meta charset="utf-8">
				<link type="text/css" href="style.css" rel="stylesheet" charset="utf-8"> 
			</head>
			<body>	
HTML;
	
	
	if (isset($_GET['test'])) {
		$file_name = $_GET['test'];
		
		if (in_array($file_name, scandir($dir))) {
		
		
			$test = file_get_contents($dir.$file_name);
			$test = json_decode($test, true);
			
			$testName = $test[0]['Test Name'];
			echo $html;
			echo <<<HTML
<h1>Тест: $testName</h1><form action="result.php" method="post">
HTML;

			
			foreach ($test as $key=>$testElement) {
				if ($key!=0) {
					echo <<<HTML
<p>{$testElement['Q']} <input type="text" name="answer[$key]" required></p>
HTML;

				}
			}
			
			?> 			
			<input type="hidden" name="filename" value="<?= $file_name ?>">
			<input type="submit">
			</form> <?php		
			
		}
		else {
			header("HTTP/1.0 404 Not Found");
			die;
		}
	}
	else {
		header("HTTP/1.0 404 Not Found");
		die;
	}
	
?>

<p><a href="list.php">Перейти к полному списку тестов</a></p>
<p><a href="index.php?exit=1">Выход</a></p>
</body>
</html>