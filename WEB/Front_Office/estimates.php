<?php
require_once('include/check_identity.php');

if (!($status == 'customer' && $connected == 1)) {
    header('Location: connect.php?status=customer&error=forb');
    exit;
}
$hm_database = new DBManager($bdd);
$customer = $hm_database->getUserById($id);
$estimates = $hm_database->getEstimateListByCustomerId($customer->getId());

if (empty($estimates)) {
    header("Location: index.php");
    exit;
}

date_default_timezone_set('Europe/Paris');
$today = date("Y-m-d");

function dateSubtraction($date1, $date2)
{
    $sub = $date1 - $date2;
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
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home Services - Mes commandes</title>
    <link rel="icon" sizes="32x32" type="image/png" href="img/favicon.png" />
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>

<body>

    <?php require_once("include/header.php"); ?>

    <main>

        <div class="container text-center">
            <br>
            <h1><?= $estimatesPage['title'] ?></h1>
            <br>
            <table class="table">
                <thead class="thead-dark">
                    <tr>
                        <th><?= $estimatesPage['date'] ?></th>
                        <th><?= $estimatesPage['service'] ?></th>
                        <th><?= $estimatesPage['price'] ?></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $isEstimate = FALSE;
                    foreach ($estimates as $estimate) {
                        $service = $hm_database->getService($estimate->getServiceId());
                        $estimateDate = $estimate->getEstimateDate();
                        $serviceProvidedDate = $estimate->getServiceProvidedDate();

                        $diffEstimateToday = dateSubtraction(strtotime($estimateDate), strtotime($today));
                        $diffServiceToday = dateSubtraction(strtotime($serviceProvidedDate), strtotime($today));

                        if ($diffEstimateToday['day'] >= 0 && $diffServiceToday['day'] >= 0 && $service != NULL) {
                    ?>
                            <tr>
                                <td><?= $estimate->getEstimateDate() ?></td>
                                <td><?= $service->getServiceTitle() ?></td>
                                <td><?= $estimate->getTotalPrice() ?>€</td>
                                <td><button type="button" class="btn btn-primary mb-2" onclick="window.location.href = 'estimate.php?id=<?= $estimate->getEstimateId() ?>';"><?= $estimatesPage['action'] ?></button></td>
                            </tr>
                    <?php
                            $isEstimate = TRUE;
                        }
                    }
                    if (!$isEstimate) {
                        header('Location: orders.php');
                        exit;
                    }

                    ?>

                </tbody>
            </table>
        </div>
    </main>
    <?php require_once("include/footer.php"); ?>
</body>

</html>