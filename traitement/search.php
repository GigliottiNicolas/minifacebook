<?php

    if(isset($_SESSION['id'])){
        if(!empty($_POST['search'])){
            $recherche = '%'.$_POST['search'].'%';

            $reqSearch = $bdd->prepare("SELECT * FROM user WHERE pseudo LIKE '%$recherche%' OR email LIKE '%$recherche%'");
            $reqSearch->execute();

            $nbSearch = $reqSearch->rowCount();

            if($nbSearch>0){
                    while ($s=$reqSearch->fetch()){
                        if($s['id'] != $_SESSION['id']){
                        ?>
                            <h5><?=$s['pseudo']?> - <small><?=$s['email']?></small></h5> 
                            <p><a href="index.php?action=profil&id=<?=$s['id']?>">Voir le profil</a></p>
                        <?php
                        }
                        else{
                            if($nbSearch == 1){
                                ?>
                                    <p>pas de resulats à votre recherche</p>
                                    <form method="POST" action="index.php?action=search" class="form-inline my-2 my-lg-0">
                                        <input class="form-control mr-sm-2" type="search" name="search" id="search" placeholder="Nouvelle recherche" aria-label="Search">
                                        <button class="btn btn-outline-success my-2 my-sm-0" type="submit"><i class="fas fa-arrow-circle-right"></i></button>
                                    </form>
                                <?php
                            }
                        }
                    }
            }
            else{
                    ?>
                        <p>pas de resulats à votre recherche</p>
                        <form method="POST" action="index.php?action=search" class="form-inline my-2 my-lg-0">
                            <input class="form-control mr-sm-2" type="search" name="search" id="search" placeholder="Nouvelle recherche" aria-label="Search">
                            <button class="btn btn-outline-success my-2 my-sm-0" type="submit"><i class="fas fa-arrow-circle-right"></i></button>
                        </form>
                    <?php
            }
        }
        else header ("Location:index.php?action=home");
    }
    else header('Location:index.php?action=connexion');

?>