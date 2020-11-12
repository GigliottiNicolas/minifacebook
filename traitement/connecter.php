
<?php
    if(!empty($_POST['pseudo']) AND !empty($_POST['password'])){
        $pseudo = htmlspecialchars($_POST['pseudo']);
        $mdp = sha1($_POST['password']);

        $connectVerif = $bdd->prepare("SELECT * FROM user WHERE pseudo = ?");
        $connectVerif->execute(array($pseudo));
        $userInfo = $connectVerif->fetch();

        if($mdp == $userInfo['mdp']){
            //l'user existe =>connexion
            $_SESSION['id'] = $userInfo['id'];
            $_SESSION['pseudo'] = $userInfo['pseudo'];
            $_SESSION['email'] = $userInfo['email'];
            $_SESSION['mdp'] = $userInfo['mdp'];

            header("Location: index.php?action=profil&id=".$_SESSION['id']);
        }
    }
    else{
        $message="remplir tous les champs";
    }
?>