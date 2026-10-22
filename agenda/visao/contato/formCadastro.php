<?php
/* ============================================================
    formCadastro.php
    Camada: VISÃO -> Contato
    Formulário em branco para cadastrar um novo contato.
    O atributo enctype="multipart/form-data" é obrigatório
    quando o form envia ARQUIVOS (no caso, a foto).
   ============================================================ */
?>
<h2>Cadastrar novo contato</h2>

<form action="contato.php?fun=cadastrar" method="POST" enctype="multipart/form-data">

    <label for="nome">Nome:</label>
    <input type="text" id="nome" name="nome" required />

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" />

    <label for="tel">Telefone:</label>
    <input type="text" id="tel" name="telefone" />

    <label for="foto">Foto:</label>
    <input type="file" id="foto" name="foto" accept="image/*" />

    <input type="submit" name="enviar" value="Cadastrar" />
</form>
