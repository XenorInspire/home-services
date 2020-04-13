<?php
require_once('class/DBManager.php');
$hm_database = new DBManager($bdd);

if (isset($_POST['date'])) {
  $date = $_POST['date'];
} else $date = '2020-04-09';

$q = $hm_database->getReservationsFromDate($date);

// $data = $q->fetchAll();
// echo json_encode($data);


while ($data = $q->fetch()) {

  $customer = $hm_database->getCustomer($data['customerId']);
  $serviceProvided = $hm_database->getServiceProvided($data['serviceProvidedId']);
  $associate = $hm_database->getAssociateFromServiceProvided($serviceProvided->getServiceProvidedId());
  $service = $hm_database->getService($serviceProvided->getServiceId());
  $beginHour = explode('.', $serviceProvided->getBeginHour());

  echo '<tr class="table-light">';
  echo '<td>' . $customer->getFirstname() . ' ' . $customer->getLastName() . '</td>';
  echo '<td>' . $serviceProvided->getAddress() . ', ' . $serviceProvided->getTown() . '</td>';
  echo '<td>' . $beginHour[0] . '</td>';
  echo '<td>' . $service->getServiceTitle() . '</td>';
  echo '<td>' . $associate->getFirstName() . ' ' . $associate->getLastName() . '</td>';
  echo '</tr>';
}

// while ($data = $q->fetch()) {
//   if (empty($data)) {
//     echo "Pas de services.";
//   } else {
//     echo json_encode($data);
//   }
// }

 ?>
