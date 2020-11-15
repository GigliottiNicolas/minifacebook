<h2>Connexion</h2>
<?php
    if(isset($_GET['message'])){
        echo "<p class=rouge>".$_GET['message']."</p>";
    }
?>

<form method="post" action="index.php?action=connecter">
    <div class="form-group">
        <label for="pseudo">Nom d'utilisateur</label>
        <input type="text" class="form-control" name="pseudo" id="pseudo">
    </div>

    <div class="form-group">
        <label for="exampleInputPassword1">Mot de passe</label>
        <input type="password" class="form-control" name="password" id="password">
    </div>

    <button type="submit" name="valider" id="valider" class="btn btn-primary">Se connecter</button>
</form>

<!--

    pour enregistrer les informations de connexion de l'user

 <div class="form-group form-check">
        <input type="checkbox" class="form-check-input" id="remember">
        <label class="form-check-label" for="remember">Se souvenir de moi</label>
    </div> 
    
    
-->