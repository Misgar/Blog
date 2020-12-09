<?php

// Executando funções no banco com Prepared Statements


function insere(string $entidade, array $dados): bool
{
    $retorno = false;

    foreach($dados as $campo => $dado)
    {
        # Gerando caracteres coringa de acordo com a quantidade de campos passados
        $coringa[$campo] = '?';
        $tipo[] = gettype($dado)[0];
        $$campo = $dado;
    }

    // insert into usuario (nome, email, senha) values (?, ?, ?)
    $instrucao = insert($entidade, $coringa);

    $conexao = conecta();

    $stmt = mysqli_prepare($conexao, $instrucao);

    // mysqli_stmt_bind_param($stmt, 'sss', $nome, $email, $senha);
    eval('mysqli_stmt_bind_param($stmt, \'' . implode('', $tipo) . '\', $'
     . implode(', $', array_keys($dados)) . ');');

    mysqli_stmt_execute($stmt);

    # Retorna true caso tenha sido possivel executar o comando no banco (caso linhas tenham sido afetadas)
    $retorno = (boolean) mysqli_stmt_affected_rows($stmt);

    $_SESSION['erros'] = mysqli_stmt_error_list($stmt);

    mysqli_stmt_close($stmt);

    desconecta($conexao);

    return $retorno;

}