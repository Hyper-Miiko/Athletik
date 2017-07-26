<?php
//====================[INITIALISATION]====================//
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=athletik;charset=utf8','root','M!8qcTr63%');
include('security.php');
//--------------------(initialisation)--------------------//
?>
<?php
//====================[SECURITE]====================//
if(!haveRight(3)) {
	header('Location: ../?url=403#top');
	exit;
}
if(!isset($_POST['id'])) { //Récupération des données nécessaires?
	header('Location: ../?url=400#top');
	exit;
}
//--------------------(securite)--------------------//
$privilege = 0;
if(isset($_POST['1'])) $privilege++;
if(isset($_POST['2'])) $privilege+=2;
if(isset($_POST['3'])) $privilege+=4;
//====================[INSERTION BDD]====================//
$request = $bdd->prepare("UPDATE user SET
						privilege = :privilege
						WHERE id = :id");
$request->execute(array(
	'privilege' => $privilege,
	'id' => $_POST['id']));
//--------------------(insertion bdd)--------------------//
header('Location: ../?url=member'); //On retour sur la page d'event d'où on vien
?>