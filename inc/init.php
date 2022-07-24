<?php

// Connection à la bdd en utilisant PDO
$pdo = new PDO('mysql:host=localhost; dbname=repertoire', 'root', '', array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
));


//Initialisation d'une variable pour afficher du contenu HTML
$contenu = '';

//inclusion du fichier functions.php
require_once 'functions.php';