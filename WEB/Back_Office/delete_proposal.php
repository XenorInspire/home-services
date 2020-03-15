<?php
require_once('class/DBManager.php');

$hm_database = new DBManager($bdd);
isset($_GET['associateId']);
$hm_database->deleteProposal($_GET['associateId']);

header('Location: reservations.php?delete=successful');
