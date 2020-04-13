<?php
require_once('class/DBManager.php');

$hm_database = new DBManager($bdd);
isset($_GET['associateId']);
isset($_GET['serviceProvidedId']);

$associateId = $_GET['associateId'];
$serviceProvidedId = $_GET['serviceProvidedId'];

$hm_database->deleteProposal($associateId, $serviceProvidedId);
$associate = $hm_database->getAssociate($associateId);

system('python3 mail/mail.py cancel_proposal ' . $associate->getEmail() . ' ' . $associate->getAssociateId());

header('Location: reservations.php?delete=successful');
exit;
