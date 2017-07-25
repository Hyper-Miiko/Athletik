<?php
	if(!isset($_GET['target'])) header('Location: ./?url=event');
	if(!isset($_GET['error'])) $error = -1;
?>
<style type="text/css">
	@import url('view/css/eventDescription.css');
</style>
<main>
	<table id="score">
		<tr>
			<input class="hidden event" value=<?php echo '"'.$_GET['target'].'"' ?> />
			<th>Place</a></th>
			<th>Participant</th>
			<th><a href=".?url=accueil&sort=0">Points</th>
			<th><a href=".?url=accueil&sort=1">Temps</th>
			<th><a href=".?url=accueil&sort=2">Courses</th>
			<?php if(haveRight(2)) echo '<th>Action</th>'; ?>
		</tr>
		<?php
			include('controler/bdd.php');
			if(!isset($_GET['sort'])) $sort = 0;
			else $sort = $_GET['sort'];
			$target = $_GET['target'];
			$classement = classement($bdd, $target, "*", $sort);
			$j = 0;
			for ($i = 1; $i <= sizeof($classement); $i++) {
				if(haveRight(2)) echo '<tr>
					<td>'.$i.'</td>
					<td><a href="./?url=accueil&user='.$classement[$i-1]["id"].'">'.$classement[$i-1]["firstname"].' '.$classement[$i-1]["lastname"].'</a></td>
					<td class="points">'.$classement[$i-1]["points"].'</td>
					<td><input class="time" name="time" value="'.$classement[$i-1]["min"].'.'.$classement[$i-1]["sec"].'" /></td>
					<td class="hidden age">'.$classement[$i-1]["age"].'</td>
					<td class="hidden id">'.$classement[$i-1]["id"].'</td>
					<td>'.$classement[$i-1]["nbrcourse"].'</td>
					<td class="action"><a class="edit" href=""><button>E</button></a></td>
				</tr>';
				else echo '<tr>
					<td>'.$i.'</td>
					<td><a href="./?url=accueil&user='.$classement[$i-1]["id"].'">'.$classement[$i-1]["firstname"].' '.$classement[$i-1]["lastname"].'</a></td>
					<td>'.$classement[$i-1]["points"].'</td>
					<td>'.$classement[$i-1]["min"].'.'.$classement[$i-1]["sec"].'</td>
					<td>'.$classement[$i-1]["nbrcourse"].'</td>
				</tr>';
				$j++;
			}
			if($j == 0) {
				echo '<tr><td>&mdash;&mdash;</td><td>&mdash;&mdash;</td><td>&mdash;&mdash;</td><td>&mdash;&mdash;</td><td>&mdash;&mdash;</td></tr>';
			}
		?>
	</table>
	<?php 
	if(haveRight(2)) {
		echo '<form id="addScore" method="post" action="./controler/addEvent.php">';
		switch ($error) {
			case 0:
				echo '<p style="color: green">Score ajouté avec succés.<p>';
			break;
		}
		$listingRunner = listingRunner($bdd);
		echo '<select name="name" id="name">';
		for ($i = 1; $i <= sizeof($listingRunner); $i++) {
			echo '<option value="'.$listingRunner[$i-1]['id'].'">'.$listingRunner[$i-1]['lastname'].' '.$listingRunner[$i-1]['firstname'].'</option>';
		}
		echo '</select>';
		echo '<input type="text" class="points" name="points" disabled/>';
		echo '<input type="text" class="time" name="time" required/>';
		echo '<input type="submit" value="+"/>';
		echo '</form>';
	}
	?>
</main>