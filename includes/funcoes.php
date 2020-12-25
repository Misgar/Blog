<?php
# Evitar SQL INJECTION

function limparDados (string $dado) : string
{
    # Tags que não serão removidas
    $tags = '<p><strong><i><u><ol><li><h1><h2><h3>';

    # <p> = &lt;p&gt;
    $retorno = htmlentities(strip_tags($dado, $tags));

    return $retorno;
}