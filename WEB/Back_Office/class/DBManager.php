<?php

require_once('include/config.php');
require_once('class/subscriptionType.php');
require_once('class/customer.php');
require_once('class/reservation.php');
require_once('class/serviceProvided.php');
require_once('class/service.php');

class DBManager
{
    private $db;
    public function __construct($bdd)
    {

        $this->db = $bdd;
    }

    //Insert subscription in db
    public function addSubscriptionType(SubscriptionType $subscription)
    {

        $subName = $subscription->getTypeName();
        $q = $this->db->query("SELECT typeName FROM SubscriptionType WHERE typeName = '" . $subName."'");

        $data = $q->fetch();

        if ($data != NULL) {
            header('Location: create_subscription.php?error=name_taken');
            exit;
        }else{
            $q = "INSERT INTO SubscriptionType(typeId,typeName,openDays,openTime,closeTime,serviceTimeAmount,price) VALUES (:typeId,:typeName,:openDays,:openTime,:closeTime,:serviceTimeAmount,:price)";
            $res = $this->db->prepare($q);
            $res->execute(array(
                'typeId' => $subscription->getTypeId(),
                'typeName' => $subscription->getTypeName(),
                'openDays' => $subscription->getOpenDays(),
                'openTime' => $subscription->getOpenTime(),
                'closeTime' => $subscription->getCloseTime(),
                'serviceTimeAmount' => $subscription->getServiceTimeAmount(),
                'price' => $subscription->getPrice()
            ));
        }
    }

    //Get all subscriptions from the db
    public function getSubscriptionTypeList(){
        $subscriptions = [];

        $q = $this->db->query('SELECT typeId,typeName,openDays,openTime,closeTime,serviceTimeAmount,price FROM SubscriptionType ORDER BY typeName');

        while ($data = $q->fetch()) {
            $subscriptions[] = new SubscriptionType($data['typeId'],$data['typeName'], $data['openDays'], $data['openTime'], $data['closeTime'], $data['serviceTimeAmount'], $data['price']);
        }

        return $subscriptions;
    }

    //Get the subscriptionType with its id 
    public function getSubscriptionType($typeId){
        $typeId = (int) $typeId;
        $q = $this->db->query('SELECT typeId,typeName,openDays,openTime,closeTime,serviceTimeAmount,price FROM SubscriptionType WHERE typeId = '.$typeId.'');

        $data = $q->fetch();

        if($data == NULL){
            header('Location: subscriptions.php');
        }
        return new SubscriptionType($data['typeId'], $data['typeName'], $data['openDays'], $data['openTime'], $data['closeTime'], $data['serviceTimeAmount'], $data['price']);
    }

    //Update the subscription
    public function updateSubscriptionType(SubscriptionType $subscription){
        $subName = $subscription->getTypeName();
        $q = $this->db->query("SELECT typeName FROM SubscriptionType WHERE typeName = '" . $subName . "'");

        $data = $q->fetch();

        if ($data != NULL && $data['typeName'] != $subscription->getTypeName() ) {
            header('Location: edit_subscription.php?error=name_taken&id='.$subscription->getTypeId());
            exit;
        } else{
            $id = $subscription->getTypeId();
            $q = "UPDATE SubscriptionType SET typeName=:typeName,openDays=:openDays,openTime=:openTime,closeTime=:closeTime,serviceTimeAmount=:serviceTimeAmount,price=:price WHERE typeId='" . $id . "'";
            $req = $this->db->prepare($q);
            $req->execute(array(
                'typeName' => $subscription->getTypeName(),
                'openDays' => $subscription->getOpenDays(),
                'openTime' => $subscription->getOpenTime(),
                'closeTime' => $subscription->getCloseTime(),
                'serviceTimeAmount' => $subscription->getServiceTimeAmount(),
                'price' => $subscription->getPrice()
            ));
        }

    }

    //Delete the subscription with its id
    public function deleteSubscriptionType($typeId)
    {
        $this->db->exec("DELETE FROM SubscriptionType WHERE typeId = '".$typeId."'");
    }

    
    public function getCustomerList()
    {

        // $q = "SELECT * FROM customer ORDER BY lastName";
        // $req = $this->db->prepare($q);
        // $req->execute();

        // $results = [];
        // $results[] = $req->fetchAll();

        // return $results;


        $users = [];

        $q = $this->db->query('SELECT * FROM Customer ORDER BY lastName');

        while ($data = $q->fetch()) {
            $users[] = new Customer($data['customerId'],$data['firstName'], $data['lastName'], $data['email'], $data['phoneNumber'], $data['address'], $data['town'], $data['enable']);
        }

        return $users;
    }



    //RESERVATIONS
    public function getReservationList(){
        $reservations = [];

        $q = $this->db->query('SELECT * FROM Reservation ORDER BY reservationDate DESC');

        while ($data = $q->fetch()) {
            $reservations[] = new Reservation($data['reservationId'], $data['reservationDate'], $data['customerId'], $data['serviceProvidedId'], $data['status']);
        }

        return $reservations;
    }


    //Service provided
    public function getServiceProvided($serviceProvidedId){
        $serviceProvidedId = (int) $serviceProvidedId;
        $q = $this->db->query('SELECT * FROM ServiceProvided WHERE serviceProvidedId = ' . $serviceProvidedId . '');

        $data = $q->fetch();

        if ($data == NULL) {
            header('Location: reservations.php');
        }
        return new ServiceProvided($data['serviceProvidedId'], $data['serviceId'], $data['date'], $data['hours'], $data['pricePerHour']);
    }

    //Service
    public function getService($serviceId)
    {
        $serviceId = (int) $serviceId;
        $q = $this->db->query('SELECT * FROM Service WHERE serviceId = ' . $serviceId . '');

        $data = $q->fetch();

        if ($data == NULL) {
            header('Location: reservations.php');
        }
        return new Service($data['serviceId'], $data['serviceTypeId'], $data['serviceTitle'], $data['description'], $data['recurrence'], $data['timeMin'], $data['servicePrice'], $data['commission']);
    }



} 
