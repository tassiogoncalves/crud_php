<?php 
require_once '../includes/header.php'; 
require_once '../bd/conexao.php';

// Busca as categorias para o select
$sql_cat = "SELECT * FROM categoria ORDER BY nome";
$res_cat = mysqli_query($conexao, $sql_cat);
?>

<div class="card" style="max-width: 600px; margin: 0 auto;">
    <h2>Novo Produto</h2>
    <p style="margin-bottom: 1.5rem; color: var(--text-muted);">Preencha os dados abaixo para cadastrar um novo produto.</p>
    
    <form action="salvar.php" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="nome">Nome do Produto</label>
            <input type="text" name="nome" id="nome" required placeholder="Ex: Smartphone">
        </div>

        <div class="form-group">
            <label for="valor">Valor (R$)</label>
            <input type="number" name="valor" id="valor" step="0.01" min="0" required placeholder="0.00">
        </div>

        <div class="form-group">
            <label for="categoria">Categoria</label>
            <select name="categoria" id="categoria" required>
                <option value="">-- Selecione uma categoria --</option>
                <?php while ($cat = mysqli_fetch_assoc($res_cat)): ?>
                    <option value="<?= $cat['cod'] ?>"><?= htmlspecialchars($cat['nome']) ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="descricao">Descrição</label>
            <textarea name="descricao" id="descricao" rows="4" placeholder="Detalhes do produto..."></textarea>
        </div>

        <div class="form-group">
            <label for="foto">Foto do Produto</label>
            <input type="file" name="foto" id="foto" accept="image/*">
        </div>
        
        <div style="display: flex; gap: 1rem; margin-top: 2rem;">
            <button type="submit" class="btn btn-primary">Salvar Produto</button>
            <a href="listar.php" class="btn" style="background-color: var(--bg-color); color: var(--text-main);">Cancelar</a>
        </div>
    </form>
</div>

<?php require_once '../includes/footer.php'; ?>
