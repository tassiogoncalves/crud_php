<?php 
require_once 'includes/header.php'; 
require_once 'bd/conexao.php';

// Busca dados quantitativos
$stats = [
    'produtos' => 0,
    'estoque_critico' => 0,
    'usuarios' => 0,
    'categorias' => 0
];

// Total de Produtos
$res = mysqli_query($conexao, "SELECT COUNT(*) as total FROM produto");
if ($row = mysqli_fetch_assoc($res)) {
    $stats['produtos'] = $row['total'];
}

// Produtos com Estoque Crítico (< 5)
$res = mysqli_query($conexao, "SELECT COUNT(*) as total FROM produto WHERE estoque < 5");
if ($row = mysqli_fetch_assoc($res)) {
    $stats['estoque_critico'] = $row['total'];
}

// Total de Usuários
$res = mysqli_query($conexao, "SELECT COUNT(*) as total FROM usuario");
if ($row = mysqli_fetch_assoc($res)) {
    $stats['usuarios'] = $row['total'];
}

// Total de Categorias
$res = mysqli_query($conexao, "SELECT COUNT(*) as total FROM categoria");
if ($row = mysqli_fetch_assoc($res)) {
    $stats['categorias'] = $row['total'];
}
?>

<div style="margin-bottom: 2rem;">
    <h2>Bem-vindo, <?= htmlspecialchars($_SESSION['usuario_nome']) ?>! 👋</h2>
    <p style="color: var(--text-muted);">Aqui está o resumo geral do sistema hoje.</p>
</div>

<!-- Grid de Cards Quantitativos -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
    
    <div class="card" style="border-left: 4px solid var(--primary); text-align: center; padding: 1.5rem;">
        <div style="font-size: 2.5rem; font-weight: 800; color: var(--text-main);"><?= $stats['produtos'] ?></div>
        <div style="color: var(--text-muted); font-size: 0.9rem; font-weight: 500; text-transform: uppercase;">Total de Produtos</div>
    </div>
    
    <div class="card" style="border-left: 4px solid var(--danger); text-align: center; padding: 1.5rem;">
        <div style="font-size: 2.5rem; font-weight: 800; color: var(--danger);"><?= $stats['estoque_critico'] ?></div>
        <div style="color: var(--text-muted); font-size: 0.9rem; font-weight: 500; text-transform: uppercase;">Estoque Crítico</div>
    </div>
    
    <div class="card" style="border-left: 4px solid #8B5CF6; text-align: center; padding: 1.5rem;">
        <div style="font-size: 2.5rem; font-weight: 800; color: var(--text-main);"><?= $stats['categorias'] ?></div>
        <div style="color: var(--text-muted); font-size: 0.9rem; font-weight: 500; text-transform: uppercase;">Categorias Ativas</div>
    </div>
    
    <?php if ($_SESSION['usuario_perfil'] === 'Administrador'): ?>
    <div class="card" style="border-left: 4px solid #10B981; text-align: center; padding: 1.5rem;">
        <div style="font-size: 2.5rem; font-weight: 800; color: var(--text-main);"><?= $stats['usuarios'] ?></div>
        <div style="color: var(--text-muted); font-size: 0.9rem; font-weight: 500; text-transform: uppercase;">Usuários Registrados</div>
    </div>
    <?php endif; ?>

</div>

<div class="card">
    <h3 style="margin-bottom: 1rem;">Acesso Rápido</h3>
    <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
        <a href="produto/listar.php" class="btn btn-primary">📦 Produtos</a>
        <a href="movimentacao/listar.php" class="btn" style="background: #10B981; color: white;">🔄 Movimentações</a>
        <a href="categoria/listar.php" class="btn btn-secondary">📂 Categorias</a>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
