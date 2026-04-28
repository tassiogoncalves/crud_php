<?php
require_once 'bd/conexao.php';
require_once 'includes/logger.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $token = $_POST['token'];
    $senha = $_POST['senha'];
    $confirma_senha = $_POST['confirma_senha'];
    
    if ($senha !== $confirma_senha) {
        header("Location: redefinir_senha.php?token=$token&erro=1");
        exit();
    }
    
    // Verifica token novamente
    $sql = "SELECT email FROM recuperacao_senha WHERE token = ? AND expiracao > NOW()";
    $stmt = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($stmt, "s", $token);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);
    
    if (mysqli_num_rows($resultado) == 0) {
        die("Link inválido ou expirado.");
    }
    
    $dados = mysqli_fetch_assoc($resultado);
    $email = $dados['email'];
    
    // Busca id do usuario
    $sql_u = "SELECT id FROM usuario WHERE email = ?";
    $stmt_u = mysqli_prepare($conexao, $sql_u);
    mysqli_stmt_bind_param($stmt_u, "s", $email);
    mysqli_stmt_execute($stmt_u);
    $res_u = mysqli_stmt_get_result($stmt_u);
    $usuario = mysqli_fetch_assoc($res_u);
    
    // Atualiza a senha
    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
    $sql_up = "UPDATE usuario SET senha = ? WHERE email = ?";
    $stmt_up = mysqli_prepare($conexao, $sql_up);
    mysqli_stmt_bind_param($stmt_up, "ss", $senha_hash, $email);
    
    if (mysqli_stmt_execute($stmt_up)) {
        // Apaga o token usado
        $sql_del = "DELETE FROM recuperacao_senha WHERE email = ?";
        $stmt_del = mysqli_prepare($conexao, $sql_del);
        mysqli_stmt_bind_param($stmt_del, "s", $email);
        mysqli_stmt_execute($stmt_del);
        
        registrar_log($conexao, $usuario['id'], 'UPDATE', 'usuario', $usuario['id'], "Senha redefinida via link de recuperação");
        
        // Redireciona pro login
        echo "<script>
                alert('Senha alterada com sucesso! Você já pode fazer o login.');
                window.location.href = 'index.php';
              </script>";
        exit();
    } else {
        echo "Erro ao salvar a nova senha.";
    }
} else {
    header("Location: index.php");
    exit();
}
?>
