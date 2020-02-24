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

    $q = "INSERT INTO customer(customerId,email,lastName,firstName,phoneNumber,address,town,password,enable) VALUES (:customerId,:email,:lastName,:firstName,:phoneNumber,:address,:town,:password,:enable)";
    $res = $this->db->prepare($q);
    $res->execute(array(
      'customerId'=> $user->getId($user),
      'email' => $user->getMail($user),
      'lastName' => $user->getLastname($user),
      'firstName' => $user->getFirstname($user),
      'phoneNumber' => $user->getPhone_number($user),
      'address' => $user->getAddress($user),
      'town' => $user->getCity($user),
      'password' => $user->getPassword(),
      'enable' => 0
    ));
  }
}
