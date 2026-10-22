<?php
/* ==========================================================================
 *  ListarContato.php
 * --------------------------------------------------------------------------
 *  Camada: CONTROLE
 *
 *  O que o Controle faz?
 *  ---------------------
 *  É o "cérebro" que recebe a requisição vinda do roteador (contato.php),
 *  decide o que fazer, conversa com o MODELO (DAO) para pegar/salvar
 *  dados e, no final, escolhe qual VISÃO mostrar ao usuário.
 *
 *  Este controle é o mais simples: pede a lista de contatos ao DAO e
 *  manda exibir a tela de listagem.
 * ========================================================================== */

require_once __DIR__ . "/../../modelo/contato/ContatoDAO.php";

class ListarContato {

    public function __construct() {
        // 1. Pega os dados do MODELO
        $dao   = new ContatoDAO();
        $lista = $dao->listar();   // array de objetos Contato

        // 2. Carrega a VISÃO que vai usar a variável $lista acima
        require __DIR__ . "/../../visao/contato/lista.php";
    }
}
