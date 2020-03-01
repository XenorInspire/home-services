<?php
require_once('include/config.php');
require_once('class/DBManager.php');

$hm_database = new DBManager($bdd);
isset($_GET['id']);
$hm_database->deleteSubscriptionType($_GET['id']);

header('Location: subscriptions.php?delete=successful');

?>

