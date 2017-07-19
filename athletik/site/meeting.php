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
			if(isModo()) echo '<tr style="background: #2277FF"><td colspan="3"><a href="./?url=addMeeting">Ajouter</td></tr>';
	?>
</table>