<?php
/* ==========================================================================
 *  ExibirContato.php
 * --------------------------------------------------------------------------
 *  Camada: CONTROLE
 *
 *  Mostra os detalhes de UM contato (página de "ficha" do contato).
 * ========================================================================== */

require_once __DIR__ . "/../../modelo/contato/ContatoDAO.php";

class ExibirContato {

    public function __construct() {
        $dao  = new ContatoDAO();
        $cont = $dao->exibir($_GET["id"]); // objeto Contato

        require __DIR__ . "/../../visao/contato/exibe.php";
    }
}
