<?php require_once __DIR__ . '/class/DBManager.php' ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Page des abonnements</title>
  <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
  <link rel="stylesheet" href="css/style.css" type="text/css">
</head>

<body>
  <?php require_once __DIR__ . '/include/header.php'; ?>
  <main id="main">
    <h1> ABONNEMENTS </h1>
    <?php
      $dbmanager = new DBManager($bdd);
      $subscriptions = $dbmanager->getSubscriptionTypes();
        foreach ($subscriptions as $subscription) {
          foreach ($subscription as $s) {?>
            <div class="subscriptions">
              <h3> Abonnement <?php echo $s["typeName"]; ?> </h3>
              <p id="subscib_description">
                <p> <?php if (substr($s["openTime"], 0, 2) != '24') {
                            echo 'Disponible de ' .
                            substr($s["openTime"], 0, 2) . 'h à ' .
                            substr($s["closeTime"], 0, 2) . 'h';
                          } else echo 'Disponible 24 heures / 24'; ?> </p>
                <p> <?php echo $s["openDays"]; ?> jours / 7 </p>
                <p> <?php echo $s["serviceTimeAmount"] ?>h de service par mois </p>
                <p> À partir de <?php echo $s["price"] ?>€ !</p>
              </p>
              <button class="btn btn-secondary subscrib_button">S'abonner !</button>
            </div>
        <?php
          }
        } ?>

    <script type="text/javascript" src="js/subscriptionpage.js"></script>
  </main>
  <footer>

  </footer>
</body>

</html>
