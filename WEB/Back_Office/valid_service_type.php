<?php

require_once('class/DBManager.php');

if ( isset($_POST['typeName']) && !empty($_POST['typeName']) ) {

    // all verif with if

	$hm_database = new DBManager($bdd);

	$hashiD = hash('sha256', $_POST['typeName'] . date('dMY-H:m:s'));
	$serviceType = new ServiceType($hashiD, $_POST['typeName']);

	$hm_database->addServiceType($serviceType);

	header('Location: service_types.php?create=successful');
	exit;

} else {

	header('Location: service_types.php?error=inputs_inv');
	exit;
}
