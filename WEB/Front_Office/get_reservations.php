<?php
require_once('class/DBManager.php');
require_once('include/lang.php');
$hm_database = new DBManager($bdd);

$date = $_POST['date'];
$id = $_POST['id'];

$serviceProvided_ids = $hm_database->getReservationsFromDate($date, $id);

if ($serviceProvided_ids != null) {
  foreach($serviceProvided_ids as $sp_id) {
     $serviceProvided = $hm_database->getServiceProvided($sp_id);
    $service = $hm_database->getService($serviceProvided->getServiceId());
    $beginHour = explode('.', $serviceProvided->getBeginHour());

    echo '<tr class="table-light">';
    echo '<td>' . $serviceProvided->getAddress() . ', ' . $serviceProvided->getTown() . '</td>';
    echo '<td>' . $beginHour[0] . '</td>';
    echo '<td>' . $service->getServiceTitle() . '</td>';
    echo '</tr>';
  }
} else {
  echo $get_reservations['noService'];
}

 ?>
