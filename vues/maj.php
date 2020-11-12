<H2>modif du compte</H2>


<?php

    if(!isset($_SESSION["id"])) {
        header("Location:index.php?action=login");
    }  
    else{
        
        if($_GET['item'] == 'mdp'){
            ?>
                <h3>Changement de votre mot de passe</h3>
                <form method="GET" action="index.php?action=update&item=mdp">
                    <label for="oldMdp">Ancien mot de passe</label>
                    <input type="password" class="form-control" name="oldMdp" id="oldMdp">

                    <label for="newMdp">Nouveaux mot de passe</label>
                    <input type="password" class="form-control" name="newMdp" id="newMdp">

                    <label for="newMdpVerif">Confirmation du mot de passe</label>
                    <input type="password" class="form-control" name="newMdpVerif" id="newMdpVerif">

                    <button type="submit" name="valider" id="valider" class="btn btn-primary">Changer le mot de passe</button>
                </form>
            <?php
        }
        if($_GET['item'] == 'pseudo'){
            ?>
                <h3>Changement de votre pseudo</h3>
            <?php
        }
        if($_GET['item'] == 'email'){
            ?>
                <h3>Changement de votre email</h3>
            <?php
        }
    }




?>