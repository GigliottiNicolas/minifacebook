<?php

    if(isset($_SESSION['id'])){

            $titre = htmlspecialchars($_POST['titre']);
            $contenu = htmlspecialchars($_POST['contenu']);
            $dateEcrit = date('Y-m-d H:i:s');
            $image = "test.jpg";
            $idAuteur = $_SESSION['id'];
            $idAmi = $_GET['idAmi'];

            if(!empty($_POST['titre']) AND !empty($_POST['contenu'])){
               
                $insertPost = $bdd->prepare("INSERT INTO ecrit(titre, contenu, dateEcrit, image, idAuteur, idAmi) VALUES(?, ?, ?, ?, ?, ?)");
                $insertPost->execute(array($titre, $contenu, $dateEcrit, $image, $idAuteur, $idAmi));

                echo "ok";

                header("Location:index.php?action=profil&id=".$idAmi);
            }

            
    }
    else{
        header("Location: index.php?action=connexion");
    }


?>