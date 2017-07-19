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
	<ul>
		<!--slider-->
	</ul>
</section>
<aside>
	<div>
		<!--calendar-->
		<table>
			<?php
				$donnees = $bdd->query('SELECT * FROM meeting');
				$event;
				while($temp = $donnees->fetch(PDO::FETCH_ASSOC)) {
					if(explode('-', $temp['date'])[0] >= date('o') && explode('-', $temp['date'])[1] >= date('n') && explode('-', $temp['date'])[2] >= date('j')) {
						echo '<tr><td>'.$temp["date"].'</td><td>'.$temp["name"].'</td><td>'.$temp["description"].'</ytd></tr>';
					}
				}
			?>
		</table>
	</div>
	<div id="classement">
		<table>
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
				echo '<tr><th>N°</th><th>Participant</th><th>Points</th></tr>';
				/*foreach($classement as $array) {
					$i++;
					echo '<tr><td>'.$i.'</td><td>'.$array["firstname"].' '.$array["lastname"].'</td><td>'.$array["points"].'</td></tr>';
				}*/
				for ($i = 1; $i <= sizeof($classement); $i++) {
					echo '<tr><td>'.$i.'</td><td>'.$classement[$i-1]["firstname"].' '.$classement[$i-1]["lastname"].'</td><td>'.$classement[$i-1]["points"].'</td></tr>';
				}
			?>
		</table>
	</div>
</aside>