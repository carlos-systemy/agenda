<?php


    $host="localhost";
    $dbname = "agenda";
    $user ="root";
    $pass ="123456";

        try{

            $conn = new PDO("mysql:host=$host:3306;dbname=$dbname",$user,$pass);


            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


        }catch(PDOException $e){

            $erro = $e->getMessage();
            echo "Erro: $erro";


        }
?>