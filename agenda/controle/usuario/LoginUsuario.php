<?php
/* ==========================================================================
 *  LoginUsuario.php
 * --------------------------------------------------------------------------
 *  Camada: CONTROLE
 *
 *  Lógica:
 *    - Se o formulário de login NÃO foi enviado -> mostra o form.
 *    - Se foi enviado:
 *         * tenta logar via UsuarioDAO;
 *         * se falhar, mostra o form com mensagem de erro;
 *         * se der certo, registra o usuário na sessão e
 *           manda para a listagem de contatos.
 *
 *  Por que registrar na sessão?
 *  ----------------------------
 *  $_SESSION é uma "memória do servidor" que dura enquanto o
 *  navegador estiver aberto. A listagem de contatos verifica
 *  $_SESSION['usuario'] para mostrar (ou não) os botões de
 *  alterar/excluir.
 * ========================================================================== */

require_once __DIR__ . "/../../modelo/usuario/UsuarioDAO.php";
require_once __DIR__ . "/../../modelo/contato/ContatoDAO.php";

class LoginUsuario {

    public function __construct() {

        // Form ainda não enviado: apenas mostra o formulário.
        if (!isset($_POST["enviar"])) {
            require __DIR__ . "/../../visao/usuario/formLogin.php";
            return;
        }

        // Tenta autenticar.
        $dao     = new UsuarioDAO();
        $usuario = $dao->logar($_POST["login"], $_POST["senha"]);

        // Login inválido: mostra o form de novo com mensagem.
        if ($usuario === null) {
            $status = "Login ou senha incorretos";
            require __DIR__ . "/../../visao/usuario/formLogin.php";
            return;
        }

        /* ----------- Login OK: registra na sessão ----------- */
        // serialize() converte o objeto em string (forma segura
        // de guardar objetos em $_SESSION).
        $_SESSION["usuario"]    = serialize($usuario);
        $_SESSION["data_login"] = date("d/m/Y H:i:s");

        // Já mostra a lista de contatos com os botões de admin.
        $daoContato = new ContatoDAO();
        $lista      = $daoContato->listar();
        require __DIR__ . "/../../visao/contato/lista.php";
    }
}
