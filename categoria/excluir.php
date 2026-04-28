<?php
require_once '../bd/conexao.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../index.php");
    exit();
}

if (isset($_GET['cod'])) {
    $cod = (int) $_GET['cod'];
    
    // Verifica permissão (Admin ou Dono)
    $sql_check_owner = "SELECT usuario_id FROM categoria WHERE cod = ?";
    $stmt_owner = mysqli_prepare($conexao, $sql_check_owner);
    mysqli_stmt_bind_param($stmt_owner, "i", $cod);
    mysqli_stmt_execute($stmt_owner);
    $res_owner = mysqli_stmt_get_result($stmt_owner);
    $cat_owner = mysqli_fetch_assoc($res_owner);

    if ($_SESSION['usuario_perfil'] !== 'Administrador' && $cat_owner['usuario_id'] != $_SESSION['usuario_id']) {
        echo "<script>
                alert('Você não tem permissão para excluir uma categoria de outro usuário.');
                window.location.href = 'listar.php';
              </script>";
        exit();
    }

    // Verifica se existem produtos usando esta categoria
    $sql_check = "SELECT cod FROM produto WHERE categoria = ?";
    $stmt_check = mysqli_prepare($conexao, $sql_check);
    mysqli_stmt_bind_param($stmt_check, "i", $cod);
    mysqli_stmt_execute($stmt_check);
    $res_check = mysqli_stmt_get_result($stmt_check);
    
    if (mysqli_num_rows($res_check) > 0) {
        // Categoria em uso, não pode excluir
        echo "<script>
                alert('Não é possível excluir esta categoria pois existem produtos vinculados a ela.');
                window.location.href = 'listar.php';
              </script>";
        exit();
    }
    
    $sql = "DELETE FROM categoria WHERE cod = ?";
    $stmt = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($stmt, "i", $cod);
    
    if (mysqli_stmt_execute($stmt)) {
        registrar_log($conexao, $_SESSION['usuario_id'], 'DELETE', 'categoria', $cod, "Categoria excluída");
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
