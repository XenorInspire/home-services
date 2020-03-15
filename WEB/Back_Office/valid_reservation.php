<?php
require_once('class/DBManager.php');

if (
    isset($_POST['serviceProvidedId']) && !empty($_POST['serviceProvidedId'])
    && is_numeric($_POST['status'])
    && isset($_POST['associateId']) && !empty($_POST['associateId'])
) {

    // all verif with if

    $hm_database = new DBManager($bdd);

    $proposal = new Proposal($_POST['serviceProvidedId'], $_POST['status'], $_POST['associateId']);

    $hm_database->proposalToAssociate($proposal);

    header('Location: reservations.php?proposal=successful');
    exit;
} else {

    header('Location: reservations.php?error=inputs_inv');
    exit;
}
