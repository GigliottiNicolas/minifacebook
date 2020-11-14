<?php

    //trois cas possible 

    //cas 1 : On n est pas connecté, il faut retourner à la page de login
    if(!isset($_SESSION["id"])) {
        header("Location:index.php?action=login");
    }  
    
    //cas 2 : c'est le profil de l'user connecté 
    elseif($_GET['id'] == $_SESSION['id']){
        $idUser = $_SESSION["id"];
        $pseudoUser = $_SESSION["pseudo"];
        $emailUser = $_SESSION["email"];
        $mdpUser = $_SESSION["mdp"];

        ?>

            <h2>Mon profil</h2>
            <p>pseudo : <?=$pseudoUser?></p>
            <a href="index.php?action=maj&item=pseudo">changer le pseudo</a></br></br>
            <p>email : <?=$emailUser?></p>
            <a href="index.php?action=maj&item=email">changer l'email</a></br></br>
            <p>mot de passe : <?=$mdpUser?></p>
            <a href="index.php?action=maj&item=mdp">changer le mot de passe</a></br></br>

            
            
            <?php
                $req = $bdd->prepare("SELECT * FROM lien JOIN user ON lien.idUtilisateur1 = user.id WHERE idUtilisateur2 = ? AND etat='attente'");
                $req->execute(array($idUser));
                $nbReq=$req->rowCount();

                if($nbReq == 0){
                    ?>
                        <p>pas de demande en cours</p>
                    <?php
                }
                else{
                    ?>
                        <p>Mes demandes en cours</p> 
                        <ul>
                    <?php
                }
                while($r=$req->fetch()){
                    ?>
                        <li><?=$r['pseudo']?> : 
                            <a href="index.php?action=acceptFriend&idUtilisateur1=<?=$r['id']?>">Accepter</a>
                            <a href="index.php?action=bannFriend&idUtilisateur1=<?=$r['id']?>">Refuser</a>
                        </li>
                    <?php
                }
            ?>
            </ul>   

        <?php
    }





    //cas 3 : c'est le profil d'un autre user

    //on cherche alors à savoir si un lien existe entre l'user co et le profil où on se trouve
    else{

        $reqInfo = $bdd->prepare("SELECT * FROM user WHERE id = ?");
        $reqInfo->execute(array($_GET['id']));

        $infoUser = $reqInfo->fetch();
        
        $idUser = $infoUser["id"];
        $pseudoUser = $infoUser["pseudo"];
        $emailUser = $infoUser["email"];
        $mdpUser = $infoUser["mdp"];

        ?>

            <h2>Profil de <?=$pseudoUser?></h2>
            <p><?=$emailUser?></p>

            <!-- rechercher le lien entre les deux user -->
            <?php
                $idUtilisateur1 = $_SESSION['id'];
                $idUtilisateur2 = $idUser;


                //si le couple existe ? 
                
                $linkReq = $bdd->prepare("SELECT * FROM lien WHERE idUtilisateur1 = ? AND idUtilisateur2 = ?");
                $linkReq->execute(array($idUtilisateur1, $idUtilisateur2));

                $linkExist=$linkReq->rowCount();


                //si le couple existe dans l'autre sens ?
                $linkReq2 = $bdd->prepare("SELECT * FROM lien WHERE idUtilisateur1 = ? AND idUtilisateur2 = ?");
                $linkReq2->execute(array($idUtilisateur2, $idUtilisateur1));

                $linkExist2=$linkReq2->rowCount();

                
                
                if($linkExist == 1){
                    //savoir quel lien ? 
                    $linkInfo=$linkReq->fetch();

                    if($linkInfo['etat'] == "attente"){
                        // demande en attente
                        ?>
                            <p>Demande d'ami en cours</p>
                            <a href="index.php?action=friendReqCanceled&idUtilisateur2=<?=$idUser?>">Annuler la demande</a>
                        <?php
                    }
                    if($linkInfo['etat'] == "ami"){
                        // demande accepté => ils sont amis

                        ?>

                            <h4>Nouveau post sur le mur de <?=$pseudoUser?></h4>

                            <form method="post" action="index.php?action=addPost&idAmi=<?=$idUser?>">
                                    <div class="form-group">
                                        <label for="titre">titre du post</label>
                                        <input type="text" class="form-control" name="titre" id="titre">

                                        <label for="contenu">contenu du post</label>
                                        <input type="text" class="form-control" name="contenu" id="contenu">

                                    </div>
                                    <button type="submit" name="valider" id="valider" class="btn btn-primary">Poster</button>
                            </form>

                            <h4> Mur de <?=$pseudoUser?></h4>

                            <?php
                                $reqPost=$bdd->prepare("SELECT * FROM ecrit JOIN user ON idAuteur = user.id WHERE idAmi = ? ORDER BY dateEcrit DESC");
                                $reqPost->execute(array($idUser));

                                $nbPost = $reqPost->rowCount();
                                if($nbPost>0){
                                    
                                    while($p = $reqPost->fetch()){
                                        if($p['idAuteur'] == $_SESSION['id']){
                                            ?>
                                                <div class="post">
                                                    <h5><?=$p['titre']?> - <small>poster par  moi le <?=$p['dateEcrit']?></small></h5> 
                                                    <p><?=$p['contenu']?></p>
                                                </div>
                                            <?php
                                        }
                                        else{
                                            ?>
                                                <div class="post">
                                                    <h5><?=$p['titre']?> - <small>poster par  <a href="index.php?action=profil&id=<?=$p['idAuteur']?>"><?=$p['pseudo']?></a> le <?=$p['dateEcrit']?></small></h5> 
                                                    <p><?=$p['contenu']?></p>
                                                </div>
                                            <?php
                                        }
                                    }
                                }
                                else{
                                    ?>
                                        <p>aucun post sur le mur, soyez le premier!</p>
                                    <?php
                                }

                                
                            ?> 

                        <?php

                    }
                    if($linkInfo['etat'] == "banni"){
                        // demande refusé => il ne peut plus le demandder en ami
                        echo "vous ne pouvez pas demander ... en ami";
                    }
                }
                elseif($linkExist2 == 1){
                    //savoir quel lien ? 
                    $linkInfo=$linkReq2->fetch();

                    if($linkInfo['etat'] == "attente"){
                        // demande en attente d'acceptatiion
                        ?>
                            <p>cette user vous a demandé en ami</p>
                            <ul>
                                <li><a href="index.php?action=acceptFriend&idUtilisateur1=<?=$idUser?>">Accepter</a></li>
                                <li><a href="index.php?action=bannFriend&idUtilisateur1<?=$idUser?>">Refuser</a></li>
                            </ul>
                        <?php
                    }

                    if($linkInfo['etat'] == "ami"){
                        // demande accepté => ils sont amis

                        ?>

                                <h4>Nouveau post sur le mur de <?=$pseudoUser?></h4>

                                <form method="post" action="index.php?action=addPost&idAmi=<?=$idUser?>">
                                        <div class="form-group">
                                            <label for="titre">titre du post</label>
                                            <input type="text" class="form-control" name="titre" id="titre">

                                            <label for="contenu">contenu du post</label>
                                            <input type="text" class="form-control" name="contenu" id="contenu">

                                        </div>
                                        <button type="submit" name="valider" id="valider" class="btn btn-primary">Poster</button>
                                </form>

                               <h4> Mur de <?=$pseudoUser?></h4>

                               <?php
                                    $reqPost=$bdd->prepare("SELECT * FROM ecrit JOIN user ON idAuteur = user.id WHERE idAmi = ?");
                                    $reqPost->execute(array($idUser));

                                    $nbPost = $reqPost->rowCount();
                                    if($nbPost>0){
                                        
                                        while($p = $reqPost->fetch()){
                                            if($p['idAuteur'] == $_SESSION['id']){
                                                ?>
                                                    <div class="post">
                                                        <h5><?=$p['titre']?> - <small>poster par  moi le <?=$p['dateEcrit']?></small></h5> 
                                                        <p><?=$p['contenu']?></p>
                                                    </div>
                                                <?php
                                            }
                                            else{
                                                ?>
                                                    <div class="post">
                                                        <h5><?=$p['titre']?> - <small>poster par  <?=$p['pseudo']?> le <?=$p['dateEcrit']?></small></h5> 
                                                        <p><?=$p['contenu']?></p>
                                                    </div>
                                                <?php
                                            }
                                        }
                                    }
                                    else{
                                        ?>
                                            <p>aucun post sur le mur, soyez le premier!</p>
                                        <?php
                                    }

                                    
                               ?>

                        <?php

                    }
                    if($linkInfo['etat'] == "bann"){
                        // demande refusé => il ne peut plus le demandder en ami
                        ?>
                            <p>Vous avez refuser cet utilisateur en ami, il est banni et ne peut plus vous demander en ami</p>
                            <a href="index.php?action=removeBann&idUtilisateur1=<?=$idUser?>">Ne plus bannir cet utilisateur</a>
                        <?php
                    }

                }

                else{
                    //aucun lien, ils ne sont pas encore ami
                    ?>
                        <a href="index.php?action=friendReq&idAmi=<?=$idUser?>">Ajouter comme ami</a>
                    <?php
                }

            ?>
        <?php

    }

?>


