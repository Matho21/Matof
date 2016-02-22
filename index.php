<?php
/*
*Partie de traitement
*/
if(isset($_POST['connexion'])){
  session_start();
  extract($_POST);
  if(!empty($pseudo) && !empty($mp)){
    //si le pseudo et le mot de passe ne sont pas vides, on se connecte à la base de données
    include 'lib/connexion.php';
    
    //requete
    $req  = $connexion->prepare('SELECT * FROM membres WHERE pseudo = ? AND mp = ?');
    $req->execute([$pseudo,$mp]);
    
    //Si on trouve le membre on le connecte, sinon on affiche une erreur
    if($user = $req->fecth(PDO::FETCH_ASSOC)){
      $_SESSION['user'] = $user;
      setMessage("Bienvenue dans notre communauté");
      header("Location:account.php");
      exit();
    }else{
      //Affichage de l'erreur
      
      setMessage("Aucun compte ne correspond à ces identifiants","danger");
    }
    
  }else{
     setMessage("Tous les champs doivent être remplis SVP","danger");
  }
}
?>

<!--
- Ceci c'est la page d'accueil avec le formulaire 
- qui permettra à l'utilisateur de se connecter dans notre système
-->
<form action="" metho="post">
  <label>Pseudo ou identifiant:</label>
  <input type="text" name="pseudo" class="form-control">

  <label>Mot de passe:</label>
  <input type="text" name="mp" class="form-control">
  
  
  <input type="submit" value="Se connecter" class="btn btn-success">

</form>



<!--
- S'il n'a pas de compte, il peut s'inscrire en cliquant ici
-->
<p><a href="register.php" title="Inscription à notre super site">Inscrivez-vous</a> dans moins de 2min</p>
