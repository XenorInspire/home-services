<?php

require_once('database.env');

$options = [

	'host=' . DB_HOST,
	'dbname=' . DB_NAME,
	'port=' . DB_PORT

];

try {

	$bdd = new PDO(DB_DRIVER . ':' . join(';', $options), DB_USER, DB_PASSWORD);
} catch (Exception $e) {

	die('Erreur : ' . $e->getMessage());
}
