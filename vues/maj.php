<H2>modif du compte</H2>


<?php

    if(!isset($_SESSION["id"])) {
        header("Location:index.php?action=login");
    }  
    else{
        
        if($_GET['item'] == 'mdp'){
            ?>
                <h3>Changement de votre mot de passe</h3>
                <?php
                    if(isset($_GET['message'])){
                        echo "<p class='rouge'>".$_GET['message']."</p>";
                    }
                ?>
                <form method="POST" action="index.php?action=update&item=mdp">
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
                    if(isset($_GET['message'])){
                        echo "<p class='rouge'>".$_GET['message']."</p>";
                    }
                ?>
                <form method="POST" action="index.php?action=update&item=pseudo">
                    <label for="newPseudo">Nouveau pseudo</label>
                    <input type="text" class="form-control" name="newPseudo" id="newPseudo">

                    <button type="submit" name="valider" id="valider" class="btn btn-primary">Changer le pseudo</button>
                </form>
            <?php
        }
        if($_GET['item'] == 'email'){
            ?>
                <h3>Changement de votre email</h3>
                <?php
                    if(isset($_GET['message'])){
                        echo "<p class='rouge'>".$_GET['message']."</p>";
                    }
                ?>
                <form method="POST" action="index.php?action=update&item=email">
                    <label for="newEmail">mettre à jour votre email</label>
                    <input type="email" class="form-control" name="newEmail" id="newEemail">

                    <button type="submit" name="valider" id="valider" class="btn btn-primary">Mettre à jour</button>
                </form>
            <?php
        }
    }




?>