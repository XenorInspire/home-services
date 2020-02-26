<?php

require_once('include/config.php');
require_once('class/subscriptionType.php');

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
        $q = "INSERT INTO subscriptionType(typeId,typeName,openDays,openTime,closeTime,serviceTimeAmount,price) VALUES (:typeId,:typeName,:openDays,:openTime,:closeTime,:serviceTimeAmount,:price)";
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

    public function getSubscriptionTypeList(){
        $subscriptions = [];

        $q = $this->db->query('SELECT typeId,typeName,openDays,openTime,closeTime,serviceTimeAmount,price FROM subscriptionType ORDER BY typeName');

        while ($data = $q->fetch(PDO::FETCH_ASSOC)) {
            $subscriptions[] = new SubscriptionType($data['typeId'],$data['typeName'], $data['openDays'], $data['openTime'], $data['closeTime'], $data['serviceTimeAmount'], $data['price']);
        }

        return $subscriptions;
    }
}
