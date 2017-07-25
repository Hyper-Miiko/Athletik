<!--C'mon on met un  paint de couleur-->
<style type="text/css">
	@import url('view/css/event.css');
</style>

<?php
//On test si il y a une potentiel erreur
if(!isset($_GET['error']))$error = -1; //On applique un valeur biddon pour éviter les problémes
else $error = $_GET['error'];
?>
<main>
	<table id="scoreGeneral">
		<tr>
			<th>Date</th>
			<th>Nom</th>
			<th>Lieu</th>
			<th>Place</th>
			<th></th>
		</tr>
		<?php
			include('controler/bdd.php');
			$listingEvent = listingEvent($bdd);
			$j = 0; //Taille du tableau
			for ($i = 1; $i <= sizeof($listingEvent); $i++) { //On parcours le tableau
				echo '<tr><td>'.$listingEvent[$i-1]["day"].'/'.$listingEvent[$i-1]["month"].'/'.$listingEvent[$i-1]["year"].'</td><td><a href=".?url=eventDescription&target='.$listingEvent[$i-1]["id"].'">'.$listingEvent[$i-1]["name"].'</a></td><td>'.$listingEvent[$i-1]["lieu"].'</td>'; //On affiche une partie de ligne
				if($listingEvent[$i-1]["places"] >= 0) echo '<td>'.$listingEvent[$i-1]["places"].'</td>'; //Si il y a des place limité on affiche le nombre de place
				else echo '<td>&infin;</td>'; //Sinon la valeur est celle de base -1 on affich'e donc le signe infinie
				if(haveRight(1) && $listingEvent[$i-1]["year"] > date('Y')) echo '<td><a href="./controler/inscription.php/?target='.$listingEvent[$i-1]["id"].'&mode=in"><span class="unresponsive">S\'inscrire</span><span class="responsive">+</span></a></td>'; //Si l'event n'est pas passé et que l'utilisateur en a le droit on lui propose de s'inscrire
				else if(haveRight(1) && $listingEvent[$i-1]["year"] = date('Y')) {
					if($listingEvent[$i-1]["month"] > date('m')) echo '<td><a href="./controler/inscription.php/?target='.$listingEvent[$i-1]["id"].'&mode=in"><span class="unresponsive">S\'inscrire</span><span class="responsive">+</span></a></td>'; //Si l'event n'est pas passé et que l'utilisateur en a le droit on lui propose de s'inscrire (date + précise)
					else if ($listingEvent[$i-1]["month"] = date('m')) {
						if ($listingEvent[$i-1]["day"] > date('d')) echo '<td><a href="./controler/inscription.php/?target='.$listingEvent[$i-1]["id"].'&mode=in"><span class="unresponsive">S\'inscrire</span><span class="responsive">+</span></a></td>'; //Si l'event n'est pas passé et que l'utilisateur en a le droit on lui propose de s'inscrire (date ++ précise)
						else echo '<td></td>'; //Si un conditions n'est pas respecté on affiche une case vide (plutot quer ne pas afficher de case)
					} else echo '<td></td>'; //Si un conditions n'est pas respecté on affiche une case vide (plutot quer ne pas afficher de case)
				} else echo '<td></td>'; //Si un conditions n'est pas respecté on affiche une case vide (plutot quer ne pas afficher de case)
				echo '</tr>'; //Fin de ligne
				$j++; //Une ligne supplémentaire
			}
			if($j == 0) {
				echo '<tr><td>&mdash;&mdash;</td><td>&mdash;&mdash;</td><td>&mdash;&mdash;</td><td>&mdash;&mdash;</td><td>&mdash;&mdash;</td></tr>'; //Faudrait pas laisser un tableau vide non ;-)
			}
		?>
	</table>
	<?php 
	if(haveRight(2)) { //Si l'utilisateur peu éditer les event (droit n°2)
		echo '<form method="post" action="./controler/addEvent.php">'; //On ouvre un formulaire ver l'ajout d'event
		switch ($error) { //Affichage des erreur au dessus du formulaire
			case 0: //Requête éxécuté avec succés (probablement)
				echo '<p style="color: green">Evénement ajouté avec succés.<p>';
			break;
			case 1: //Mauvaise expression réguliére de date
				echo '<p style="color: red">Format de date invalide.<p>';
				break;
			case 2: //Si les place sont inséré et qu'il ne correspond pas à un chiffre >= 0
				echo '<p style="color: red">Le nombre de place doit être un entier positif.</p>';
				break;
		}
		if($error == 1) echo '<input type="text" name="date" placeholder="JJ/MM/AAAA" class="error" required/>'; //Petit effet visuel pour épater la populasse en cas d'erreur
		else echo '<input type="text" name="date" placeholder="JJ/MM/AAAA" required/>';
		echo '<input type="text" name="nom" required/>';
		echo '<input type="text" name="lieu" required/>';
		if($error == 2) echo '<input type="text" name="place" placeholder="si vide: &infin;" class="error" />'; //Petit effet visuel pour épater la populasse en cas d'erreur
		else echo '<input type="text" name="place" placeholder="si vide: &infin;" />';
		echo '<input type="submit" value="+"/>';
		echo '</form>';
	}
	?>
</main>