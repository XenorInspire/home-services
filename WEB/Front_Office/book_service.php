    <?php
    require_once('include/check_identity.php');

    if (!($status == 'customer' && $connected == 1)) {

        header('Location: connect.php?status=customer&error=forb');
        exit;
    }

    if (!isset($_GET['i']) || empty($_GET['i'])) {

        header('Location: shop.php');
        exit;
    }

    $hm_database = new DBManager($bdd);
    if (($service = $hm_database->getService($_GET['i'])) == NULL) {

        header('Location: shop.php');
        exit;
    }

    $isEstimate = FALSE;
    if (
        isset($_POST['date']) && !empty(trim($_POST['date'])) && isset($_POST['beginHour']) && !empty(trim($_POST['beginHour'])) && isset($_POST['hours'])
        && !empty(trim($_POST['hours'])) && isset($_POST['address']) && !empty(trim($_POST['address'])) && isset($_POST['town']) && !empty(trim($_POST['town'])
            && is_numeric($_POST['totalPrice']))
    ) {
        $isEstimate = TRUE;
        $date = $_POST['date'];
        $beginHour = $_POST['beginHour'];
        $hours = $_POST['hours'];
        $address = $_POST['address'];
        $town = $_POST['town'];
        $totalPrice = $_POST['totalPrice'];
    }

    $canBeBooked = 1;

    ?>

    <!DOCTYPE html>
    <html lang="en" dir="ltr">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Home Services - <?= $service->getServiceTitle() ?></title>
        <link rel="icon" sizes="32x32" type="image/png" href="img/favicon.png" />
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/bootstrap.min.css">
    </head>

    <body>

        <?php require_once("include/header.php"); ?>

        <main>

            <section class="container text-center">

                <br>
                <br>
                <br>
                <h1><?= $service->getServiceTitle() ?></h1>
                <br>

                <?php

                if (($subscription = $hm_database->checkSubscription($id)) != NULL) {


                    if ($service->getTimeMin() > $subscription->getRemainingHours()) {

                        echo '<div class="alert alert-danger alert-dimissible text-center" class="close" data-dismiss="alert" role="alert">Il ne vous reste plus assez d\'heures dans votre abonnement.</div>';
                        echo '<br>';
                        $canBeBooked = 0;
                    } else {

                        echo '<div class="alert alert-success alert-dimissible text-center" class="close" data-dismiss="alert" role="alert">Il vous reste ' . $subscription->getRemainingHours() . ' heures dans votre abonnement</div>';
                        echo '<br>';

                        $subscriptionType = $hm_database->getSubscriptionTypeById($subscription->getTypeId());
                    }
                }

                if (isset($_GET['error'])) {


                    if ($_GET['error'] == 'inp') {

                        echo '<div class="alert alert-danger alert-dimissible text-center" class="close" data-dismiss="alert" role="alert">' . $book_service['invalidInput'] . '</div>';
                        echo '<br>';
                    }

                    if ($_GET['error'] == 'date') {

                        echo '<div class="alert alert-danger alert-dimissible text-center" class="close" data-dismiss="alert" role="alert">' . $book_service['invalidDate'] . '</div>';
                        echo '<br>';
                    }

                    if ($_GET['error'] == 'hours') {

                        echo '<div class="alert alert-danger alert-dimissible text-center" class="close" data-dismiss="alert" role="alert">' . $book_service['serviceTimeMin'] . $service->getTimeMin() . $book_service['serviceTimeMax'] . '</div>';
                        echo '<br>';
                    }

                    if ($_GET['error'] == 'rem_hours') {

                        echo '<div class="alert alert-danger alert-dimissible text-center" class="close" data-dismiss="alert" role="alert">Il ne vous reste plus assez d\'heures dans votre abonnement.</div>';
                        echo '<br>';
                    }
                }

                ?>

                <ul style="margin:auto;width:50%;padding:0px;">
                    <li class="list-group-item list-group-item-info"><?= $service->getDescription() ?></li>
                    <li class="list-group-item"> <?= $book_service['minimum'] ?> <?= $service->getTimeMin() ?>h</li>
                    <li class="list-group-item"><?= $book_service['price'] ?><?php
                                                                                if ($isEstimate)
                                                                                    echo $totalPrice;
                                                                                else
                                                                                    echo $service->getServicePrice();
                                                                                ?>€ <?= $book_service['tax'] ?></li>
                    <br>
                    <?php

                    if ($canBeBooked == 1) {

                    ?>

                        <form class="container-fluid" action="insert_reservation.php?i=<?= $service->getServiceId() ?>" style="padding: 0px;" method="POST">
                            <div class="form-group">
                                <label><?= $book_service['serviceDate'] ?></label>
                                <input type="date" name="date" min="<?= date('Y-m-d') ?>" class="form-control" value="<?php if ($isEstimate) echo $date; ?>" <?php if ($isEstimate) echo "readonly";
                                                                                                                                                                else echo "required"; ?>>

                                <?php

                                if ($subscription != NULL)
                                    $parts1 = explode(".", $subscriptionType->getBeginTime());
                                    $parts2 = explode(".", $subscriptionType->getEndTime());

                                ?>

                            </div>
                            <div class="form-group">
                                <label><?= $book_service['serviceHour'] ?></label>
                                <input type="time" name="beginHour" min="<?php if ($subscription != NULL && $parts1[0] != "24:00:00") echo $parts1[0]; ?>" max="<?php if ($subscription != NULL) echo $parts2[0]; ?>" class="form-control" value="<?php if ($isEstimate) echo $beginHour; ?>" <?php if ($isEstimate) echo "readonly";
                                                                                                                                                                                                                                                                                                                        else echo "required"; ?>>
                            </div>
                            <div class="form-group">
                                <label><?= $book_service['hourAmount'] ?></label>
                                <input type="number" name="hours" min="<?= $service->getTimeMin() ?>" max="<?php if ($subscription != NULL  && $subscription->getRemainingHours() < 24) {
                                                                                                                echo $subscription->getRemainingHours();
                                                                                                            } else {
                                                                                                                echo "24";
                                                                                                            }  ?>" class="form-control" value="<?php if ($isEstimate) echo $hours; ?>" <?php if ($isEstimate) echo "readonly";
                                                                                                                                                                                        else echo "required"; ?>>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label><?= $book_service['address'] ?></label>
                                        <input type="text" name="address" class="form-control" value="<?= $user->getAddress() ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label><?= $book_service['town'] ?></label>
                                        <input type="text" name="town" class="form-control" value="<?= $user->getCity() ?>" required>

                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md mb-3">
                                        <div class="btn btn-primary btn-block" data-toggle="modal" data-target="#modalSave"><?= $book_service['book'] ?></a></div>
                                    </div>
                                    <?php
                                    if ($isEstimate == FALSE) {
                                    ?>
                                        <div class="col-md mb-3">
                                            <div class="btn btn-primary btn-block text center" data-toggle="modal" data-target="#modalEstimate"><?= $book_service['createCostEstimate'] ?></div>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                </div>
                                <div class="row">
                                    <div class="col-md mb-3">
                                        <div class="btn btn-secondary btn-block text center" onclick="history.back()"><?= $book_service['cancel'] ?></div>
                                    </div>
                                </div>
                            </div>
                            <?php
                            if ($isEstimate) { ?>
                                <input type="hidden" name="totalPrice" value="<?= $totalPrice ?>">
                            <?php
                            } ?>
                            <br>

                            <!-- Modal for saving -->
                            <div class="modal fade" id="modalSave">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <!-- Modal Header -->
                                        <div class="modal-header">
                                            <h4 class="modal-title"><?= $book_service['booking'] ?></h4>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <!-- Modal body -->
                                        <div class="modal-body">
                                            <?= $book_service['bookService'] ?>
                                        </div>
                                        <!-- Modal footer -->
                                        <div class="modal-footer">
                                            <button class="btn btn-outline-success" type="submit"><?= $book_service['book'] ?></button>
                                            <button type="button" class="btn btn-outline-secondary" data-dismiss="modal"><?= $book_service['cancel'] ?></button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal for estimate -->
                            <div class="modal fade" id="modalEstimate">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <!-- Modal Header -->
                                        <div class="modal-header">
                                            <h4 class="modal-title"><?= $book_service['costEstimate'] ?></h4>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <!-- Modal body -->
                                        <div class="modal-body">
                                            <?= $book_service['serviceCostEstimate'] ?>
                                        </div>
                                        <!-- Modal footer -->
                                        <div class="modal-footer">
                                            <button class="btn btn-outline-success" type="submit" formaction="insert_estimate.php?i=<?= $service->getServiceId() ?>"><?= $book_service['createCostEstimate'] ?></button>
                                            <button type="button" class="btn btn-outline-secondary" data-dismiss="modal"><?= $book_service['cancel'] ?></button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </form>
                </ul>

            <?php
                    }
            ?>

            </section>

        </main>

        <?php require_once("include/footer.php"); ?>

    </body>

    </html>