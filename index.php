<?php

include("config/config.php");
include("config/bd.php");
include("divers/balises.php");
include("config/actions.php");
session_start();
ob_start();


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Klaussnetword</title>

    <!-- style -->
    <link rel="stylesheet" href="asset/css/main.css">

    <!-- bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

    <!-- fontawesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">

    
</head>
<body>


<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#">Klaus</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="index.php?action=home">Home <span class="sr-only">(current)</span></a>
      </li>
      <?php
        if(isset($_SESSION['id'])){
          ?>
          <li class="nav-item">
            <a class="nav-link" href="index.php?action=deconnexion">Deconnexion</a>
          </li>
          <?php
        }
        else{
          ?>
          <li class="nav-item">
            <a class="nav-link" href="index.php?action=inscription">Inscription</a>
          </li>
          <?php
        }
      ?>
        
      <li class="nav-item">
        <a class="nav-link" href="index.php?action=profil&id=<?=$_SESSION['id']?>">Profil</a>
      </li>
    </ul>
    <form class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form>
  </div>
</nav>


    <div class="container-fluid">
        <div class="row">
            <!--<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">-->
            <div class="col-md-12 main">
                <?php
                // Quelle est l'action à faire ?
                if (isset($_GET["action"])) {
                    $action = $_GET["action"];
                } else {
                    $action = "home";
                }

                // Est ce que cette action existe dans la liste des actions
                if (array_key_exists($action, $listeDesActions) == false) {
                    include("vues/404.php"); // NON : page 404
                } else {
                    include($listeDesActions[$action]); // Oui, on la charge
                }

                ob_end_flush(); // Je ferme le buffer, je vide la mémoire et affiche tout ce qui doit l'être
                ?>


            </div>
        </div>
    </div>





<!-- js -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    
</body>
</html>