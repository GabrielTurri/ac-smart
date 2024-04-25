<?php
    $server = "ac-smart-database.cha6yq8iwxxu.sa-east-1.rds.amazonaws.com";
    $usuario = "felipe";
    $senha = "abcd=1234";
    $banco = "humanitae_db";

    $conexao = mysqli_connect($server, $usuario, $senha);

    $db = mysqli_select_db($conexao, $banco);
        if ($conexao && $db)
        {
            echo "Conexão OK";
        }
        else
        {
            echo "Conexão errada";
        }

?>