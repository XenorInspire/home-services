<?php
require_once('include/check_identity.php');
require_once('include/lang.php');
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
          <a class="nav-link" href="index.php">Accueil <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="shop.php">Boutique</a>
          <?php
          if ($connected != 0 && $status == 'associate') { ?>
            <a class="nav-link" href="associate_services.php">Mes Services</a>
          <?php
          }
          ?>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="about_us.php">A propos</a>
          <?php
          if ($connected != 0 && $status == 'associate') { ?>
            <a class="nav-link" href="associate_services_provided.php">Mes Préstations</a>
          <?php
          }
          ?>
        </li>
        <?php

        if ($connected == 0) {

        ?>
          <li id="hm-connect" class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Connexion
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
              <a class="dropdown-item" href="connect.php?status=customer">Espace client</a>
              <a class="dropdown-item" href="connect.php?status=associate">Espace prestataire</a>
            </div>
          </li>

          <?php

        } else {

          if ($status == 'customer') {

          ?>

            <li id="hm-connect" class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Mon compte
              </a>
              <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                <a class="dropdown-item" href="profile_customer.php">Mes informations personnelles</a>
                <a class="dropdown-item" href="orders.php">Mes commandes</a>
              </div>
            </li>

          <?php

          } else {

          ?>

            <li id="hm-connect" class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Mon compte
              </a>
              <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                <a class="dropdown-item" href="profile_associate.php">Mes informations personnelles</a>
                <a class="dropdown-item" href="deconnect.php">Déconnexion</a>
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
            <a class="nav-link" href="registration.php">S'inscrire</a>
          </li>

          <?php

        } else {

          if ($status == 'customer') {

          ?>

            <li id="hm-regis" class="nav-item">
              <a class="nav-link" href="deconnect.php">Déconnexion</a>
            </li>

          <?php

          } else {
          ?>
            <li id="hm-regis" class="nav-item">
              <a class="nav-link" href="about_us.php">A propos</a>
            </li>
        <?php
          }
        }
        ?>
      </ul>
    </div>
  </nav>
</header>
