<?php
/* ============================================================
    exibe.php
    Camada: VISÃO -> Contato
    Mostra detalhes de UM contato. Espera $cont (objeto Contato).
   ============================================================ */
?>
<h2>Contato: <?php echo htmlspecialchars($cont->getNome()); ?></h2>

<ul>
    <li><strong>Nome:</strong> <?php echo htmlspecialchars($cont->getNome()); ?></li>
    <li><strong>Telefone:</strong> <?php echo htmlspecialchars($cont->getTelefone()); ?></li>
    <li><strong>E-mail:</strong> <?php echo htmlspecialchars($cont->getEmail()); ?></li>
    <li>
        <?php if ($cont->getFoto() && $cont->getFoto() !== "..."): ?>
            <img src="<?php echo htmlspecialchars($cont->getFoto()); ?>" width="150" alt="Foto" />
        <?php else: ?>
            <em>(sem foto)</em>
        <?php endif; ?>
    </li>
</ul>

<a href="contato.php?fun=listar">&larr; Voltar para a lista</a>
