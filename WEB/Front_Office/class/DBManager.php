<?php

require_once('include/config.php');
require_once('class/customer.php');
require_once('class/subscription_type.php');

class DBManager
{

  private $db;
  public function __construct($bdd)
  {

    $this->db = $bdd;
  }

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
    $q = "SELECT typeId, typeName, openDays, openTime, closeTime, serviceTimeAmount, price FROM SubscriptionType";
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

      return $results;
    } else {

      return NULL;
    }
  }
}
