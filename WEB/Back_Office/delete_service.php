<?php
require_once('class/DBManager.php');

$hm_database = new DBManager($bdd);
isset($_GET['serviceId']);
isset($_GET['serviceTypeId']);
$serviceiId = $_GET['serviceId'];
$serviceTypeId = $_GET['serviceTypeId'];

$hm_database->deleteService($serviceiId);

$url = "services.php?serviceTypeId=" . $serviceTypeId . "&delete=successful";
header('Location: ' . $url);
exit;
