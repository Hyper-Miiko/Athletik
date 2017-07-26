<!--C'mon on met un  paint de couleur-->
<style type="text/css">
	@import url('view/css/accueil.css');
</style>

<main>
	<article>
		<p id="presentation">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
		tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
		quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
		consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
		cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
		proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
	</article>
	<div id="slideshow">
		<button class="slideButton slideButtonLeft" onclick="plusDivs(-1)">&#10094;</button>
		<img class="slideImg" src="data/img1.jpg" />
		<img class="slideImg" src="data/img2.jpg" />
		<img class="slideImg" src="data/img3.jpg" />
		<img class="slideImg" src="data/img4.jpg" />
		<button class="slideButton slideButtonRight" onclick="plusDivs(+1)">&#10095;</button>
	</div>
	<table id="scoreGeneral">
		<tr>
			<th>Place</th>
			<th>Participant</th>
			<th><a href=".?url=accueil&sort=0">Points</a></th>
			<th><a href=".?url=accueil&sort=1">Temps</a></th>
			<th><a href=".?url=accueil&sort=2">Courses</a></th>
		</tr>
		<?php
			include('controler/bdd.php');
			if(!isset($_GET['sort'])) $sort = 0; //Si on à pas mis de tri on le met par default
			else $sort = $_GET['sort']; //Sinon, bah ça parait logique non? On mange des crêpes
			if(!isset($_GET['user'])) $user = "*"; //Si on ne cible pas d'utilisateur en particulier on les cible tous
			else $user = $_GET['user']; //Après le coup que je t'es fait tu lit quand même cette ligne?
			$classement = classement($bdd, "*", $user, $sort); //On récup le tableau de tous les event du/des utilisateur sélectionné avec le tri choisi
			$j = 0; //Taille du tableau
			for ($i = 1; $i <= sizeof($classement); $i++) { //On parcours $classement
				echo '<tr><td>'.$i.'</td><td><a href="./?url=accueil&user='.$classement[$i-1]["id"].'">'.$classement[$i-1]["firstname"].' '.$classement[$i-1]["lastname"].'</a></td><td>'.$classement[$i-1]["points"].'</td><td>'.$classement[$i-1]["min"].'.'.$classement[$i-1]["sec"].'</td><td>'.$classement[$i-1]["nbrcourse"].'</td></tr>'; //Une ligne du tableau
				$j++; //Une ligne supplémentaire
			}
			if($j == 0) { //Si il n'y a aucunne ligne une fois que $classement est parcouru
				echo '<tr><td>&mdash;&mdash;</td><td>&mdash;&mdash;</td><td>&mdash;&mdash;</td><td>&mdash;&mdash;</td><td>&mdash;&mdash;</td></tr>'; //On rajoute une ligne pour faire moins moche
			}
		?>
	</table>
<main>