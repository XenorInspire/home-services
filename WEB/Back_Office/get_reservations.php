<?php
require_once('class/DBManager.php');
$hm_database = new DBManager($bdd);

$date = $_POST['date'];

$q = $hm_database->getReservationsFromDate($date);

$counter = 0;

while ($data = $q->fetch()) {

  $customer = $hm_database->getCustomer($data['customerId']);
  $serviceProvided = $hm_database->getServiceProvided($data['serviceProvidedId']);
  $associate = $hm_database->getAssociateFromServiceProvided($serviceProvided->getServiceProvidedId());
  $service = $hm_database->getService($serviceProvided->getServiceId());
  $beginHour = explode('.', $serviceProvided->getBeginHour());
  $counter++;

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

if ($counter == 0) {
  echo 'Pas de service à cette date !';
}

 ?>
