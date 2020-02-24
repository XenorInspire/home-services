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

    public function addSubscriotionType(SubscriptionType $subscription){
        $q = "INSERT INTO subscriotionType(typeId,typeName,openDays,openTime,closeTime,serviceTimeAmount,price) VALUES (:typeId,:typeName,:openDays,:openTime,:closeTime,:serviceTimeAmount,:price)";
        $res = $this->db->prepare($q);
        $res->execute(array(
            'typeId' => $subscription->getTypeId(),
            'typeName' => $subscription->getTypeName(),
            'openDays' => $subscription->getOpenDays(),
            'openTime' => $subscription->getOpenTime(),
            'closeTime' => $subscription->getCloseTime(),
            'serviceTimeAmount' => $subscription->getServiceTimeAmount(),
            'price' => $user->getCity(),
        ));
    }
}
