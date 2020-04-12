<?php

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

    $resultBill = $hm_database->getLastSubscriptionBill($id);

    header('Location: subscription_bill.php?id=' . $resultBill['billId']);
    exit;
} elseif ($_GET['mode'] == 2) {

    if (!isset($_GET['sp']) || empty($_GET['sp'])) {

        header('Location: orders.php');
        exit;
    }

    if (($bill = $hm_database->checkBill($_GET['sp'])) == NULL) {

        header('Location: orders.php');
        exit;
    }

    if (($reservation = $hm_database->getReservationByServiceProvidedId($_GET['sp'])) == NULL) {

        header('Location: orders.php');
        exit;
    }

    if ($reservation->getCustomerId() != $user->getId()) {

        header('Location: orders.php');
        exit;
    }

    header('Location: service_bill.php?i=' . $bill['billId']);
    exit;
} elseif ($_GET['mode'] == 3) {

    if (!isset($_GET['i']) || empty($_GET['i'])) {

        header('Location: orders.php?test=3');
        exit;
    }

    if (($oldSubscriptions = $hm_database->getInactiveSubscriptionsByCustomerId($id)) == NULL) {

        header('Location: orders.php?test=2');
        exit;
    }

    $set = 0;

    for ($i = 0; $i < count($oldSubscriptions); $i++) {

        if (in_array($_GET['i'], $oldSubscriptions[$i])) {
            $set = 1;
            break;
        }
    }

    if ($set == 0) {

        header('Location: orders.php?test=3');
        exit;
    }

    header('Location: subscription_bill.php?id=' . $_GET['i']);
    exit;
} else {

    header('Location: orders.php');
    exit;
}
