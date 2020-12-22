<?php

session_start();

require_once '../includes/funcoes.php';
require_once 'conexao_mysql.php';
require_once 'sql.php';
require_once 'mysql.php';

# Certificando as tags passadas pelo usuário, evitando ataques.
foreach ($_POST as $indice => $dado)
{
    $$indice = limparDados($dado);
}

foreach($_GET as $indice => $dado)
{
    $$indice = limparDados($dado);
}