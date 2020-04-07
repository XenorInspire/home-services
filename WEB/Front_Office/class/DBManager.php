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

    $q = "SELECT * FROM SubscriptionBill WHERE customerId = ? ORDER BY billDate ASC LIMIT 1";
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

  public function addSubscriptionBill($user, $subscriptionType)
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
      'billDate' => date('Y-m-d'),
      'typeName' => $subscriptionType->getTypeName(),
      'price' => $subscriptionType->getPrice()
    ));
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

    // if ($data == NULL) {
    //   header('Location: reservations.php');
    // }
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

    // if ($data == NULL) {
    //   header('Location: reservations.php');
    // }
    return new Reservation($data['reservationId'], $data['reservationDate'], $data['customerId'], $data['serviceProvidedId'], $data['status']);
  }

  public function getReservationByServiceProvidedId($serviceProvidedId)
  {
    $serviceProvidedId = (int) $serviceProvidedId;
    $q = $this->db->query('SELECT * FROM Reservation WHERE serviceProvidedId = ' . $serviceProvidedId . '');

    $data = $q->fetch();

    // if ($data == NULL) {
    //   header('Location: reservations.php');
    // }
    return new Reservation($data['reservationId'], $data['reservationDate'], $data['customerId'], $data['serviceProvidedId'], $data['status']);
  }

  public function endServiceProvided($serviceProvidedId, $hoursAssociate, $additionalPrices)
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
  }

  /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
* * * * * * * * * * * * * * * * * SERVICE PART * * * * * * * * * * * * * * * * *
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

  public function getService($serviceId)
  {
    $serviceId = (int) $serviceId;
    $q = $this->db->query('SELECT * FROM Service WHERE serviceId = ' . $serviceId . '');

    $data = $q->fetch();

    // if ($data == NULL) {
    //   header('Location: reservations.php');
    // }
    return new Service($data['serviceId'], $data['serviceTypeId'], $data['serviceTitle'], $data['description'], $data['recurrence'], $data['timeMin'], $data['servicePrice'], $data['commission']);
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
