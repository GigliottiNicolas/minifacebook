<?php

    if(isset($_SESSION['id'])){
        if(isset($_GET['id'])){
            $idEcrit = $_GET['id'];
            $idUtilisateur = $_SESSION['id'];

            $addLike = $bdd->PREPARE("INSERT INTO aime(idEcrit, idUtilisateur) VALUES(?, ?)");
            $addLike->execute(array($idEcrit, $idUtilisateur));

            header("Location:index.php?action=home");
        }
        else{
            header("Location:index.php?action=home");
        }
    }
    else{
        header("Location:index.php?action=connexion");
    }

//verif que le couple id et user n'existe pas déjà !!! 
?>