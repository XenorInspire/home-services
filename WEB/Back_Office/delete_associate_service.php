<?php
require_once('class/DBManager.php');

$hm_database = new DBManager($bdd);
isset($_GET['associateId']);
isset($_GET['serviceId']);

$associateId = $_GET['associateId'];
$serviceId = $_GET['serviceId'];

$hm_database->deleteAssociateService($serviceId, $associateId);

echo $serviceId;
echo $associateId;

$url = "associate_services.php?associateId=" . $associateId . "&delete=successful";
header('Location: ' . $url);
exit;
