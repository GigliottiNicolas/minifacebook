<?php

    if(!isset($_SESSION["id"])) {
        header("Location:index.php?action=login");
    }
    else{
        if($_GET['item'] == 'mdp'){
            if(!empty($_GET['oldMdp']) AND !empty($_GET['newMdp']) AND !empty($_GET['newMdpVerif'])){
                $oldMdp = $_GET['oldMdp'];
                $newMdp = $_GET['newMdp'];
                $newMdpVerif = $_GET['newMdpVerif'];

                echo $oldMdp;
                echo $newMdp;
                echo $newMdpVerif;
            }
        }
    }


?>