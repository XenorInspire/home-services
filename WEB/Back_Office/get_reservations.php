<?php
require_once('class/DBManager.php');
$hm_database = new DBManager($bdd);

if (isset($_POST['date'])) {
  $date = $_POST['date'];
} else $date = '2020-04-09';

$data = $hm_database->getReservationsFromDate($date);
echo json_encode($data);

 ?>
