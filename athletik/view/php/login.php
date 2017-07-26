<!--Colorfull-->
<style type="text/css">
	@import url('view/css/login.css');
</style>

<?php
if(!isset($_GET['error'])) $error = 0; //Test d'une potentielle erreur
else $error = $_GET['error'];
?>
<main>
	<?php
	if(!isset($_SESSION['login'])) { //Si il n'est pas connecté (se serait bête de se connecter deux fois)
		echo '
		<form id="login" method="post" action="controler/login.php?referer='.$_SERVER["HTTP_REFERER"]/*pour retrouver la page avant le login*/.'">
			<fieldset>
				<legend>Connexion</legend>
				<input type="hidden" name="form" value="login" />';//Pour différencier le login du register 
				if($error == 1) echo '<label><span class="label">Identifiant : </span><input type="text" name="login" placeholder="Utilisateur inexistant." class="error" required/></label>';
				else echo '<label><span class="label">Identifiant : </span><input type="text" name="login" placeholder="ex. : jipéper" required/></label>';
				if($error == 2) echo '<label><span class="label">Mot de passe : </span><input type="password" name="password" placeholder="Mot de passe incorrect" class="error" required/></label>';
				else echo '<label><span class="label">Mot de passe : </span><input type="password" name="password" placeholder="Mot de passe" required/></label>';
				echo '<input type="submit" name="valider" value="Je me connecte" />
			</fieldset>
		</form>
		<form id="register" method="post" action="controler/login.php?referer='.$_SERVER["HTTP_REFERER"].'">
			<fieldset>
				<legend>Inscription</legend>
				<input type="hidden" name="form" value="register" />';//Pour différencier le login du register 
				if($error == 7) echo '<label><span class="label">Prénom : </span><input type="text" name="firstname" placeholder="Prénom invalide" class="error" required/></label>';
				else echo '<label><span class="label">Prénom : </span><input type="text" name="firstname" placeholder="ex. : Jule" required/></label>';
				if($error == 8) echo '<label><span class="label">Nom : </span><input type="text" name="lastname" placeholder="Nom invalide" class="error" required /></label>';
				else echo '<label><span class="label">Nom : </span><input type="text" name="lastname" placeholder="ex. : ipéper" required /></label>';
				if($error == 9) echo '<label><span class="label">Date de naissance : </span><input type="date" name="birthdate" placeholder="Format invalide : AAAA-MM-JJ" class="error" required/></label>';
				else echo '<label><span class="label">Date de naissance : </span><input type="date" name="birthdate" placeholder="AAAA-MM-JJ" required/></label>';
				if($error == 3) echo '<label><span class="label">Identifiant : </span><input type="text" name="login" placeholder="Utilisateur déjà existant" class="error" required/></label>';
				else if($error == 4) echo '<label><span class="label">Identifiant : </span><input type="text" name="login" placeholder="Identifiant invalide" class="error" required/></label>';
				else echo '<label><span class="label">Identifiant : </span><input type="text" name="login" placeholder="ex. : jipéper" required/></label>';
				if($error == 5) echo '<label><span class="label">Mot de passe : </span><input type="password" name="password" placeholder="Mot de passe invalide" class="error" required/></label>';
				else echo '<label><span class="label">Mot de passe : </span><input type="password" name="password" placeholder="Mot de passe" required/></label>';
				if($error == 6) echo '<label><span class="label">Confirmer : </span><input type="password" name="confpassword" placeholder="Mot de passe différent" class="error" required/></label>';
				else echo '<label><span class="label">Confirmer : </span><input type="password" name="confpassword" placeholder="Mot de passe" required/></label>';
				/*echo '<button
					class="g-recaptcha"
					data-sitekey="6LdXeioUAAAAAFkztxQPDFtkeZO5ECnZxyIcM1AL"
					data-callback="recaptchaSubmit">
					Je m\'enregistre
					</button>'; //API Google recaptcha*/
				echo '<input type="submit" name="valider" value="Je m\'enregistre" />
			</fieldset>
		</form>';
	}
	else echo '<p id="connected">Vous êtes déjà connecté.</p>'; //Si il est connecté (même si il ne devrait pas pouvoir retourner ici normalement)
	?>
</main>