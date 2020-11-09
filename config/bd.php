<?php

$host="localhost";

$db="klaus";

$user="root";

$passwd="root";
try {
// On essaie de créer une instance de PDO.
$bdd = new PDO("mysql:host=$host;dbname=$db", $user, $passwd,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}  
catch(Exception $e) {
echo "Erreur : ".$e->getMessage()."<br />";
}

?>
