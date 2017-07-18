<?php
session_start();
	$bdd = new PDO('mysql:host=localhost;dbname=athletik;charset=utf8','root','M!8qcTr63%');
	if(!isset($_POST['identifiant']) || !isset($_POST['password'])) {
		echo '<p>Une erreur est survenue, veuillez réessayez ultérieurement. Si le problème persiste contactez votre administrateur réseau.</p></br>
		<a href="..site/login.php">Retour à la page d\'enregistrement.</a>';
	} else {
		$identifiant = addslashes($_POST['identifiant']);
		$password = addslashes($_POST['password']);
		$user = $bdd->query('SELECT password from user WHERE identifiant = "'.$identifiant.'"')->fetch(PDO::FETCH_ASSOC);
		if(!$user) header('Location: ../?url=login&error=1');
		else if ($user['password'] != hash('md5', $password)) header('Location: ../?url=login&error=2');
		else $_SESSION['login'] = $identifiant;
	}
	header('Location: ..');
?>