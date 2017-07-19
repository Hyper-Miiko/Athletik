<?php
if(isset($_GET['error'])) $error = $_GET['error'];
else $error = 0;
echo '<form id="login" method="post" action="action/login.php">';
	if($error == 1) echo '<input name="identifiant" type="text" placeholder="Compte inexistant" class="error" required/>';
	else echo '<input name="identifiant" type="text" placeholder="Nom de compte" required/>';
	if($error == 2) echo '<input name="password" type="password" placeholder="Mot de passe incorrect" class="error" required/>';
	else echo '<input name="password" type="password" placeholder="Votre mot de passe" required/>';
	echo '<input name="validating" type="submit" value="Se connecter" />
</form>
<form id="register" method="post" action="action/register.php">';
	if($error == 3) echo '<input name="identifiant" type="text" placeholder="Utilisateur déjà enregistré" class="error" required/>';
	else if($error == 4) echo '<input name="identifiant" type="text" placeholder="Nom de compte invalide" class="error" required/>';
	else echo '<input name="identifiant" type="text" placeholder="Nom de compte" required/>';
	if($error == 5) echo '<input name="password" type="password" placeholder="Mot de passe invalide" class="error" required/>';
	else echo '<input name="password" type="password" placeholder="Votre mot de passe" required/>';
	if($error == 6) echo '<input name="confpassword" type="password" placeholder="Mots de passe différents" class="error" required/>';
	else echo '<input name="confpassword" type="password" placeholder="Confirmer votre mot de passe" required/>';
	if($error == 7) echo '<input name="firstname" type="text" placeholder="Prénom invalid" class="error" required/>';
	else echo '<input name="firstname" type="text" placeholder="Votre prénom" required/>';
	if($error == 8) '<input name="lastname" type="text" placeholder="Nom de famille invalid" class="error" required/>';
	else echo '<input name="lastname" type="text" placeholder="Votre nom de famille" required/>';
	if($error == 9) echo '<input name="birthdate" type="date" placeholder="Date invalide : JJ/MM/AAAA" class="error" required/>';
	else echo '<input name="birthdate" type="date" placeholder="JJ/MM/AAAA" required/>';
	echo '<input name="validating" type="submit" value="S\'enregistrer" />
</form>';
?>