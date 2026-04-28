<?php
require_once '../bd/conexao.php';

// Verificação de Autenticação (reforço de segurança)
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = trim($_POST['nome']);
    
    $sql = "INSERT INTO categoria (nome) VALUES (?)";
    $stmt = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($stmt, "s", $nome);
    
    if (mysqli_stmt_execute($stmt)) {
        header("Location: listar.php");
        exit();
    } else {
        echo "Erro ao cadastrar: " . mysqli_error($conexao);
    }
} else {
    header("Location: listar.php");
    exit();
}
?>
