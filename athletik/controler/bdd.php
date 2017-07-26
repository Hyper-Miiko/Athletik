<?php
//Comparaison pour les classements
function fonctionComparaisonPoints($a, $b){
    return $a['points'] < $b['points']; //Priorité au plus de points
}
function fonctionComparaisonTemps($a, $b){
    return $a['time'] > $b['time']; //Priorité au moins de temps
}
function fonctionComparaisonCourses($a, $b){
    return $a['nbrcourse'] < $b['nbrcourse']; //Priorité au plus de courses
}
function fonctionComparaisonDate($a, $b){
	$a = explode('-', $a['date'])[0].explode('-', $a['date'])[1].explode('-', $a['date'])[2]; //On retire les '-' pour n'avoir qu'un entier et éviter d'éventuel erreur
	$b = explode('-', $b['date'])[0].explode('-', $b['date'])[1].explode('-', $b['date'])[2]; //On place les jour en dernier car il on moins de poids
    return $a > $b; //Priorité à la date la plus récente
}
function fonctionComparaisonNom($a, $b){
	return $a['lastname'] > $b['lastname']; //Tri alphabétique selon le nom de famille
}
function classement($bdd, $event, $user, $sort) { //$bdd, toujours $bdd; $event, id event ou '*'; $user, id user ou '*'; $sort, entier strictement positif ou entier(sans tri)
	if($user == "*")$donnees = $bdd->query('SELECT id, firstname, lastname, birthdate FROM user'); //Tous les utilisateurs
	else $donnees = $bdd->query('SELECT id, firstname, lastname FROM user WHERE id="'.$user.'"'); //L'utilisateur choisie
	$classement; //Initialisations
	while($temp = $donnees->fetch(PDO::FETCH_ASSOC)) {//On cut le premier élément de $donnees dans $classement tant qu'il y a des élément dans $donnees
		$classement[] = $temp; //On insert une nouvelle ligne dans le tableau $classement
	}
	if(isset($classement)) {
		foreach($classement as &$array) { //On parcours $classement en éditant chaque élément qu'on nommera $array
			$array['points'] = 0; //Reset des points
			$array['time'] = 0; //Reset du temps
			if ($event == "*")$donnees = $bdd->query('SELECT points, time FROM result WHERE user_id="'.$array['id'].'"'); //On compte le total de points de chaque utilisateurs
			else $donnees = $bdd->query('SELECT points, time FROM result WHERE user_id="'.$array['id'].'" AND event_id="'.$event.'"'); //On compte les points d'un $event de chaque utilisateurs
			$i = 0; //Nombre de course
			while ($temp = $donnees->fetch(PDO::FETCH_ASSOC)) {//On cut le premier élément de $donnees tant qu'il y a des élément dans $donnees
				$array['points'] += $temp['points']; //Somme des points
				$array['time'] += $temp['time']; //Somme du temps
				$i++; //Chaque somme = une nouvelle course
			}
			$array['nbrcourse'] = $i; //Editions du nombre de course
		}
		$i = 0; //Boucle for conditionnel => while
		while ($i < sizeof($classement)) { //Pour chaque élément de $classement
			if($classement[$i]['nbrcourse'] == 0) { //Si l'user n'a pas de course on ne l'affiche pas
				array_splice($classement, $i, 1); //donc on le supprime du tableau, donc pas besoin d'incrémenter $i
			} else {
				$classement[$i]['min'] = floor($classement[$i]['time']/60); //Convertion du temps de la bdd (en sec) vers le temps affiché (en min)
				$classement[$i]['sec'] = $classement[$i]['time']%60; //On rajoute les seconde restante
				if($event != '*') { //Si on cible un event particulier
					$date = $bdd->query('SELECT date FROM event WHERE id="'.$event.'"')->fetch(PDO::FETCH_ASSOC); //On récupérer la date de l'event
					$classement[$i]['age'] = explode('-', $date['date'])[0] - explode('-', $classement[$i]['birthdate'])[0]; //On récupére ~ le nombre d'année entre la date de naissance de l'utilisateur et la date de la course
					if(explode('-', $classement[$i]['birthdate'])[1] < explode('-', $date['date'])[1]) $classement[$i]['age']++; //On vérifie aussi les mois
					if(explode('-', $classement[$i]['birthdate'])[1] = explode('-', $date['date'])[1] && explode('-', $classement[$i]['birthdate'])[2] <= explode('-', $date['date'])[2]) $classement[$i]['age']++; //Et enfin les jours
				}
				$i++; //L'utilisateur est fait on passe au suivant
			}
		}
		switch($sort) { //Liste des choix de classement
		case 1:
			usort($classement, 'fonctionComparaisonTemps');
			break;
		case 2:
			usort($classement, 'fonctionComparaisonCourses');
			break;
		default:
			usort($classement, 'fonctionComparaisonPoints'); //Par default on classe par points
		}
		return $classement;
	}
	return array();
}
function listingEvent($bdd) { //Liste des events (Non, sans blague?)
	$donnees = $bdd->query('SELECT * FROM event'); //On récupe tous
	$listingEvent; //On init la variable de retour
	while($temp = $donnees->fetch(PDO::FETCH_ASSOC)) { //On cut le premier élément de $donnees tant qu'il y a des élément dans $donnees
		$temp['day'] = explode('-', $temp['date'])[2]; //Convertion de format
		$temp['month'] = explode('-', $temp['date'])[1];
		$temp['year'] = explode('-', $temp['date'])[0];
		$listingEvent[] = $temp; //On insert chaque élément dans la liste
	}
	if(!isset($listingEvent)) $listingEvent = array();
	usort($listingEvent, 'fonctionComparaisonDate'); //On tri par date
	return $listingEvent; //Et basta
}
function listingRunner($bdd) { //Liste des coureur et non pas des utilisateurs
	$donnees = $bdd->query('SELECT * FROM user'); //On récupe tous les utilisateur
	$listingRunner; //On init la variable de retour
	while($temp = $donnees->fetch(PDO::FETCH_ASSOC)) { //On cut le premier élément de $donnees tant qu'il y a des élément dans $donnees
		//On vérifie le droit de courir de chaque utilisateur
		//On n'utilise pas haveRight(1) car il ne s'applique qu'à l'utilisateur connecté
		//$temp['privilege']%2 renvoie 1 si impair et 0 si pair
		//le bit de privilége pour participé est le bit 2⁰ qui vaut 1 si impair et 0 si pair
		if($temp['privilege']%2 == 1) $listingRunner[] = $temp; 
	}
	usort($listingRunner, 'fonctionComparaisonNom'); //On tri par ordre de nom
	return $listingRunner; //Et pasta
}
function listingMissingRunner($bdd, $event) { //Liste des coureur non inscrit sur le tableau
	$donnees = $bdd->query('SELECT * FROM user'); //On récupe tous les utilisateur
	$listingMissingRunner;
	$listingMissingRunnerTemp;
	while($user = $donnees->fetch(PDO::FETCH_ASSOC)) { //On cut le premier élément de $donnees tant qu'il y a des élément dans $donnees
		//On vérifie le droit de courir de chaque utilisateur
		//On n'utilise pas haveRight(1) car il ne s'applique qu'à l'utilisateur connecté
		//$temp['privilege']%2 renvoie 1 si impair et 0 si pair
		//le bit de privilége pour participé est le bit 2⁰ qui vaut 1 si impair et 0 si pair
		if($user['privilege']%2 == 1) $listingMissingRunnerTemp[] = $user;
	}
	$event = $bdd->query('SELECT participant FROM event WHERE id="'.$event.'"')->fetch(PDO::FETCH_ASSOC)['participant']; //On récupe l'event
	$event = explode(',', $event);
	for($i = 0; $i < sizeof($listingMissingRunnerTemp); $i++) {
		for($j = 0; $j < sizeof($event); $j++) {
			if($listingMissingRunnerTemp[$i]['id'] == $event[$j]) {
				$listingMissingRunner[] = $listingMissingRunnerTemp[$i];
			}
		}
	}
	if(!isset($listingMissingRunner)) $listingMissingRunner = array();
	return $listingMissingRunner;
}
function isparticipant($bdd, $id) { //$id, id de l'event; l'utilisateur est celui connecté
	if(!isset($_SESSION['id'])) return false;
	$donnees = $bdd->query('SELECT participant FROM event WHERE id="'.$id.'"')->fetch(PDO::FETCH_ASSOC)['participant']; //On récup la liste des participant de l'event sous forme de chaine de caractére
	$donnees = explode(',', $donnees); //On met la chaine de caractére dans un tableau
	foreach ($donnees as $key) if($key == $_SESSION['id']) return true; //On compare l'id de l'utilisateur avec les id du tableau et dès qu'on le trouve en renvoie true
	return false; //Si la boucle arrive à terme sans être cassé par return true ça veut dire qu'il n'y est pas
}
function placeLeft($bdd, $event) {
	$donnees = $bdd->query('SELECT participant, places FROM event WHERE id="'.$event.'"')->fetch(PDO::FETCH_ASSOC);
	if(explode(',', $donnees['participant'])[0] == "")$result = $donnees['places'];
	else $result = $donnees['places'] - sizeof(explode(',', $donnees['participant']));
	return $result;
}
?>