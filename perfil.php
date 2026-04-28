<?php 
require_once 'includes/header.php'; 
require_once 'bd/conexao.php';

$id = $_SESSION['usuario_id'];
$sql = "SELECT * FROM usuario WHERE id = ?";
$stmt = mysqli_prepare($conexao, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$resultado = mysqli_stmt_get_result($stmt);
$usuario = mysqli_fetch_assoc($resultado);
?>

<div class="card" style="max-width: 600px; margin: 0 auto;">
    <h2>Meu Perfil</h2>
    <p style="margin-bottom: 1.5rem; color: var(--text-muted);">Atualize seus dados pessoais e senha.</p>
    
    <?php if (isset($_GET['sucesso'])): ?>
        <div style="background: #F0FDF4; color: var(--success); padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; text-align: center;">
            Perfil atualizado com sucesso!
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['erro'])): ?>
        <div style="background: #FEF2F2; color: var(--danger); padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; text-align: center;">
            A nova senha e a confirmação não coincidem!
        </div>
    <?php endif; ?>
    
    <form action="atualizar_perfil.php" method="POST">
        <div class="form-group">
            <label for="nome">Nome Completo</label>
            <input type="text" name="nome" id="nome" value="<?= htmlspecialchars($usuario['nome']) ?>" required>
        </div>

        <div class="form-group">
            <label for="email">E-mail (Não pode ser alterado)</label>
            <input type="email" name="email" id="email" value="<?= htmlspecialchars($usuario['email']) ?>" readonly style="background: #F3F4F6; cursor: not-allowed;">
        </div>

        <hr style="margin: 2rem 0; border: none; border-top: 1px solid #E5E7EB;">
        <h3 style="margin-bottom: 1rem; font-size: 1.1rem; color: var(--text-main);">Alterar Senha</h3>

        <div class="form-group">
            <label for="senha">Nova Senha (deixe em branco para não alterar)</label>
            <input type="password" name="senha" id="senha">
        </div>

        <div class="form-group">
            <label for="confirma_senha">Confirmar Nova Senha</label>
            <input type="password" name="confirma_senha" id="confirma_senha">
        </div>

        <div style="display: flex; gap: 1rem; margin-top: 2rem;">
            <button type="submit" class="btn btn-primary">Salvar Alterações</button>
        </div>
    </form>
</div>

<?php require_once 'includes/footer.php'; ?>
