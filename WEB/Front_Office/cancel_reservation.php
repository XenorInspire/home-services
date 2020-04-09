<?php

if (!isset($_GET['rid']) || empty($_GET['rid'])) {

    header('Location: orders.php');
    exit;
}

require_once('include/check_identity.php');
if (!($status == 'customer' && $connected == 1)) {

    header('Location: index.php');
    exit;
}
$hm_database = new DBManager($bdd);
$hm_database->deleteReservation($_GET['rid']);

header('Location: orders.php');
exit;
