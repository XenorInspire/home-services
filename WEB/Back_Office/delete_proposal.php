<?php
require_once('class/DBManager.php');

$hm_database = new DBManager($bdd);
isset($_GET['associateId']);
isset($_GET['serviceId']);

$associateId = $_GET['associateId'];
$serviceId = $_GET['serviceId'];

$hm_database->deleteAssociateService($serviceId, $associateId);

header('Location: reservations.php?delete=successful');
exit;
