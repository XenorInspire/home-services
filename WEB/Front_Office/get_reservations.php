<?php
require_once('class/DBManager.php');
require_once('include/check_identity.php');
require_once('include/lang.php');
$hm_database = new DBManager($bdd);

if (isset($_POST['date'])) {
  $date = $_POST['date'];
} else $date = '2020-04-09';

$q = $hm_database->getReservationsFromDate($date, $id);

$counter = 0;

while ($data = $q->fetch()) {

  $counter++;

  $serviceProvided = $hm_database->getServiceProvided($data['serviceProvidedId']);
  $service = $hm_database->getService($serviceProvided->getServiceId());
  $beginHour = explode('.', $serviceProvided->getBeginHour());

  echo '<tr class="table-light">';
  echo '<td>' . $serviceProvided->getAddress() . ', ' . $serviceProvided->getTown() . '</td>';
  echo '<td>' . $beginHour[0] . '</td>';
  echo '<td>' . $service->getServiceTitle() . '</td>';
  echo '</tr>';
}

if ($counter == 0) {
  echo $get_reservations['noService'];
}

 ?>
