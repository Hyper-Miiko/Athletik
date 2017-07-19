<section>
	<article>
		<h2>Présentation</h2>
		<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
		tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
		quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
		consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
		cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
		proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
	</article>
	<h2>Galerie</h2>
	<div id="galerie">
		<img src="data/event1.jpg">
		<img src="data/event2.jpg">
		<img src="data/event3.jpg">
	</div>
</section>
<aside>
	<div>
		<h3>Prochaines rencontres</h3>
		<table>
			<tr>
				<th>Date</th>
				<th>Lieu</th>
				<th>Description</th>
			</tr>
			<?php
				$donnees = $bdd->query('SELECT * FROM meeting');
				$event;
				while($temp = $donnees->fetch(PDO::FETCH_ASSOC)) {
					if(explode('-', $temp['date'])[0] >= date('o') && explode('-', $temp['date'])[1] >= date('n') && explode('-', $temp['date'])[2] >= date('j')) {
						echo '<tr><td>'.$temp["date"].'</td><td>'.$temp["name"].'</td><td>'.$temp["description"].'</ytd></tr>';
					}
				}
				echo '<tr id="meeting" style="background: #2277FF"><td colspan="3"><a href=".?url=meeting">Voir</a></td></tr>';
			?>
		</table>
	</div>
	<div id="classement">
		<h3>Classement général</h3>
		<table>
			<tr>
				<th>N°</th>
				<th>Participant</th>
				<th>Points</th>
			</tr>
			<?php
				function fonctionComparaison($a, $b){
				    return $a['points'] < $b['points'];
				}
				$donnees = $bdd->query('SELECT id, firstname, lastname FROM user');
				$classement;
				while($temp = $donnees->fetch(PDO::FETCH_ASSOC)) {
					$classement[] = $temp;
				}
				
				foreach($classement as &$array) {
					$array['points'] = 0;
					$donnees = $bdd->query('SELECT points FROM result WHERE athlete_id="'.$array['id'].'"');
					while ($temp = $donnees->fetch(PDO::FETCH_ASSOC)) {
						$array['points'] += $temp['points'];
					}
				}
				usort($classement, 'fonctionComparaison');
				$i = 0;
				for ($i = 1; $i <= sizeof($classement); $i++) {
					echo '<tr><td>'.$i.'</td><td>'.$classement[$i-1]["firstname"].' '.$classement[$i-1]["lastname"].'</td><td>'.$classement[$i-1]["points"].'</td></tr>';
				}
			?>
		</table>
	</div>
</aside>