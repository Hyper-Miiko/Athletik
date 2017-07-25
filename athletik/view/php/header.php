<header>
	<a id="titre" href=".">
		<img id="logo" src="data/logo.png" />
		<div>
			<h1>Athletik</h1>
			<h2>Les 1000 pas</h2>
		</div>
	</a>
	<?php
	if(!isset($_SESSION['login']) && $_GET['url'] != 'login') echo '<a id="buttonConnexion" href="?url=login"><span class="symbol">A</span> - Connection</a>'; //Si il n'est pas connecte ni sur la page de login on affiche le boutton de connection
	else if(isset($_SESSION['login'])) {//Si il est connecté
		echo '<div id="profil"><p id="salutation">Bonjour, '.$bdd->query('SELECT firstname from user WHERE login = "'.$_SESSION["login"].'"')->fetch(PDO::FETCH_ASSOC)['firstname'].'</p>'; //On dit bonjour
		echo '<a id="buttonDisconnexion" href="controler/disconnect.php">Déconnection</a></div>'; //Et on lui propose d'aller voir ailleur si j'y suis
	}
	?>
</header>