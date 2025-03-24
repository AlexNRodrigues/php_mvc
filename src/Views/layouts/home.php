<?php

use Core\Session;

?>

<h1>Bem-vindo, <?php echo Session::get('usuario_id') ?? 'Visitante'; ?></h1>
<p>Você está logado como <?php echo Session::getAccessLevel(); ?>.</p>

<?php dump(Session::get('usuario')); ?>