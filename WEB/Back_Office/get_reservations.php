<?php
require_once('class/DBManager.php');
$hm_database = new DBManager($bdd);

$date = $_POST['date'];

$serviceProvided_ids = $hm_database->getReservationsFromDate($date);

if ($serviceProvided_ids != null) {
  foreach($serviceProvided_ids as $sp_id) {
    $serviceProvided = $hm_database->getServiceProvided($sp_id);
    $service = $hm_database->getService($serviceProvided->getServiceId());
    $beginHour = explode('.', $serviceProvided->getBeginHour());
    $reservation = $hm_database->getReservationByServiceProvidedId($sp_id);
    $customerId = $reservation->getCustomerId();
    $customer = $hm_database->getCustomer($customerId);
    $associate = $hm_database->getAssociateFromServiceProvided($serviceProvided->getServiceProvidedId());

    echo '<tr class="table-light">';
    echo '<td>' . $customer->getFirstname() . ' ' . $customer->getLastName() . '</td>';
    echo '<td>' . $serviceProvided->getAddress() . ', ' . $serviceProvided->getTown() . '</td>';
    echo '<td>' . $beginHour[0] . '</td>';
    echo '<td>' . $service->getServiceTitle() . '</td>';
    if ($associate != null) {
      echo '<td>' . $associate->getFirstName() . ' ' . $associate->getLastName() . '</td>';
    } else echo '<td>Aucun</td>';

    echo '</tr>';
  }
} else echo 'Pas de service à cette date !';


 ?>
