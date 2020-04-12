<?php
require_once('class/DBManager.php');

$hm_database = new DBManager($bdd);
isset($_GET['associateId']);
isset($_GET['serviceId']);

$associateId = $_GET['associateId'];
$serviceId = $_GET['serviceId'];

$hm_database->deleteAssociateService($serviceId, $associateId);
$associate = $hm_database->getAssociate($associateId);

system('python3 mail/mail.py cancel_proposal ' . $associate->getEmail() . ' ' . $associate->getAssociateId());

header('Location: reservations.php?delete=successful');
exit;
