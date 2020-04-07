<?php
require_once('class/DBManager.php');

if (
    isset($_POST['customerId']) && !empty($_POST['customerId'])
    && !empty($_POST['date'])
    && !empty($_POST['beginHour'])
    && is_numeric($_POST['hours']) && !empty($_POST['hours'])
    && isset($_POST['serviceId']) && !empty($_POST['serviceId'])
    && isset($_POST['address']) && !empty($_POST['address'])
    && isset($_POST['town']) && !empty($_POST['town'])
) {
    $hm_database = new DBManager($bdd);

    $customerId = $_POST['customerId'];
    $date = $_POST['date'];
    $beginHour = $_POST['beginHour'];
    $hours = $_POST['hours'];
    $serviceId = $_POST['serviceId'];
    $address = $_POST['address'];
    $town = $_POST['town'];

    date_default_timezone_set('Europe/Paris');

    //Customer
    $customer = new Customer($customerId, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

    //ServiceProvided
    $serviceProvidedId = hash('sha256', $customerId . $serviceId . date('dMY-H:m:s'));
    $serviceProvided = new ServiceProvided($serviceProvidedId, $serviceId, $date, $beginHour, $hours, NULL, $address, $town);

    //Reservation
    $reservationId = hash('sha256', $customerId . $serviceProvidedId);
    $reservationDate = date("Y-m-d");
    $reservation = new Reservation($reservationId, $reservationDate, $customerId, $serviceProvidedId, 0);

    $hm_database->addReservation($customer, $reservation, $serviceProvided);

    header('Location: reservations.php?create=successful');
    exit;
} else {

    header('Location: edit_customer.php?customerId='. $customerId.'&error=inputs_inv');
    exit;
}