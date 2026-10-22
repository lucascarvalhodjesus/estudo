<?php
/* ============================================================
    formLogin.php
    Camada: VISÃO -> Usuario
    Formulário de autenticação.
    Se o controle setou $status (ex.: "Login ou senha incorretos"),
    a mensagem é exibida acima do form.
   ============================================================ */
?>
<h2>Área Administrativa</h2>

<?php if (isset($status)): ?>
    <p style="color:#f55;"><strong><?php echo htmlspecialchars($status); ?></strong></p>
<?php endif; ?>

<form action="usuario.php?fun=logar" method="POST">

    <label for="login">Login:</label>
    <input type="text" id="login" name="login" required />

    <label for="senha">Senha:</label>
    <input type="password" id="senha" name="senha" required />

    <input type="submit" name="enviar" value="Entrar" />
</form>
