<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title><?php echo isset($title) ? $title : 'Minha Aplicação'; ?></title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/css/style.css">
</head>

<body>
    <header>
        <h1>Minha Aplicação</h1>
        <nav>
            <a href="<?php echo BASE_URL; ?>/users">Usuários</a>
        </nav>
    </header>

    <main>
        <?php echo $content; ?>
    </main>

    <footer>
        <p>© 2025 Minha Aplicação</p>
    </footer>

    <script src="<?php echo BASE_URL; ?>/js/app.js"></script>
</body>

</html>