<?php
require_once('class/DBManager.php');

if (
    isset($_POST['serviceTitle']) && !empty($_POST['serviceTitle'])
    && isset($_POST['description']) && !empty($_POST['description'])
    && isset($_POST['recurrence'])
    && is_numeric($_POST['timeMin']) && !empty($_POST['timeMin'])
    && is_numeric($_POST['servicePrice']) && !empty($_POST['servicePrice'])
    && is_numeric($_POST['commission']) && !empty($_POST['commission'])
    && isset($_POST['serviceTypeId']) && !empty($_POST['serviceTypeId'])
    && isset($_POST['serviceId']) && !empty($_POST['serviceId'])
) {

    $hm_database = new DBManager($bdd);

    $serviceTitle = $_POST['serviceTitle'];
    $description = $_POST['description'];
    $recurrence = $_POST['recurrence'];
    $timeMin = $_POST['timeMin'];
    $servicePrice = $_POST['servicePrice'];
    $commission = $_POST['commission'];
    $serviceTypeId = $_POST['serviceTypeId'];
    $serviceId =  $_POST['serviceId'];

    $service = new Service($serviceId, $serviceTypeId, $serviceTitle, $description, $recurrence, $timeMin, $servicePrice, $commission);

    $hm_database->updateService($service);

    $url = "services.php?serviceTypeId=" . $service->getServiceTypeId() . "&edit=successful";
    header('Location: ' . $url);
    exit;
} else {
    $url = "services.php?serviceTypeId=" . $service->getServiceTypeId() . "&error=inputs_inv";
    header('Location: ' . $url);
    exit;
}
