<?php	
	session_start();
	error_reporting(E_ALL);
	$dir = "test/";
	
	if (!isset($_SESSION['isAdmin'])) {	
		header("HTTP/1.0 403 Forribean");
		exit("Доступ запрещен");		
	}	

	function sertifikat($text, $testName) {
		$im = imagecreatetruecolor(1000, 480);
		$bc = imagecolorallocate($im, 239, 228, 176);
		
		$like = imagecreatefrompng(__DIR__ . "/like.png");
		
		$rectColor = imagecolorallocate($im, 112, 146, 190);
		$textColor = imagecolorallocate($im, 255, 255, 221);
		$fontFile = realpath(__DIR__ . "/georgiaz.ttf");
		
		imagefill($im, 100, 200, $bc);

		imagecopy($im, $like, 360, 70, 0, 0, 300, 240);
		imagefilledrectangle($im, 0, 345, 1000, 480, $rectColor);
		imagefilledrectangle($im, 0, 0, 1000, 50, $rectColor);
		imagettftext($im, 28, 0, 200, 400, $textColor, $fontFile, $text);
		imagettftext($im, 28, 0, 200, 35, $textColor, $fontFile, $testName);
		
		imagepng($im);		
		imagedestroy($im);
	}
	
	if (!empty($_POST)) {
	
		$filename = $_POST['filename'];
		$username = $_SESSION['login'];
		
		$test = file_get_contents($dir.$filename);
		$test = json_decode($test, true);	
		$result = 0;
		$num = 0;
		
		foreach ($test as $key=>$testElement) {
			if ($key!=0) {
				if ($_POST['answer'][$key]==$testElement['A']) {$result++;}
				$num++;
			}
		}
		$testName = $test[0]['Test Name'];
		$text = "Привет, $username!".PHP_EOL."Ваш результат: ".round(($result/$num)*100,2)."% ($result из $num)";	
		header('Content-Type: image/png');
		sertifikat($text, $testName);
	}	
	else {
		header("Location: list.php");
	}
	
?>