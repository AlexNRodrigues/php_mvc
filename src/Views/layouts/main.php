<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? $title : 'Minha Aplicação'; ?></title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/css/style.css">
</head>

<body>
    <nav>
        <a href="<?= $router->url('/home') ?>">Home</a>
        <?php
            use Core\Session;
            Session::start(); 
        ?>
        <?php if (Session::isLoggedIn()): ?>
            <?php if (Session::getAccessLevel() === 'admin'): ?>
                <a href="/php_mvc/adm/dashboard">Admin Dashboard</a>
            <?php endif; ?>
            <a href="<?= $router->url('/logout') ?>">Logout</a>
        <?php else: ?>
            <a href="<?= $router->url('/login') ?>">Login</a>
        <?php endif; ?>
    </nav>
    <main>
        <?php echo $content; ?>
    </main>

    <footer>
        <p>© 2025 Minha Aplicação</p>
    </footer>

    <script src="<?php echo BASE_URL; ?>/js/app.js"></script>
</body>

</html>