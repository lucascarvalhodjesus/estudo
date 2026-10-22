<!--
   ============================================================
    topo.php
    Camada: VISÃO -> Layout
    Cabeçalho HTML usado por TODAS as páginas (DRY).
   ============================================================
-->
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="assets/css/style.css"  rel="stylesheet">
    <link href="assets/css/fonts.css"  rel="stylesheet">
    <link href="assets/css/media.css"  rel="stylesheet">
    <title>Agenda - Área Administrativa</title>
</head>
<body>
    <header>
        <div id="title">
            <h1>Área</h1>
            <h1>Administrativa</h1>
        </div>
        <ul>
            <a href="index.php"><li>Início</li></a>
            <a href="#"><li>Sobre</li></a>
            <a href="contato.php?fun=listar"><li>Contatos</li></a>

            <?php if (isset($_SESSION['usuario'])): ?>
                <a href="usuario.php?fun=sair" id="adminButton"><li>Sair</li></a>
            <?php else: ?>
                <a href="usuario.php?fun=logar" id="adminButton"><li>Área Administrativa</li></a>
            <?php endif; ?>
        </ul>
    </header>

    <main>
        <aside>
