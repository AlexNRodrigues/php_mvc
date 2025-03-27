<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? $title : 'Minha Aplicação'; ?></title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/css/app.css">
</head>

<body>

    <?php include __DIR__ . '/partials/sidebar.php'; ?>

    <div class="main-content">
        <?php include __DIR__ . '/partials/navbar.php'; ?>

        <div id="content" class="content">
            <?php echo $content; ?>
        </div>
        
        <footer>
            <p>© 2025 Minha Aplicação</p>
        </footer>
    </div>

    <script src="<?php echo BASE_URL; ?>/js/app.js"></script>
</body>

</html>