<?php
require_once 'bd/conexao.php';

if (!isset($_GET['token'])) {
    header("Location: index.php");
    exit();
}

$token = $_GET['token'];
$sql = "SELECT email FROM recuperacao_senha WHERE token = ? AND expiracao > NOW()";
$stmt = mysqli_prepare($conexao, $sql);
mysqli_stmt_bind_param($stmt, "s", $token);
mysqli_stmt_execute($stmt);
$resultado = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($resultado) == 0) {
    // Token inválido ou expirado
    die("O link de recuperação é inválido ou expirou. Por favor, solicite um novo.");
}

$dados = mysqli_fetch_assoc($resultado);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redefinir Senha - PHP CRUD</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body style="display: flex; justify-content: center; align-items: center; min-height: 100vh; background-color: var(--bg-color);">
    <div class="card" style="width: 100%; max-width: 400px; padding: 2rem;">
        <h2 style="text-align: center; margin-bottom: 0.5rem;">Criar Nova Senha</h2>
        <p style="text-align: center; color: var(--text-muted); margin-bottom: 2rem; font-size: 0.9rem;">
            Redefinição para: <strong><?= htmlspecialchars($dados['email']) ?></strong>
        </p>

        <?php if (isset($_GET['erro'])): ?>
            <div style="background: #FEF2F2; color: var(--danger); padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; text-align: center; font-size: 0.9rem;">
                As senhas digitadas não coincidem.
            </div>
        <?php endif; ?>

        <form action="salvar_nova_senha.php" method="POST">
            <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
            
            <div class="form-group">
                <label for="senha">Nova Senha</label>
                <input type="password" name="senha" id="senha" required>
            </div>
            
            <div class="form-group">
                <label for="confirma_senha">Confirmar Nova Senha</label>
                <input type="password" name="confirma_senha" id="confirma_senha" required>
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 1rem;">Salvar Senha</button>
        </form>
    </div>
</body>
</html>
