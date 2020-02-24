<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <title>Home Services - Inscription</title>
  <link rel="icon" sizes="32x32" type="image/png" href="img/favicon.png" />
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
      <h1 style="text-align: center;">Inscription</h1>

      <?php

      if (isset($_GET['error'])) {


        if ($_GET['error'] == 'captcha_inv') {

          echo '<br>';
          echo '<li style="color: red;text-align: center;list-style:none;">Erreur, veuillez entrer le bon numéro correspondant à l\'image</li>';
        }

        if ($_GET['error'] == 'inputs_inv') {

          echo '<br>';
          echo '<li style="color: red;text-align: center;list-style:none;">Erreur, un ou plusieurs champs n\'ont pas été complétés ou ne sont pas valides</li>';
        }

        if ($_GET['error'] == 'password_inv') {

          echo '<br>';
          echo '<li style="color: red;text-align: center;list-style:none;">Veuillez entrer le même mot de passe lors de la confirmation de celui-ci</li>';
        }

        if ($_GET['error'] == 'password_length') {

          echo '<br>';
          echo '<li style="color: red;text-align: center;list-style:none;">Veuillez entrer un mot de passe de 6 caractères minimum</li>';
        }

        if ($_GET['error'] == 'email_inv') {

          echo '<br>';
          echo '<li style="color: red;text-align: center;list-style:none;">Erreur, veuillez saisir une adresse e-mail valide</li>';
        }

        if ($_GET['error'] == 'mail_taken') {

          echo '<br>';
          echo '<li style="color: red;text-align: center;list-style:none;">Cette adresse e-mail est déjà attribuée à un autre compte</li>';
        }

        if ($_GET['error'] == 'lname_length') {

          echo '<br>';
          echo '<li style="color: red;text-align: center;list-style:none;">Vous avez dépassé le maximum de caractères possibles pour le champ "Nom"</li>';
        }

        if ($_GET['error'] == 'fname_length') {

          echo '<br>';
          echo '<li style="color: red;text-align: center;list-style:none;">Vous avez dépassé le maximum de caractères possibles pour le champ "Prénom"</li>';
        }

        if ($_GET['error'] == 'city_length') {

          echo '<br>';
          echo '<li style="color: red;text-align: center;list-style:none;">Vous avez dépassé le maximum de caractères possibles pour le champ "Ville"</li>';
        }

        if ($_GET['error'] == 'ps_length') {

          echo '<br>';
          echo '<li style="color: red;text-align: center;list-style:none;">Vous avez dépassé le maximum de caractères possibles pour le champ "Pseudo"</li>';
        }

        if ($_GET['error'] == 'mail_length') {

          echo '<br>';
          echo '<li style="color: red;text-align: center;list-style:none;">Vous avez dépassé le maximum de caractères possibles pour le champ "E-mail"</li>';
        }
      }

      ?>

      <br>
      <form action="valid_registration.php" method="POST">
        <div class="form-group">
          <label>Nom</label>
          <input type="text" name="lastname" class="form-control" placeholder="Entrez votre nom" max="255" required>
        </div>
        <div class="form-group">
          <label>Prénom</label>
          <input type="text" name="firstname" class="form-control" placeholder="Entrez votre prénom" max="255" required>
        </div>
        <div class="form-group">
          <label>Adresse mail</label>
          <input type="email" name="mail" class="form-control" placeholder="Enter email" autocomplete="email" max="255" required>
          <small id="emailHelp" class="form-text text-muted">Votre adresse mail ne sera pas partagée.</small>
        </div>
        <div class="form-group">
          <label>Numéro de téléphone</label>
          <input type="tel" name="phone_number" class="form-control" placeholder="Entrez votre numéro de téléphone" required>
        </div>
        <div class="form-group">
          <label>Adresse</label>
          <input type="text" name="address" class="form-control" placeholder="Entrez votre adresse" max="255" required>
        </div>
        <div class="form-group">
          <label>Ville</label>
          <input type="text" name="city" class="form-control" placeholder="Entrez votre ville" max="255" required>
        </div>
        <div class="form-group">
          <label>Mot de passe</label>
          <input type="password" id="password_length" name="passwd" onkeyup="checkPassword()" class="form-control" placeholder="Entrez votre mot de passe" required>
          <small id="password_size" class="form-text">6 caractères minimum</small>
        </div>
        <div class="form-group">
          <label>Confirmation</label>
          <input type="password" id="same" onkeyup="samePassword()" name="passwd_confirmed" class="form-control" placeholder="Confirmez votre mot de passe" required>
          <small id="password_same" class="form-text">Ce mot de passe est différent du champs précédent !</small>
        </div>
        <div class="form-group">
          <label>Entrez le code affiché ci-dessous</label>
          <input type="text" name="captcha" class="form-control" required>
          <img src="captcha/captcha.php" alt="captcha">
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
  <script src="js/password.js"></script>

</body>

</html>