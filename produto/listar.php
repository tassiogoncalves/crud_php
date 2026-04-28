<?php
require_once '../includes/header.php';
require_once '../bd/conexao.php';

$sql = "SELECT p.*, c.nome as categoria_nome 
        FROM produto p 
        INNER JOIN categoria c ON p.categoria = c.cod 
        ORDER BY p.nome";
$resultado = mysqli_query($conexao, $sql);
?>

<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
        <h2>Gerenciar Produtos</h2>
        <a href="form_inserir.php" class="btn btn-primary">+ Novo Produto</a>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th style="width: 80px;">Foto</th>
                    <th>Nome</th>
                    <th>Valor</th>
                    <th>Categoria</th>
                    <th style="width: 150px;">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($resultado)): ?>
                <tr>
                    <td>
                        <?php if(!empty($row['foto'])): ?>
                            <img src="../assets/img/<?= htmlspecialchars($row['foto']) ?>" width="60" style="border-radius: 8px; object-fit: cover; aspect-ratio: 1;">
                        <?php else: ?>
                            <div style="width: 60px; height: 60px; background: #E5E7EB; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #9CA3AF; font-size: 0.8rem;">Sem Foto</div>
                        <?php endif; ?>
                    </td>
                    <td>
                        <strong><?= htmlspecialchars($row['nome']) ?></strong>
                        <?php if(!empty($row['descricao'])): ?>
                            <div style="font-size: 0.85rem; color: var(--text-muted); margin-top: 0.2rem;"><?= htmlspecialchars(substr($row['descricao'], 0, 50)) ?>...</div>
                        <?php endif; ?>
                    </td>
                    <td>R$ <?= number_format($row['valor'], 2, ',', '.') ?></td>
                    <td><span style="background: #E0E7FF; color: var(--primary); padding: 0.2rem 0.6rem; border-radius: 999px; font-size: 0.85rem; font-weight: 500;"><?= htmlspecialchars($row['categoria_nome']) ?></span></td>
                    <td class="table-actions">
                        <a href="form_editar.php?cod=<?= $row['cod'] ?>" class="btn btn-sm btn-secondary">Editar</a>
                        <a href="excluir.php?cod=<?= $row['cod'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja excluir este produto?');">Excluir</a>
                    </td>
                </tr>
                <?php endwhile; ?>
                
                <?php if (mysqli_num_rows($resultado) == 0): ?>
                <tr>
                    <td colspan="5" style="text-align: center; color: var(--text-muted);">Nenhum produto cadastrado.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>
