<?php
require_once('include/check_identity.php');

?>

<header>
  <nav id="navhm" class="navbar navbar-expand-md navbar-dark">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <a href="index.php"><img id="hm-logo" src="img/favicon.png" alt="logo"></a>
      <ul id="hm-home" class="navbar-nav">
        <li class="nav-item active">
          <a class="nav-link" href="index.php"><?= $header['homepage'] ?> <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <?php
          if ($connected != 0 && $status == 'associate') { ?>
            <a class="nav-link" href="associate_services.php"><?= $header['myServices'] ?></a>
          <?php
          } else {
          ?>
            <a class="nav-link" href="shop.php"><?= $header['shop'] ?></a>
          <?php
          }
          ?>
        </li>
        <li class="nav-item">
          <?php
          if ($connected != 0 && $status == 'associate') { ?>
            <a class="nav-link" href="associate_services_provided.php"><?= $header['myDiary'] ?></a>
          <?php
          } else {
          ?>
            <a class="nav-link" href="about_us.php" target="_blank"><?= $header['aboutUs'] ?></a>
          <?php
          }
          ?>
        </li>
        <?php

        if ($connected == 0) {

        ?>
          <li id="hm-connect" class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <?= $header['logIn'] ?>
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
              <a class="dropdown-item" href="connect.php?status=customer"><?= $header['customerSpace'] ?></a>
              <a class="dropdown-item" href="connect.php?status=associate"><?= $header['associateSpace'] ?></a>
            </div>
          </li>

          <?php

        } else {

          if ($status == 'customer') {

          ?>

            <li id="hm-connect" class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <?= $header['myAccount'] ?>
              </a>
              <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                <a class="dropdown-item" href="calendar.php"><?= $header['mySchedule'] ?></a>
                <a class="dropdown-item" href="orders.php"><?= $header['myOrders'] ?></a>
                <a class="dropdown-item" href="profile_customer.php"><?= $header['myInformations'] ?></a>
              </div>
            </li>

          <?php

          } else {

          ?>

            <li id="hm-connect" class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <?= $header['myAccount'] ?>
              </a>
              <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                <a class="dropdown-item" href="profile_associate.php"><?= $header['myInformations'] ?></a>
                <a class="dropdown-item" href="deconnect.php"><?= $header['logOut'] ?></a>
              </div>
            </li>

        <?php

          }
        }

        ?>
        </li>

        <?php

        if ($connected == 0) {

        ?>

          <li id="hm-regis" class="nav-item">
            <a class="nav-link" href="registration.php"><?= $header['signIn'] ?></a>
          </li>

          <?php

        } else {

          if ($status == 'customer') {

          ?>

            <li id="hm-regis" class="nav-item">
              <a class="nav-link" href="deconnect.php"><?= $header['logOut'] ?></a>
            </li>

          <?php

          } else {
          ?>
            <li id="hm-regis" class="nav-item">
              <a class="nav-link" href="about_us.php" target="_blank"><?= $header['aboutUs'] ?></a>
            </li>
        <?php
          }
        }
        ?>
      </ul>
    </div>
  </nav>
</header>
