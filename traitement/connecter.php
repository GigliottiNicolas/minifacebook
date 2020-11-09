<?php


    if(!empty($_POST['pseudo']) AND !empty($_POST['mdp'])){
        $pseudo = htmlspecialchars($_POST['pseudo']);
        $mdp = sha1($_POST['password']);

        $connectVerif = $bdd->prepare("SELECT * FROM user WHERE pseudo = ? AND mdp = ?");
        $connectVerif->execute(array($pseudo, $mdp));
        $userExist = $connectVerif->rowCount(); //si une ligne existe, l'utilisateur existe et peut se co 

        if($userExist == 1){
            //l'user existe =>connexion
            $userInfo = $connectVerif->fetch();
            $_SESSION['id'] = $userInfo['id'];
            $_SESSION['pseudo'] = $userInfo['pseudo'];
            $_SESSION['email'] = $userInfo['email'];
            header("Location: index.php?action=profil AND id=".$_SESSION['id']);
        }
        else{
            //mauvais mail ou mdp
        }
    }
    else{
        $message="remplir tous les champs";
    }



?>