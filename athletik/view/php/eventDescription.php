<?php
	if(!isset($_GET['target'])) header('Location: ./?url=event'); //Un petit retour arriére si il manque des infos
	if(!isset($_GET['error'])) $error = -1; //On test si il y a des erreurs
	else $error = $_GET['error'];
?>
<!--Yeah on met un peu de style-->
<style type="text/css">
	@import url('view/css/eventDescription.css');
</style>

<main>
	<table id="score">
		<tr>
			<input class="hidden event" value=<?php echo '"'.$_GET['target'].'"' ?> />
			<th>Place</a></th>
			<th>Participant</th>
			<th><a href=".?url=eventDescription&sort=0&target=<?php echo $_GET['target'] ?>">Points</th>
			<th><a href=".?url=eventDescription&sort=1&target=<?php echo $_GET['target'] ?>">Temps</th>
			<?php if(haveRight(2)) echo '<th>Action</th>';//Si l'utilisateur peut éditer on le lui permet ?>
		</tr>
		<?php
			include('controler/bdd.php');
			if(!isset($_GET['sort'])) $sort = 0; //Si pas de tri, alors tri par défault
			else $sort = $_GET['sort']; //Sinon, bah...
			$target = $_GET['target']; //C'est plus simple comme ça
			$classement = classement($bdd, $target, "*", $sort); //On récup tous les utilisateur de l'event avec le tri choisi
			$j = 0; //taille du tableau
			for ($i = 1; $i <= sizeof($classement); $i++) { //On parcours $classement
				if(haveRight(2)) echo '<tr>
					<td>'.$i.'</td>
					<td><a href="./?url=accueil&user='.$classement[$i-1]["id"].'">'.$classement[$i-1]["firstname"].' '.$classement[$i-1]["lastname"].'</a></td>
					<td class="points">'.$classement[$i-1]["points"].'</td>
					<td><input class="time" name="time" value="'.$classement[$i-1]["min"].'.'.$classement[$i-1]["sec"].'" /></td>
					<td class="hidden age">'.$classement[$i-1]["age"].'</td>
					<td class="hidden id">'.$classement[$i-1]["id"].'</td>
					<td class="action"><a class="edit" href=""><button>E</button></a></td>
				</tr>'; //Si il a le droit d'éditer on lui rajoute des outils
				else echo '<tr>
					<td>'.$i.'</td>
					<td><a href="./?url=accueil&user='.$classement[$i-1]["id"].'">'.$classement[$i-1]["firstname"].' '.$classement[$i-1]["lastname"].'</a></td>
					<td>'.$classement[$i-1]["points"].'</td>
					<td>'.$classement[$i-1]["min"].'.'.$classement[$i-1]["sec"].'</td>
				</tr>'; //Sinon, shine!
				$j++; //Une ligne de plus
			}
			if($j == 0) {
				echo '<tr><td>&mdash;&mdash;</td><td>&mdash;&mdash;</td><td>&mdash;&mdash;</td><td>&mdash;&mdash;</td>';
				if(haveRight(2)) echo '<td>&mdash;&mdash;</td>';
				echo '</tr>'; //au moins une ligne sinon ça fait moche
			}
		?>
	</table>
	<?php 
	if(haveRight(2)) {//Si il en a le droit il pourra rajouter les score
		echo '<div id="returnError">';
		switch ($error) { //Affichage des erreurs
			case 0: //Aucune erreur
				echo '<p style="color: green">Score ajouté avec succés.<p>';
			break;
		}
		echo '</div>';
		echo '<form id="addScore" method="post" action="./controler/addScore.php">';
		echo '<input type="hidden" name="event" value="'.$_GET["target"].'" />';
		$listingMissingRunner = listingMissingRunner($bdd, $target); //On récup les coureur potentiel non présent sur le tableau
		echo '<select name="user" id="name">'; //Menu défilant pour choisir le nom
		for ($i = 1; $i <= sizeof($listingMissingRunner); $i++) { //On parcours $listingRunner pour en afficher tous les coureur potentiel
			echo '<option value="'.$listingMissingRunner[$i-1]['id'].'">'.$listingMissingRunner[$i-1]['lastname'].' '.$listingMissingRunner[$i-1]['firstname'].'</option>';
		}
		echo '</select>';
		echo '<input type="text" name="time" required/>';
		echo '<input type="submit" value="+"/>';
		echo '</form>';
	}
	?>
</main>