<?php
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=athletik;charset=utf8','root','M!8qcTr63%');
include('controler/security.php');
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Athletik &mdash; Les 1000 pas</title>
		<link rel="stylesheet" type="text/css" href="view/css/master.css" />
	</head>
	<body>
		<?php
		include('view/php/header.php');
		include('view/php/nav.php');
		if(isset($_GET['url'])) {
			if(!include('view/php/'.$_GET["url"].'.php')) {
				header('Location: ./?url=404#top');
			}
		} else header('Location: ./?url=accueil');
		include('view/php/footer.php');
		?>
	</body>
	<script type="text/javascript" src="view/js/variable.js"></script>
    <script type="text/javascript" src="view/js/function.js"></script>
    <script type="text/javascript" src="view/js/script.js"></script>
</html>