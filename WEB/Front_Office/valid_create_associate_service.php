<?php
require_once('class/DBManager.php');

if (
    isset($_POST['associateId']) && !empty($_POST['associateId'])
    && isset($_POST['serviceId']) && !empty($_POST['serviceId'])
) {
    $associateId = $_POST['associateId'];
    $serviceId = $_POST['serviceId'];

    $hm_database = new DBManager($bdd);

    $hm_database->addServiceToAssociate($serviceId, $associateId);

    $url = "associate_services.php?&create=successful";
    header('Location: ' . $url);
    exit;
} else {
    $url = "associate_services.php?error";
    header('Location: ' . $url);
    exit;
}
