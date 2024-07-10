<?php

    $servidorBD = "localhost";
    $usuarioBD  = "root";
    $senhaBD    = "root";
    $database   = "generico_lojas";

    //Função do PHP para estabelecer conexao com o BD
    $conn = mysqli_connect($servidorBD, $usuarioBD, $senhaBD, $database);

    if(!$conn){
        echo "<p>Erro ao tentar conectar à Base de Dados <b>$database!</b> </p>";
    }
?>