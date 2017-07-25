<?php
session_start();
session_destroy(); //On casse tous, MOUHAHAHAHAHAHAHAHA, je suis machiavélique!
header('Location: '.$_SERVER["HTTP_REFERER"]); //Derniére page visité
?>