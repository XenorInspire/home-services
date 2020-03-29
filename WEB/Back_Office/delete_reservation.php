<?php
require_once('class/DBManager.php');

$hm_database = new DBManager($bdd);
isset($_GET['reservationId']);
$hm_database->deleteReservation($_GET['reservationId']);
// $hm_database->getReservation($_GET['reservationId']);

// system('python3 mail/mail.py cancel_proposal ' . $associate->getEmail() . ' ' . $associate->getAssociateId());


header('Location: reservations.php?delete=successful');
