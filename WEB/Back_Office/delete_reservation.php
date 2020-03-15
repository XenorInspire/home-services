<?php
require_once('class/DBManager.php');

$hm_database = new DBManager($bdd);
isset($_GET['reservationId']);
$hm_database->deleteReservation($_GET['reservationId']);

header('Location: reservations.php?delete=successful');
