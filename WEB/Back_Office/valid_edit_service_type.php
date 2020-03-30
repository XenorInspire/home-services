<?php
require_once('class/DBManager.php');

if (
    isset($_POST['id']) && !empty($_POST['id']) &&
    isset($_POST['typeName']) && !empty($_POST['typeName'])
) {

    // all verif with if

    $hm_database = new DBManager($bdd);

    $service = new ServiceType($_POST['id'], $_POST['typeName']);

    $hm_database->updateServiceType($service);

    header('Location: service_types.php?edit=successful');
    exit;
} else {

    header('Location: service_types.php?error=inputs_inv');
    exit;
}
