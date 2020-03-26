<?php
require_once('class/DBManager.php');

$hm_database = new DBManager($bdd);
isset($_GET['id']);
$hm_database->deleteService($_GET['id']);

header('Location: service_Types.php?delete=successful');
