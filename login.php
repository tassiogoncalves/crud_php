<?php
require_once 'bd/conexao.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $senha = $_POST['senha'];

    $sql = "SELECT u.id, u.nome, u.senha, p.nome as perfil 
            FROM usuario u 
            JOIN perfil p ON u.perfil_id = p.id 
            WHERE u.email = ?";
            
    $stmt = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($resultado) == 1) {
        $usuario = mysqli_fetch_assoc($resultado);
        
        if (password_verify($senha, $usuario['senha'])) {
            // Login com sucesso
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario_nome'] = $usuario['nome'];
            $_SESSION['usuario_perfil'] = $usuario['perfil'];
            
            header("Location: dashboard.php");
            exit();
        }
    }
    
    // Falha no login
    header("Location: index.php?erro=1");
    exit();
} else {
    header("Location: index.php");
    exit();
}
?>
