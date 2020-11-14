<?php

    if(isset($_SESSION['id'])){
        if(!empty($_POST['search'])){
            $recherche = '%'.$_POST['search'].'%';

            $reqSearch = $bdd->prepare("SELECT * FROM ecrit WHERE titre LIKE '%$recherche%' OR contenu LIKE '%$recherche%'");
            $reqSearch->execute();

            $nbSearch = $reqSearch->rowCount();

            if($nbSearch>0){
                    while ($s=$reqSearch->fetch()){
                        ?>
                            <h5><?=$s['titre']?> - <small>poster par  ... le <?=$s['dateEcrit']?></small></h5> 
                            <p><?=$s['contenu']?></p>
                        <?php
                    }
            }
            else{
                    ?>
                        <p>pas de resulats à votre recherche</p>
                    <?php
            }
        }
        else header ("Location:index.php?action=home");
    }
    else header('Location:index.php?action=connexion');

?>