<?php
require_once '../bd/conexao.php';
require_once '../includes/logger.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['usuario_id']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../index.php");
    exit();
}

$produto_id = (int) $_POST['produto_id'];
$usuario_id = (int) $_SESSION['usuario_id'];
$tipo = $_POST['tipo']; // ENTRADA ou SAIDA
$quantidade = (int) $_POST['quantidade'];
$motivo = trim($_POST['motivo']);

if ($quantidade <= 0) {
    die("Quantidade inválida.");
}

// Inicia transação
mysqli_begin_transaction($conexao);

try {
    // Busca o estoque atual com bloqueio (FOR UPDATE) para evitar concorrência
    $sql_prod = "SELECT estoque, nome FROM produto WHERE cod = ? FOR UPDATE";
    $stmt_prod = mysqli_prepare($conexao, $sql_prod);
    mysqli_stmt_bind_param($stmt_prod, "i", $produto_id);
    mysqli_stmt_execute($stmt_prod);
    $res_prod = mysqli_stmt_get_result($stmt_prod);
    
    if (mysqli_num_rows($res_prod) == 0) {
        throw new Exception("Produto não encontrado.");
    }
    
    $produto = mysqli_fetch_assoc($res_prod);
    $estoque_atual = (int) $produto['estoque'];
    
    // Valida se a saída não deixa o estoque negativo
    if ($tipo === 'SAIDA' && $quantidade > $estoque_atual) {
        mysqli_rollback($conexao);
        header("Location: form_inserir.php?produto_id={$produto_id}&erro=estoque_insuficiente");
        exit();
    }
    
    // Insere no histórico de movimentação
    $sql_mov = "INSERT INTO movimentacao_estoque (produto_id, usuario_id, tipo, quantidade, motivo) VALUES (?, ?, ?, ?, ?)";
    $stmt_mov = mysqli_prepare($conexao, $sql_mov);
    mysqli_stmt_bind_param($stmt_mov, "iisss", $produto_id, $usuario_id, $tipo, $quantidade, $motivo);
    mysqli_stmt_execute($stmt_mov);
    $mov_id = mysqli_insert_id($conexao);
    
    // Atualiza o estoque do produto
    $novo_estoque = ($tipo === 'ENTRADA') ? ($estoque_atual + $quantidade) : ($estoque_atual - $quantidade);
    $sql_up = "UPDATE produto SET estoque = ? WHERE cod = ?";
    $stmt_up = mysqli_prepare($conexao, $sql_up);
    mysqli_stmt_bind_param($stmt_up, "ii", $novo_estoque, $produto_id);
    mysqli_stmt_execute($stmt_up);
    
    // Log da ação global
    $sinal = ($tipo === 'ENTRADA') ? '+' : '-';
    registrar_log($conexao, $usuario_id, 'UPDATE', 'estoque', $mov_id, "{$tipo} de {$quantidade} un. do produto '{$produto['nome']}'");
    
    // Confirma transação
    mysqli_commit($conexao);
    
    header("Location: listar.php");
    exit();
    
} catch (Exception $e) {
    mysqli_rollback($conexao);
    die("Erro ao processar movimentação: " . $e->getMessage());
}
?>
