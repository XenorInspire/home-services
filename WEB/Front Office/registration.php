<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Home Services - Inscription</title>
    <link rel="icon" sizes="32x32" type="image/png" href="img/favicon.png"/>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
  </head>
  <body>

    <?php require_once("include/header.php"); ?>

    <main>

        <section class="container">
          <br>
          <br>
          <br>
          <h1>Inscription</h1>
          <br>
        <form action="valid_registration.php" method="post">
        <div class="form-group">
          <label>Nom</label>
          <input type="text" name="lastname" class="form-control" placeholder="Entrez votre nom" required>
        </div>
        <div class="form-group">
          <label>Prénom</label>
          <input type="text" name="firstname" class="form-control" placeholder="Entrez votre prénom" required>
        </div>
        <div class="form-group">
          <label>Adresse mail</label>
          <input type="email" class="form-control" placeholder="Enter email" required>
          <small id="emailHelp" class="form-text text-muted">Votre adresse mail ne sera pas partagée.</small>
        </div>
        <div class="form-group">
          <label>Numéro de téléphone</label>
          <input type="tel" name="phone_number" class="form-control" placeholder="Entrez votre numéro de téléphone" required>
        </div>
        <div class="form-group">
          <label>Adresse</label>
          <input type="text" name="address" class="form-control" placeholder="Entrez votre adresse" required>
        </div>
        <div class="form-group">
          <label>Ville</label>
          <input type="text" name="address" class="form-control" placeholder="Entrez votre ville" required>
        </div>
        <div class="form-group">
          <label>Mot de passe</label>
          <input type="password" name="passwd" class="form-control" placeholder="Entrez votre mot de passe" required>
        </div>
        <div class="form-group">
          <label>Confirmation</label>
          <input type="password" name="passwd_confirmed" class="form-control" placeholder="Confirmez votre mot de passe" required>
        </div>
        <button id="regis_button" type="submit" class="btn btn-primary">S'inscrire</button>
      </form>
          <br>
          <br>
          <br>
          <br>
          <br>
          <br>
        </section>

    </main>

    <?php require_once("include/footer.php"); ?>

  </body>
</html>