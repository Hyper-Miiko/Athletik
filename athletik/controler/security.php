<?php
function haveRight($r) { //$r, entier strictement positif : droit vérifié
	if(isset($_SESSION['privilege'])) { //Déjà si on n'est pas co ça pose probléme
		$p = $_SESSION['privilege']; //On va devoir éditer la valeur des privilége pour les calculs sans pour autant les changer les droits
		for($i = 0; $i < $r-1; $i++) { //pour chaque rang de privilége
			//Hum, comment dire... copie-colle ça marche...
			if($p%pow(2, $i+1) == pow(2, $i)) { 
				$p -= pow(2, $i);
			}
		}
		if($p%pow(2, $r) == pow(2, $r-1)) return true; //il a le privilége
	}
	return false; //il ne l'a pas
}
function recaptchaSubmit() {
	$url = 'https://www.google.com/recaptcha/api/siteverify';
	$data = array('secret' => '6LdXeioUAAAAAGClsezmM80DHz3Brukk_sDhOgAi',
		'response' => $_POST['g-recaptacha-response']);
	$option = array('http' => array(
		'header' => 'Content-type: application/x-www-form-urlencoded\r\n',
		'method' => 'POST',
		'content' => http_buildquery($data)));
	$context  = stream_context_create($options);
	$result = file_get_contents($url, false, $context);
	var_dump($result);
}
?>