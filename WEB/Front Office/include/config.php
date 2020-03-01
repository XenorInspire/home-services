<?php

try {

	$bdd = new PDO('mysql:host=localhost;dbname=home-services','root','root');

}catch(Exception $e) {

	die('Erreur : ' . $e->getMessage());

}

?>
