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

if (
    isset($_POST['serviceProvidedId']) && !empty($_POST['serviceProvidedId'])
    && is_numeric($_POST['totalAdditionalPrice'])
    && is_numeric($_POST['hoursAssociate'])

) {
    require_once('include/check_identity.php');
    if (!($status == 'associate' && $connected == 1)) {

        header('Location: connect.php?status=associate&error=forb');
        exit;
    }

    date_default_timezone_set('Europe/Paris');

    $serviceProvidedId = $_POST['serviceProvidedId'];
    $hoursAssociate = $_POST['hoursAssociate'];
    $totalAdditionalPrice = $_POST['totalAdditionalPrice'];

    $additionalPrices = [];
    if ($totalAdditionalPrice == 0) {
        $additionalPrices = NULL;
    } else {
        for ($i = 1; $i <= $totalAdditionalPrice; $i++) {

            $issetDescription = "description" . $i;
            isset($_POST[$issetDescription]);
            $description = $_POST[$issetDescription];

            $issetPrice = "price" . $i;
            isset($_POST[$issetPrice]);
            $price = $_POST[$issetPrice];

            $additionalPriceId = hash('sha256', $description . $price . date('dMY-H:m:s'));

            $additionalPrice = new AdditionalPrice($additionalPriceId, $serviceProvidedId, $description, $price);
            array_push($additionalPrices, $additionalPrice);
        }
    }

    $reservation = $hm_database->getReservationByServiceProvidedId($serviceProvidedId);
    $customerId = $reservation->getCustomerId();
    $customer = $hm_database->getCustomer($customerId);
    $email = $customer->getId();
    $billId = $hm_database->getLastIdBill();
    $serviceProvided = $hm_database->getServiceProvided($serviceProvidedId);
    $service = $hm_database->getService($serviceProvided->getServiceId());

    //Associate
    $associate = $hm_database->getAssociateById($id);

    //AssociateBill
    $associateBillId = $hm_database->getLastIdAssociateBill();
    $billDate = $serviceProvided->getDate();
    $paidSatus = 0;

    $totalAdd = 0;
    if ($additionalPrices != NULL) {
        foreach ($additionalPrices as $additionalP) {
            $totalAdd += $additionalP->getPrice();
        }
    }

    $result = $hm_database->remainingHours($customer->getId(), $hoursAssociate);

    if ($result == NULL) {

        $paidSatus = 0;
    } else {

        $paidSatus = 1;
    }


    $estimates = $hm_database->getEstimateListByCustomerId($customerId);
    if (!empty($estimates)) {
        foreach ($estimates as $estimate) {
            // echo $estimate;
            $estimateServiceProvidedDate = $estimate->getServiceProvidedDate();
            $estimateServiceProvidedHour = $estimate->getServiceProvidedHour();

            $diffDate = dateSubtraction(strtotime($estimateServiceProvidedDate), strtotime($serviceProvided->getDate()));
            $diffHour = dateSubtraction(strtotime($estimateServiceProvidedHour), strtotime($serviceProvided->getBeginHour()));

            if (
                $estimate->getServiceId() == $service->getServiceId()
                && $diffDate['day'] == 0
                && $diffHour['hour'] == 0
            ) {
                $totalPrice = $estimate->getTotalPrice() + $totalAdd;
            } else {
                $totalPrice = ($service->getServicePrice() * $hoursAssociate) + $totalAdd;
            }
        }
    } else {
        $totalPrice = ($service->getServicePrice() * $hoursAssociate) + $totalAdd;
    }

    $bill = new Bill($billId, $paidSatus, $customerId, $customer->getLastname(), $customer->getFirstname(), $customer->getAddress(), $customer->getCity(), $customer->getMail(), $serviceProvided->getDate(), $service->getServiceTitle(), $totalPrice, $serviceProvidedId);
    $totalPrice = $totalPrice - ($totalPrice * $service->getCommission());
    $associateBill = new AssociateBill($associateBillId, $billDate, $paidSatus, $id, $associate->getLastName(), $associate->getFirstName(), $associate->getAddress(), $associate->getTown(), $associate->getEmail(), $associate->getSirenNumber(), $associate->getCompanyName(), $service->getServiceTitle(), $totalPrice, $serviceProvidedId);

    $hm_database->addAssociateBill($associateBill);
    $hm_database->endServiceProvided($serviceProvidedId, $hoursAssociate, $additionalPrices, $bill, $associateBill);

    $url = "associate_services_provided.php?ending=successful";
    header('Location: ' . $url);
    exit;
} else {
    $url = "associate_services_provided.php?ending=error";
    header('Location: ' . $url);
    exit;
}
