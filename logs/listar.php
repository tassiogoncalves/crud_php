<?php
require_once '../includes/header.php';
require_once '../bd/conexao.php';

if ($_SESSION['usuario_perfil'] !== 'Administrador') {
    header("Location: ../dashboard.php");
    exit();
}

$sql = "SELECT l.*, u.nome as usuario_nome 
        FROM logs l 
        LEFT JOIN usuario u ON l.usuario_id = u.id 
        ORDER BY l.data_hora DESC 
        LIMIT 100";
$resultado = mysqli_query($conexao, $sql);
?>

<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
        <h2>Histórico de Logs (Auditoria)</h2>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Data/Hora</th>
                    <th>Usuário</th>
                    <th>Ação</th>
                    <th>Módulo</th>
                    <th>Detalhes</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($resultado)): ?>
                <tr>
                    <td style="white-space: nowrap;"><?= date('d/m/Y H:i:s', strtotime($row['data_hora'])) ?></td>
                    <td><strong><?= htmlspecialchars($row['usuario_nome'] ?? 'Sistema') ?></strong></td>
                    <td>
                        <?php 
                        $cor = 'gray';
                        if ($row['acao'] == 'INSERT') $cor = 'var(--success)';
                        if ($row['acao'] == 'UPDATE') $cor = 'var(--primary)';
                        if ($row['acao'] == 'DELETE') $cor = 'var(--danger)';
                        if ($row['acao'] == 'LOGIN') $cor = '#8B5CF6';
                        ?>
                        <span style="color: <?= $cor ?>; font-weight: bold; font-size: 0.85rem;"><?= $row['acao'] ?></span>
                    </td>
                    <td><span style="background: #F3F4F6; padding: 0.2rem 0.5rem; border-radius: 4px; font-size: 0.8rem; text-transform: uppercase;"><?= htmlspecialchars($row['tabela']) ?></span></td>
                    <td style="font-size: 0.9rem; color: var(--text-muted);"><?= htmlspecialchars($row['detalhes']) ?> (ID: <?= $row['registro_id'] ?>)</td>
                </tr>
                <?php endwhile; ?>
                
                <?php if (mysqli_num_rows($resultado) == 0): ?>
                <tr>
                    <td colspan="5" style="text-align: center; color: var(--text-muted);">Nenhum log registrado ainda.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>
