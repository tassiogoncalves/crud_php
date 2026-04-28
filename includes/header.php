<?php
require_once __DIR__ . '/../bd/conexao.php';

// Verificação de Autenticação
if (!isset($_SESSION['usuario_id'])) {
    header("Location: " . BASE_URL . "index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel - PHP CRUD</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/style.css">
</head>
<body>
    <header>
        <a href="<?= BASE_URL ?>dashboard.php" class="brand">🚀 Sistema CRUD</a>
        <nav>
            <a href="<?= BASE_URL ?>dashboard.php">Dashboard</a>
            <a href="<?= BASE_URL ?>categoria/listar.php">Categorias</a>
            <a href="<?= BASE_URL ?>produto/listar.php">Produtos</a>
            <?php if ($_SESSION['usuario_perfil'] === 'Administrador'): ?>
                <a href="<?= BASE_URL ?>usuario/listar.php">Usuários</a>
            <?php endif; ?>
        </nav>
        <div class="user-info">
            Olá, <strong><?= htmlspecialchars($_SESSION['usuario_nome']) ?></strong> (<?= htmlspecialchars($_SESSION['usuario_perfil']) ?>)
            <a href="<?= BASE_URL ?>perfil.php" style="margin-left: 1rem;">Meu Perfil</a>
            <a href="<?= BASE_URL ?>logout.php" style="margin-left: 1rem;">Sair</a>
        </div>
    </header>
    <main>
