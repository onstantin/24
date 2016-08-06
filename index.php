<?php	
	session_start();
	error_reporting(E_ALL);
	
	if (isset($_GET['exit'])) {
		session_unset();
		session_destroy();
		header("Location: index.php");	
	}
	
	if (isset($_SESSION['isAdmin'])) {	
		header("Location: list.php");
		die;
	}	
	
	$msg = "Введите логин/пароль или войдите как гость без ввода пароля";

	if (isset($_POST['login'])&&$_POST['password']=="") 
	{
		$_SESSION['login'] = htmlspecialchars($_POST['login']);
		$_SESSION['isAdmin'] = 0;
		header("Location: list.php");	
		die;
	}	
	else if (isset($_POST['login'])&&$_POST['password']!="") 
	{
		$_SESSION['login'] = htmlspecialchars($_POST['login']);
		$_SESSION['password'] = htmlspecialchars($_POST['password']);
		
		$file = file_get_contents("login.json");
		$json = json_decode($file, true);
		$n = 0;
		
		foreach ($json as $user_info) {
			if ($_SESSION['login'] == $user_info['login']) {
				if ($_SESSION['password'] == $user_info['password']) {
					$_SESSION['isAdmin'] = 1;						
					header("Location: list.php");	
					break;
				}
				else {
					$msg = "Неверный пароль";
					session_unset();	
					break;
				}
			}
			$n++;
			if ($n == count($json)) {
				$msg = "Такого пользователя не существует";	
				session_unset();					
			}
		}
	}	 	
	
	if (isset($_GET['err']) && $_GET['err']==1) {
		$err = "Это имя уже занято!";
	}
	else if (isset($_GET['err']) && $_GET['err']==0) {
		$err = "Вы успешно зарегистрированы, теперь можно войти.";
	}
	else {
		$err = "";
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Вход</title>
	<meta charset="utf-8">
	<link type="text/css" href="style.css" rel="stylesheet" charset="utf-8"> 
</head>
<body>	

<?php if (empty($_SESSION['login'])) : ?>
			<h2>Авторизация</h2>
			<p><?= $msg ?></p>
			<form action="" method="post">
				<input type="text" name="login" placeholder="Введите логин" required>
				<input type="password" name="password" placeholder="Введите пароль">
				<input type="submit" value="OK">
			</form>
			
			<h2>Регистрация</h2>			
			<p><?= $err ?></p>
			<form action="reg.php" method="post">
				<input type="text" name="login" placeholder="Введите логин" required>
				<input type="password" name="password" placeholder="Введите пароль" required>
				<input type="submit" value="OK">
			</form>
			
<?php endif; ?>
</body>
</html>

