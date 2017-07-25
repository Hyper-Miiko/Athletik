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
	<table id="scoreGeneral">
		<tr>
		<?php
			if(!isset($_GET['user'])) echo'
				<th>Place</a></th>
				<th>Participant</th>
				<th><a href=".?url=accueil&sort=0">Points</th>
				<th><a href=".?url=accueil&sort=1">Temps</th>
				<th><a href=".?url=accueil&sort=2">Courses</th>';
			else echo'
				<th>Place</a></th>
				<th>Participant</th>
				<th><a href=".?url='.$_GET['user'].'&sort=0">Points</th>
				<th><a href=".?url='.$_GET['user'].'&sort=1">Temps</th>
				<th><a href=".?url='.$_GET['user'].'&sort=2">Courses</th>';
		?>
		</tr>
		<?php
			include('controler/bdd.php');
			if(!isset($_GET['sort'])) $sort = 0;
			else $sort = $_GET['sort'];
			if(!isset($_GET['user'])) $user = "*";
			else $user = $_GET['user'];
			$classement = classement($bdd, "*", $user, $sort);
			$j = 0;
			for ($i = 1; $i <= sizeof($classement); $i++) {
				echo '<tr><td>'.$i.'</td><td><a href="./?url=accueil&user='.$classement[$i-1]["id"].'">'.$classement[$i-1]["firstname"].' '.$classement[$i-1]["lastname"].'</a></td><td>'.$classement[$i-1]["points"].'</td><td>'.$classement[$i-1]["min"].'.'.$classement[$i-1]["sec"].'</td><td>'.$classement[$i-1]["nbrcourse"].'</td></tr>';
				$j++;
			}
			if($j == 0) {
				echo '<tr><td>&mdash;&mdash;</td><td>&mdash;&mdash;</td><td>&mdash;&mdash;</td><td>&mdash;&mdash;</td><td>&mdash;&mdash;</td></tr>';
			}
		?>
	</table>
<main>