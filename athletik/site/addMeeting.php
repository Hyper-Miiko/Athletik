<?php if(!isModo()) header('Location: .?url=403'); ?>
<form method="post" action="action/addMeeting.php">
	<input type="text" name="date" />
	<input type="text" name="name" />
	<input type="text" name="description" />
	<input type="submit" name="valider" />
</form>