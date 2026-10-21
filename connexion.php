<?php

    //Parametre de connexion

    $hote = "localhost";
    $base = "etudiants";
    $user = "root";
    $password = "";


    //Connexion a la base de données avec PDO

    try {
        $pdo = new PDO("mysql:host=$hote;dbname=$base;charset=utf8", $user, $password);

        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    } catch (PDOException $e) {

        die("Erreur de connexion : " .$e->getMessage());
    }
?>