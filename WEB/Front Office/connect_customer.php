<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <title>Home Services - Connexion client</title>
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
      <h1 style="text-align: center;">Connexion</h1>

      <?php

      if (isset($_GET['error'])) {

        if ($_GET['error'] == 'password_inv') {

          echo '<br>';
          echo '<div class="alert alert-danger alert-dimissible text-center" class="close" data-dismiss="alert" role="alert">Ce mot de passe ne correspond pas à l\'adresse mail donnée</div>';
        }

        if ($_GET['error'] == 'email_inv') {

          echo '<br>';
          echo '<div class="alert alert-danger alert-dimissible text-center" class="close" data-dismiss="alert" role="alert">Erreur, veuillez saisir une adresse e-mail valide</div>';
        }

        if ($_GET['error'] == 'mail_nexit') {

          echo '<br>';
          echo '<div class="alert alert-danger alert-dimissible text-center" class="close" data-dismiss="alert" role="alert">Cette adresse e-mail n\'existe pas</div>';
        }

        if ($_GET['error'] == 'acc_dis') {

          echo '<br>';
          echo '<div class="alert alert-danger alert-dimissible text-center" class="close" data-dismiss="alert" role="alert">Ce compte client n\'est pas activé</div>';
        }
      }

      ?>

      <br>
      <form action="valid_customer_connect.php" method="POST">
        <div class="form-group">
          <label>Adresse mail</label>
          <input type="email" name="mail" class="form-control" placeholder="Enter email" autocomplete="email" maxlength="255" required>
        </div>
        <div class="form-group">
          <label>Mot de passe</label>
          <input type="password" id="password_length" name="passwd" class="form-control" placeholder="Entrez votre mot de passe" required>
          <small id="emailHelp" class="form-text text-muted">Vous avez oublié votre mot de passe ? <i><u><a href="">Cliquez ici</a></u></i></small>
        </div>
        <button style="margin:auto;display:block;" id="regis_button" type="submit" class="btn btn-primary">Se connecter</button>
      </form>
      <br>
      <br>
      <br>
      <br>
      <br>
      <br>
      <br>
      <br>
      <br>
      <br>
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