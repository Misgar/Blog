<?php

function conecta() : mysqli
{
    $conexao = mysqli_connect('127.0.0.1', 'root', ' ', 'blog');

    if (!$conexao)
    {
        echo "Erro: Não foi possivel conectar ao mysql." . PHP_EOL;
        echo "Debuggin errno: " . mysqli_connect_errno() . PHP_EOL;
        echo "Debuggin error: " . mysqli_connect_error() . PHP_EOL;

    }

    return $conexao;
}

function desconecta($conexao)
{
    mysqli_close($conexao);
}