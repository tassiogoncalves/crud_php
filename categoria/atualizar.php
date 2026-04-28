<?php
require_once '../bd/conexao.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cod = (int) $_POST['cod'];
    $nome = trim($_POST['nome']);
    
    $sql = "UPDATE categoria SET nome = ? WHERE cod = ?";
    $stmt = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($stmt, "si", $nome, $cod);
    
    if (mysqli_stmt_execute($stmt)) {
        header("Location: listar.php");
        exit();
    } else {
        echo "Erro ao atualizar: " . mysqli_error($conexao);
    }
} else {
    header("Location: listar.php");
    exit();
}
?>
