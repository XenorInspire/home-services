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
  if ($data['status'] == 1) {
    $customer = $hm_database->getCustomer($data['customerId']);
    echo 'Customer : ' . $customer->getFirstname() . ' ' . $customer->getLastName() . '<br>';
    $serviceProvided = $hm_database->getServiceProvided($data['serviceProvidedId']);
    echo 'Service Provided : ' . $serviceProvided->getBeginHour() . '<br>';
    $service = $hm_database->getService($serviceProvided->getServiceId());
    echo 'Service Title : ' . $service->getServiceTitle() . '<br>';
    $associate = $hm_database->getAssociateFromServiceProvided($serviceProvided->getServiceProvidedId());
    echo 'Associate : ' . $associate->getFirstName() . ' ';
    echo $associate->getLastName() . '<br>';

  } else {

  }

}

// while ($data = $q->fetch()) {
//   if (empty($data)) {
//     echo "Pas de services.";
//   } else {
//     echo json_encode($data);
//   }
// }

 ?>
