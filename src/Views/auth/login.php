<?php
$title = "Login";
?>

<h1>Login</h1>
<?php if (isset($error)): ?>
    <p class="error"><?php echo $error; ?></p>
<?php endif; ?>
<form method="POST" action="login">
    <label>
        Usuário:
        <input type="text" name="numero" required>
    </label><br>
    <label>
        Senha:
        <input type="password" name="senha" required>
    </label><br>
    <button type="submit">Entrar</button>
</form>