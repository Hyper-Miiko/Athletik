<nav>
	<?php
	if($_GET['url'] != 'accueil') echo '<a href="./?ulr=accueil">Accueil</a>';
	if($_GET['url'] != 'event')echo '<a href="./?url=event">Evénements</a>';
	if($_GET['url'] != 'member')echo '<a href="./?url=member">Membres</a>';
	?>
</nav>