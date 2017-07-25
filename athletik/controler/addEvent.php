<?php
//====================[INITIALISATION]====================//
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=athletik;charset=utf8','root','M!8qcTr63%');
include('security.php');
//--------------------(initialisation)--------------------//
?>
<?php
//====================[SECURITE]====================//
if(!haveright(2)) {
	header('Location: ../?url=403#top');
	exit;
}
if(!isset($_POST['date']) || !isset($_POST['nom']) || !isset($_POST['lieu'])) {
	header('Location: ../?url=400#top');
	exit;
}
//--------------------(securite)--------------------//

//====================[TEST DONNEES]====================//
if(preg_match("#^[0-3][0-9]/[0-1][0-9]/[0-2][0-9]{3}$#", $_POST['date']) != 1) {
	header('Location: ../?url=event&error=1');
	exit;
}
$date = explode('/', $_POST['date'])[2].'-'.explode('/', $_POST['date'])[1].'-'.explode('/', $_POST['date'])[0]; //Passage au format bdd
if(!isset($_POST['place'])) {
	if(!is_numeric($_POST['place']) || $_POST['place'] < 0) {
		header('Location: ../?url=event&error=2');
		exit;
	}
	//--------------------(test donnees)--------------------//

	//====================[INSERTION BDD]====================//
	//Sans limite de place
	$request = $bdd->prepare('INSERT INTO event(name, lieu, date) VALUES (:name, :lieu, :date)');
	$request->execute(array('name' => $_POST['nom'],
							'lieu' => $_POST['lieu'],
							'date' => $_POST['date']));
}
else {
	//Avec limite de place
	$request = $bdd->prepare('INSERT INTO event(name, lieu, date, places) VALUES (:name, :lieu, :date, :places)');
	$request->execute(array('name' => $_POST['nom'],
							'lieu' => $_POST['lieu'],
							'date' => $date,
							'places' => $_POST['place']));
}
header('Location: ../?url=event&error=0'); //Retour à la page event, insertion done
?>