<div class="navbar">
    <h1>Schedule</h1>
    <div class="actions">
        <button class="icon-button">
            <img src="bell-icon.svg" alt="Notifications" width="20" height="20">
            <span class="notification-dot"></span>
        </button>

        <?php
            use Core\Session;
            Session::start(); 
        ?>
        <?php if (Session::isLoggedIn()): ?>
            <?php
                $usuario = Session::get('usuario');    
            ?>
            <div class="user-info">
                <span><?= $usuario->nome; ?></span>
                <!-- <button class="icon-button">
                    <img src="user-icon.svg" alt="User" width="20" height="20">
                </button> -->
                <a href="<?= $router->url('/logout') ?>">Logout</a>
            </div>
        <?php else: ?>
            <a href="<?= $router->url('/login') ?>" class="user-info">
                <span>Login</span>
                <button class="icon-button">
                    <img src="user-icon.svg" alt="User" width="20" height="20">
                </button>
            </a>
        <?php endif; ?>
    </div>
</div>