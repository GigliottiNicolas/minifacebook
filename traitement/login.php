<?php

  
        //l'user a rempli tous les chamos
        if(!empty($_POST['pseudo']) AND !empty($_POST['email']) AND !empty($_POST['password']) AND !empty($_POST['passwordVerif'])){
            $pseudo = htmlspecialchars($_POST['pseudo']);
            $email = htmlspecialchars($_POST['email']);
            $mdp = sha1($_POST['password']);
            $mdpVerif = sha1($_POST['passwordVerif']);

            //le pseudo est inferieur à 100
            $pseudoLength = strlen($pseudo);
            if($pseudo <= 100){

                //l'email est valide
                if(filter_var($email, FILTER_VALIDATE_EMAIL)){

                    //l'email n'existe pas pour une autre compte
                    $reqmail = $bdd->prepare("SELECT * FROM user WHERE email = ?");
                    $reqmail->execute(array($email));
                    $mailexist = $reqmail->rowCount(); //si une ligne est renvoyé, l'email existe déjà dans la bdd

                    if($mailexist == 0){

                        //l'email n'existe pas pour une autre compte
                        $reqpseudo = $bdd->prepare("SELECT * FROM user WHERE pseudo = ?");
                        $reqpseudo->execute(array($pseudo));
                        $pseudoexist = $reqpseudo->rowCount(); //si une ligne est renvoyé, le pseudo existe déjà dans la bdd

                        if($pseudoexist == 0 ){

                            //verifier que les deux mots de passe correspondent
                            if($mdp == $mdpVerif){

                                //toutes les conditions sont ok => inscription/insertion des données dans le bdd
                                $insertUser = $bdd->prepare("INSERT INTO user(pseudo, email, mdp) VALUES(?, ?, ?)");
                                $insertUser->execute(array($pseudo, $email, $mdp));
                                $message = "Votre compte a bien été créé ! <a href=\"index.php?action=connexion\">Me connecter</a>";
                            }
                            else{
                                $message="les mots de passe ne correspondent pas";
                                header("Location:index.php?action=inscription&message=".$message);
                            }
                        }
                        else{
                            $message='ce pseudo existe déjà';
                            header("Location:index.php?action=inscription&message=".$message);
                        }
                    }
                    else{
                        $message="cet email existe déjà!";
                        header("Location:index.php?action=inscription&message=".$message);
                    }
                }
                else{
                    $message="l'email n'est pas valide";
                    header("Location:index.php?action=inscription&message=".$message);
                }
            }
            else{
                $message="le pseudo est trop long";
                header("Location:index.php?action=inscription&message=".$message);
            }
        }
        else{
            $message = "veuilllez remplir tous les champs";
            header("Location:index.php?action=inscription&message=".$message);
        }

?>