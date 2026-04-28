<?php
require_once 'bd/conexao.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_SESSION['usuario_id'];
    $nome = trim($_POST['nome']);
    $senha = $_POST['senha'];
    $confirma_senha = $_POST['confirma_senha'];
    
    if (!empty($senha)) {
        if ($senha !== $confirma_senha) {
            header("Location: perfil.php?erro=1");
            exit();
        }
        
        $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
        $sql = "UPDATE usuario SET nome = ?, senha = ? WHERE id = ?";
        $stmt = mysqli_prepare($conexao, $sql);
        mysqli_stmt_bind_param($stmt, "ssi", $nome, $senha_hash, $id);
    } else {
        $sql = "UPDATE usuario SET nome = ? WHERE id = ?";
        $stmt = mysqli_prepare($conexao, $sql);
        mysqli_stmt_bind_param($stmt, "si", $nome, $id);
    }
    
    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['usuario_nome'] = $nome; // Atualiza nome na sessão
        header("Location: perfil.php?sucesso=1");
        exit();
    } else {
        echo "Erro ao atualizar: " . mysqli_error($conexao);
    }
} else {
    header("Location: perfil.php");
    exit();
}
?>
