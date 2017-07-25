<?php
//====================[INITIALISATION]====================//
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=athletik;charset=utf8','root','M!8qcTr63%');
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
include('../controler/security.php');
//--------------------(initialisation)--------------------//
?>
<?php
//====================[SECURITE]====================//
if(!isset($_GET['target']) || !isset($_GET['mode'])) {
	header('Location: ../?url=400#top');
	exit;
}
if(!haveRight(1)) {
	header('Location: ../?url=403#top');
	exit;
}
//--------------------(securite)--------------------//

$donnees = $bdd->query('SELECT participant FROM event WHERE id="'.$_GET["target"].'"')->fetch(PDO::FETCH_ASSOC)['participant']; //On recup la liste de particpant de l'event sous forme de chaine
$id = $bdd->query('SELECT id FROM user WHERE login="'.$_SESSION['login'].'"')->fetch(PDO::FETCH_ASSOC)['id']; //On recup l'id de l'utilisateur connecté
$temp = explode(',', $donnees); //On casse la chaine dans un tableau

//====================[TEST DONNEES]====================//
if($_GET['mode'] == "in") {
	for($i = 0; $i < sizeof($temp); $i++) {
		if($id == $temp[$i]) { //Si l'utilisateur est déjà inscrit
			header('Location: ../../?url=400#top');
			exit;
		}
	}
}
//--------------------(test donnees)--------------------//

//====================[INSERTION BDD]====================//
if($_GET['mode'] == "in") {
	if(sizeof($temp) > 1)$donnees = $donnees.','.$id; //Si il y a déjà de participant on place un caractére de séparation','
	else $donnees = $id; //Sinon on y va yolo
} else {
	$donnees = "";
	for($i = 0; $i < sizeof($temp)-1; $i) {
		if($temp[$i] == $_SESSION['id']) {
			array_splice($temp, $i, 1);
			//$i--;
		} else $donnees = $donnees.$temp[$i];
	}
}
$request = $bdd->prepare("UPDATE event SET
						participant = :participant
						WHERE id = :id");
$request->execute(array(
	'participant' => $donnees,
	'id' => $_GET['target']));
//--------------------(insertion bdd)--------------------//
header('Location: '.$_SERVER["HTTP_REFERER"]);
?>