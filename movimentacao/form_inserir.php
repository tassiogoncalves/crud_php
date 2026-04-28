<?php
require_once '../includes/header.php';
require_once '../bd/conexao.php';

// Busca todos os produtos para o select
$sql_produtos = "SELECT cod, nome, estoque FROM produto ORDER BY nome";
$resultado_produtos = mysqli_query($conexao, $sql_produtos);

// Produto pré-selecionado vindo da tela de listagem de produtos
$produto_selecionado = isset($_GET['produto_id']) ? (int)$_GET['produto_id'] : 0;
?>

<div class="card" style="max-width: 600px; margin: 0 auto;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
        <h2>Nova Movimentação de Estoque</h2>
        <a href="listar.php" class="btn btn-secondary">Voltar</a>
    </div>

    <?php if (isset($_GET['erro']) && $_GET['erro'] == 'estoque_insuficiente'): ?>
        <div style="background: #FEF2F2; color: var(--danger); padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; text-align: center;">
            Erro: A quantidade de saída é maior do que o estoque atual do produto!
        </div>
    <?php endif; ?>

    <form action="salvar.php" method="POST">
        <div class="form-group">
            <label for="produto_id">Produto</label>
            <select name="produto_id" id="produto_id" required style="width: 100%; padding: 0.8rem; border: 1px solid #D1D5DB; border-radius: 8px; outline: none; transition: border-color 0.3s; font-family: inherit; background-color: white;">
                <option value="">-- Selecione o Produto --</option>
                <?php while ($p = mysqli_fetch_assoc($resultado_produtos)): ?>
                    <option value="<?= $p['cod'] ?>" <?= $p['cod'] == $produto_selecionado ? 'selected' : '' ?>>
                        <?= htmlspecialchars($p['nome']) ?> (Estoque atual: <?= $p['estoque'] ?>)
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="form-group" style="display: flex; gap: 1rem;">
            <div style="flex: 1;">
                <label for="tipo">Tipo de Movimentação</label>
                <select name="tipo" id="tipo" required style="width: 100%; padding: 0.8rem; border: 1px solid #D1D5DB; border-radius: 8px; outline: none; background-color: white;">
                    <option value="ENTRADA">Entrada (+)</option>
                    <option value="SAIDA">Saída (-)</option>
                </select>
            </div>
            <div style="flex: 1;">
                <label for="quantidade">Quantidade</label>
                <input type="number" name="quantidade" id="quantidade" min="1" required placeholder="Ex: 5">
            </div>
        </div>

        <div class="form-group">
            <label for="motivo">Motivo / Descrição (Opcional)</label>
            <input type="text" name="motivo" id="motivo" placeholder="Ex: Compra do fornecedor, Venda no balcão, etc.">
        </div>

        <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 1rem;">Registrar Movimentação</button>
    </form>
</div>

<?php require_once '../includes/footer.php'; ?>
