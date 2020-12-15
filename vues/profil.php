<div class="profil marge">
<?php

    //trois cas possible :
        // => pas co, on retourne à la page login
        // => connecté et sur notre compte, on affiche les données de l'utilisateurs
        // => conecté et sur le compte de qlq d'autre
                    // on regarde s'ils ont un lien 
                            //amis : 

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
            <div>
                <p>pseudo : <?=$pseudoUser?></p>
                <!-- Button changer de pseudo-->
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#changePseudo">
                    Changer le pseudo
                    </button>
            </div>


            <div>
                <p>email : <?=$emailUser?></p>
                <!-- Button changer d'email-->
                     <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#changeEmail">
                    Changer l'email
                    </button>
            </div>

            <div>
                <p>mot de passe : *********</p>
                <!-- Button changer d'email-->
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#changeMdp">
                    Changer le mot de passe
                    </button>
            </div>

            
            
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
                //dans l'autre sens
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


<!-- MODAL de changements : -->


<!-- Modal changer de pseudo-->
<div class="modal fade" id="changePseudo" tabindex="-1" role="dialog" aria-labelledby="changePseudoLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="changePseudoLabel">Changement de votre pseudo</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
                <?php
                    if(isset($_GET['message'])){
                        echo "<p class='rouge'>".$_GET['message']."</p>";
                    }
                ?>
                <form method="POST" action="index.php?action=update&item=pseudo">
                    <input type="text" class="form-control" name="newPseudo" id="newPseudo" placeholder="nouveau pseudo">

                    
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" name="valider" id="valider" class="btn btn-primary">Changer le pseudo</button>
                </form>
      </div>
    </div>
  </div>
</div>




<!-- Modal changer d'email-->
<div class="modal fade" id="changeEmail" tabindex="-1" role="dialog" aria-labelledby="changeEmailLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="changeEmailLabel">Changement de votre email</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
                <?php
                    if(isset($_GET['message'])){
                        echo "<p class='rouge'>".$_GET['message']."</p>";
                    }
                ?>
                <form method="POST" action="index.php?action=update&item=email">
                    <label for="newEmail">mettre à jour votre email</label>
                    <input type="email" class="form-control" name="newEmail" id="newEemail">          
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" name="valider" id="valider" class="btn btn-primary">Mettre à jour</button>
                </form>
      </div>
    </div>
  </div>
</div>




<!-- Modal changer de mot de passe-->
<div class="modal fade" id="changeMdp" tabindex="-1" role="dialog" aria-labelledby="changeMdpLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="changeMdpLabel">Changement de votre mot de passe</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
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
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" name="valider" id="valider" class="btn btn-primary">Changer le mot de passe</button>
                </form>
      </div>
    </div>
  </div>
</div>

</div>