<?php

if (!isset($_GET['mode']) || empty($_GET['mode'])) {

    header('Location: orders.php');
    exit;
}

require_once('include/check_identity.php');
if ($connected != 1) {

    header('Location: index.php');
    exit;
}
$hm_database = new DBManager($bdd);

if ($_GET['mode'] == 1) {

    if (($subscription = $hm_database->checkSubscription($id)) == NULL) {

        header('Location: orders.php');
        exit;
    }

    $customer = $hm_database->getUserById($id);
    $subscriptionType = $hm_database->getSubscriptionTypeById($subscription->getTypeId());
    $hm_database->addSubscriptionBill($customer, $subscriptionType);

    header('Location: pdf/subscription_bill.php?id=' . $hm_database->getLastIdSubscriptionBill($customer->getId()));
    exit;
}
