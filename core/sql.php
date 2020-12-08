<?php

# Abstração de querys sql

# Retorna query Insert.
function insert(string $entidade, array $dados): string
{
    $instrucao = "INSERT INTO {$entidade}";

    # Retorna as chaves e valores do array dados, converte em uma string separada por virgula
    $campos = implode(', ', array_keys($dados));
    $valores = implode(', ', array_values($dados));

    $instrucao .= " ({$campos})";
    $instrucao .= " VALUES ({$valores})";

    return $instrucao;
}

$table = 'usuarios';
$campos = array(
    "Nome" => "Renato",
    "Email" => "oliveira.renato12"
);

$criterios = [
    'nome', 'idade'];


echo insert($table, $campos);

# Retorna query de update com ou sem where
function update(string $entidade, array $dados, array $criterio = []): string
{
    $instrucao = "UPDATE {$entidade}";

    foreach($dados as $campo => $dado)
    {
        $set[] = "{$campo} = {$dado}";
    }
    
    $instrucao .= ' SET ' . implode(', ', $set);
    
    if(!empty($criterio))
    {
        $instrucao .= ' WHERE ';

        foreach($criterio as $expressao)
        {
            $instrucao .= ' ' . implode(' ', $expressao);
        }
    }

    return $instrucao;
}

# Retorna query Delete com ou sem where.
function delete(string $entidade, array $criterio = [])
{
    $instrucao = "DELETE FROM {$entidade}";

    if (!empty($criterio))
    {
        $instrucao .= ' WHERE';

        foreach ($criterio as $expressao)
        {
            $instrucao .= ' ' . implode(' ', $expressao);
        }
    }
    
    return $instrucao;
}


echo update($table, $campos, $criterios);