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

if (!isset($_GET['mode']) || empty($_GET['mode'])) {

    header('Location: orders.php');
    exit;
}

require_once('include/check_identity.php');
if ($connected != 1 || $status != "customer") {

    header('Location: orders.php');
    exit;
}
$hm_database = new DBManager($bdd);

if ($_GET['mode'] == 1) {

    if (($subscription = $hm_database->checkSubscription($id)) == NULL) {

        header('Location: orders.php');
        exit;
    }

    $customer = $hm_database->getUserById($id);
    $resultBill = $hm_database->getLastSubscriptionBill($customer->getId());

    if ($resultBill == NULL || dateSubtraction(strtotime($resultBill['billDate']) + (365 * 24 * 60 * 60), time()) > 365) {

        $subscriptionType = $hm_database->getSubscriptionTypeById($subscription->getTypeId());
        $hm_database->addSubscriptionBill($customer, $subscriptionType, $subscription->getBeginDate());
        $url = "subscription_bill.php?id=" . ($resultBill['billId'] + 1);
    } else {

        $url = "subscription_bill.php?id=" . $resultBill['billId'];
    }

    header('Location: ' . $url);
    exit;
}
