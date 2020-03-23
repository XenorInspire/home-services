<?php

require_once('include/config.php');
require_once('class/subscriptionType.php');
require_once('class/customer.php');
require_once('class/reservation.php');
require_once('class/serviceProvided.php');
require_once('class/service.php');
require_once('class/associateServices.php');
require_once('class/associate.php');
require_once('class/proposal.php');
require_once('class/serviceType.php');

class DBManager
{
    private $db;
    public function __construct($bdd)
    {

        $this->db = $bdd;
    }

    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
* * * * * * * * * * * * * * * * SUBSCRIPTION PART * * * * * * * * * * * * * * *
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

    //Insert subscription in db
    public function addSubscriptionType(SubscriptionType $subscription)
    {

        $subName = $subscription->getTypeName();
        $q = $this->db->query("SELECT typeName FROM SubscriptionType WHERE typeName = '" . $subName . "'");

        $data = $q->fetch();

        if ($data != NULL) {
            header('Location: create_subscription.php?error=name_taken');
            exit;
        } else {
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
    public function getSubscriptionTypeList()
    {
        $subscriptions = [];

        $q = $this->db->query('SELECT typeId,typeName,openDays,openTime,closeTime,serviceTimeAmount,price FROM SubscriptionType ORDER BY typeName');

        while ($data = $q->fetch()) {
            $subscriptions[] = new SubscriptionType($data['typeId'], $data['typeName'], $data['openDays'], $data['openTime'], $data['closeTime'], $data['serviceTimeAmount'], $data['price']);
        }

        return $subscriptions;
    }

    //Get the subscriptionType with its id
    public function getSubscriptionType($typeId)
    {
        $typeId = (int) $typeId;
        $q = $this->db->query('SELECT typeId,typeName,openDays,openTime,closeTime,serviceTimeAmount,price FROM SubscriptionType WHERE typeId = ' . $typeId . '');

        $data = $q->fetch();

        if ($data == NULL) {
            header('Location: subscriptions.php');
        }
        return new SubscriptionType($data['typeId'], $data['typeName'], $data['openDays'], $data['openTime'], $data['closeTime'], $data['serviceTimeAmount'], $data['price']);
    }

    //Update the subscription
    public function updateSubscriptionType(SubscriptionType $subscription)
    {
        $subName = $subscription->getTypeName();
        $q = $this->db->query("SELECT typeName FROM SubscriptionType WHERE typeName = '" . $subName . "'");

        $data = $q->fetch();

        if ($data != NULL && $data['typeName'] != $subscription->getTypeName()) {
            header('Location: edit_subscription.php?error=name_taken&id=' . $subscription->getTypeId());
            exit;
        } else {
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
        $this->db->exec("DELETE FROM SubscriptionType WHERE typeId = '" . $typeId . "'");
    }

    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
* * * * * * * * * * * * * * * * CUSTOMER PART * * * * * * * * * * * * * * * * *
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
    public function getCustomer($customerId)
    {
        $customerId = (int) $customerId;
        $q = $this->db->query('SELECT * FROM Customer WHERE customerId = ' . $customerId . '');

        $data = $q->fetch();

        if ($data == NULL) {
            header('Location: customers.php');
        }
        return new Customer($data['customerId'], $data['firstName'], $data['lastName'], $data['email'], $data['phoneNumber'], $data['address'], $data['town'], $data['enable']);
    }

    public function getCustomerList()
    {
        $users = [];

        $q = $this->db->query('SELECT * FROM Customer ORDER BY enable DESC, lastName');

        while ($data = $q->fetch()) {
            $users[] = new Customer($data['customerId'], $data['firstName'], $data['lastName'], $data['email'], $data['phoneNumber'], $data['address'], $data['town'], $data['enable']);
        }

        return $users;
    }

    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
* * * * * * * * * * * * * * * * RESERVATION PART * * * * * * * * * * * * * * * *
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

    //Reservations list
    public function getReservationList()
    {
        $reservations = [];

        $q = $this->db->query('SELECT * FROM Reservation ORDER BY reservationDate DESC');

        while ($data = $q->fetch()) {
            $reservations[] = new Reservation($data['reservationId'], $data['reservationDate'], $data['customerId'], $data['serviceProvidedId'], $data['status']);
        }

        return $reservations;
    }

    public function getReservation($reservationId){
        $reservationId = (int) $reservationId;
        $q = $this->db->query('SELECT * FROM Reservation WHERE reservationId = ' . $reservationId . '');

        $data = $q->fetch();

        if ($data == NULL) {
            header('Location: reservations.php');
        }
        return new Reservation($data['reservationId'], $data['reservationDate'], $data['customerId'], $data['serviceProvidedId'], $data['status']);
    }

    //Delete reservation
    public function deleteReservation($reservationId)
    {
        $this->db->exec("DELETE FROM Reservation WHERE reservationId = '" . $reservationId . "'");
    }


    //Service provided
    public function getServiceProvided($serviceProvidedId)
    {
        $serviceProvidedId = (int) $serviceProvidedId;
        $q = $this->db->query('SELECT * FROM ServiceProvided WHERE serviceProvidedId = ' . $serviceProvidedId . '');

        $data = $q->fetch();

        if ($data == NULL) {
            header('Location: reservations.php');
        }
        return new ServiceProvided($data['serviceProvidedId'], $data['serviceId'], $data['date'], $data['beginHour'], $data['hours'], $data['additionalPrice'], $data['hoursAssociate'], $data['address'], $data['town']);
    }

    //Insert a reservation 
    public function addReservation(Customer $customer, Reservation $reservation, ServiceProvided $serviceProvided)
    {
        //Insert into ServiceProvided
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

        //Insert into Reservation
        $q = "INSERT INTO Reservation(reservationId,reservationDate,customerId,serviceProvidedId,status) VALUES (:reservationId,:reservationDate,:customerId,:serviceProvidedId,:status)";
        $res = $this->db->prepare($q);
        $res->execute(array(
            'reservationId' => $reservation->getReservationId(),
            'reservationDate' => $reservation->getReservationDate(),
            'customerId' => $customer->getCustomerId(),
            'serviceProvidedId' => $serviceProvided->getServiceProvidedId(),
            'status' => $reservation->getStatus()
        ));
    }

    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
* * * * * * * * * * * * * * * * * SERVICE PART * * * * * * * * * * * * * * * * *
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

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

    public function getServiceListByType($serviceTypeId)
    {
        $services = [];
        $serviceTypeId = (int) $serviceTypeId;
        $q = $this->db->query('SELECT * FROM Service WHERE serviceTypeId = ' . $serviceTypeId . '');

        while ($data = $q->fetch()) {
            $services[] = new Service($data['serviceId'], $data['serviceTypeId'], $data['serviceTitle'], $data['description'], $data['recurrence'], $data['timeMin'], $data['servicePrice'], $data['commission']);
        }

        return $services;
    }

    public function addServiceType(ServiceType $service)
    {

        $subName = $service->getTypeName();
        $q = $this->db->query("SELECT typeName FROM ServiceType WHERE typeName = '" . $subName . "'");

        $data = $q->fetch();

        if ($data != NULL) {
            header('Location: add_service_type.php?error=name_taken');
            exit;
        } else {
            $q = "INSERT INTO ServiceType(serviceTypeId,typeName) VALUES (:serviceTypeId,:typeName)";
            $res = $this->db->prepare($q);
            $res->execute(array(
                'serviceTypeId' => $service->getServiceTypeId(),
                'typeName' => $service->getTypeName()
            ));
        }
    }

    public function getServiceType($typeId)
    {
        $q = $this->db->query('SELECT serviceTypeId,typeName FROM ServiceType WHERE serviceTypeId = "' . $typeId . '"');
        $data = $q->fetch();

        if ($data == NULL) {
            header('Location: service_type.php');
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

    public function updateServiceType(ServiceType $service)
    {
        $subName = $service->getTypeName();
        $q = $this->db->query("SELECT typeName FROM ServiceType WHERE typeName = '" . $subName . "'");

        $data = $q->fetch();

        if ($data != NULL && $data['typeName'] != $service->getTypeName()) {
            header('Location: edit_service_type.php?error=name_taken&id=' . $service->getServiceTypeId());
            exit;
        } else {
            $id = $service->getServiceTypeId();
            $q = "UPDATE ServiceType SET typeName=:typeName WHERE serviceTypeId='" . $id . "'";
            $req = $this->db->prepare($q);
            $req->execute(array(
                'typeName' => $service->getTypeName()
            ));
        }
    }

    public function deleteServiceType($typeId)
    {
        $this->db->exec("DELETE FROM ServiceType WHERE serviceTypeId = '" . $typeId . "'");
    }

    //AssociateServices get associate with the service id
    public function getAssociateServicesList($serviceId)
    {

        $associatesId = [];

        $q = $this->db->query('SELECT * FROM AssociateServices WHERE serviceId = ' . $serviceId . '');

        while ($data = $q->fetch()) {
            $associatesId[] = new AssociateServices($data['serviceId'], $data['associateId']);
        }

        $associates = [];
        foreach ($associatesId as $associateId) {
            array_push($associates, $this->getAssociate($associateId->getAssociateId()));
        }

        return $associates;
    }

    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
* * * * * * * * * * * * * * * * *ASSOCIATE PART* * * * * * * * * * * * * * * * *
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

    //Associate
    public function getAssociate($associateId)
    {
        $associateId = (int) $associateId;
        $q = $this->db->query('SELECT * FROM Associate WHERE associateId = ' . $associateId . '');

        $data = $q->fetch();

        if ($data == NULL) {
            header('Location: reservations.php');
        }
        return new Associate($data['associateId'], $data['lastName'], $data['firstName'], $data['email'], $data['phoneNumber'], $data['address'], $data['town'], $data['sirenNumber'], $data['companyName']);
    }


    //Give the propose to the associate
    public function proposalToAssociate(Proposal $proposal)
    {
        $q = "INSERT INTO Proposal(serviceProvidedId,status,associateId) VALUES (:serviceProvidedId,:status,:associateId)";
        $res = $this->db->prepare($q);
        $res->execute(array(
            'serviceProvidedId' => $proposal->getServiceProvidedId(),
            'status' => ($proposal->getStatus() == 0 ? false : true),
            'associateId' => $proposal->getAssociateId()
        ));
    }

    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
* * * * * * * * * * * * * * * * * PROPOSAL PART* * * * * * * * * * * * * * * * *
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

    public function getProposal($serviceProvidedId)
    {
        $serviceProvidedId = (int) $serviceProvidedId;
        $q = $this->db->query('SELECT * FROM Proposal WHERE serviceProvidedId = ' . $serviceProvidedId . '');

        $data = $q->fetch();

        if ($data == NULL) {
            return NULL;
        } else {
            return new Proposal($data['serviceProvidedId'], $data['status'], $data['associateId']);
        }
    }

    public function deleteProposal($associateId)
    {
        $this->db->exec("DELETE FROM Proposal WHERE associateId = '" . $associateId . "'");
    }
}
