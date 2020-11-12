<?php
    if(isset($_SESSION['id'])){
        if(isset($_GET['idUtilisateur1'])){
            $idUtilisateur1 = $_GET['idUtilisateur1'];
            $idUtilisateur2 = $_SESSION['id'];

            echo $idUtilisateur1;
            echo $idUtilisateur2;

            $reqRem = $bdd->prepare("DELETE FROM lien WHERE idUtilisateur1 = ? AND idUtilisateur2 = ?");
            $reqRem->execute(array($idUtilisateur1, $idUtilisateur2));

            $nbReq = $reqRem->rowCount();
            echo $nbReq;
            header("Location:index.php?action=profil&id=".$idUtilisateur1);
        }
        else{
            header("Location:index.php?action=home");
        }
    }
    else{
        header("Location:idnex.php?action=connexion");
    }


?>