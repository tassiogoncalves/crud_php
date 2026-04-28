<?php
require_once '../includes/header.php';
require_once '../bd/conexao.php';

// Bloqueio de acesso para quem não é Administrador
if ($_SESSION['usuario_perfil'] !== 'Administrador') {
    header("Location: ../dashboard.php");
    exit();
}

$sql = "SELECT u.*, p.nome as perfil_nome 
        FROM usuario u 
        INNER JOIN perfil p ON u.perfil_id = p.id 
        ORDER BY u.nome";
$resultado = mysqli_query($conexao, $sql);
?>

<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
        <h2>Gerenciar Usuários</h2>
        <a href="form_inserir.php" class="btn btn-primary">+ Novo Usuário</a>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>E-mail</th>
                    <th>Perfil</th>
                    <th style="width: 150px;">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($resultado)): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><strong><?= htmlspecialchars($row['nome']) ?></strong></td>
                    <td><?= htmlspecialchars($row['email']) ?></td>
                    <td>
                        <?php if($row['perfil_nome'] === 'Administrador'): ?>
                            <span style="background: #FEF2F2; color: var(--danger); padding: 0.2rem 0.6rem; border-radius: 999px; font-size: 0.85rem; font-weight: 500;">Admin</span>
                        <?php else: ?>
                            <span style="background: #F0FDF4; color: var(--secondary); padding: 0.2rem 0.6rem; border-radius: 999px; font-size: 0.85rem; font-weight: 500;">Comum</span>
                        <?php endif; ?>
                    </td>
                    <td class="table-actions">
                        <a href="form_editar.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-secondary">Editar</a>
                        <a href="excluir.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja excluir este usuário?');">Excluir</a>
                    </td>
                </tr>
                <?php endwhile; ?>
                
                <?php if (mysqli_num_rows($resultado) == 0): ?>
                <tr>
                    <td colspan="5" style="text-align: center; color: var(--text-muted);">Nenhum usuário encontrado.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>
