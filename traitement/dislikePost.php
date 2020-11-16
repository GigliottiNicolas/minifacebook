<?php

    if(isset($_SESSION['id'])){
        if(isset($_GET['id'])){
            $idEcrit = $_GET['id'];
            $idUtilisateur = $_SESSION['id'];

            $deleteLike = $bdd->PREPARE("DELETE FROM aime WHERE idEcrit = ? AND idUtilisateur = ?");
            $deleteLike->execute(array($idEcrit, $idUtilisateur));

            header("Location:index.php?action=home");
        }
        else{
            header("Location:index.php?action=home");
        }
    }
    else{
        header("Location:index.php?action=connexion");
    }


?>