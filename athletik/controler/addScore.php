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
if(!isset($_POST['event']) || !isset($_POST['user']) || !isset($_POST['time'])) { //Récupération des données nécessaires?
	header('Location: ../?url=400#top');
	exit;
}
//--------------------(securite)--------------------//

//====================[DONNEES]====================//
$birthdate = $bdd->query('SELECT birthdate FROM user WHERE id="'.$_POST['user'].'"')->fetch(PDO::FETCH_ASSOC)['birthdate'];
$date = $bdd->query('SELECT date FROM event WHERE id="'.$_POST['event'].'"')->fetch(PDO::FETCH_ASSOC)['date'];
//--------------------(donnees)--------------------/

//====================[CALCUL]====================//
$age = explode('-', $date)[0] - explode('-', $birthdate)[0];
if(explode('-', $date)[1] < explode('-', $birthdate)[1]) $age++;
else if(explode('-', $date)[2] <= explode('-', $birthdate)[2]) $age++;

if($age <= 11) $points = (1000/$_POST['time'])*1.5; 
else if($age <= 13) $points = (1000/$_POST['time'])*1.42;
else if($age <= 15) $points = (1000/$_POST['time'])*1.35;
else if($age <= 17) $points = (1000/$_POST['time'])*1.21;
else if($age <= 19) $points = (1000/$_POST['time'])*1.18;
else if($age <= 22) $points = (1000/$_POST['time'])*1.09;
else if($age <= 40) $points = (1000/$_POST['time']);
else $points = (1000/$_POST['time'])*1.35; //au dessus de 40 ans
$points = ceil($points);

$time = $_POST['time']*60;
$time += $_POST['time']%60;
//--------------------(calcul)--------------------//

//====================[INSERTION BDD]====================//
$request = $bdd->prepare('INSERT INTO result(event_id, user_id, time, points) VALUES (:event_id, :user_id, :time, :points)');
$request->execute(array('event_id' => $_POST['event'],
						'user_id' => $_POST['user'],
						'time' => $time,
						'points' => $points));
header('Location: ../?url=eventDescription&error=0&target='.$_POST['event']); //Retour à la page eventDescription, insertion done
?>