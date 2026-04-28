<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Senha - PHP CRUD</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body style="display: flex; justify-content: center; align-items: center; min-height: 100vh; background-color: var(--bg-color);">
    <div class="card" style="width: 100%; max-width: 400px; padding: 2rem;">
        <h2 style="text-align: center; margin-bottom: 0.5rem;">Recuperar Senha</h2>
        <p style="text-align: center; color: var(--text-muted); margin-bottom: 2rem; font-size: 0.9rem;">
            Digite o e-mail cadastrado. Enviaremos um link de recuperação.
        </p>

        <?php if (isset($_GET['erro'])): ?>
            <div style="background: #FEF2F2; color: var(--danger); padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; text-align: center; font-size: 0.9rem;">
                <?php
                    if ($_GET['erro'] == 1) echo "E-mail não encontrado no sistema.";
                    if ($_GET['erro'] == 2) echo "Erro ao enviar e-mail. Tente novamente.";
                ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['sucesso'])): ?>
            <div style="background: #F0FDF4; color: var(--success); padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; text-align: center; font-size: 0.9rem;">
                E-mail de recuperação enviado com sucesso! Verifique sua caixa de entrada.
            </div>
        <?php endif; ?>

        <form action="enviar_recuperacao.php" method="POST">
            <div class="form-group">
                <label for="email">E-mail</label>
                <input type="email" name="email" id="email" required placeholder="seu@email.com">
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 1rem;">Enviar Link</button>
        </form>
        
        <div style="text-align: center; margin-top: 1.5rem;">
            <a href="index.php" style="font-size: 0.9rem; color: var(--text-muted); text-decoration: none;">Voltar ao Login</a>
        </div>
    </div>
</body>
</html>
