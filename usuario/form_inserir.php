<?php 
require_once '../includes/header.php'; 
require_once '../bd/conexao.php';

if ($_SESSION['usuario_perfil'] !== 'Administrador') {
    header("Location: ../dashboard.php");
    exit();
}

$sql_perfis = "SELECT * FROM perfil ORDER BY nome";
$res_perfis = mysqli_query($conexao, $sql_perfis);
?>

<div class="card" style="max-width: 600px; margin: 0 auto;">
    <h2>Novo Usuário</h2>
    <p style="margin-bottom: 1.5rem; color: var(--text-muted);">Cadastre um novo usuário de acesso.</p>
    
    <form action="salvar.php" method="POST">
        <div class="form-group">
            <label for="nome">Nome Completo</label>
            <input type="text" name="nome" id="nome" required placeholder="Ex: João da Silva">
        </div>

        <div class="form-group">
            <label for="email">E-mail</label>
            <input type="email" name="email" id="email" required placeholder="joao@exemplo.com">
        </div>

        <div class="form-group">
            <label for="senha">Senha</label>
            <input type="password" name="senha" id="senha" required>
        </div>

        <div class="form-group">
            <label for="perfil_id">Perfil de Acesso</label>
            <select name="perfil_id" id="perfil_id" required>
                <option value="">-- Selecione um perfil --</option>
                <?php while ($perfil = mysqli_fetch_assoc($res_perfis)): ?>
                    <option value="<?= $perfil['id'] ?>"><?= htmlspecialchars($perfil['nome']) ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <div style="display: flex; gap: 1rem; margin-top: 2rem;">
            <button type="submit" class="btn btn-primary">Salvar Usuário</button>
            <a href="listar.php" class="btn" style="background-color: var(--bg-color); color: var(--text-main);">Cancelar</a>
        </div>
    </form>
</div>

<?php require_once '../includes/footer.php'; ?>
