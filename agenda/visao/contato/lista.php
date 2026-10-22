<?php
/* ============================================================
    lista.php
    Camada: VISÃO -> Contato

    Espera receber do CONTROLE:
      $lista  -> array de objetos Contato (obrigatório)
      $status -> mensagem de sucesso/erro (opcional)
   ============================================================ */
?>
<h2>Listagem de Contatos</h2>

<?php
    // Mostra mensagem de status (cadastro feito, contato excluído, etc.)
    if (isset($status)) {
        echo "<p><strong>" . htmlspecialchars($status) . "</strong></p>";
    }

    // Boas-vindas se o usuário estiver logado
    if (isset($_SESSION['usuario'])) {
        $usuario = unserialize($_SESSION['usuario']);
        echo "<h3>Bem-vindo(a) " . htmlspecialchars($usuario->getNome()) . "</h3>";
    }
?>

<a href="contato.php?fun=cadastrar">+ Cadastrar novo contato</a>
<br /><br />

<table border="1" cellpadding="6" cellspacing="0">
    <tr>
        <th>ID</th>
        <th>Nome</th>
        <th>Email</th>
        <th>Telefone</th>
        <?php if (isset($_SESSION['usuario'])): ?>
            <th><img src="assets/img/update.png" width="25" alt="Alterar" /></th>
            <th><img src="assets/img/delete.png" width="25" alt="Excluir" /></th>
        <?php endif; ?>
    </tr>

    <?php foreach ($lista as $c): ?>
        <tr>
            <td><?php echo $c->getId(); ?></td>
            <td>
                <a href="contato.php?fun=exibir&id=<?php echo $c->getId(); ?>">
                    <?php echo htmlspecialchars($c->getNome()); ?>
                </a>
            </td>
            <td><?php echo htmlspecialchars($c->getEmail()); ?></td>
            <td><?php echo htmlspecialchars($c->getTelefone()); ?></td>

            <?php if (isset($_SESSION['usuario'])): ?>
                <td>
                    <a href="contato.php?fun=alterar&id=<?php echo $c->getId(); ?>">
                        <img src="assets/img/update.png" width="25" alt="Alterar" />
                    </a>
                </td>
                <td>
                    <a href="contato.php?fun=excluir&id=<?php echo $c->getId(); ?>">
                        <img src="assets/img/delete.png" width="25" alt="Excluir" />
                    </a>
                </td>
            <?php endif; ?>
        </tr>
    <?php endforeach; ?>
</table>
