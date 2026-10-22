<?php
/* ============================================================
    confirmaExclusao.php
    Camada: VISÃO -> Contato
    Pergunta ao usuário se ele realmente quer excluir o contato.
    Espera $cont (objeto Contato).
   ============================================================ */
?>
<h2>Confirmar exclusão</h2>

<p>Deseja realmente excluir o contato
   <strong><?php echo htmlspecialchars($cont->getNome()); ?></strong>?
</p>

<p>
    <a href="contato.php?fun=excluir&conf=sim&id=<?php echo $cont->getId(); ?>">Sim, excluir</a>
    &nbsp;|&nbsp;
    <a href="contato.php?fun=listar">Não, voltar</a>
</p>
