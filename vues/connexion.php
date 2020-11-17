<div class="login marge">    
    <div class="inscription bgBleuFonce white">
        <h2>inscription</h2>
                <?php

                    if(isset($_GET['message'])){
                        echo "<p class=rouge>".$_GET['message']."</p>";
                    }

                ?>

                <form method="post" action="index.php?action=login">

                    <div class="form-group">
                        <label for="pseudo">Nom d'utilisateur</label>
                        <input type="text" class="form-control" name="pseudo" id="pseudo">
                    </div>

                    <div class="form-group">
                        <label for="email">Adresse mail</label>
                        <input type="email" class="form-control" name="email" id="email" aria-describedby="emailHelp">
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
    </div>


    <div class="connexion bgBleuFonce white">
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


    </div>
</div>
