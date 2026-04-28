<?php
require_once '../includes/header.php';
require_once '../bd/conexao.php';

$sql = "SELECT m.*, p.nome as produto_nome, u.nome as usuario_nome 
        FROM movimentacao_estoque m 
        INNER JOIN produto p ON m.produto_id = p.cod 
        INNER JOIN usuario u ON m.usuario_id = u.id 
        ORDER BY m.data_hora DESC";
$resultado = mysqli_query($conexao, $sql);
?>

<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 1rem;">
        <h2>Extrato de Movimentações</h2>
        <a href="form_inserir.php" class="btn btn-primary">+ Nova Movimentação</a>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Data/Hora</th>
                    <th>Produto</th>
                    <th>Tipo</th>
                    <th>Qtd</th>
                    <th>Motivo</th>
                    <th>Usuário</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($resultado)): ?>
                <tr>
                    <td style="white-space: nowrap;"><?= date('d/m/Y H:i', strtotime($row['data_hora'])) ?></td>
                    <td><strong><?= htmlspecialchars($row['produto_nome']) ?></strong></td>
                    <td>
                        <?php if ($row['tipo'] == 'ENTRADA'): ?>
                            <span style="background: #F0FDF4; color: var(--success); padding: 0.2rem 0.6rem; border-radius: 999px; font-size: 0.85rem; font-weight: bold;">Entrada</span>
                        <?php else: ?>
                            <span style="background: #FEF2F2; color: var(--danger); padding: 0.2rem 0.6rem; border-radius: 999px; font-size: 0.85rem; font-weight: bold;">Saída</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <strong style="color: <?= $row['tipo'] == 'ENTRADA' ? 'var(--success)' : 'var(--danger)' ?>;">
                            <?= $row['tipo'] == 'ENTRADA' ? '+' : '-' ?><?= $row['quantidade'] ?>
                        </strong>
                    </td>
                    <td style="font-size: 0.85rem; color: var(--text-muted);"><?= empty($row['motivo']) ? '-' : htmlspecialchars($row['motivo']) ?></td>
                    <td style="font-size: 0.85rem; color: var(--text-muted);"><?= htmlspecialchars($row['usuario_nome']) ?></td>
                </tr>
                <?php endwhile; ?>
                
                <?php if (mysqli_num_rows($resultado) == 0): ?>
                <tr>
                    <td colspan="6" style="text-align: center; color: var(--text-muted);">Nenhuma movimentação registrada.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>
