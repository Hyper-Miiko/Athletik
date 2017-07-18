<?php
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=athletik;charset=utf8','root','M!8qcTr63%');
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title>Athletik &mdash; les 1000 pas</title>
	<link rel="stylesheet" type="text/css" href="css/master.css" />
</head>
<body>
	<header>
		<img alt="Athletik - les 1000 pas" title="Athletik - les 1000 pas" src="data/logo.gif" />
		<h1>Athletik &mdash; les 1000 pas</h1>
		<?php
			if(isset($_GET['url'])) {
				if ($_GET['url'] != 'login') echo '<a href=".?url=login" title="Connectez-vous"><span class="symbol"><!--symbol-->O</span> Connexion</a>';
			} else if(isset($_SESSION['login'])) echo '<p>Bonjour, '.$bdd->query('SELECT firstname from user WHERE identifiant = "'.$_SESSION["login"].'"')->fetch(PDO::FETCH_ASSOC)['firstname'].'</p><a href="action/disconnect.php">Déconnection</a>';
			else echo '<a href=".?url=login" title="Connectez-vous"><span class="symbol"><!--symbol-->O</span> Connexion</a>';
		?>
	</header>
	<main>
	<?php
		if(isset($_GET['url'])) try {
			require('site/'.$_GET["url"].'.php');
		} catch (Exception $e) {
			include('site/404.php');
		}
		else require('site/accueil.php');
	?>
	</main>
	<footer>
		<!--seem usefull?-->
	</footer>
</body>
</html>