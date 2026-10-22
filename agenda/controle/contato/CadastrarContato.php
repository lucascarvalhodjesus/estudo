<?php
/* ==========================================================================
 *  CadastrarContato.php
 * --------------------------------------------------------------------------
 *  Camada: CONTROLE
 *
 *  Lógica:
 *    - Se o formulário NÃO foi enviado ainda -> mostra o formulário.
 *    - Se o formulário FOI enviado (POST)    -> processa upload da foto,
 *      salva o contato no banco e mostra a lista atualizada.
 * ========================================================================== */

require_once __DIR__ . "/../../modelo/contato/ContatoDAO.php";

class CadastrarContato {

    public function __construct() {

        // Se não houve POST, apenas mostra o formulário em branco.
        if (!isset($_POST["enviar"])) {
            require __DIR__ . "/../../visao/contato/formCadastro.php";
            return;
        }

        /* ----------- 1. Trata o upload da FOTO ----------- */
        $foto = "..."; // valor padrão se não houver foto
        if (isset($_FILES["foto"]) && $_FILES["foto"]["error"] === UPLOAD_ERR_OK) {

            $arquivoTmp = $_FILES["foto"]["tmp_name"];
            $nomeOrig   = $_FILES["foto"]["name"];
            $extensao   = strtolower(pathinfo($nomeOrig, PATHINFO_EXTENSION));

            // Aceita apenas formatos de imagem comuns.
            if (in_array($extensao, ["jpg", "jpeg", "png", "gif"])) {
                // Gera nome único para não sobrescrever fotos existentes.
                $novoNome = uniqid((string)time()) . "." . $extensao;
                $destino  = __DIR__ . "/../../assets/fotos/" . $novoNome;

                if (move_uploaded_file($arquivoTmp, $destino)) {
                    // Caminho relativo (a partir da raiz pública) que será
                    // gravado no BD e usado nas tags <img>.
                    $foto = "assets/fotos/" . $novoNome;
                }
            }
        }

        /* ----------- 2. Monta a entidade Contato ----------- */
        $c = new Contato();
        $c->setNome($_POST["nome"]);
        $c->setEmail($_POST["email"]);
        $c->setTelefone($_POST["telefone"]);
        $c->setFoto($foto);

        /* ----------- 3. Salva no banco via DAO ----------- */
        $dao = new ContatoDAO();
        $dao->cadastrar($c);

        $status = "Cadastro do Contato " . $c->getNome() . " efetuado com sucesso";
        $lista  = $dao->listar();

        /* ----------- 4. Renderiza a listagem ----------- */
        require __DIR__ . "/../../visao/contato/lista.php";
    }
}
