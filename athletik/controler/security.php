<?php
function haveRight($r) {
	if(isset($_SESSION['privilege'])) {
		$p = $_SESSION['privilege'];
		for($i = 0; $i < $r-1; $i++) {
			if($p%pow(2, $i+1) == pow(2, $i)) {
				$p -= pow(2, $i);
			}
		}
		if($p%pow(2, $r) == pow(2, $r-1)) return true;
	}
	return false;
}
?>