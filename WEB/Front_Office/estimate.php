<?php
require_once('include/check_identity.php');
if (!($status == 'customer' && $connected == 1)) {
    header('Location: connect.php?status=customer&error=forb');
    exit;
}

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: estimates.php");
    exit;
}

$estimateId = $_GET['id'];

$estimate = $hm_database->getEstimate($estimateId);

if ($estimate == NULL) {
    header("Location: estimates.php");
    exit;
}

if ($estimate->getCustomerId() != $id) {
    header("Location: estimates.php");
    exit;
}

$service = $hm_database->getService($estimate->getServiceId());
if ($service == NULL) {
    header("Location: estimates.php");
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

$estimateDate = $estimate->getEstimateDate();
$serviceProvidedDate = $estimate->getServiceProvidedDate();

$diffEstimateToday = dateSubtraction(strtotime($estimateDate), strtotime($today));
$diffServiceToday = dateSubtraction(strtotime($serviceProvidedDate), strtotime($today));

if ($diffEstimateToday['day'] < 0 || $diffServiceToday['day'] < 0) {
    header("Location: estimates.php");
    exit;
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

        <div class="container">
            <br>
            <h1 class="text-center"><?= $estimatePage['title'] ?></h1>
            <br>
            <form action="book_service.php?i=<?= $estimate->getServiceId() ?>" method="POST">

                <div class="form-group">
                    <label><?= $estimatePage['service'] ?></label>
                    <input type="text" class="form-control" value="<?= $service->getServiceTitle() ?>" readonly>
                </div>
                <div class="form-group">
                    <label><?= $estimatePage['description'] ?></label>
                    <input type="text" class="form-control" value="<?= $service->getDescription() ?>" readonly>
                </div>
                <div class="form-group">
                    <label><?= $estimatePage['date'] ?></label>
                    <input type="text" class="form-control" value="<?= $estimate->getEstimateDate() ?>" readonly>
                </div>
                <div class="form-group">
                    <label></label><?= $estimatePage['serviceDate'] ?>
                    <input type="text" class="form-control" name="date" value="<?= $estimate->getServiceProvidedDate() ?>" readonly>
                </div>
                <div class="form-group">
                    <label><?= $estimatePage['serviceHour'] ?></label>
                    <input type="text" class="form-control" name="beginHour" value="<?= $estimate->getServiceProvidedHour() ?>" readonly>
                </div>
                <div class="form-group">
                    <label><?= $estimatePage['hours'] ?></label>
                    <input type="text" class="form-control" name="hours" value="<?= $estimate->getHours() ?>" readonly>
                </div>
                <div class="form-group">
                    <label><?= $estimatePage['address'] ?></label>
                    <input type="text" class="form-control" name="address" value="<?= $estimate->getCustomerAddress() ?>" readonly>
                </div>
                <div class="form-group">
                    <label><?= $estimatePage['town'] ?></label>
                    <input type="text" class="form-control" name="town" value="<?= $estimate->getCustomerTown() ?>" readonly>
                </div>
                <div class="form-group">
                    <label><?= $estimatePage['price'] ?></label>
                    <input type="text" class="form-control" name="totalPrice" value="<?= $estimate->getTotalPrice() ?>" readonly>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-md mb-3">
                            <button type="button" class="btn btn-primary btn-block" onclick="window.open('generate_estimate.php?i=<?= $estimate->getEstimateId() ?>');"><?= $estimatePage['generate'] ?></button>
                        </div>
                        <div class="col-md mb-3">
                            <button type="submit" class="btn btn-primary btn-block"><?= $estimatePage['book'] ?></button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </main>
    <?php require_once("include/footer.php"); ?>
</body>

</html>