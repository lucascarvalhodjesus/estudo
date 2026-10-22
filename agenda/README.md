# Agenda — Projeto Didático MVC com PHP

Este projeto é um exemplo de aplicação **MVC (Model-View-Controller)** em PHP puro,
sem framework. Contém **dois CRUDs**:

- **Contato** — cadastrar, listar, exibir, alterar e excluir contatos.
- **Usuário** — autenticar usuário (login) na área administrativa.

O objetivo é mostrar, de forma simples e comentada, como separar
responsabilidades dentro de uma aplicação web.

---

## Estrutura de Pastas

```
agenda/
├── index.php                ← Ponto de entrada (home / lista contatos)
├── contato.php              ← Roteador: contato.php?fun=...
├── usuario.php              ← Roteador: usuario.php?fun=...
├── README.md
│
├── modelo/                  ← M  -- Dados e regras de negócio
│   ├── ConnectionFactory.php       (conexão única com o BD)
│   ├── contato/
│   │   ├── Contato.php             (entidade)
│   │   └── ContatoDAO.php          (CRUD no banco)
│   └── usuario/
│       ├── Usuario.php             (entidade)
│       └── UsuarioDAO.php          (login)
│
├── visao/                   ← V  -- O que o usuário vê (HTML)
│   ├── layout/
│   │   ├── topo.php                (cabeçalho HTML comum)
│   │   └── base.php                (rodapé HTML comum)
│   ├── contato/
│   │   ├── lista.php
│   │   ├── exibe.php
│   │   ├── formCadastro.php
│   │   ├── formAltera.php
│   │   └── confirmaExclusao.php
│   └── usuario/
│       └── formLogin.php
│
├── controle/                ← C  -- Cérebro: orquestra modelo + visão
│   ├── contato/
│   │   ├── ListarContato.php
│   │   ├── CadastrarContato.php
│   │   ├── AlterarContato.php
│   │   ├── ExcluirContato.php
│   │   └── ExibirContato.php
│   └── usuario/
│       └── LoginUsuario.php
│
└── assets/                  ← Recursos estáticos (CSS, imagens, fontes)
    ├── css/
    ├── img/
    ├── fonts/
    └── fotos/                      (uploads de fotos dos contatos)
```

---

## Como funciona o fluxo MVC

Imagine que o usuário clica em **"Listar Contatos"**:

1. O navegador chama `contato.php?fun=listar` (o **roteador**).
2. `contato.php` decide chamar o controle `ListarContato`.
3. `ListarContato` (CONTROLE) pede ao DAO os dados:
   `$dao->listar()` retorna um array de objetos `Contato`.
4. O controle inclui a **visão** `visao/contato/lista.php`, passando
   a variável `$lista`.
5. A visão monta o HTML com os dados e devolve ao navegador.

**Resumo:**

```
URL  →  Roteador  →  Controle  →  Modelo (DAO)  →  Visão  →  HTML
```

---

## Rotas disponíveis

| URL                                 | O que faz                              |
|-------------------------------------|----------------------------------------|
| `index.php`                         | Página inicial (lista contatos)        |
| `contato.php?fun=listar`            | Lista todos os contatos                |
| `contato.php?fun=cadastrar`         | Form / processa novo contato           |
| `contato.php?fun=exibir&id=X`       | Mostra detalhes do contato X           |
| `contato.php?fun=alterar&id=X`      | Form / processa alteração do contato X |
| `contato.php?fun=excluir&id=X`      | Pede confirmação / exclui contato X    |
| `usuario.php?fun=logar`             | Form / processa login                  |
| `usuario.php?fun=sair`              | Encerra a sessão (logout)              |

---

## Banco de dados

Crie um banco chamado `agenda` no MySQL com as tabelas:

```sql
CREATE TABLE contato (
    id        INT AUTO_INCREMENT PRIMARY KEY,
    nome      VARCHAR(100) NOT NULL,
    email     VARCHAR(100),
    telefone  VARCHAR(30),
    foto      VARCHAR(255)
);

CREATE TABLE usuario (
    id     INT AUTO_INCREMENT PRIMARY KEY,
    nome   VARCHAR(100) NOT NULL,
    login  VARCHAR(50)  NOT NULL UNIQUE,
    senha  VARCHAR(32)  NOT NULL    -- guardada como md5
);

-- Usuário de teste (login: admin / senha: 123)
INSERT INTO usuario (nome, login, senha)
VALUES ('Administrador', 'admin', MD5('123'));
```

As credenciais ficam em `modelo/ConnectionFactory.php`. Ajuste se o
seu MySQL tiver senha diferente.

---

## Conceitos importantes para os alunos

### 1. Separação de responsabilidades
- **MODELO** não sabe nada sobre HTML.
- **VISÃO** não acessa o banco diretamente.
- **CONTROLE** une os dois.

### 2. Por que `__DIR__`?
Os `require_once` usam `__DIR__` para construir caminhos **absolutos**
a partir do arquivo atual. Isso evita o problema clássico do "arquivo
não encontrado" quando o include é chamado por outro script.

### 3. Por que prepared statements (`bindValue`)?
Para impedir **SQL Injection**. Nunca concatene valores do usuário
direto no SQL.

### 4. Por que `htmlspecialchars` na visão?
Para impedir **XSS** (scripts maliciosos no HTML). Sempre que
imprimir algo vindo do banco/usuário, escape.

### 5. Sessão (`$_SESSION`)
É a memória do servidor para lembrar quem está logado. O objeto
`Usuario` é guardado serializado em `$_SESSION['usuario']`.

---

## O que foi corrigido nesta refatoração

1. **Bug do login** — em `UsuarioDAO::logar`, havia uma chamada
   `$lista->fetchAll()` em uma variável que já era array, causando
   erro fatal logo após autenticar. Por isso a listagem de contatos
   não aparecia depois do login. Corrigido.
2. **`echo $sql`** esquecido em produção — removido.
3. **SQL Injection** — substituído por prepared statements em todos os DAOs.
4. **Conexão duplicada** — `ConnectionFactory` e `ConnectionFactory2`
   foram unificadas em uma só classe singleton.
5. **Arquivos duplicados/quebrados** removidos
   (`*_class2.php`, `formCadastroContato2.php`, etc.).
6. **Includes frágeis** (`include_once("modelo/...")`) substituídos
   por `require_once __DIR__ . "/..."`.
7. **Estrutura de pastas** organizada por entidade
   (`modelo/contato/`, `modelo/usuario/`, etc.).
