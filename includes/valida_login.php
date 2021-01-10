<?php
    $_SESSION['url_retorno'] = $_SERVER['PHP_SELF'];

    if(!isset($_SESSION['login'])){
        header('Location: Projeto/login_formulario.php');
        exit;
    }