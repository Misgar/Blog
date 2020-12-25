<?php

/**
 * Gerenciando as ações dentro do sistema utilizando os metodos
 * de acesso ao banco previamente configurados.
 */

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

switch ($acao) {
    case 'insert':
        $dados = [
            'nome'  => $nome,
            'email' => $email,
            'senha' => crypt($senha)
        ];

        insere(
            'usuario',
            $dados
        );

        break;

    case 'update':
        $id = (int) $id;
        $dados = [
            'nome' => $nome,
            'email' => $email,
        ];

        $criterio = [
            ['id', '=', $id]
        ];

        atualiza(
            'usuario',
            $dados,
            $criterio
        );

        break;

    case 'login':
        # Verificando email e se está ativo
        $criterio = [
            ['email', '=', $email],
            ['AND', 'ativo', '=', 1]
        ];

        # Retornando busca do usuario no banco
        $retorno = buscar(
            'usuario',
            ['id', 'nome', 'email', 'senha', 'adm'],
            $criterio
        );

        if(count($retorno) > 0){
            if (crypt($senha, $retorno[0]['senha']) == $retorno[0]['senha']){
                $_SESSION['login']['usuario'] = $retorno[0]; # Armazenando os dados do usuario retornado

                # Verifica se está logado e armazena a url
                if (!empty($_SESSION['url_retorno'])) 
                {
                    # Se sim, redireciona para url
                    header('Location: ' . $_SESSION['url_retorno']);
                    $_SESSION['url_retorno'] = '';
                    exit;
                }
            }
        }

        break;
    case 'logout':
        session_destroy();
        break;
    
    # Atualizando o status do usuario no sistema (ativo/desativado)
    case 'status':
        $id = (int) $id;
        $valor = (int) $valor;

        $dados = [
            'ativo' => $valor
        ];

        $criterio = [
            ['id', '=', $id]
        ];

        atualiza(
            'usuario',
            $dados,
            $criterio
        );

        header('Location: ../usuarios.php');
        exit;
        break;

        # Promoção para administrador
    case 'adm':
        $id = (int) $id;
        $valor = (int) $valor;

        $dados = [
            'adm' => $valor
        ];

        $criterio = [
            ['id', '=', $id]
        ];

        atualiza(
            'usuario',
            $dados,
            $criterio
        );

        header('Location: ../usuarios.php');
        exit;
        break;

}

header('Location: ../index.php');