<?php
require_once('class/DBManager.php');

$hm_database = new DBManager($bdd);
isset($_GET['id']);
$hm_database->deleteServiceType($_GET['id']);

header('Location: service_type.php?delete=successful');

?>
