<?php
/* ==========================================================================
 *  Contato.php
 * --------------------------------------------------------------------------
 *  Camada: MODELO  -> Entidade
 *
 *  O que é uma "Entidade"?
 *  -----------------------
 *  É uma classe que representa um conceito do mundo real (Contato,
 *  Produto, Aluno...). Geralmente possui apenas:
 *    - atributos privados;
 *    - getters e setters (encapsulamento).
 *
 *  Cada OBJETO desta classe representa UM contato. O conjunto de
 *  contatos virá do banco de dados através do ContatoDAO.
 * ========================================================================== */

class Contato {

    // Atributos privados — só podem ser acessados via get/set.
    private $id;
    private $nome;
    private $email;
    private $telefone;
    private $foto;

    /* ----------------- Getters e Setters ----------------- */
    public function getId()                  { return $this->id; }
    public function setId($id)               { $this->id = $id; }

    public function getNome()                { return $this->nome; }
    public function setNome($nome)           { $this->nome = $nome; }

    public function getEmail()               { return $this->email; }
    public function setEmail($email)         { $this->email = $email; }

    public function getTelefone()            { return $this->telefone; }
    public function setTelefone($telefone)   { $this->telefone = $telefone; }

    public function getFoto()                { return $this->foto; }
    public function setFoto($foto)           { $this->foto = $foto; }
}
