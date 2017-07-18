<?php
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=athletik;charset=utf8','root','M!8qcTr63%');
if(!isset($_POST['identifiant']) || !isset($_POST['password']) || !isset($_POST['confpassword']) || !isset($_POST['firstname']) || !isset($_POST['lastname']) || !isset($_POST['birthdate'])) {
	echo '<p>Une erreur est survenue, veuillez réessayez ultérieurement. Si le problème persiste contactez votre administrateur réseau.</p></br>
	<a href="..site/login.php">Retour à la page d\'enregistrement.</a>';
} else {
	$identifiant = addslashes($_POST['identifiant']);
	$password = addslashes($_POST['password']);
	$confpassword = addslashes($_POST['confpassword']);
	$firstname = addslashes($_POST['firstname']);
	$lastname = addslashes($_POST['lastname']);
	$birthdate = addslashes($_POST['birthdate']);
	if($bdd->query('SELECT * from user WHERE identifiant = "'.$identifiant.'"')->fetch(PDO::FETCH_ASSOC)) header('Location: ../?url=login&error=3');
	else if(strlen($identifiant) > 32) header('Location: ../?url=login&error=4');
	else if(strlen($password) > 32) header('Location: ../?url=login&error=5');
	else if($password != $confpassword) header('Location: ../?url=login&error=6');
	else if($firstname > 128) header('Location: ../?url=login&error=7');
	else if($lastname > 128) header('Location: ../?url=login&error=8');
	else if(!is_numeric($birthdate) || strlen($birthdate) != 4) header('Location: ../?url=login&error=9');
	else {
		$password = hash('md5', $password);
		$req = $bdd->prepare('INSERT INTO user(identifiant, password, firstname, lastname, birthdate) VALUES(:identifiant, :password, :firstname, :lastname, :birthdate)');
		$req->execute(array('identifiant' => $identifiant,
							'password' => $password,
							'firstname' => $firstname,
							'lastname' => $lastname,
							'birthdate' => $birthdate));
		$_SESSION['login'] = $identifiant;
		header('Location: ..');
	}
}
?>