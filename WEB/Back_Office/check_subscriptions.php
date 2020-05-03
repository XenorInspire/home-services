<?php

function dateSubtraction($date1, $date2)
{
    $sub = abs($date1 - $date2); // abs pour avoir la valeur absolute, ainsi éviter d'avoir une différence négative
    $result = array();

    $tmp = $sub;
    $result['second'] = $tmp % 60;

    $tmp = floor(($tmp - $result['second']) / 60);
    $result['minute'] = $tmp % 60;

    $tmp = floor(($tmp - $result['minute']) / 60);
    $result['hour'] = $tmp % 24;

    $tmp = floor(($tmp - $result['hour'])  / 24);
    $result['day'] = $tmp;

    return $result;
}

require_once('class/DBManager.php');
$hm_database = new DBManager($bdd);

$q = "SELECT Customer.email,Customer.customerId,Subscription.beginDate FROM Customer,Subscription,SubscriptionBill WHERE SubscriptionBill.active = 1 AND Customer.customerId = SubscriptionBill.customerId AND Customer.customerId = Subscription.customerId";
$req = $hm_database->getDb()->prepare($q);
$req->execute();

while ($data = $req->fetch()) {

    $sub = dateSubtraction(strtotime($data['beginDate']) + (365 * 24 * 60 * 60), time());
    $sub['day']++;

    if ($sub['day'] <= 0) {

        system('python3 mail/mail.py delete_subscription ' . $data['email']);
        $hm_database->deleteSubscription($date['customerId']);
    } elseif ($sub['day'] < 30) {

        system('python3 mail/mail.py subscription_30_days ' . $data['email']);
    }
}
