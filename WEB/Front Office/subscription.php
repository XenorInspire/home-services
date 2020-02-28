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
    <?php
      $dbmanager = new DBManager($bdd);
      $subscriptions = $dbmanager->getSubscriptionTypes();
      var_dump($subscriptions);
        foreach ($subscriptions as $subscription) {
          foreach ($subscription as $s) {?>
            <div class="subscriptions container-fluid">
              <p> Abonnement <?php echo $s["typeName"]; ?> </p>
              <p> Service <?php echo $s["openDays"]; ?> </p>
              <p> Disponible de <?php echo substr($s["openTime"], 0, 2); ?>h à <?php echo substr($s["closeTime"], 0, 2); ?>h </p>
              <p> <?php echo $s["serviceTimeAmount"] ?>h de service par mois </p>
              <p> À partir de seulement <?php echo $s["price"] ?>€ !</p>
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
