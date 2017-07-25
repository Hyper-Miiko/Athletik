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
if(!isset($_GET['user']) || !isset($_GET['event']) || !isset($_GET['time']) || !isset($_GET['points'])) {
	header('Location: ../?url=400#top');
	exit;
}
//--------------------(securite)--------------------//

//test de donnees non effectué, coming soon

//====================[INSERTION BDD]====================//
$request = $bdd->prepare("UPDATE result SET
						time = :time,
						points = :points
						WHERE user_id = :user_id
						AND event_id = :event_id");
$request->execute(array(
	'time' => $_GET['time'],
	'points' => $_GET['points'],
	'user_id' => $_GET['user'],
	'event_id' => $_GET['event']));
//--------------------(insertion bdd)--------------------//
header('Location: ../?url=eventDescription&target='.$_GET['event']); //On retour sur la page d'event d'où on vien
?>