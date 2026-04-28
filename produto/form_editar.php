<?php 
require_once '../includes/header.php'; 
require_once '../bd/conexao.php';

if (!isset($_GET['cod'])) {
    header("Location: listar.php");
    exit();
}

$cod = (int) $_GET['cod'];
$sql = "SELECT * FROM produto WHERE cod = ?";
$stmt = mysqli_prepare($conexao, $sql);
mysqli_stmt_bind_param($stmt, "i", $cod);
mysqli_stmt_execute($stmt);
$resultado = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($resultado) == 0) {
    header("Location: listar.php");
    exit();
}

$produto = mysqli_fetch_assoc($resultado);

// Busca as categorias para o select
$sql_cat = "SELECT * FROM categoria ORDER BY nome";
$res_cat = mysqli_query($conexao, $sql_cat);
?>

<div class="card" style="max-width: 600px; margin: 0 auto;">
    <h2>Editar Produto</h2>
    <p style="margin-bottom: 1.5rem; color: var(--text-muted);">Altere os dados do produto selecionado.</p>
    
    <form action="atualizar.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="cod" value="<?= $produto['cod'] ?>">
        
        <div class="form-group">
            <label for="nome">Nome do Produto</label>
            <input type="text" name="nome" id="nome" value="<?= htmlspecialchars($produto['nome']) ?>" required>
        </div>

        <div class="form-group" style="display: flex; gap: 1rem;">
            <div style="flex: 1;">
                <label for="valor">Valor (R$)</label>
                <input type="number" name="valor" id="valor" step="0.01" min="0" value="<?= $produto['valor'] ?>" required>
            </div>
            <div style="flex: 1;">
                <label for="estoque">Estoque Atual</label>
                <input type="number" name="estoque" id="estoque" min="0" value="<?= $produto['estoque'] ?>" required>
            </div>
        </div>

        <div class="form-group">
            <label for="categoria">Categoria</label>
            <select name="categoria" id="categoria" required>
                <option value="">-- Selecione uma categoria --</option>
                <?php while ($cat = mysqli_fetch_assoc($res_cat)): ?>
                    <option value="<?= $cat['cod'] ?>" <?= ($cat['cod'] == $produto['categoria']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($cat['nome']) ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="descricao">Descrição</label>
            <textarea name="descricao" id="descricao" rows="4"><?= htmlspecialchars($produto['descricao']) ?></textarea>
        </div>

        <div class="form-group">
            <label>Foto Atual</label><br>
            <?php if(!empty($produto['foto'])): ?>
                <img src="../assets/img/<?= htmlspecialchars($produto['foto']) ?>" width="100" style="border-radius: 8px; margin-bottom: 1rem;">
            <?php else: ?>
                <div style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 1rem;">Nenhuma foto cadastrada.</div>
            <?php endif; ?>
            
            <label for="foto">Nova Foto (deixe em branco para manter a atual)</label>
            <input type="file" name="foto" id="foto" accept="image/*">
        </div>
        
        <div style="display: flex; gap: 1rem; margin-top: 2rem;">
            <button type="submit" class="btn btn-primary">Atualizar Produto</button>
            <a href="listar.php" class="btn" style="background-color: var(--bg-color); color: var(--text-main);">Cancelar</a>
        </div>
    </form>
</div>

<?php require_once '../includes/footer.php'; ?>
