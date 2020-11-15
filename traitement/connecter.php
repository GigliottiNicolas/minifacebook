
<?php

    if(!empty($_POST['pseudo']) AND !empty($_POST['password'])){
        $pseudo = htmlspecialchars($_POST['pseudo']);
        $mdp = sha1($_POST['password']);

        $connectVerif = $bdd->prepare("SELECT * FROM user WHERE pseudo = ?");
        $connectVerif->execute(array($pseudo));
        
        $nbProfil = $connectVerif->rowCount();
        if($nbProfil == 1){
            $userInfo = $connectVerif->fetch();
            if($mdp == $userInfo['mdp']){
                //l'user existe =>connexion
                $_SESSION['id'] = $userInfo['id'];
                $_SESSION['pseudo'] = $userInfo['pseudo'];
                $_SESSION['email'] = $userInfo['email'];
                $_SESSION['mdp'] = $userInfo['mdp'];

                header("Location: index.php?action=profil&id=".$_SESSION['id']);
            }
            else{
                $message="mauvais mot de passe";
                header("Location:index.php?action=connexion&message=".$message);
            }
        }
        else{
            $message="aucun profil ne correspond à ce pseudo";
            header("Location:index.php?action=connexion&message=".$message);
        }
    }
    else{
        $message="remplir tous les champs";
        header("Location:index.php?action=connexion&message=".$message);
    }
?>