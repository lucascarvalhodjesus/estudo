<?php
/* ==========================================================================
 *  UsuarioDAO.php
 * --------------------------------------------------------------------------
 *  Camada: MODELO  -> DAO (Data Access Object)
 *
 *  Responsável pelas operações de banco relacionadas ao Usuario.
 *  Aqui temos só a função `logar`, que tenta autenticar o usuário.
 *
 *  CORREÇÃO DE BUG (importante!)
 *  -----------------------------
 *  Versão antiga tinha 3 problemas:
 *    1. `echo $sql;` deixava o SQL aparecer na tela.
 *    2. `$dado = $lista->fetchAll(...)` causava erro fatal — $lista
 *       já era array (resultado de fetchAll). Isso quebrava tudo
 *       depois do login, antes mesmo de carregar a lista de contatos.
 *    3. SQL concatenado com strings (vulnerável a SQL Injection).
 *  Aqui usamos prepared statements e tratamos o resultado certinho.
 * ========================================================================== */

require_once __DIR__ . "/../ConnectionFactory.php";
require_once __DIR__ . "/Usuario.php";

class UsuarioDAO {

    private $con;

    public function __construct() {
        $this->con = ConnectionFactory::getConnection();
    }

    /* ===================================================================
     *  logar($login, $senha)
     *
     *  Verifica se existe um usuário com aquele login/senha.
     *  Devolve o objeto Usuario se encontrou, ou null se não encontrou.
     *
     *  A senha é armazenada no banco como md5 (foi como o projeto
     *  começou). Em produção use password_hash()/password_verify().
     * =================================================================== */
    public function logar($login, $senha) {
        try {
            $senhaCriptografada = md5($senha);

            $stmt = $this->con->prepare(
                "SELECT * FROM usuario
                  WHERE login = :login
                    AND senha = :senha"
            );
            $stmt->bindValue(":login", $login);
            $stmt->bindValue(":senha", $senhaCriptografada);
            $stmt->execute();

            // fetch() devolve UMA linha (array assoc) ou false se não achou.
            $linha = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$linha) {
                return null; // login/senha incorretos
            }

            // Monta o objeto Usuario que será guardado na sessão.
            $u = new Usuario();
            $u->setId($linha["id"]);
            $u->setNome($linha["nome"]);
            $u->setLogin($linha["login"]);
            // Por segurança NÃO guardamos a senha no objeto retornado.

            return $u;
        } catch (PDOException $ex) {
            echo "Erro ao realizar login: " . $ex->getMessage();
            return null;
        }
    }
}
