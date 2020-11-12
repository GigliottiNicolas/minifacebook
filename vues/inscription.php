<h2>inscription</h2>

<a href="index.php?action=connexion">connexion</a>

<form method="post" action="index.php?action=login">

    <div class="form-group">
        <label for="pseudo">Nom d'utilisateur</label>
        <input type="text" class="form-control" name="pseudo" id="pseudo">
    </div>

    <div class="form-group">
        <label for="email">Adresse mail</label>
        <input type="email" class="form-control" name="email" id="email" aria-describedby="emailHelp">
        <small id="emailHelp" class="form-text text-muted">Ne communiquez pas ses informations</small>
    </div>

    <div class="form-group">
        <label for="exampleInputPassword1">Mot de passe</label>
        <input type="password" class="form-control" name="password" id="password">
    </div>

    <div class="form-group">
        <label for="exampleInputPassword1">Confirmation du mot de passe</label>
        <input type="password" class="form-control" name="passwordVerif" id="passwordVerif">
    </div>

    <button type="submit" name="valider" id="valider" class="btn btn-primary">S'inscrire</button>

</form>

<?php 

if(isset($message)){
    echo $message;
}