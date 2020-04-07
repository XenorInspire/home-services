<?php
if (
    isset($_POST['serviceProvidedId']) && !empty($_POST['serviceProvidedId'])
    && is_numeric($_POST['totalAdditionalPrice'])
    && is_numeric($_POST['hoursAssociate'])

) {
    require_once('class/DBManager.php');
    $hm_database = new DBManager($bdd);

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

    $hm_database->endServiceProvided($serviceProvidedId,$hoursAssociate,$additionalPrices);

    $url = "associate_services_provided.php?ending=successful";
    header('Location: ' . $url);
    exit;
} else {
    $url = "associate_services_provided.php?ending=error";
    header('Location: ' . $url);
    exit;
}
