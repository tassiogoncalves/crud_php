<?php 
require_once '../includes/header.php'; 
require_once '../bd/conexao.php';

if ($_SESSION['usuario_perfil'] !== 'Administrador') {
    header("Location: ../dashboard.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: listar.php");
    exit();
}

$id = (int) $_GET['id'];
$sql = "SELECT * FROM usuario WHERE id = ?";
$stmt = mysqli_prepare($conexao, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$resultado = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($resultado) == 0) {
    header("Location: listar.php");
    exit();
}

$usuario = mysqli_fetch_assoc($resultado);

$sql_perfis = "SELECT * FROM perfil ORDER BY nome";
$res_perfis = mysqli_query($conexao, $sql_perfis);
?>

<div class="card" style="max-width: 600px; margin: 0 auto;">
    <h2>Editar Usuário</h2>
    <p style="margin-bottom: 1.5rem; color: var(--text-muted);">Altere os dados de acesso do usuário.</p>
    
    <form action="atualizar.php" method="POST">
        <input type="hidden" name="id" value="<?= $usuario['id'] ?>">
        
        <div class="form-group">
            <label for="nome">Nome Completo</label>
            <input type="text" name="nome" id="nome" value="<?= htmlspecialchars($usuario['nome']) ?>" required>
        </div>

        <div class="form-group">
            <label for="email">E-mail</label>
            <input type="email" name="email" id="email" value="<?= htmlspecialchars($usuario['email']) ?>" required>
        </div>

        <div class="form-group">
            <label for="senha">Nova Senha</label>
            <input type="password" name="senha" id="senha" placeholder="Deixe em branco para manter a senha atual">
        </div>

        <div class="form-group">
            <label for="perfil_id">Perfil de Acesso</label>
            <select name="perfil_id" id="perfil_id" required>
                <option value="">-- Selecione um perfil --</option>
                <?php while ($perfil = mysqli_fetch_assoc($res_perfis)): ?>
                    <option value="<?= $perfil['id'] ?>" <?= ($perfil['id'] == $usuario['perfil_id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($perfil['nome']) ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <div style="display: flex; gap: 1rem; margin-top: 2rem;">
            <button type="submit" class="btn btn-primary">Atualizar Usuário</button>
            <a href="listar.php" class="btn" style="background-color: var(--bg-color); color: var(--text-main);">Cancelar</a>
        </div>
    </form>
</div>

<?php require_once '../includes/footer.php'; ?>
