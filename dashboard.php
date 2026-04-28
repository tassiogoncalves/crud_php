<?php require_once 'includes/header.php'; ?>

<div class="card">
    <h2>Bem-vindo, <?= htmlspecialchars($_SESSION['usuario_nome']) ?>!</h2>
    <p style="margin-top: 1rem; color: var(--text-muted);">
        Você está logado como <strong><?= htmlspecialchars($_SESSION['usuario_perfil']) ?></strong>.
    </p>
    
    <div style="margin-top: 2rem; display: flex; gap: 1rem;">
        <a href="categoria/listar.php" class="btn btn-primary">Gerenciar Categorias</a>
        <a href="produto/listar.php" class="btn btn-secondary">Gerenciar Produtos</a>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
