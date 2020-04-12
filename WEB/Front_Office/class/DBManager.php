<?php

require_once('include/config.php');
require_once('class/customer.php');
require_once('class/subscription_type.php');
require_once('class/reservation.php');
require_once('class/serviceProvided.php');
require_once('class/service.php');
require_once('class/associate.php');
require_once('class/proposal.php');
require_once('class/subscription.php');
require_once('class/additionalPrice.php');
// require_once('class/invoicing.php');
require_once('class/bill.php');
require_once('class/serviceType.php');

class DBManager
{

  private $db;
  public function __construct($bdd)
  {

    $this->db = $bdd;
  }

  /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
* * * * * * * * * * * * * * * * CUSTOMER PART * * * * * * * * * * * * * * * *
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

  public function addCustomer(Customer $user)
  {
    $user->setId();

    $q = "INSERT INTO Customer(customerId, email, lastName, firstName, phoneNumber, address, town, password, enable)
          VALUES (:customerId, :email, :lastName, :firstName, :phoneNumber, :address, :town, :password, :enable)";
    $res = $this->db->prepare($q);
    $res->execute(array(
      'customerId' => $user->getId(),
      'email' => $user->getMail(),
      'lastName' => $user->getLastname(),
      'firstName' => $user->getFirstname(),
      'phoneNumber' => $user->getPhone_number(),
      'address' => $user->getAddress(),
      'town' => $user->getCity(),
      'password' => $user->getPassword(),
      'enable' => 0
    ));
  }

  public function doesMailExist($mail)
  {

    $q = "SELECT CustomerId FROM Customer WHERE email = ?";
    $req = $this->db->prepare($q);
    $req->execute([$mail]);

    $results = [];
    while ($user = $req->fetch())
      $results[] = $user;

    if (count($results) != 0)
      return 1;
    else
      return 0;
  }

  public function enableCustomerAccount($id)
  {

    $q = "UPDATE Customer SET enable = 1 WHERE Customer.customerId = ?";
    $req = $this->db->prepare($q);
    $req->execute([$id]);
  }

  public function disableCustomerAccount($id)
  {

    $q = "UPDATE Customer SET enable = 0 WHERE Customer.customerId = ?";
    $req = $this->db->prepare($q);
    $req->execute([$id]);
  }

  public function getAllSubscriptionTypes()
  {
    $q = "SELECT typeId, typeName, openDays, openTime, closeTime, serviceTimeAmount, price FROM SubscriptionType WHERE enable = 1";
    $req = $this->db->prepare($q);
    $req->execute();

    while ($results = $req->fetch()) {

      $subscriptionType = new SubscriptionType($results['typeId'], $results['typeName'], $results['openDays'], $results['openTime'], $results['closeTime'], $results['serviceTimeAmount'], $results['price']);
      $subs[] = $subscriptionType;
    }

    return $subs;
  }

  public function getSubscriptionTypeById($id)
  {

    $q = "SELECT typeId, typeName, openDays, openTime, closeTime, serviceTimeAmount, price FROM SubscriptionType WHERE typeId = ?";
    $req = $this->db->prepare($q);
    $req->execute([$id]);

    $result = $req->fetch();

    if (empty($result)) return NULL;

    $subscriptionType = new SubscriptionType($result['typeId'], $result['typeName'], $result['openDays'], $result['openTime'], $result['closeTime'], $result['serviceTimeAmount'], $result['price']);
    return $subscriptionType;
  }

  public function checkEnableSubscriptionType($id)
  {

    $q = "SELECT enable FROM SubscriptionType WHERE typeId = ?";
    $req = $this->db->prepare($q);
    $req->execute([$id]);

    $result = $req->fetch();
    if (empty($result) || $result[0] == 0) return NULL;

    return 1;
  }

  public function getUserById($id)
  {

    $q = "SELECT * FROM Customer WHERE customerId = ?";
    $req = $this->db->prepare($q);
    $req->execute([$id]);

    $results = $req->fetch();

    if (!empty($results)) {

      $user = new Customer($results[0], $results[2], $results[1], $results[3], $results[4], $results[5], $results[6], $results[7]);
      return $user;
    } else {

      return NULL;
    }
  }

  public function getUserByMail($mail)
  {

    $q = "SELECT * FROM Customer WHERE email = ?";
    $req = $this->db->prepare($q);
    $req->execute([$mail]);

    $results = $req->fetch();

    if (!empty($results)) {

      $user = new Customer($results[0], $results[2], $results[1], $results[3], $results[4], $results[5], $results[6], $results[7]);
      return $user;
    } else {

      return NULL;
    }
  }

  public function doesAccountIsActivated($id)
  {

    $q = "SELECT enable FROM Customer WHERE customerId = ?";
    $req = $this->db->prepare($q);
    $req->execute([$id]);
    $results = $req->fetch();

    return $results[0];
  }

  public function getDb()
  {
    return $this->db;
  }

  public function checkSubscription($id)
  {

    $q = "SELECT * FROM Subscription WHERE customerId = ?";
    $req = $this->db->prepare($q);
    $req->execute([$id]);
    $results = $req->fetch();

    if (!empty($results)) {

      return new Subscription($results['beginDate'], $results['customerId'], $results['typeId'], $results['remainingHours']);
    } else {

      return NULL;
    }
  }

  public function remainingHours($id, $hours)
  {

    $subscription = $this->checkSubscription($id);
    if ($subscription == NULL) return NULL;
    if ($subscription->getRemainingHours() - $hours < 0) return 0;

    $q = "UPDATE Subscription SET remainingHours = :remainingHours WHERE customerId = :customerId";
    $req = $this->db->prepare($q);
    $req->execute(array(
      'remainingHours' => ($subscription->getRemainingHours() - $hours),
      'customerId' => $id
    ));

    return 1;
  }

  public function setNewPasswdCustomer($password, $id)
  {

    $q = "UPDATE Customer SET password = :password WHERE customerId = :id";
    $req = $this->db->prepare($q);
    $req->execute(array(
      'password' => $password,
      'id' => $id
    ));
  }

  public function getLastSubscriptionBill($id)
  {

    $q = "SELECT * FROM SubscriptionBill WHERE customerId = ? ORDER BY billDate DESC LIMIT 1";
    $req = $this->db->prepare($q);
    $req->execute([$id]);

    $results = $req->fetch();

    if (!empty($results)) {

      return $results;
    } else {

      return NULL;
    }
  }

  public function getLastIdSubscriptionBill()
  {

    $req = $this->db->query('SELECT billId FROM SubscriptionBill ORDER BY billId ASC');
    $newId = 1;
    while ($id = $req->fetch()) {
      if ($newId != $id['billId']) {
        break;
      }
      $newId++;
    }

    return $newId;
  }

  public function addSubscriptionBill($user, $subscriptionType, $beginDate)
  {

    $q = "INSERT INTO SubscriptionBill(billId, customerId, customerLastName, customerFirstName, customerAddress, customerTown, email, billDate, typeName, price) VALUES (:billId, :customerId, :customerLastName, :customerFirstName, :customerAddress, :customerTown, :email, :billDate, :typeName, :price)";
    $res = $this->db->prepare($q);
    $res->execute(array(
      'billId' => $this->getLastIdSubscriptionBill(),
      'customerId' => $user->getId(),
      'customerLastName' => $user->getLastname(),
      'customerFirstName' => $user->getFirstname(),
      'customerAddress' => $user->getAddress(),
      'customerTown' => $user->getCity(),
      'email' => $user->getMail(),
      'billDate' => $beginDate,
      'typeName' => $subscriptionType->getTypeName(),
      'price' => $subscriptionType->getPrice()
    ));
  }

  public function getCustomer($customerId)
  {
    $customerId = (int) $customerId;
    $q = $this->db->query('SELECT * FROM Customer WHERE customerId = ' . $customerId . '');

    $data = $q->fetch();

    if ($data == NULL) {
      header('Location: customers.php');
      exit;
    }
    return new Customer($data['customerId'], $data['firstName'], $data['lastName'], $data['email'], $data['phoneNumber'], $data['address'], $data['town'], $data['enable']);
  }


  /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
* * * * * * * * * * * * * * * * SERVICE PROVIDED PART * * * * * * * * * * * * * * * *
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
  //Service provided
  public function getServiceProvided($serviceProvidedId)
  {
    $serviceProvidedId = (int) $serviceProvidedId;
    $q = $this->db->query('SELECT * FROM ServiceProvided WHERE serviceProvidedId = ' . $serviceProvidedId . '');

    $data = $q->fetch();

    if ($data == NULL) {
      return NULL;
    }
    return new ServiceProvided($data['serviceProvidedId'], $data['serviceId'], $data['date'], $data['beginHour'], $data['hours'], $data['hoursAssociate'], $data['address'], $data['town']);
  }

  /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
* * * * * * * * * * * * * * * * RESERVATION PART * * * * * * * * * * * * * * * *
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
  public function getReservation($reservationId)
  {
    $reservationId = (int) $reservationId;
    $q = $this->db->query('SELECT * FROM Reservation WHERE reservationId = ' . $reservationId . '');

    $data = $q->fetch();

    if ($data == NULL) {
      return NULL;
    }
    return new Reservation($data['reservationId'], $data['reservationDate'], $data['customerId'], $data['serviceProvidedId'], $data['status']);
  }

  public function getReservationByServiceProvidedId($serviceProvidedId)
  {

    $q = "SELECT * FROM Reservation WHERE serviceProvidedId = ?";
    $req = $this->db->prepare($q);
    $req->execute([$serviceProvidedId]);

    $data = $req->fetch();

    if ($data == NULL) {
      return NULL;
    }
    return new Reservation($data['reservationId'], $data['reservationDate'], $data['customerId'], $data['serviceProvidedId'], $data['status']);
  }

  public function endServiceProvided($serviceProvidedId, $hoursAssociate, $additionalPrices, $bill)
  {
    $q = "UPDATE ServiceProvided SET hoursAssociate = :hoursAssociate WHERE serviceProvidedId = :serviceProvidedId";
    $req = $this->db->prepare($q);
    $req->execute(array(
      'hoursAssociate' => $hoursAssociate,
      'serviceProvidedId' => $serviceProvidedId
    ));

    $q = "UPDATE Reservation SET status = :status WHERE serviceProvidedId = :serviceProvidedId";
    $req = $this->db->prepare($q);
    $req->execute(array(
      'status' => 1,
      'serviceProvidedId' => $serviceProvidedId
    ));

    $this->db->exec("DELETE FROM Proposal WHERE status = 0 OR status = 2 " . "AND serviceProvidedId = '" . $serviceProvidedId . "'");

    if ($additionalPrices != NULL) {
      foreach ($additionalPrices as $additionalPrice) {
        $q = "INSERT INTO AdditionalPrice(additionalPriceId,serviceProvidedId,description,price) VALUES (:additionalPriceId,:serviceProvidedId,:description,:price)";
        $res = $this->db->prepare($q);
        $res->execute(array(
          'additionalPriceId' => $additionalPrice->getAdditionalPriceId(),
          'serviceProvidedId' => $additionalPrice->getServiceProvidedId(),
          'description' => $additionalPrice->getDescription(),
          'price' => $additionalPrice->getPrice()
        ));
      }
    }

    $this->addBill($bill);
  }

  public function deleteReservation($reservationId)
  {
    $reservation = $this->getReservation($reservationId);
    $serviceProvided = $this->getServiceProvided($reservation->getServiceProvidedId());

    $this->db->exec("DELETE FROM Reservation WHERE reservationId = '" . $reservationId . "'");
    $this->db->exec("DELETE FROM ServiceProvided WHERE serviceProvidedId = '" . $serviceProvided->getServiceProvidedId() . "'");
    $this->db->exec("DELETE FROM Proposal WHERE serviceProvidedId = '" . $serviceProvided->getServiceProvidedId() . "'");
  }

  /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
* * * * * * * * * * * * * * * * * BILL PART * * * * * * * * * * * * * * * * *
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
  public function getLastIdBill()
  {

    $req = $this->db->query('SELECT billId FROM Bill ORDER BY billId ASC');
    $newId = 1;
    while ($id = $req->fetch()) {
      if ($newId != $id['billId']) {
        break;
      }
      $newId++;
    }

    return $newId;
  }

  public function addBill(Bill $bill)
  {
    $q = "INSERT INTO Bill(billId, paidStatus, customerId, customerLastName, customerFirstName, customerAddress, customerTown, email, date, serviceTitle, totalPrice, serviceProvidedId) VALUES (:billId, :paidStatus, :customerId, :customerLastName, :customerFirstName, :customerAddress, :customerTown, :email, :date, :serviceTitle, :totalPrice, :serviceProvidedId)";
    $res = $this->db->prepare($q);
    $res->execute(array(
      'billId' => $bill->getBillId(),
      'paidStatus' => $bill->getPaidStatus(),
      'customerId' => $bill->getCustomerId(),
      'customerLastName' => $bill->getCustomerLastName(),
      'customerFirstName' => $bill->getCustomerFirstName(),
      'customerAddress' => $bill->getCustomerAddress(),
      'customerTown' => $bill->getCustomerTown(),
      'email' => $bill->getEmail(),
      'date' => $bill->getDate(),
      'serviceTitle' => $bill->getServiceTitle(),
      'totalPrice' => $bill->getTotalPrice(),
      'serviceProvidedId' => $bill->getServiceProvidedId()
    ));
  }

  public function checkBill($id)
  {

    $q = "SELECT * FROM Bill WHERE serviceProvidedId = ?";
    $res = $this->db->prepare($q);
    $res->execute([$id]);

    $results = $res->fetch();

    if (empty($results)) return NULL;
    return $results;
  }

  public function getBill($billId)
  {

    $q = "SELECT * FROM Bill WHERE billId = ?";
    $res = $this->db->prepare($q);
    $res->execute([$billId]);

    $data = $res->fetch();

    if ($data == NULL) {
      return NULL;
    }

    return new Bill($data['billId'], $data['paidStatus'], $data['customerId'], $data['customerLastName'], $data['customerFirstName'], $data['customerAddress'], $data['customerTown'], $data['email'], $data['date'], $data['serviceTitle'], $data['totalPrice'], $data['serviceProvidedId']);
  }

  public function getAdditionalPrice($serviceProvidedId)
  {
    $additionalPrices = [];
    $q = "SELECT * FROM AdditionalPrice WHERE serviceProvidedId = ?";
    $res = $this->db->prepare($q);
    $res->execute([$serviceProvidedId]);

    while ($data = $res->fetch()) {
      $additionalPrices[] = new AdditionalPrice($data['additionalPriceId'], $data['serviceProvidedId'], $data['description'], $data['price']);
    }

    return $additionalPrices;
  }

  /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
* * * * * * * * * * * * * * * * * SERVICE PART * * * * * * * * * * * * * * * * *
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

  public function getService($serviceId)
  {
    $q = "SELECT * FROM Service WHERE serviceId = ?";
    $res = $this->db->prepare($q);
    $res->execute([$serviceId]);

    $data = $res->fetch();

    if ($data == NULL) {
      return NULL;
    }
    return new Service($data['serviceId'], $data['serviceTypeId'], $data['serviceTitle'], $data['description'], $data['recurrence'], $data['timeMin'], $data['servicePrice'], $data['commission']);
  }

  public function getRecurringServices()
  {

    $q = "SELECT * FROM Service WHERE recurrence = 1";
    $res = $this->db->prepare($q);
    $res->execute();

    while ($results = $res->fetch()) {

      $service = new Service($results['serviceId'], $results['serviceTypeId'], $results['serviceTitle'], $results['description'], $results['recurrence'], $results['timeMin'], $results['servicePrice'], $results['commission']);
      $services[] = $service;
    }

    return $services;
  }

  public function addReservation(Customer $customer, Reservation $reservation, ServiceProvided $serviceProvided)
  {
    $q = "INSERT INTO ServiceProvided(serviceProvidedId,serviceId,date,beginHour,hours,address,town) VALUES (:serviceProvidedId,:serviceId,:date,:beginHour,:hours,:address,:town)";
    $res = $this->db->prepare($q);
    $res->execute(array(
      'serviceProvidedId' => $serviceProvided->getServiceProvidedId(),
      'serviceId' => $serviceProvided->getServiceId(),
      'date' => $serviceProvided->getDate(),
      'beginHour' => $serviceProvided->getBeginHour(),
      'hours' => $serviceProvided->getHours(),
      'address' => $serviceProvided->getAddress(),
      'town' => $serviceProvided->getTown()
    ));

    $q = "INSERT INTO Reservation(reservationId,reservationDate,customerId,serviceProvidedId,status) VALUES (:reservationId,:reservationDate,:customerId,:serviceProvidedId,:status)";
    $res = $this->db->prepare($q);
    $res->execute(array(
      'reservationId' => $reservation->getReservationId(),
      'reservationDate' => $reservation->getReservationDate(),
      'customerId' => $customer->getId(),
      'serviceProvidedId' => $serviceProvided->getServiceProvidedId(),
      'status' => $reservation->getStatus()
    ));
  }

  public function getReservationsByCustomerId($id)
  {

    $q = "SELECT Reservation.reservationId,Reservation.status,Service.serviceTitle,Service.servicePrice,Service.serviceId,ServiceProvided.date,ServiceProvided.beginHour,ServiceProvided.serviceProvidedId FROM Reservation,Service,ServiceProvided WHERE Reservation.customerId = ? AND Reservation.serviceProvidedId = ServiceProvided.serviceProvidedId AND ServiceProvided.serviceId = Service.serviceId";
    $req = $this->db->prepare($q);
    $req->execute([$id]);

    while ($results = $req->fetch())
      $services[] = $results;

    if (empty($services)) return NULL;

    return $services;
  }

  /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
* * * * * * * * * * * * * * * * * Service Type * * * * * * * * * * * * * * * * *
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

  public function getServiceType($typeId)
  {
    $q = "SELECT serviceTypeId,typeName FROM ServiceType WHERE serviceTypeId = ?";
    $res = $this->db->prepare($q);
    $res->execute([$typeId]);

    $data = $res->fetch();

    if ($data == NULL) {
      return NULL;
    }

    return new ServiceType($data['serviceTypeId'], $data['typeName']);
  }

  public function getServiceTypeByName($typeName)
  {

    $q = "SELECT serviceTypeId,typeName FROM ServiceType WHERE typeName = ?";
    $res = $this->db->prepare($q);
    $res->execute([$typeName]);

    $data = $res->fetch();

    if ($data == NULL) {
      return NULL;
    }

    return new ServiceType($data['serviceTypeId'], $data['typeName']);
  }

  public function getServiceTypeList()
  {
    $serviceTypes = [];
    $q = $this->db->query('SELECT * FROM ServiceType ORDER BY typeName');

    while ($data = $q->fetch()) {
      $serviceTypes[] = new ServiceType($data["serviceTypeId"], $data["typeName"]);
    }

    return $serviceTypes;
  }

  public function getServiceListByType($serviceTypeId)
  {
    $q = "SELECT * FROM Service WHERE serviceTypeId = ?";
    $res = $this->db->prepare($q);
    $res->execute([$serviceTypeId]);

    while ($data = $res->fetch()) {
      $services[] = new Service($data['serviceId'], $data['serviceTypeId'], $data['serviceTitle'], $data['description'], $data['recurrence'], $data['timeMin'], $data['servicePrice'], $data['commission']);
    }

    return $services;
  }

  /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
* * * * * * * * * * * * * * * * * PROPOSAL PART * * * * * * * * * * * * * * * * *
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

  public function acceptProposal($serviceProvidedId, $associateId)
  {
    $q = "UPDATE Proposal SET status=:status WHERE serviceProvidedId='" . $serviceProvidedId . "'" . "AND associateId='" . $associateId . "'";
    $req = $this->db->prepare($q);
    $req->execute(array(
      'status' => 1
    ));
  }

  public function denyProposal($serviceProvidedId, $associateId)
  {
    $q = "UPDATE Proposal SET status=:status WHERE serviceProvidedId='" . $serviceProvidedId . "'" . "AND associateId='" . $associateId . "'";
    $req = $this->db->prepare($q);
    $req->execute(array(
      'status' => 2
    ));
  }

  public function getAssociateProposal($associateId)
  {
    $q = "SELECT * FROM Proposal WHERE associateId = ?";
    $res = $this->db->prepare($q);
    $res->execute([$associateId]);

    $proposals = [];
    while ($data = $res->fetch()) {
      $proposals[] = new Proposal($data['serviceProvidedId'], $data['status'], $data['associateId']);
    }

    if ($proposals == NULL)
      return NULL;

    return $proposals;
  }

  /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
* * * * * * * * * * * * * * * * * ASSOCIATE PART * * * * * * * * * * * * * * * * *
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

  public function getAssociateById($associateId)
  {
    $associateId = (int) $associateId;
    $q = $this->db->query('SELECT * FROM Associate WHERE associateId = ' . $associateId . '');

    $data = $q->fetch();

    if ($data == NULL) {
      return NULL;
    }
    return new Associate($data['associateId'], $data['lastName'], $data['firstName'], $data['email'], $data['phoneNumber'], $data['address'], $data['town'], $data['sirenNumber'], $data['companyName'], $data['password']);
  }

  public function getAssociateByMail($associateMail)
  {
    $q = "SELECT * FROM Associate WHERE email = ?";
    $req = $this->db->prepare($q);
    $req->execute([$associateMail]);

    $data = $req->fetch();

    if ($data == NULL) {
      return NULL;
    }
    return new Associate($data['associateId'], $data['lastName'], $data['firstName'], $data['email'], $data['phoneNumber'], $data['address'], $data['town'], $data['sirenNumber'], $data['companyName'], $data['password']);
  }

  public function setNewPasswdAssociate($password, $id)
  {

    $q = "UPDATE Associate SET password = :password WHERE associateId = :id";
    $req = $this->db->prepare($q);
    $req->execute(array(
      'password' => $password,
      'id' => $id
    ));
  }

  public function doesAssociateAccountIsActivated($id)
  {

    $q = "SELECT enable FROM Associate WHERE associateId = ?";
    $req = $this->db->prepare($q);
    $req->execute([$id]);
    $results = $req->fetch();

    return $results[0];
  }

  public function enableAssociateAccount($id)
  {

    $q = "UPDATE Associate SET enable = 1 WHERE Associate.associateId = ?";
    $req = $this->db->prepare($q);
    $req->execute([$id]);
  }

  public function getAssociateServicesProvided($associateId)
  {
    $servicesProvidedId = [];

    $q = $this->db->query('SELECT * FROM Proposal WHERE associateId = ' . $associateId . '');

    while ($data = $q->fetch()) {
      $servicesProvidedId[] = new Proposal($data['serviceProvidedId'], $data['status'], $data['associateId']);
    }

    $servicesProvided = [];
    foreach ($servicesProvidedId as $serviceProvidedId) {
      array_push($servicesProvided, $this->getServiceProvided($serviceProvidedId->getServiceProvidedId()));
    }

    return $servicesProvided;
  }

  public function getAssociateServicesProvidedOnlyAcceptedAndUndone($associateId)
  {
    // $associateId = (int) $associateId;
    $servicesProvidedId = [];

    $q = $this->db->query("SELECT * FROM Proposal WHERE associateId = '" . $associateId . "'AND status = 1");

    while ($data = $q->fetch()) {
      $servicesProvidedId[] = new Proposal($data['serviceProvidedId'], $data['status'], $data['associateId']);
    }

    $servicesProvided = [];
    foreach ($servicesProvidedId as $serviceProvidedId) {
      $reservation = $this->getReservationByServiceProvidedId($serviceProvidedId->getServiceProvidedId());
      if ($reservation->getStatus() == 0)
        array_push($servicesProvided, $this->getServiceProvided($serviceProvidedId->getServiceProvidedId()));
    }

    return $servicesProvided;
  }
}
