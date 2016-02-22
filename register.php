<?php

//Connexion à la db
require_once 'lib/pdo.php';
if(!empty($_POST)){
  //Création du tableau $errors stockant les erreurs
  $errors = array();

  //Simplification des variables
  $pseudo = $_POST['pseudo'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $password2 = $_POST['password2'];

  //On teste si la variable $pseudo est vide
  if (empty($pseudo) || !preg_match('/^[a-zA-Z0-9_@]+$/',$pseudo)) {
    $errors['pseudo'] = 'Votre pseudo est invalide';
  }else{
    $req = $pdo->prepare('SELECT * FROM users WHERE pseudo =?');
    $req->execute([$pseudo]);
    $user = $req->fetch();
    if($user){
      $errors['pseudo'] = 'Ce pseudo a déjà été pris par un utilisateur';
    }
  }

  if(empty($email) || !filter_var($email,FILTER_VALIDATE_EMAIL)){
    $errors['email'] = 'Votre email est invalide';
  }else{
    $req = $pdo->prepare('SELECT * FROM users WHERE email =?');
    $req->execute([$email]);
    $user = $req->fetch();
    if($user){
      $errors['email'] = 'Cet email a été déjà attribué à un compte';
    }
  }

  if (empty($password) || $password != $password2) {
    $errors['password'] = 'Attention avec vos mots de passe, ils ne correspondent pas';
  }
  if(empty($errors)){
    session_start();
    //On hache le password
    $password = password_hash($password,PASSWORD_BCRYPT);
    //Insertion du membre
    $code = Attribute_code(4);
    $req = $pdo->prepare("INSERT INTO users SET pseudo =?,email =?,password=?,code=?");
    $req->execute([$pseudo,$email,$password,$code]);
    $user_id = $pdo->lastInsertId();

    //$_SESSION['flash']['success'] = '';
    header("Location:confirm.php?id=$user_id&code=$code");
    exit();
  }

}


$title = 'S\'inscrire dans moins de 2min';
require 'inc/header.php'; ?>
<div class="container">

  <?php if(!empty($errors)) {?>
    <div class="alert alert-danger">
      <h3>Vous n'avez pas rempli le formulaire correctement</h3>
      <?php foreach ($errors AS $error){ ?>
        <p><?= $error;?></p>
      <?php } ?>
    </div>
<?php } ?>

<div class="row">



  <div class="col-lg-5">
    <div class="well bs-component">
    <h2>S'inscrire</h2>
    <form action="" method="post">

      <div class="form-group">
        <label for="pseudo">Pseudo:</label>
        <input type="text" name="pseudo" id="pseudo" class="form-control">
      </div>

      <div class="form-group">
        <label for="email">Email:</label>
        <input type="text" name="email" id="email" class="form-control">
      </div>

      <div class="form-group">
        <label for="password">Mot de passe:</label>
        <input type="password" name="password" id="password" class="form-control">
      </div>

      <div class="form-group">
        <label for="password2">Mot de passe <small>(Vérification)</small>:</label>
        <input type="password" name="password2" id="password2" class="form-control">
      </div>

      <div class="form-group">
        <button type="submit" class="btn btn-primary">S'inscrire</button>
        <button type="reset" class="btn btn-danger">Annuler</button>
      </div>

    </form>
    <h6>Vous avez un compte? <a href="login.php">Connectez-vous <span class="glyphicon glyphicon-user"></span></a> pour voir nos actualités</h6>
  </div>
  </div>

  <div class="col-lg-7 well bs-component">
  <h3>Inscrivez-vous avec votre compte de :</h3>
  <div class="col-lg-4">

  </div>
  <div class="col-lg-4">

  <form >
    <div class="form-group">
      <a href="#" class="form-control btn btn-primary btn-lg">Facebook <span class="glyphicon glyphicon-thumbs-up"></span></a>
    </div>

    <div class="form-group">
      <a href="#" class="form-control btn btn-danger btn-lg">gmail <span class="glyphicon glyphicon-thumbs-up"></span></a>
    </div>


    <div class="form-group">
      <a href="#" class="form-control btn btn-success btn-lg">whatsapp <span class="glyphicon glyphicon-thumbs-up"></span></a>
    </div>



    <div class="form-group">
      <a href="#" class="form-control btn btn-warning btn-lg">rss <span class="glyphicon glyphicon-thumbs-up"></span></a>
    </div>
  </form>

  </div>
  </div>


</div>
<?php require 'inc/footer.php'; ?>
