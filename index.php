<?php
require_once 'bd/conexao.php';

// Redireciona se já estiver logado
if (isset($_SESSION['usuario_id'])) {
    header("Location: dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - PHP CRUD</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="login-container card">
        <div class="login-header">
            <h1>🚀 Login</h1>
            <p class="user-info">Acesse o sistema CRUD</p>
        </div>
        
        <?php if (isset($_GET['erro'])): ?>
            <div class="alert alert-error">
                E-mail ou senha incorretos!
            </div>
        <?php endif; ?>

        <form action="login.php" method="POST">
            <div class="form-group">
                <label for="email">E-mail</label>
                <input type="email" name="email" id="email" required placeholder="admin@admin.com">
            </div>
            <div class="form-group">
                <label for="senha">Senha</label>
                <input type="password" name="senha" id="senha" required placeholder="admin123">
                <div style="text-align: right; margin-top: 0.5rem;">
                    <a href="esqueci_senha.php" style="font-size: 0.85rem; color: var(--primary); text-decoration: none;">Esqueci minha senha</a>
                </div>
            </div>
            <button type="submit" class="btn btn-primary" style="width: 100%;">Entrar</button>
        </form>
    </div>
</body>
</html>
