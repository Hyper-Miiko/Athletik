<?php
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=athletik;charset=utf8','root','M!8qcTr63%');
include('../controler/security.php');
?>
<?php
if(!isset($_GET['target']) || !isset($_GET['mode'])) {
	header('Location: ../?url=400#top');
	exit;
}
if(!haveRight(1)) {
	header('Location: ../?url=403#top');
	exit;
}
$donnees = $bdd->query('SELECT participant FROM event WHERE id="'.$_GET["target"].'"')->fetch(PDO::FETCH_ASSOC)['participant'];
$id = $bdd->query('SELECT id FROM user WHERE login="'.$_SESSION['login'].'"')->fetch(PDO::FETCH_ASSOC)['id'];
$temp = explode(',', $donnees);
for($i = 0; $i < sizeof($temp); $i++) {
	if($id == $temp[$i]) {
		header('Location: ../../?url=event&error=3');
		exit;
	}
}
if(sizeof($temp) > 1)$donnees = $donnees.','.$id;
else $donnees = $id;
$request = $bdd->prepare("UPDATE event SET
						participant = :participant
						WHERE id = :id");
$request->execute(array(
	'participant' => $donnees,
	'id' => $_GET['target']));
header('Location '.$_SERVER["HTTP_REFERER"]);
?>