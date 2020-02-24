<?php

require_once('include/config.php');
require_once('class/customer.php');

class DBManager
{

  private $db;
  public function __construct($bdd)
  {

    $this->db = $bdd;
  }

  public function addCustomer(Customer $user)
  {

    $q = "INSERT INTO customer(customerId, email, lastName, firstName, phoneNumber, address, town, password, enable)
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

  public function doesMailExist(Customer $user)
  {

    $q = "SELECT customerId FROM customer WHERE email = ?";
    $req = $this->db->prepare($q);
    $req->execute([$user->getMail($user)]);

    $results = [];
    while ($user = $req->fetch())
      $results[] = $user;

    if (count($results) != 0)
      return 1;
    else
      return 0;
  }

  public function enableCustomerAccount($string)
  {

    $q = "UPDATE Customer SET enable = 1 WHERE customer.customerId = ?";
    $req = $this->db->prepare($q);
    $req->execute([$string]);
  }

  public function getSubscritionTypes()
  {
    $q = "SELECT (typeName, openDays, openTime, closeTime, serviceTimeAmount, price) FROM SubscriptionType";
    $req = $this->db->prepare($q);
    $req->execute();

    $results = $req->fetchAll();

    return $results[];
  }


}
