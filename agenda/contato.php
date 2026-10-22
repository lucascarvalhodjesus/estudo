<?php
/* ==========================================================================
 *  contato.php
 * --------------------------------------------------------------------------
 *  ROTEADOR de Contato.
 *
 *  Recebe o parâmetro ?fun= na URL e decide qual CONTROLE chamar:
 *
 *      contato.php?fun=listar     -> ListarContato
 *      contato.php?fun=cadastrar  -> CadastrarContato
 *      contato.php?fun=alterar    -> AlterarContato
 *      contato.php?fun=excluir    -> ExcluirContato
 *      contato.php?fun=exibir     -> ExibirContato
 *
 *  Sem parâmetro -> cai no listar (padrão).
 * ========================================================================== */

session_start();

// A classe Usuario precisa estar carregada antes de unserialize() na sessão.
require_once __DIR__ . "/modelo/usuario/Usuario.php";

require_once __DIR__ . "/visao/layout/topo.php";

// Pega a função pedida; se não vier nada, usa "listar".
$fun = isset($_GET["fun"]) ? $_GET["fun"] : "listar";

switch ($fun) {
    case "cadastrar":
        require_once __DIR__ . "/controle/contato/CadastrarContato.php";
        new CadastrarContato();
        break;

    case "alterar":
        require_once __DIR__ . "/controle/contato/AlterarContato.php";
        new AlterarContato();
        break;

    case "excluir":
        require_once __DIR__ . "/controle/contato/ExcluirContato.php";
        new ExcluirContato();
        break;

    case "exibir":
        require_once __DIR__ . "/controle/contato/ExibirContato.php";
        new ExibirContato();
        break;

    case "listar":
    default:
        require_once __DIR__ . "/controle/contato/ListarContato.php";
        new ListarContato();
        break;
}

require_once __DIR__ . "/visao/layout/base.php";
