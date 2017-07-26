<?php
//====================[INITIALISATION]====================//
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=athletik;charset=utf8','root','M!8qcTr63%');
include('security.php');
//--------------------(initialisation)--------------------//
?>
<?php
//====================[SECURITE]====================//
if(!isset($_GET['referer'])) header('Location: ../?url=400#top');
if(!isset($_POST['form'])) header('Location: ../?url=400#top');
if($_POST['form'] != 'login' && $_POST['form'] != 'register') header('Location: ../?url=400#top');
//--------------------(securite)--------------------//

//====================[CONNEXION]====================//
if($_POST['form'] == 'login') {
	if(!isset($_POST['login']) || !isset($_POST['password'])) header('Location: ../?url=400#top'); //Un bout de sécu encore :-)
	else {
		$login = addslashes($_POST['login']); //On échape les caractére problématique
		$password = addslashes($_POST['password']); //On échape les caractére problématique
		$user = $bdd->query('SELECT password from user WHERE login = "'.$login.'"')->fetch(PDO::FETCH_ASSOC); //On récup le mot de passe de l'utilisateur
		if(!$user) header('Location: ../?url=login&error=1'); //Si il n'y a pas de mot de passe, l'utilisateur n'existe pas
		else if ($user['password'] != hash('md5', $password)) header('Location: ../?url=login&error=2'); //Si lemot de passe ne correspond pas... C'est que c'est pas le même
		else { //Sinon, il n'y a pas de probléme
			$_SESSION['login'] = $login; //On récup les info utiles
			$_SESSION['id'] = $bdd->query('SELECT id FROM user WHERE login="'.$_SESSION['login'].'"')->fetch(PDO::FETCH_ASSOC)['id'];
			$_SESSION['privilege'] = $bdd->query('SELECT privilege FROM user WHERE login="'.$_SESSION['login'].'"')->fetch(PDO::FETCH_ASSOC)['privilege'];
			header('Location: '.$_GET['referer']); //Retour à la maison
		}
	}
}
//--------------------(connexion)--------------------//

//====================[ENREGISTREMENT]====================//
else if($_POST['form'] == 'register') {
	if(!isset($_POST['login']) || !isset($_POST['password']) || !isset($_POST['confpassword']) || !isset($_POST['firstname']) || !isset($_POST['lastname']) || !isset($_POST['birthdate'])) header('Location: ../?url=400#top'); //Un bout de sécu encore :-)
	else {
		/*/====================[RECAPTCHA]====================//
		$url = 'https://www.google.com/recaptcha/api/siteverify';
		$data = array('secret' => '6LdXeioUAAAAAGClsezmM80DHz3Brukk_sDhOgAi',
			'response' => $_POST['g-recaptcha-response']);
		$option = array('http' => array(
			'header' => 'Content-type: application/x-www-form-urlencoded\r\n',
			'method' => 'POST',
			'content' => http_build_query($data)));
		$context  = stream_context_create($options);
		$result = file_get_contents($url, false, $context);
		var_dump($result);
		//--------------------(recaptcha)--------------------/*/
		$login = addslashes($_POST['login']); //On échape les caractére problématique
		$password = addslashes($_POST['password']); //On échape les caractére problématique
		$confpassword = addslashes($_POST['confpassword']); //On échape les caractére problématique
		$firstname = addslashes($_POST['firstname']); //On échape les caractére problématique
		$lastname = addslashes($_POST['lastname']); //On échape les caractére problématique
		$birthdate = addslashes($_POST['birthdate']); //On échape les caractére problématique
		if($bdd->query('SELECT * from user WHERE login = "'.$login.'"')->fetch(PDO::FETCH_ASSOC)) header('Location: ../?url=login&error=3'); //Si on arrive à recup l'utilisateur de ce login il existe déjà (such magical)
		//Format des donnees entrée
		else if(strlen($login) > 32) header('Location: ../?url=login&error=4'); 
		else if(strlen($password) > 32) header('Location: ../?url=login&error=5');
		else if($password != $confpassword) header('Location: ../?url=login&error=6');
		else if($firstname > 128) header('Location: ../?url=login&error=7');
		else if($lastname > 128) header('Location: ../?url=login&error=8');
		else if(preg_match("#^[1-2]{1}[0-9]{3}-[0-1]{1}[0-9]{1}-[0-3]{1}[0-9]{1}$#", $birthdate) != 1) header('Location: ../?url=login&error=9');
		else if(explode("-", $birthdate)[0] > date('Y')-10) header('Location: ../?url=login&error=9'); //Si l'utiliateur à moins de ~ 10 ans
		else { //Pas de probléme? Right! On continue
			$password = hash('md5', $password); //encodage du mot de passe
			//====================[INSERTION BDD]====================//
			$req = $bdd->prepare('INSERT INTO user(login, password, firstname, lastname, birthdate) VALUES(:login, :password, :firstname, :lastname, :birthdate)');
			$req->execute(array('login' => $login,
								'password' => $password,
								'firstname' => $firstname,
								'lastname' => $lastname,
								'birthdate' => $birthdate));
			//--------------------(insertion bdd)--------------------//
			//On a toujours des chose utile à mettre dans la variable de session... N'est-ce pas?
			$_SESSION['login'] = $login; 
			$_SESSION['id'] = $bdd->query('SELECT id FROM user WHERE login="'.$_SESSION['login'].'"')->fetch(PDO::FETCH_ASSOC)['id'];
			header('Location: '.$_GET['referer']); //On rentre à la maison
		}
	}
}
//--------------------(enregistrement)--------------------//
?>
