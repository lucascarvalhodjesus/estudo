<?php
/* ==========================================================================
 *  index.php
 * --------------------------------------------------------------------------
 *  PONTO DE ENTRADA da aplicação (a 1ª página que abre).
 *  Aqui não há lógica complexa: apenas mostra a listagem de contatos.
 * ========================================================================== */

session_start(); // habilita $_SESSION (necessário para reconhecer o login)

// Carrega a classe Usuario ANTES de qualquer coisa, pois a visão pode
// fazer unserialize($_SESSION['usuario']) e precisa da classe definida.
require_once __DIR__ . "/modelo/usuario/Usuario.php";

require_once __DIR__ . "/visao/layout/topo.php";
require_once __DIR__ . "/controle/contato/ListarContato.php";

new ListarContato();   // o construtor já carrega a visão de listagem

require_once __DIR__ . "/visao/layout/base.php";
