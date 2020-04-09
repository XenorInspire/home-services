<?php require_once('include/lang.php'); ?>
<br>
<header class="container-fluid sticky-top">
  <nav id="navhm" class="navbar navbar-expand-md navbar-dark rounded">
    <div class="navbar-collapse collapse w-100 order-1 order-md-0 dual-collapse2">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item">
          <a class="nav-link" href="index.php"><?= $nav['homepage'] ?></a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="publications.php" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?= $nav['manage'] ?>
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="customers.php"><?= $nav['customers'] ?></a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="associates.php"><?= $nav['associates'] ?></a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="subscriptions.php"><?= $nav['subscriptions'] ?></a>
          </div>
        </li>
      </ul>
    </div>
    <!-- <div class="mx-auto order-0"> -->
    <a class="navbar-brand nav_line" href="index.php"><img class="rounded" src="img/favicon.png" alt="logo" width="60"></a>
    <div class="navbar-toggler nav-link">
      <div class="justify-content-center">
        Home-Services
      </div>
    </div>
    <!-- </div> -->
    <div class="navbar-collapse collapse w-100 order-3 dual-collapse2">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link" href="reservations.php"><?= $nav['reservations'] ?></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="services_provided_bills.php"><?= $nav['servicesProvided'] ?></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="service_types.php"><?= $nav['services'] ?></a>
        </li>
      </ul>
    </div>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target=".dual-collapse2">
      <span class="navbar-toggler-icon"></span>
    </button>
  </nav>
</header>