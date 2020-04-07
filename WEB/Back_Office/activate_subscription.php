<?php
require_once('class/DBManager.php');

$hm_database = new DBManager($bdd);
isset($_GET['id']);
$hm_database->activateSubscription($_GET['id']);

header('Location: subscriptions.php?activate=successful');
exit;
