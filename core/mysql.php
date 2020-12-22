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

    # Retorna true com Casting caso  tenha sido possivel executar o comando no banco (caso linhas tenham sido afetadas)
    $retorno = (boolean) mysqli_stmt_affected_rows($stmt);

    # Criando variavel erros em sessão
    $_SESSION['erros'] = mysqli_stmt_error_list($stmt);

    mysqli_stmt_close($stmt);

    desconecta($conexao);

    return $retorno;

}

function atualiza(string $entidade, array $dados, array $criterio = []) : bool
{
    $retorno = false;

    foreach ($dados as $campo => $dado)
    {
        $coringa_dados[$campo] = '?';
        $tipo[] = gettype($dado)[0];
        $$campo = $dado;
    }

    foreach($criterio as $expressao)
    {
         # -1 Pra pegar indice pela func count
         $dado = $expressao[count($expressao) - 1];

        $tipo[] = gettype($dado)[0];

        # -1 Pra pegar indice pela func count
        $expressao[count($expressao) - 1] = '?';
        $coringa_criterio[] = $expressao;

        /*
            Podemos ter uma lista de criterios
            count < 4                           count = 4
            [['nome', '=', 'Maria de Souza'], ['AND', 'email', 'like', %ecorp%]]
        */

        $nome_campo = (count($expressao) < 4) ? $expressao[0] : $expressao[1];
            
        if (isset($$nome_campo)) 
        {
            $nome_campo .= '_' . rand();
        }

            $campos_criterio[] = $nome_campo;

            $$nome_campo = $dado;

        }

    # update usuario set nome = ?, email = ?, senha = ?
        # where id = ?

    $instrucao = update($entidade, $coringa_dados, $coringa_criterio);

    $conexao = conecta();

    $stmt = mysqli_prepare($conexao, $instrucao);

    # Montando o statement e executando ##
    if(isset($tipo)){
        $comando = 'mysqli_stmt_bind_param($stmt, ';
        $comando .= "'" . implode('', $tipo) . "'";
        $comando .= ', $' . implode(', $', array_keys($dados));
        $comando .= ', $' . implode(', $', $campos_criterio);
        $comando .= ');';
            
        // Executando a string
        eval($comando);
    }

    mysqli_stmt_execute($stmt);

    $retorno = (boolean) mysqli_stmt_affected_rows($stmt);

    $_SESSION['erros'] = mysqli_stmt_error_list($stmt);

    mysqli_stmt_close($stmt);

    desconecta($conexao);

    return $retorno;

}

function delete(string $entidade, array $criterio = []) : bool
{
    $retorno = false;

    $coringa_criterio = [];
    
    foreach($criterio as $expressao)
    {
        $dado = $expressao[count($expressao) - 1];

        $tipo[] = gettype($dado)[0];
        $expressao[count($expressao) - 1] = '?';
        $coringa_criterio[] = $expressao;

        $nome_campo = (count($expressao) < 4) ? $expressao[0] : $expressao[1];

        $campos_criterio[] = $nome_campo;

        $$nome_campo = $dado;
    }

    $intrucao = delete($entidade, $coringa_criterio);

    $conexao = conecta();

    $stmt = mysqli_prepare($conexao, $instrucao);

    if(isset($tipo))
    {
        $comando = 'mysqli_stmt_bind_param($stmt, ';
        $comando .= "'" . implode('', $tipo) . "'";
        $comando .= ', $' . implode(', $', $campos_criterio);
        $comando .= ');';

        eval($comando);
    }

    mysqli_stmt_execute($stmt);

    $retorno = (boolean) mysqli_stmt_affected_rows($stmt);

    $_SESSION['erros'] = mysqli_stmt_error_list($stmt);

    $mysqli_stmt_close($stmt);

    desconecta($conexao);

    return $retorno;
}

function buscar (string $entidade, array $campos = ['*'], array $criterio = [], string $ordem = null): array
{
    $retorno = [];
    $coringa_criterio = [];

    foreach ($criterio as $expressao)
    {
        $dado = $expressao[count($expressao) - 1];

        $tipo[] = gettype($dado)[0];
        $expressao[count($expressao) - 1] = '?';
        $coringa_criterio[] = $expressao;

        $nome_campo = (count($expressao) < 4 ) ? $expressao[0] : $expressao[1];

        if (isset($$nome)) {
            $nome_campo = $nome_campo . '_' . rand();
        }

        $campo_criterio[] = $nome_campo;
    }
}
