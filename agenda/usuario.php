<?php
/* ==========================================================================
 *  usuario.php
 * --------------------------------------------------------------------------
 *  ROTEADOR de Usuário.
 *
 *      usuario.php?fun=logar -> LoginUsuario   (mostra form / processa login)
 *      usuario.php?fun=sair  -> destrói a sessão e volta para o início
 * ========================================================================== */

session_start();

// A classe Usuario precisa estar carregada antes de unserialize() na sessão.
require_once __DIR__ . "/modelo/usuario/Usuario.php";

require_once __DIR__ . "/visao/layout/topo.php";

$fun = isset($_GET["fun"]) ? $_GET["fun"] : "";

switch ($fun) {
    case "logar":
        require_once __DIR__ . "/controle/usuario/LoginUsuario.php";
        new LoginUsuario();
        break;

    case "sair":
        // Logout: limpa e destrói a sessão.
        $_SESSION = array();
        session_destroy();
        // Redireciona para a página inicial.
        echo "<script>location.href='index.php';</script>";
        break;

    default:
        // Sem parâmetro válido: volta pra home.
        echo "<script>location.href='index.php';</script>";
        break;
}

require_once __DIR__ . "/visao/layout/base.php";
