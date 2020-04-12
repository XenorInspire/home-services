<?php
require_once('class/DBManager.php');

$hm_database = new DBManager($bdd);
isset($_GET['associateId']);
isset($_GET['serviceProvidedId']);

$associateId = $_GET['associateId'];
$serviceProvidedId = $_GET['serviceProvidedId'];

$hm_database->denyProposal($serviceProvidedId, $associateId);

header('Location: associate_services_proposal.php?deny=successful');
