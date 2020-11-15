<?php

    if(!isset($_SESSION["id"])) {
        header("Location:index.php?action=login");
    }
    else{
        if($_GET['item'] == 'mdp'){
            if(!empty($_POST['oldMdp']) AND !empty($_POST['newMdp']) AND !empty($_POST['newMdpVerif'])){
                $oldMdp = sha1($_POST['oldMdp']);
                $newMdp = sha1($_POST['newMdp']);
                $newMdpVerif = sha1($_POST['newMdpVerif']);

                //recherche de l'ancien mdp
                $id = $_SESSION["id"];
                $reqMdp = $bdd->prepare("SELECT * FROM user WHERE id=?");
                $reqMdp->execute(array($id));
                $userInfo = $reqMdp->fetch();

                if($oldMdp == $userInfo['mdp']){
                    //verif que les deux newMdp entrés sont les mêmes

                    if($newMdp == $newMdpVerif){
                        $majMdp = $bdd->prepare("UPDATE user SET mdp=? WHERE id=?");
                        $majMdp->execute(array($newMdp, $id));

                        header("Location:index.php?action=deconnexion");
                    }
                    else{
                        $message = "les deux nouveaux mots de passes ne correspondent pas";
                        header("Location:index.php?action=maj&item=mdp&message=".$message);
                    }
                }
                else{
                    $message = "mauvais mot de passe";
                    header("Location:index.php?action=maj&item=mdp&message=".$message);
                }
                

            }
        }

        //VERIF QUE LE PSEUDO N4EXISTE PAS DEJA !!!!!!!!!!!!!!!!!!!!
        if($_GET['item'] == 'pseudo'){
            if(!empty($_POST['newPseudo'])){
                $id=$_SESSION['id'];
                $newPseudo = $_POST['newPseudo'];
                $pseudoLength = strlen($newPseudo);
                if($pseudoLength <= 100){
                    $majPseudo = $bdd->prepare("UPDATE user SET pseudo=? WHERE id=?");
                    $majPseudo->execute(array($newPseudo, $id));

                    echo "pseudo changé";
                    header("Location:index.php?action=connexion");
                }
                else{
                    $message = "pseudo trop long";
                    header("Location:index.php?action=maj&item=pseudo&message=".$message);
                }
            }
            else{
                $message = "entrer un nouveau pseudo";
                header("Location:index.php?action=maj&item=pseudo&message=".$message);
            }
        }

        if($_GET['item'] == 'email'){
            if(!empty($_POST['newEmail'])){
                $id=$_SESSION['id'];
                $newEmail = $_POST['newEmail'];

                if(filter_var($newEmail, FILTER_VALIDATE_EMAIL)){
                    $verifMail = $bdd->prepare("SELECT * FROM user WHERE email=?");
                    $verifMail->execute(array($newEmail));
                    $mailExist=$verifMail->rowCount();
                    
                    if($mailExist == 0){
                        $majMail = $bdd->prepare("UPDATE user SET email=? WHERE id=?");
                        $majMail->execute(array($newEmail, $id));
                       
                        echo "mail changé";
                        header("Location:index.php?action=connexion");

                    }
                    else{
                        $message = "l'email existe déjà ou vous avez rentrer votre ancien email";
                        header("Location:index.php?action=maj&item=email&message=".$message);
                    }
                }   
                else{
                    $message = "l'email n'est pas valide";
                    header("Location:index.php?action=maj&item=email&message=".$message);
                }
            }
            else{
                $message = "aucun mail renseigné";
                header("Location:index.php?action=maj&item=email&message=".$message);
            }
        }
    }


?>