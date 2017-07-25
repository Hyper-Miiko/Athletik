<?php
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=athletik;charset=utf8','root','M!8qcTr63%');
include('security.php');
?>
<?php
	if(!isset($_GET['referer'])) header('Location: ../?url=400#top');
	if(!isset($_POST['form'])) header('Location: ../?url=400#top');
	if($_POST['form'] != 'login' && $_POST['form'] != 'register') header('Location: ../?url=400#top');
	if($_POST['form'] == 'login') {
		if(!isset($_POST['login']) || !isset($_POST['password'])) header('Location: ../?url=400#top');
		else {
			$login = addslashes($_POST['login']);
			$password = addslashes($_POST['password']);
			$user = $bdd->query('SELECT password from user WHERE login = "'.$login.'"')->fetch(PDO::FETCH_ASSOC);
			if(!$user) header('Location: ../?url=login&error=1');
			else if ($user['password'] != hash('md5', $password)) header('Location: ../?url=login&error=2');
			else {
				$_SESSION['login'] = $login;
				$_SESSION['id'] = $bdd->query('SELECT id FROM user WHERE login="'.$_SESSION['login'].'"')->fetch(PDO::FETCH_ASSOC)['id'];
				$_SESSION['privilege'] = $bdd->query('SELECT privilege FROM user WHERE login="'.$_SESSION['login'].'"')->fetch(PDO::FETCH_ASSOC)['privilege'];
				header('Location: '.$_GET['referer']);
			}
		}
	} else if($_POST['form'] == 'register') {
		if(!isset($_POST['login']) || !isset($_POST['password']) || !isset($_POST['confpassword']) || !isset($_POST['firstname']) || !isset($_POST['lastname']) || !isset($_POST['birthdate'])) header('Location: ../?url=400#top');
		else {
			$login = addslashes($_POST['login']);
			$password = addslashes($_POST['password']);
			$confpassword = addslashes($_POST['confpassword']);
			$firstname = addslashes($_POST['firstname']);
			$lastname = addslashes($_POST['lastname']);
			$birthdate = addslashes($_POST['birthdate']);
			if($bdd->query('SELECT * from user WHERE login = "'.$login.'"')->fetch(PDO::FETCH_ASSOC)) header('Location: ../?url=login&error=3');
			else if(strlen($login) > 32) header('Location: ../?url=login&error=4');
			else if(strlen($password) > 32) header('Location: ../?url=login&error=5');
			else if($password != $confpassword) header('Location: ../?url=login&error=6');
			else if($firstname > 128) header('Location: ../?url=login&error=7');
			else if($lastname > 128) header('Location: ../?url=login&error=8');
			else if(preg_match("#^[1-2]{1}[0-9]{3}-[0-1]{1}[0-9]{1}-[0-3]{1}[0-9]{1}$#", $birthdate) != 1) header('Location: ../?url=login&error=9');
			else if(explode("-", $birthdate)[0] > date('Y') || explode("-", $birthdate)[1] > date('n') || explode("-", $birthdate)[2] > date('j')) header('Location: ../?url=login&error=9');
			else {
				$password = hash('md5', $password);
				$req = $bdd->prepare('INSERT INTO user(login, password, firstname, lastname, birthdate) VALUES(:login, :password, :firstname, :lastname, :birthdate)');
				$req->execute(array('login' => $login,
									'password' => $password,
									'firstname' => $firstname,
									'lastname' => $lastname,
									'birthdate' => $birthdate));
				$_SESSION['login'] = $login;
				$_SESSION['id'] = $bdd->query('SELECT id FROM user WHERE login="'.$_SESSION['login'].'"')->fetch(PDO::FETCH_ASSOC)['id'];
				header('Location: '.$_GET['referer']);
			}
		}
	}
?>
