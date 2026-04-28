<?php
require_once '../bd/conexao.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../index.php");
    exit();
}

if (isset($_GET['cod'])) {
    $cod = (int) $_GET['cod'];
    
    // Busca a foto para excluir do servidor
    $sql_old = "SELECT foto FROM produto WHERE cod = ?";
    $stmt_old = mysqli_prepare($conexao, $sql_old);
    mysqli_stmt_bind_param($stmt_old, "i", $cod);
    mysqli_stmt_execute($stmt_old);
    $res_old = mysqli_stmt_get_result($stmt_old);
    
    if ($old = mysqli_fetch_assoc($res_old)) {
        if (!empty($old['foto']) && file_exists('../assets/img/' . $old['foto'])) {
            unlink('../assets/img/' . $old['foto']);
        }
    }
    
    $sql = "DELETE FROM produto WHERE cod = ?";
    $stmt = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($stmt, "i", $cod);
    
    if (mysqli_stmt_execute($stmt)) {
        registrar_log($conexao, $_SESSION['usuario_id'], 'DELETE', 'produto', $cod, "Produto excluído");
        header("Location: listar.php");
        exit();
    } else {
        echo "Erro ao excluir: " . mysqli_error($conexao);
    }
} else {
    header("Location: listar.php");
    exit();
}
?>
