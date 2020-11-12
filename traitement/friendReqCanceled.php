<?php
    if(isset($_SESSION['id'])){
        if(isset($_GET['idUtilisateur2'])){
            $idUtilisateur1 = $_SESSION['id'];
            $idUtilisateur2 = $_GET['idUtilisateur2'];

            echo $idUtilisateur1;
            echo $idUtilisateur2;

            $reqRem = $bdd->prepare("DELETE FROM lien WHERE idUtilisateur1 = ? AND idUtilisateur2 = ?");
            $reqRem->execute(array($idUtilisateur1, $idUtilisateur2));

            $nbReq = $reqRem->rowCount();
            echo $nbReq;
            header("Location:index.php?action=profil&id=".$idUtilisateur2);
        }
        else{
            header("Location:index.php?action=home");
        }
    }
    else{
        header("Location:idnex.php?action=connexion");
    }


?>