<style type="text/css">
	@import url('view/css/event.css');
</style>
<?php
if(!isset($_GET['error']))$error = -1;
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
			$j = 0;
			for ($i = 1; $i <= sizeof($listingEvent); $i++) {
				echo '<tr><td>'.$listingEvent[$i-1]["day"].'/'.$listingEvent[$i-1]["month"].'/'.$listingEvent[$i-1]["year"].'</td><td><a href=".?url=eventDescription&target='.$listingEvent[$i-1]["id"].'">'.$listingEvent[$i-1]["name"].'</a></td><td>'.$listingEvent[$i-1]["lieu"].'</td>';
				if($listingEvent[$i-1]["places"] >= 0) echo '<td>'.$listingEvent[$i-1]["places"].'</td>';
				else echo '<td>&infin;</td>';
				if(haveRight(1) && $listingEvent[$i-1]["year"] > date('Y')) echo '<td><a href="./controler/inscription.php/?target='.$listingEvent[$i-1]["id"].'&mode=in"><span class="unresponsive">S\'inscrire</span><span class="responsive">+</span></a></td>';
				else if(haveRight(1) && $listingEvent[$i-1]["year"] = date('Y')) {
					if($listingEvent[$i-1]["month"] > date('m')) echo '<td><a href="./controler/inscription.php/?target='.$listingEvent[$i-1]["id"].'&mode=in"><span class="unresponsive">S\'inscrire</span><span class="responsive">+</span></a></td>';
					else if ($listingEvent[$i-1]["month"] = date('m')) {
						if ($listingEvent[$i-1]["day"] > date('d')) echo '<td><a href="./controler/inscription.php/?target='.$listingEvent[$i-1]["id"].'&mode=in"><span class="unresponsive">S\'inscrire</span><span class="responsive">+</span></a></td>';
						else echo '<td></td>';
					} else echo '<td></td>';
				} else echo '<td></td>';
				echo '</tr>';
				$j++;
			}
			if($j == 0) {
				echo '<tr><td>&mdash;&mdash;</td><td>&mdash;&mdash;</td><td>&mdash;&mdash;</td><td>&mdash;&mdash;</td><td>&mdash;&mdash;</td></tr>';
			}
		?>
	</table>
	<?php 
	if(haveRight(2)) {
		echo '<form method="post" action="./controler/addEvent.php">';
		switch ($error) {
			case 0:
				echo '<p style="color: green">Evénement ajouté avec succés.<p>';
			break;
			case 1:
				echo '<p style="color: red">Format de date invalide.<p>';
				break;
			case 2:
				echo '<p style="color: red">Le nombre de place doit être un entier positif.</p>';
				break;
		}
		if($error == 1) echo '<input type="text" name="date" placeholder="JJ/MM/AAAA" class="error" required/>';
		else echo '<input type="text" name="date" placeholder="JJ/MM/AAAA" required/>';
		echo '<input type="text" name="nom" required/>';
		echo '<input type="text" name="lieu" required/>';
		if($error == 2) echo '<input type="text" name="place" placeholder="si vide: &infin;" class="error" />';
		else echo '<input type="text" name="place" placeholder="si vide: &infin;" />';
		echo '<input type="submit" value="+"/>';
		echo '</form>';
	}
	?>
</main>