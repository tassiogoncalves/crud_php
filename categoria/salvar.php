<?php
require_once '../bd/conexao.php';

// Verificação de Autenticação (reforço de segurança)
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = trim($_POST['nome']);
    $usuario_id = $_SESSION['usuario_id'];
    
    $sql = "INSERT INTO categoria (nome, usuario_id) VALUES (?, ?)";
    $stmt = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($stmt, "si", $nome, $usuario_id);
    
    if (mysqli_stmt_execute($stmt)) {
        $novo_cod = mysqli_insert_id($conexao);
        registrar_log($conexao, $_SESSION['usuario_id'], 'INSERT', 'categoria', $novo_cod, "Categoria '$nome' criada");
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
