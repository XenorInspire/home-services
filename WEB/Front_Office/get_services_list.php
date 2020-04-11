<?php

if (!isset($_POST['select']) || empty(trim($_POST['select']))) {

    http_response_code(400);
    echo http_response_code();
    return;
}

// Connexion à la base de données
require_once('class/DBManager.php');
$hm_database = new DBManager($bdd);

if (($serviceType = $hm_database->getServiceTypeByName($_POST['select'])) == NULL) {

    http_response_code(400);
    echo http_response_code();
    return;
}

$services = $hm_database->getServiceListByType($serviceType->getServiceTypeId());

echo '<table class="table">';
echo '<thead class="thead-dark">';
echo    '<tr>';
echo    '<th scope="col">Catégorie</th>';
echo    '<th scope="col">Service</th>';
echo    '<th scope="col">Prix</th>';
echo    '<th scope="col"></th>';
echo    '</tr>';
echo  '</thead>';
echo  '<tbody id="myTable">';

for ($i = 0; $i < count($services); $i++) {

    echo '<tr>';
    echo '<td>' . $serviceType->getTypeName() . '</td>';
    echo '<td>' . $services[$i]->getServiceTitle() . '</td>';
    echo '<td>' . $services[$i]->getServicePrice() . '€/h</td>';
    echo '<td><button type="button" class="btn btn-primary mb-2" onclick="window.location.href = \'book_service.php?i=' . $services[$i]->getServiceId() . '\';">Réserver</button></td>';
    echo '</tr>';
}

echo '</tbody>';
echo '</table>';
