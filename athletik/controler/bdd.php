<?php
function fonctionComparaisonPoints($a, $b){
    return $a['points'] < $b['points'];
}
function fonctionComparaisonTemps($a, $b){
    return $a['time'] > $b['time'];
}
function fonctionComparaisonCourses($a, $b){
    return $a['nbrcourse'] < $b['nbrcourse'];
}
function fonctionComparaisonDate($a, $b){
	$a = explode('-', $a['date'])[0].explode('-', $a['date'])[1].explode('-', $a['date'])[2];
	$b = explode('-', $b['date'])[0].explode('-', $b['date'])[1].explode('-', $b['date'])[2];
    return $a > $b;
}
function fonctionComparaisonNom($a, $b){
	return $a['lastname'] > $b['lastname'];
}
function classement($bdd, $event, $user, $sort) {
	if($user == "*")$donnees = $bdd->query('SELECT id, firstname, lastname, birthdate FROM user');
	else $donnees = $bdd->query('SELECT id, firstname, lastname FROM user WHERE id="'.$user.'"');
	$classement;
	while($temp = $donnees->fetch(PDO::FETCH_ASSOC)) {
		$classement[] = $temp;
	}
	foreach($classement as &$array) {
		$array['points'] = 0;
		$array['time'] = 0;
		if ($event == "*")$donnees = $bdd->query('SELECT points, time FROM result WHERE user_id="'.$array['id'].'"');
		else $donnees = $bdd->query('SELECT points, time FROM result WHERE user_id="'.$array['id'].'" AND event_id="'.$event.'"');
		$i = 0;
		while ($temp = $donnees->fetch(PDO::FETCH_ASSOC)) {
			$array['points'] += $temp['points'];
			$array['time'] += $temp['time'];
			$i++;
		}
		$array['nbrcourse'] = $i;
	}
	$i = 0;
	while ($i < sizeof($classement)) {
		if($classement[$i]['nbrcourse'] == 0) {
			array_splice($classement, $i, 1);
		} else {
			$classement[$i]['min'] = floor($classement[$i]['time']/60);
			$classement[$i]['sec'] = $classement[$i]['time']%60;
			if($event != '*') {
				$date = $bdd->query('SELECT date FROM event WHERE id="'.$event.'"')->fetch(PDO::FETCH_ASSOC);
				$classement[$i]['age'] = explode('-', $date['date'])[0] - explode('-', $classement[$i]['birthdate'])[0];
				if(explode('-', $classement[$i]['birthdate'])[1] < explode('-', $date['date'])[1]) $classement[$i]['age']++;
				if(explode('-', $classement[$i]['birthdate'])[1] = explode('-', $date['date'])[1] && explode('-', $classement[$i]['birthdate'])[2] <= explode('-', $date['date'])[2]) $classement[$i]['age']++;
			}
			$i++;
		}
	}
	switch($sort) {
	case 1:
		usort($classement, 'fonctionComparaisonTemps');
		break;
	case 2:
		usort($classement, 'fonctionComparaisonCourses');
		break;
	default:
		usort($classement, 'fonctionComparaisonPoints');
	}
	return $classement;
}
function listingEvent($bdd) {
	$donnees = $bdd->query('SELECT * FROM event');
	$listingEvent;
	while($temp = $donnees->fetch(PDO::FETCH_ASSOC)) {
		$temp['day'] = explode('-', $temp['date'])[2];
		$temp['month'] = explode('-', $temp['date'])[1];
		$temp['year'] = explode('-', $temp['date'])[0];
		$listingEvent[] = $temp;
	}
	usort($listingEvent, 'fonctionComparaisonDate');
	return $listingEvent;
}
function listingRunner($bdd) {
	$donnees = $bdd->query('SELECT * FROM user');
	$listingRunner;
	while($temp = $donnees->fetch(PDO::FETCH_ASSOC)) {
		if($temp['privilege']%2 == 1) $listingRunner[] = $temp;
	}
	usort($listingRunner, 'fonctionComparaisonNom');
	return $listingRunner;
}
function isparticipant($bdd, $id) {
	$donnees = $bdd->query('SELECT participant FROM event WHERE id="'.$id.'"')->fetch(PDO::FETCH_ASSOC)['participant'];
	$donnees = explode(',', $donnees);
	foreach ($donnees as $key) if($key == $_SESSION['id']) return true;
	return false;
}
?>