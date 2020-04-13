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
require_once('class/bill.php');
require_once('class/additionalPrice.php');

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

    //Insert subscriptionType
    public function addSubscriptionType(SubscriptionType $subscription)
    {
        $subName = $subscription->getTypeName();

        $q = "SELECT typeName FROM SubscriptionType WHERE typeName = ?";
        $req = $this->db->prepare($q);
        $req->execute([$subName]);
        $result = $req->fetch();

        if ($result != NULL) {
            header('Location: create_subscription.php?error=name_taken');
            exit;
        } else {
            $q = "INSERT INTO SubscriptionType(typeId,typeName,openDays,openTime,closeTime,serviceTimeAmount,price,enable) VALUES (:typeId,:typeName,:openDays,:openTime,:closeTime,:serviceTimeAmount,:price,:enable)";
            $res = $this->db->prepare($q);
            $res->execute(array(
                'typeId' => $subscription->getTypeId(),
                'typeName' => $subscription->getTypeName(),
                'openDays' => $subscription->getOpenDays(),
                'openTime' => $subscription->getOpenTime(),
                'closeTime' => $subscription->getCloseTime(),
                'serviceTimeAmount' => $subscription->getServiceTimeAmount(),
                'price' => $subscription->getPrice(),
                'enable' => $subscription->getEnable()
            ));
        }
    }

    //Get all subscriptionType
    public function getSubscriptionTypeList()
    {
        $subscriptions = [];

        $q = "SELECT * FROM SubscriptionType ORDER BY typeName";
        $req = $this->db->prepare($q);
        $req->execute();

        while ($data = $req->fetch())
            $subscriptions[] = new SubscriptionType($data['typeId'], $data['typeName'], $data['openDays'], $data['openTime'], $data['closeTime'], $data['serviceTimeAmount'], $data['price'], $data['enable']);

        if ($subscriptions == NULL)
            return NULL;

        return $subscriptions;
    }

    //Get the subscriptionType
    public function getSubscriptionType($typeId)
    {
        $q = "SELECT * FROM SubscriptionType WHERE typeId = ?";
        $req = $this->db->prepare($q);
        $req->execute([$typeId]);

        $data = $req->fetch();

        if ($data == NULL)
            return NULL;

        return new SubscriptionType($data['typeId'], $data['typeName'], $data['openDays'], $data['openTime'], $data['closeTime'], $data['serviceTimeAmount'], $data['price'], $data['enable']);
    }

    //Update the subscriptionType
    public function updateSubscriptionType(SubscriptionType $subscription)
    {
        $subName = $subscription->getTypeName();

        $q = "SELECT typeName FROM SubscriptionType WHERE typeName = ?";
        $req = $this->db->prepare($q);
        $req->execute([$subName]);
        $data = $req->fetch();

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

    //Delete the subscriptionType
    public function deleteSubscriptionType($typeId)
    {
        $q = "DELETE FROM SubscriptionType WHERE typeId = ?";
        $req = $this->db->prepare($q);
        $req->execute([$typeId]);
    }

    //Desactivate the subscriptionType
    public function desactivateSubscription($typeId)
    {
        $q = "UPDATE SubscriptionType SET enable=:enable WHERE typeId='" . $typeId . "'";
        $req = $this->db->prepare($q);
        $req->execute(array(
            'enable' => 0
        ));
    }

    //Activate the suscriptionType
    public function activateSubscription($typeId)
    {
        $q = "UPDATE SubscriptionType SET enable=:enable WHERE typeId=:typeId";
        $req = $this->db->prepare($q);
        $req->execute(array(
            'enable' => 1,
            'typeId' => $typeId

        ));
    }

    //Restore remainingHours to clients for theire subscription
    public function restoreRemainingHours()
    {
        $subscriptionTypes = $this->getSubscriptionTypeList();

        foreach ($subscriptionTypes as $subscriptionType) {
            $serviceTimeAmount = $subscriptionType->getServiceTimeAmount();
            $typeId = $subscriptionType->getTypeId();

            $q = "UPDATE Subscription SET remainingHours = :remainingHours WHERE typeId = :typeId";
            $req = $this->db->prepare($q);
            $req->execute(array(
                'remainingHours' => $serviceTimeAmount,
                'typeId' => $typeId
            ));
        }

        return 1;
    }

    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
* * * * * * * * * * * * * * * * CUSTOMER PART * * * * * * * * * * * * * * * * *
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
    //Get the customer
    public function getCustomer($customerId)
    {
        $q = "SELECT * FROM Customer WHERE customerId = ?";
        $req = $this->db->prepare($q);
        $req->execute([$customerId]);
        $data = $req->fetch();

        if ($data == NULL)
            return NULL;

        return new Customer($data['customerId'], $data['firstName'], $data['lastName'], $data['email'], $data['phoneNumber'], $data['address'], $data['town'], $data['enable']);
    }

    //Get all the customers
    public function getCustomerList()
    {
        $users = [];
        $q = "SELECT * FROM Customer ORDER BY enable DESC, lastName";
        $req = $this->db->prepare($q);
        $req->execute();
        while ($data = $req->fetch())
            $users[] = new Customer($data['customerId'], $data['firstName'], $data['lastName'], $data['email'], $data['phoneNumber'], $data['address'], $data['town'], $data['enable']);

        if ($users == NULL)
            return NULL;

        return $users;
    }

    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
* * * * * * * * * * * * * * * * RESERVATION PART * * * * * * * * * * * * * * * *
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

    //Reservations list
    public function getReservationList()
    {
        $reservations = [];

        $q = "SELECT * FROM Reservation ORDER BY reservationDate DESC";
        $req = $this->db->prepare($q);
        $req->execute();

        while ($data = $req->fetch())
            $reservations[] = new Reservation($data['reservationId'], $data['reservationDate'], $data['customerId'], $data['serviceProvidedId'], $data['status']);

        if ($reservations == NULL)
            return NULL;

        return $reservations;
    }

    //Get the reservation
    public function getReservation($reservationId)
    {
        $q = "SELECT * FROM Reservation WHERE reservationId = ?";
        $req = $this->db->prepare($q);
        $req->execute([$reservationId]);

        $data = $req->fetch();

        if ($data == NULL)
            return NULL;

        return new Reservation($data['reservationId'], $data['reservationDate'], $data['customerId'], $data['serviceProvidedId'], $data['status']);
    }

    //Delete reservation
    public function deleteReservation($reservationId)
    {
        $reservation = $this->getReservation($reservationId);

        $serviceProvided = $this->getServiceProvided($reservation->getServiceProvidedId());

        $q = "DELETE FROM Reservation WHERE reservationId =  ?";
        $req = $this->db->prepare($q);
        $req->execute([$reservationId]);

        $q = "DELETE FROM ServiceProvided WHERE serviceProvidedId =  ?";
        $req = $this->db->prepare($q);
        $req->execute([$serviceProvided->getServiceProvidedId()]);

        $q = "DELETE FROM Proposal WHERE serviceProvidedId =  ?";
        $req = $this->db->prepare($q);
        $req->execute([$serviceProvided->getServiceProvidedId()]);

        return 1;
    }

    //Get the service provided
    public function getServiceProvided($serviceProvidedId)
    {
        $q = "SELECT * FROM ServiceProvided WHERE serviceProvidedId = ?";
        $req = $this->db->prepare($q);
        $req->execute([$serviceProvidedId]);
        $data = $req->fetch();

        if ($data == NULL)
            return NULL;

        return new ServiceProvided($data['serviceProvidedId'], $data['serviceId'], $data['date'], $data['beginHour'], $data['hours'], $data['hoursAssociate'], $data['address'], $data['town']);
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

    function getReservationsFromDate($date)
    {
        $q = $this->db->query("SELECT customerId,serviceProvidedId FROM Reservation WHERE reservationDate = '" . $date . "'");

        $data = $q->fetch();

        return $data;
    }

    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
* * * * * * * * * * * * * * * * * SERVICE PART * * * * * * * * * * * * * * * * *
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

    //Add the service
    public function addService(Service $service)
    {
        $servTitle = $service->getServiceTitle();

        $q = "SELECT serviceTitle FROM Service WHERE serviceTitle = ?";
        $req = $this->db->prepare($q);
        $req->execute([$servTitle]);
        $data = $req->fetch();

        if ($data != NULL) {
            $url = "create_service.php?serviceTypeId=" . $service->getServiceTypeId() . "&error=name_taken";
            header('Location: ' . $url);
            exit;
        } else {
            $q = "INSERT INTO Service(serviceId,serviceTypeId,serviceTitle,description,recurrence,timeMin,servicePrice,commission) VALUES (:serviceId,:serviceTypeId,:serviceTitle,:description,:recurrence,:timeMin,:servicePrice,:commission)";
            $res = $this->db->prepare($q);

            $res->execute(array(
                'serviceId' => $service->getServiceId(),
                'serviceTypeId' => $service->getServiceTypeId(),
                'serviceTitle' => $service->getServiceTitle(),
                'description' => $service->getDescription(),
                'recurrence' => $service->getRecurrence(),
                'timeMin' => $service->getTimeMin(),
                'servicePrice' => $service->getServicePrice(),
                'commission' => $service->getCommission()
            ));
        }
    }

    //Update the service
    public function updateService(Service $service)
    {
        $serviceTitle = $service->getServiceTitle();

        $q = "SELECT serviceTitle FROM Service WHERE serviceTitle = ?";
        $req = $this->db->prepare($q);
        $req->execute([$serviceTitle]);
        $data = $req->fetch();

        if ($data != NULL && $data['serviceId'] != $service->getServiceId()) {
            header('Location: edit_service.php?error=name_taken&id=' . $service->getServiceId());
            exit;
        } else {
            $id = $service->getServiceId();
            $q = "UPDATE Service SET serviceTitle=:serviceTitle,description=:description,recurrence=:recurrence,timeMin=:timeMin,servicePrice=:servicePrice,commission=:commission WHERE serviceId=:id";
            $req = $this->db->prepare($q);
            $req->execute(array(
                'serviceTitle' => $service->getServiceTitle(),
                'description' => $service->getDescription(),
                'recurrence' => $service->getRecurrence(),
                'timeMin' => $service->getTimeMin(),
                'servicePrice' => $service->getServicePrice(),
                'commission' => $service->getCommission(),
                'id' => $id
            ));
        }
    }

    //Get the service
    public function getService($serviceId)
    {
        $q = "SELECT * FROM Service WHERE serviceId = ?";
        $req = $this->db->prepare($q);
        $req->execute([$serviceId]);
        $data = $req->fetch();

        if ($data == NULL)
            return NULL;
        return new Service($data['serviceId'], $data['serviceTypeId'], $data['serviceTitle'], $data['description'], $data['recurrence'], $data['timeMin'], $data['servicePrice'], $data['commission']);
    }

    //Delete the service
    public function deleteService($serviceId)
    {
        $q = "DELETE FROM Service WHERE serviceId =  ?";
        $req = $this->db->prepare($q);
        $req->execute([$serviceId]);

        $q = "DELETE FROM AssociateServices WHERE serviceId =  ?";
        $req = $this->db->prepare($q);
        $req->execute([$serviceId]);

        return 1;
    }

    //Get all the service by service type
    public function getServiceListByType($serviceTypeId)
    {
        $services = [];

        $q = "SELECT * FROM Service WHERE serviceTypeId = ?";
        $req = $this->db->prepare($q);
        $req->execute([$serviceTypeId]);

        while ($data = $req->fetch())
            $services[] = new Service($data['serviceId'], $data['serviceTypeId'], $data['serviceTitle'], $data['description'], $data['recurrence'], $data['timeMin'], $data['servicePrice'], $data['commission']);

        return $services;
    }

    //Add the service type
    public function addServiceType(ServiceType $service)
    {
        $typeName = $service->getTypeName();

        $q = "SELECT typeName FROM ServiceType WHERE typeName = ?";
        $req = $this->db->prepare($q);
        $req->execute([$typeName]);
        $data = $req->fetch();

        if ($data != NULL) {
            header('Location: create_service_type.php?error=name_taken');
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

    //Get the service type
    public function getServiceType($typeId)
    {
        $q = "SELECT serviceTypeId,typeName FROM ServiceType WHERE serviceTypeId = ?";
        $req = $this->db->prepare($q);
        $req->execute([$typeId]);
        $data = $req->fetch();

        if ($data == NULL)
            return NULL;

        return new ServiceType($data['serviceTypeId'], $data['typeName']);
    }

    //Get all the service types
    public function getServiceTypeList()
    {
        $serviceTypes = [];

        $q = "SELECT * FROM ServiceType ORDER BY typeName";
        $req = $this->db->prepare($q);
        $req->execute();
        while ($data = $req->fetch())
            $serviceTypes[] = new ServiceType($data["serviceTypeId"], $data["typeName"]);

        if ($serviceTypes == NULL)
            return NULL;

        return $serviceTypes;
    }

    //Update the service type
    public function updateServiceType(ServiceType $service)
    {
        $typeName = $service->getTypeName();

        $q = "SELECT typeName FROM ServiceType WHERE typeName = ?";
        $req = $this->db->prepare($q);
        $req->execute([$typeName]);
        $data = $req->fetch();

        if ($data != NULL && $data['serviceTypeId'] != $service->getServiceTypeId()) {
            header('Location: edit_service_type.php?error=name_taken&id=' . $service->getServiceTypeId());
            exit;
        } else {
            $id = $service->getServiceTypeId();
            $q = "UPDATE ServiceType SET typeName=:typeName WHERE serviceTypeId=:id";
            $req = $this->db->prepare($q);
            $req->execute(array(
                'typeName' => $service->getTypeName(),
                'id' => $id
            ));
        }
    }

    //Delete service type
    public function deleteServiceType($typeId)
    {
        $q = "DELETE FROM ServiceType WHERE serviceTypeId = ?";
        $req = $this->db->prepare($q);
        $req->execute([$typeId]);
    }

    //AssociateServices get associate with the service id
    public function getAssociateServicesList($serviceId)
    {
        $associatesId = [];

        $q = "SELECT * FROM AssociateServices WHERE serviceId =";
        $req = $this->db->prepare($q);
        $req->execute([$serviceId]);

        while ($data = $req->fetch())
            $associatesId[] = new AssociateServices($data['serviceId'], $data['associateId']);


        $associates = [];
        foreach ($associatesId as $associateId) {
            array_push($associates, $this->getAssociate($associateId->getAssociateId()));
        }

        return $associates;
    }

    //Get additional price
    public function getAdditionalPrice($serviceProvidedId)
    {
        $additionalPrices = [];

        $q = "SELECT * FROM AdditionalPrice WHERE serviceProvidedId =";
        $req = $this->db->prepare($q);
        $req->execute([$serviceProvidedId]);

        while ($data = $req->fetch())
            $additionalPrices[] = new AdditionalPrice($data['additionalPriceId'], $data['serviceProvidedId'], $data['description'], $data['price']);
        
        return $additionalPrices;
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
            exit;
        }
        return new Associate($data['associateId'], $data['lastName'], $data['firstName'], $data['email'], $data['phoneNumber'], $data['address'], $data['town'], $data['sirenNumber'], $data['companyName'], $data['enable'], $data['password']);
    }

    public function getAssociateList()
    {
        $associates = [];

        $q = $this->db->query('SELECT * FROM Associate ORDER BY lastName');

        while ($data = $q->fetch()) {
            $associates[] = new Associate($data['associateId'], $data['lastName'], $data['firstName'], $data['email'], $data['phoneNumber'], $data['address'], $data['town'], $data['sirenNumber'], $data['companyName'], $data['enable'], $data['password']);
        }

        return $associates;
    }


    //Give the propose to the associate
    public function proposalToAssociate(Proposal $proposal)
    {
        $q = "INSERT INTO Proposal(serviceProvidedId,status,associateId) VALUES (:serviceProvidedId,:status,:associateId)";
        $res = $this->db->prepare($q);
        $res->execute(array(
            'serviceProvidedId' => $proposal->getServiceProvidedId(),
            'status' => $proposal->getStatus(),
            'associateId' => $proposal->getAssociateId()
        ));
    }

    public function addServiceToAssociate($serviceId, $associateId)
    {
        $q = "INSERT INTO AssociateServices(serviceId,associateId) VALUES (:serviceId,:associateId)";
        $res = $this->db->prepare($q);
        $res->execute(array(
            'serviceId' => $serviceId,
            'associateId' => $associateId
        ));
    }

    public function getServiceListAssociate($associateId)
    {
        $servicesId = [];

        $q = $this->db->query('SELECT * FROM AssociateServices WHERE associateId = ' . $associateId . '');

        while ($data = $q->fetch()) {
            $servicesId[] = new AssociateServices($data['serviceId'], $data['associateId']);
        }

        $services = [];
        foreach ($servicesId as $serviceId) {
            array_push($services, $this->getService($serviceId->getServiceId()));
        }

        return $services;
    }

    public function deleteAssociateService($serviceId, $associateId)
    {
        $this->db->exec("DELETE FROM AssociateServices WHERE associateId = '" . $associateId . "'" . "AND serviceId = '" . $serviceId . "'");
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

    public function deleteProposal($associateId, $serviceProvidedId)
    {
        $this->db->exec("DELETE FROM Proposal WHERE associateId = '" . $associateId . "'" . "AND serviceProvidedId = '" . $serviceProvidedId . "'");
    }

    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
* * * * * * * * * * * * * * * * BILL PART * * * * * * * * * * * * * * * * *
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

    public function getBillList()
    {

        $bills = [];

        $q = $this->db->query('SELECT * FROM Bill ORDER BY billId');

        while ($data = $q->fetch()) {
            $bills[] = new Bill($data['billId'], $data['paidStatus'], $data['customerId'], $data['customerLastName'], $data['customerFirstName'], $data['customerAddress'], $data['customerTown'], $data['email'], $data['date'], $data['serviceTitle'], $data['totalPrice'], $data['serviceProvidedId']);
        }

        return $bills;
    }

    public function getBill($billId)
    {
        $billId = (int) $billId;
        $q = $this->db->query('SELECT * FROM Bill WHERE billId = ' . $billId . '');

        $data = $q->fetch();

        return new Bill($data['billId'], $data['paidStatus'], $data['customerId'], $data['customerLastName'], $data['customerFirstName'], $data['customerAddress'], $data['customerTown'], $data['email'], $data['date'], $data['serviceTitle'], $data['totalPrice'], $data['serviceProvidedId']);
    }
}
