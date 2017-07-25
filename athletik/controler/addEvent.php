<?php
//====================[INITIALISATION]====================//
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=athletik;charset=utf8','root','M!8qcTr63%');
include('security.php');
//--------------------(initialisation)--------------------//
?>
<?php
//====================[SECURITE]====================//
if(!haveRight(2)) {
	header('Location: ../?url=403#top');
	exit;
}
if(!isset($_POST['date']) || !isset($_POST['nom']) || !isset($_POST['lieu'])) { //Récupération des données nécessaires?
	header('Location: ../?url=400#top');
	exit;
}
//--------------------(securite)--------------------//

//====================[TEST DONNEES]====================//
if(preg_match("#^[0-3][0-9]/[0-1][0-9]/[0-2][0-9]{3}$#", $_POST['date']) != 1) { //Date au bon format?
	header('Location: ../?url=event&error=1'); //Retour à la page event, format date invalide
	exit;
}
$date = explode('/', $_POST['date'])[2].'-'.explode('/', $_POST['date'])[1].'-'.explode('/', $_POST['date'])[0]; //Passage au format bdd
var_dump($_POST['place'] == "");
if($_POST['place'] == "") { //Limite de place?
	//--------------------(test donnees)--------------------//

	//====================[INSERTION BDD]====================//
	//Sans limite de place
	$request = $bdd->prepare('INSERT INTO event(name, lieu, date) VALUES (:name, :lieu, :date)');
	$request->execute(array('name' => $_POST['nom'],
							'lieu' => $_POST['lieu'],
							'date' => $date));
}
else {
	//Avec limite de place
	if(!is_numeric($_POST['place']) || $_POST['place'] < 0) { //Nombre de place entier positif?
		header('Location: ../?url=event&error=2'); //Retour à la page event, format place invalide
		exit;
	}
	$request = $bdd->prepare('INSERT INTO event(name, lieu, date, places) VALUES (:name, :lieu, :date, :places)');
	$request->execute(array('name' => $_POST['nom'],
							'lieu' => $_POST['lieu'],
							'date' => $date,
							'places' => $_POST['place']));
}
header('Location: ../?url=event&error=0'); //Retour à la page event, insertion done
?>