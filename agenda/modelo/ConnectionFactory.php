<?php
/* ==========================================================================
 *  ConnectionFactory.php
 * --------------------------------------------------------------------------
 *  Camada: MODELO  (parte da pasta modelo/)
 *
 *  O que é?
 *  --------
 *  Esta classe é a "fábrica de conexões" com o banco de dados.
 *  Toda vez que um DAO (Data Access Object) precisa conversar com o BD,
 *  ele pede uma conexão para esta classe.
 *
 *  Por que existe uma classe só pra isso?
 *  --------------------------------------
 *  - Centraliza os dados de conexão (host, usuário, senha, banco) em
 *    UM único lugar. Se um dia mudar a senha do banco, mudo aqui só.
 *  - Reaproveita a mesma conexão durante a requisição (padrão Singleton),
 *    evitando abrir várias conexões desnecessárias.
 *  - Usa PDO, que protege contra SQL Injection quando combinado com
 *    prepared statements (veja ContatoDAO).
 *
 *  Antes existiam DUAS classes (ConnectionFactory_class e
 *  ConnectionFactory2_class) fazendo a mesma coisa. Foram unificadas.
 * ========================================================================== */

class ConnectionFactory {

    /* -------------------------------------------------------------------
     *  Configurações de acesso ao banco.
     *  ATENÇÃO ALUNO: em projetos de verdade essas informações ficam
     *  num arquivo de configuração separado (e fora do controle de versão).
     * ------------------------------------------------------------------- */
    private static $dbType = "mysql";
    private static $host   = "localhost";
    private static $user   = "root";
    private static $senha  = "vertrigo";
    private static $db     = "agenda";

    // Guarda a única instância de conexão (padrão Singleton).
    private static $con = null;

    /* -------------------------------------------------------------------
     *  getConnection()
     *  Retorna sempre a MESMA conexão PDO durante a requisição.
     *  Se ainda não existe conexão, cria. Se já existe, devolve a
     *  conexão guardada.
     * ------------------------------------------------------------------- */
    public static function getConnection() {
        if (self::$con === null) {
            try {
                // String de conexão no formato: mysql:host=localhost;dbname=agenda
                $dsn = self::$dbType . ":host=" . self::$host . ";dbname=" . self::$db . ";charset=utf8";

                self::$con = new PDO(
                    $dsn,
                    self::$user,
                    self::$senha,
                    array(
                        // Faz o PDO lançar exceções em caso de erro:
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        // Sempre retornar arrays associativos por padrão:
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    )
                );
            } catch (PDOException $ex) {
                // Em produção: gravar log. Aqui, mostra o erro para o aluno entender.
                die("Erro ao conectar no banco: " . $ex->getMessage());
            }
        }
        return self::$con;
    }

    /* -------------------------------------------------------------------
     *  close()
     *  Encerra a conexão (boa prática em scripts longos; em PHP web
     *  comum a conexão fecha sozinha ao final da requisição).
     * ------------------------------------------------------------------- */
    public static function close() {
        self::$con = null;
    }
}
