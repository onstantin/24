<?php	
	session_start();
	error_reporting(E_ALL);
	
	if (isset($_POST['login']) && isset($_POST['password'])) {
		$file = file_get_contents("login.json");
		$json = json_decode($file, true);

		$id = count($json) + 1;
		$login = htmlspecialchars($_POST['login']);
		$password = htmlspecialchars($_POST['password']);		

		foreach ($json as $user_info) {
			if ($login==$user_info['login']) {
				header("Location: index.php?err=1");
				die;
			}
		}
		
		$json[] = array("id"=>$id, "login"=>$login, "password"=>$password);
		
		$json = json_encode($json);
		file_put_contents("login.json", $json);
		header("Location: index.php?err=0");
	}
	

