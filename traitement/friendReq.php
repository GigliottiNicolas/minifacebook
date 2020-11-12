<?php

    if(isset($_SESSION['id'])){
        if(isset($_GET['idAmi'])){

            $idUtilisateur1 = $_SESSION['id'];
            $idUtilisateur2 = $_GET['idAmi'];
            $link = "attente";

            echo $idUtilisateur1;
            echo $idUtilisateur2;
            echo $link  ;
            
            $addFriend = $bdd->prepare("INSERT INTO lien(idUtilisateur1, idUtilisateur2, etat) VALUES(?, ?, ?)");
            $addFriend->execute(array($idUtilisateur1, $idUtilisateur2, $link));
            header("Location:index.php?action=profil&id=$idUtilisateur2");

        }
        else{
            header("Location:index.php?action=login");
        }
    }
    else{
        header("Location:index.php?action=login");
    }

?>