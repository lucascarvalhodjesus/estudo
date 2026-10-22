<?php
/* ==========================================================================
 *  AlterarContato.php
 * --------------------------------------------------------------------------
 *  Camada: CONTROLE
 *
 *  Lógica:
 *    - Se chegou via GET (link "alterar")  -> busca o contato pelo id
 *      e mostra o formulário PREENCHIDO com os dados atuais.
 *    - Se chegou via POST (form enviado)   -> aplica a alteração no BD
 *      e mostra a lista atualizada.
 * ========================================================================== */

require_once __DIR__ . "/../../modelo/contato/ContatoDAO.php";

class AlterarContato {

    public function __construct() {

        // Form ainda não foi enviado: busca dados atuais e mostra o formulário.
        if (!isset($_POST["enviar"])) {
            $dao  = new ContatoDAO();
            $cont = $dao->exibir($_GET["id"]); // objeto Contato
            require __DIR__ . "/../../visao/contato/formAltera.php";
            return;
        }

        // Form enviado: aplica a alteração no banco.
        $c = new Contato();
        $c->setId($_POST["id"]);
        $c->setNome($_POST["nome"]);
        $c->setEmail($_POST["email"]);
        $c->setTelefone($_POST["telefone"]);
        // Mantém a foto antiga (não estamos atualizando o arquivo aqui).
        $dao = new ContatoDAO();
        $atual = $dao->exibir($_POST["id"]);
        $c->setFoto($atual ? $atual->getFoto() : "...");

        $dao->alterar($c);

        $status = "Alteração do Contato " . $c->getNome() . " efetuada com sucesso";
        $lista  = $dao->listar();

        require __DIR__ . "/../../visao/contato/lista.php";
    }
}
