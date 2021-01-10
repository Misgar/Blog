<div class="card">
    <div class="card-header">
        Menu
    </div>

    <div class="card-body">
        <ul class="nav flex-column">
            <li class="nav-item"><a href="index.php" class="nav-link">Home</a></li>
            <li class="nav-item"><a href="usuario_formulario.php" class="nav-link">Cadastre-se</a></li>
            <li class="nav-item"><a href="login_formulario.php" class="nav-link">Login</a></li>
            <li class="nav-item"><a href="post_formulario.php" class="nav-link">Incluir Post</a></li>         
            <?php if ((isset($_SESSION['login'])) && ($_SESSION['login']['usuario']['adm'] ===1)) : ?>
                <li class="nav-item"><a href="usuarios.php" class="nav-link">Usuários</a></li>
            <?php endif; ?>
        
        </ul>
    </div>

</div>