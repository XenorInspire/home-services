<?php
require_once('class/DBManager.php');

$hm_database = new DBManager($bdd);
isset($_GET['id']);
$hm_database->desactivateSubscription($_GET['id']);

header('Location: subscriptions.php?desactivate=successful');
