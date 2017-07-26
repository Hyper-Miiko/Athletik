<?php
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=athletik;charset=utf8','root','M!8qcTr63%');
include('controler/security.php');
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Athletik &mdash; Les 1000 pas</title>
		<link rel="stylesheet" type="text/css" href="view/css/master.css" />
		<script src='https://www.google.com/recaptcha/api.js'></script>
	</head>
	<body>
		<?php
		include('view/php/header.php');//Bannière de haute de page (sur chaque page)
		include('view/php/nav.php');//Menu (sur chaque page)
		if(isset($_GET['url'])) {//Si on a un url sous forme de get
			if(!include('view/php/'.$_GET["url"].'.php')) {//On essaye d'include la page correspondante si ça ne marche pas
				header('Location: ./?url=404#top'); //On s'casse! (page d'erreur not found)
				exit;
			}
		} else {
			header('Location: ./?url=accueil'); //Sinon on en met un nah :-p
			exit;
		}
		include('view/php/footer.php');//Ok il y en a pas encore mais bon
		?>
	</body>
	<script type="text/javascript" src="view/js/variable.js"></script>
    <script type="text/javascript" src="view/js/function.js"></script>
    <script type="text/javascript" src="view/js/script.js"></script>
</html>