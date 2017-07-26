<!--C'mon on met un  paint de couleur-->
<style type="text/css">
	@import url('view/css/member.css');
</style>

<?php
//On test si il y a une potentiel erreur
if(!isset($_GET['error']))$error = -1; //On applique un valeur biddon pour éviter les problémes
else $error = $_GET['error'];
?>
<main>
	<table id="userList">
		<tr>
			<th>Identifiant</th>
			<th>Prénom</th>
			<th>Nom</th>
			<?php if(haveRight(3)) echo '<th>Action</th>'; ?>
		</tr>
		<?php
			include('controler/bdd.php');
			$userList = listingRegister($bdd);
			$j = 0; //Taille du tableau
			for ($i = 1; $i <= sizeof($userList); $i++) { //On parcours le tableau
				//Variable de condition
				echo '<tr>';
					echo '<td>'.$userList[$i-1]['login'].'</td>';
					echo '<td>'.$userList[$i-1]['firstname'].'</td>';
					echo '<td>'.$userList[$i-1]['lastname'].'</td>';
					if(haveRight(3)) {
						echo '<td><form method="post" action="controler/editRight.php">';
								echo '<input name="id" type="hidden" value="'.$userList[$i-1]["id"].'" />';
								echo '<label>3:</label><input type="checkbox" name="3" value="true"';
								if($userList[$i-1]['privilege'] >= 4) echo ' checked';
								if($userList[$i-1]["id"] == $_SESSION["id"]) echo ' onclick="rightWarning()" class="rightWarning"';
								echo ' /><label>2:</label><input type="checkbox" name="2" value="true"';
								if($userList[$i-1]['privilege'] == 2 || $userList[$i-1]['privilege'] == 3 || $userList[$i-1]['privilege'] == 6 || $userList[$i-1]['privilege'] == 7) echo ' checked';
								echo ' /><label>1:</label><input type="checkbox" name="1" value="true"';
								if($userList[$i-1]['privilege']%2 == 1) echo ' checked';
								echo ' /><input type="submit" value="E"';
						echo ' /></form></td>';
					}
				echo '</tr>';
				$j++; //Une ligne supplémentaire
			}
			if($j == 0) {
				echo '<tr><td>&mdash;&mdash;</td><td>&mdash;&mdash;</td><td>&mdash;&mdash;</td><td>&mdash;&mdash;</td><td>&mdash;&mdash;</td></tr>'; //Faudrait pas laisser un tableau vide non ;-)
			}
		?>
	</table>
</main>