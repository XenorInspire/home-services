<?php
require_once('class/DBManager.php');

$hm_database = new DBManager($bdd);
isset($_GET['associateId']);
isset($_GET['serviceProvidedId']);

$associateId = $_GET['associateId'];
$serviceProvidedId = $_GET['serviceProvidedId'];

$hm_database->deleteProposal($associateId, $serviceProvidedId);

header('Location: reservations.php?delete=successful');
