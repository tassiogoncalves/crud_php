<?php
require_once '../includes/header.php';
require_once '../bd/conexao.php';

$sql = "SELECT * FROM categoria ORDER BY nome";
$resultado = mysqli_query($conexao, $sql);
?>

<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
        <h2>Gerenciar Categorias</h2>
        <a href="form_inserir.php" class="btn btn-primary">+ Nova Categoria</a>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Nome</th>
                    <th style="width: 150px;">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($resultado)): ?>
                <tr>
                    <td><?= $row['cod'] ?></td>
                    <td><?= htmlspecialchars($row['nome']) ?></td>
                    <td class="table-actions">
                        <a href="form_editar.php?cod=<?= $row['cod'] ?>" class="btn btn-sm btn-secondary">Editar</a>
                        <a href="excluir.php?cod=<?= $row['cod'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja excluir esta categoria?');">Excluir</a>
                    </td>
                </tr>
                <?php endwhile; ?>
                
                <?php if (mysqli_num_rows($resultado) == 0): ?>
                <tr>
                    <td colspan="3" style="text-align: center; color: var(--text-muted);">Nenhuma categoria cadastrada.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>
