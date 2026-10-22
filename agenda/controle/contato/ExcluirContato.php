<?php
/* ==========================================================================
 *  ExcluirContato.php
 * --------------------------------------------------------------------------
 *  Camada: CONTROLE
 *
 *  Fluxo de exclusão em 2 passos (boa prática didática):
 *    Passo 1: usuário clica em "excluir" -> mostramos uma página
 *             pedindo confirmação ("Tem certeza?").
 *    Passo 2: se confirmar (link com conf=sim), o registro é apagado
 *             e mostramos a lista atualizada.
 * ========================================================================== */

require_once __DIR__ . "/../../modelo/contato/ContatoDAO.php";

class ExcluirContato {

    public function __construct() {

        $dao  = new ContatoDAO();
        $cont = $dao->exibir($_GET["id"]); // contato a ser excluído

        // Passo 2 — confirmação recebida: apaga e mostra lista.
        if (isset($_GET["conf"]) && $_GET["conf"] === "sim") {

            // Se houver arquivo de foto físico, removê-lo do disco.
            if ($cont && $cont->getFoto() && file_exists(__DIR__ . "/../../" . $cont->getFoto())) {
                @unlink(__DIR__ . "/../../" . $cont->getFoto());
            }

            $dao->excluir($cont);
            $status = "O contato " . $cont->getNome() . " foi excluído com sucesso";
            $lista  = $dao->listar();

            require __DIR__ . "/../../visao/contato/lista.php";
            return;
        }

        // Passo 1 — pede confirmação.
        require __DIR__ . "/../../visao/contato/confirmaExclusao.php";
    }
}
