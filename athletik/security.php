<?php
function isAdmin() {
	if(isset($_SESSION['privilege'])) {
		$p = $_SESSION['privilege'];
		while ($p >= 1000) $p -= 1000;
		if($p >= 100) return true;
	}
	return false;
}
function isModo() {
	if(isset($_SESSION['privilege'])) {
		$p = $_SESSION['privilege'];
		while ($p >= 100) $p -= 100;
		if($p >= 10) return true;
	}
	return false;
}
function isRegister() {
	if(isset($_SESSION['privilege'])) {
		$p = $_SESSION['privilege'];
		while ($p >= 10) $p -= 10;
		if($p >= 1) return true;
	}
	return false;
}
?>