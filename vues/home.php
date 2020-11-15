<div class="home">

    <?php

    if(isset($_SESSION['id'])){
        ?>

            <!-- mur -->
            <div class="feed">
                <h2>Home</h2>
                <?php
                    $idAuteur = $_SESSION['id'];

                    $reqPost=$bdd->prepare("SELECT * FROM ecrit JOIN user ON idAmi = user.id WHERE idAuteur = ?");
                    $reqPost->execute(array($idAuteur));

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
                
            </div>

            <div class="friendsCo">
                <h4>mes amis connectés </h4>
                <?php
                    $idUtilisateur2 = $_SESSION['id'];
                    $reqFriends = $bdd->prepare("SELECT * FROM lien JOIN user ON lien.idUtilisateur1=user.id WHERE idUtilisateur2=? AND etat = 'ami'");
                    $reqFriends->execute(array($idUtilisateur2));

                    echo "<ul>";
                        while($f = $reqFriends->fetch()){
                            ?>
                                <li><a href="index.php?action=profil&id=<?=$f['id']?>"><?=$f['pseudo']?></a></li>
                            <?php
                        }
                    echo "</ul>";
                ?>

                <h4>mes demandes d'amis en attente</h4>
                <?php
                    $req = $bdd->prepare("SELECT * FROM lien JOIN user ON lien.idUtilisateur1=user.id WHERE idUtilisateur2 = ? AND etat = 'attente'");
                    $req->execute(array($_SESSION['id']));
                    $nbReq = $req->rowCount();
                    
                    if($nbReq>0){
                        ?>
                            <p>Vous avez <b><?=$nbReq?></b> demande(s) d'amitié en cours</p>
                        <?php
                            if($nbReq==1){
                                ?>
                                    <a href="index.php?action=profil&id=<?=$_SESSION['id']?>">Voir la demande</a>
                                <?php
                            }
                            else{
                                ?>
                                    <a href="index.php?action=profil&id=<?=$_SESSION['id']?>">Voir les demandes</a>
                                <?php
                            }
                    }
                ?>
                
            </div>


        <?php
    }
    else{
        header("Location: index.php?action=connexion");
    }

    ?>

</div>