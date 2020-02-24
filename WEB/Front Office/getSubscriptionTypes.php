<?php
require_once('class/DBManager.php');
$db = new DBManager($bdd);

echo json_encode($db->getSubscriptionTypes());

?>
