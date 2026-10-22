<?php
/* ============================================================
    formAltera.php
    Camada: VISÃO -> Contato
    Formulário PRÉ-PREENCHIDO para alterar um contato.
    Espera $cont (objeto Contato).
    O id vai num <input type="hidden"> para chegar no $_POST.
   ============================================================ */
?>
<h2>Alterar Contato</h2>

<form action="contato.php?fun=alterar" method="POST">

    <input type="hidden" name="id" value="<?php echo $cont->getId(); ?>" />

    <label for="nome">Nome:</label>
    <input type="text" id="nome" name="nome"
           value="<?php echo htmlspecialchars($cont->getNome()); ?>" required />

    <label for="email">Email:</label>
    <input type="email" id="email" name="email"
           value="<?php echo htmlspecialchars($cont->getEmail()); ?>" />

    <label for="tel">Telefone:</label>
    <input type="text" id="tel" name="telefone"
           value="<?php echo htmlspecialchars($cont->getTelefone()); ?>" />

    <input type="submit" name="enviar" value="Salvar alterações" />
</form>
