<?php
/* ==========================================================================
 *  ContatoDAO.php
 * --------------------------------------------------------------------------
 *  Camada: MODELO  -> DAO (Data Access Object)
 *
 *  O que é um DAO?
 *  ---------------
 *  É a classe responsável por TODAS as operações no banco de dados
 *  relacionadas a uma entidade (no caso, Contato). Implementa o CRUD:
 *
 *      C - Create   -> cadastrar()
 *      R - Read     -> listar() e exibir()
 *      U - Update   -> alterar()
 *      D - Delete   -> excluir()
 *
 *  Por que separar?
 *  ----------------
 *  Os Controles e as Visões NÃO precisam saber como o BD funciona.
 *  Eles apenas pedem ao DAO: "me dê a lista de contatos", "salve este
 *  contato", etc. Isso facilita manutenção e troca de banco.
 * ========================================================================== */

// __DIR__ garante que o caminho seja relativo a ESTE arquivo, e não
// ao script principal. Isso evita o famoso "include não encontrado".
require_once __DIR__ . "/../ConnectionFactory.php";
require_once __DIR__ . "/Contato.php";

class ContatoDAO {

    // Conexão PDO injetada pela ConnectionFactory (singleton).
    private $con;

    public function __construct() {
        $this->con = ConnectionFactory::getConnection();
    }

    /* ===================================================================
     *  CREATE — cadastrar um novo contato
     * =================================================================== */
    public function cadastrar(Contato $c) {
        try {
            // Prepared statement: as âncoras (:nome, :email...) protegem
            // contra SQL Injection.
            $stmt = $this->con->prepare(
                "INSERT INTO contato (nome, email, telefone, foto)
                 VALUES (:nome, :email, :telefone, :foto)"
            );

            $stmt->bindValue(":nome",     $c->getNome());
            $stmt->bindValue(":email",    $c->getEmail());
            $stmt->bindValue(":telefone", $c->getTelefone());
            $stmt->bindValue(":foto",     $c->getFoto());

            return $stmt->execute();
        } catch (PDOException $ex) {
            echo "Erro ao cadastrar contato: " . $ex->getMessage();
            return false;
        }
    }

    /* ===================================================================
     *  UPDATE — alterar um contato existente
     * =================================================================== */
    public function alterar(Contato $c) {
        try {
            $stmt = $this->con->prepare(
                "UPDATE contato
                    SET nome     = :nome,
                        email    = :email,
                        telefone = :telefone,
                        foto     = :foto
                  WHERE id = :id"
            );

            $stmt->bindValue(":nome",     $c->getNome());
            $stmt->bindValue(":email",    $c->getEmail());
            $stmt->bindValue(":telefone", $c->getTelefone());
            $stmt->bindValue(":foto",     $c->getFoto());
            $stmt->bindValue(":id",       $c->getId());

            return $stmt->execute();
        } catch (PDOException $ex) {
            echo "Erro ao alterar contato: " . $ex->getMessage();
            return false;
        }
    }

    /* ===================================================================
     *  DELETE — excluir um contato pelo id
     * =================================================================== */
    public function excluir(Contato $c) {
        try {
            $stmt = $this->con->prepare("DELETE FROM contato WHERE id = :id");
            $stmt->bindValue(":id", $c->getId());
            $stmt->execute();
            return $stmt->rowCount(); // nº de linhas afetadas
        } catch (PDOException $ex) {
            echo "Erro ao excluir contato: " . $ex->getMessage();
            return 0;
        }
    }

    /* ===================================================================
     *  READ — listar todos os contatos
     *  Retorna um array de objetos Contato.
     * =================================================================== */
    public function listar() {
        try {
            $stmt   = $this->con->query("SELECT * FROM contato ORDER BY nome");
            $linhas = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $lista = array();
            foreach ($linhas as $linha) {
                $c = new Contato();
                $c->setId($linha["id"]);
                $c->setNome($linha["nome"]);
                $c->setEmail($linha["email"]);
                $c->setTelefone($linha["telefone"]);
                $c->setFoto($linha["foto"]);
                $lista[] = $c;
            }
            return $lista;
        } catch (PDOException $ex) {
            echo "Erro ao listar contatos: " . $ex->getMessage();
            return array();
        }
    }

    /* ===================================================================
     *  READ — exibir UM contato pelo id
     *  Retorna um objeto Contato (ou null se não achar).
     * =================================================================== */
    public function exibir($id) {
        try {
            $stmt = $this->con->prepare("SELECT * FROM contato WHERE id = :id");
            $stmt->bindValue(":id", $id);
            $stmt->execute();

            $linha = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$linha) return null;

            $c = new Contato();
            $c->setId($linha["id"]);
            $c->setNome($linha["nome"]);
            $c->setEmail($linha["email"]);
            $c->setTelefone($linha["telefone"]);
            $c->setFoto($linha["foto"]);
            return $c;
        } catch (PDOException $ex) {
            echo "Erro ao exibir contato: " . $ex->getMessage();
            return null;
        }
    }
}
