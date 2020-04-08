<?php

if (!isset($_GET['i']) || empty($_GET['i'])) {

    header('Location: shop.php');
    exit;
}

// Connexion à la base de données
require_once('class/DBManager.php');
$hm_database = new DBManager($bdd);

if (($service = $hm_database->getService($_GET['i'])) == NULL) {

    header('Location: shop.php');
    exit;
}

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
    isset($_POST['date']) && !empty(trim($_POST['date'])) && isset($_POST['beginHour']) && !empty(trim($_POST['beginHour'])) && isset($_POST['hours'])
    && !empty(trim($_POST['hours'])) && isset($_POST['address']) && !empty(trim($_POST['address'])) && isset($_POST['town']) && !empty(trim($_POST['town']))
) {

    if (is_numeric($_POST['address']) || is_numeric($_POST['town'])) {

        header('Location: book_service.php?i=' . $_GET['i'] . '&error=inp');
        exit;
    }

    if(!is_numeric($_POST['hours']) || $_POST['hours'] <= 0 || $_POST['hours'] > 24){

        header('Location: book_service.php?i=' . $_GET['i'] . '&error=hours');
        exit; 

    }

    if(dateSubtraction(strtotime($_POST['date']),time())['day'] < 0){

        header('Location: book_service.php?i=' . $_GET['i'] . '&error=date');
        exit;

    }

    require_once('include/check_identity.php');

    $serviceProvided = new ServiceProvided(NULL, $service->getServiceId(), $_POST['date'], $_POST['beginHour'], $_POST['hours'], NULL, $_POST['address'], $_POST['town']);
    $serviceProvided->setServiceProvidedId($user->getId(), $service->getServiceId());

    date_default_timezone_set('Europe/Paris');
    $reservationDate = date("Y-m-d");
    $reservation = new Reservation(NULL, $reservationDate, $user->getId(), $serviceProvided->getServiceProvidedId(), 0);
    $reservation->setReservationId($user->getId(), $serviceProvided->getServiceProvidedId());

    $hm_database->addReservation($user, $reservation, $serviceProvided);

    header('Location: shop.php?info=success');
    exit;

} else {

    header('Location: book_service.php?i=' . $_GET['i'] . '&error=inp');
    exit;
}
