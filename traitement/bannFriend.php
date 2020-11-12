<?php

    if(isset($_SESSION['id'])){
        if(!empty($_GET['idUtilisateur1'])){
            $idUtilisateur1 = $_GET['idUtilisateur1'];
            $idUtilisateur2 = $_SESSION['id'];

            $reqAccept = $bdd->prepare("UPDATE lien SET etat='bann' WHERE idUtilisateur1 = ? AND idUtilisateur2 = ?");
            $reqAccept->execute(array($idUtilisateur1, $idUtilisateur2));

            header('Location:index.php?action=profil&id='.$idUtilisateur1);
        }   
        else{
            header("Location:index.php?action=home");
        }
    }
    else{
        header("Location:index.php?action=connexion");
    }

?>