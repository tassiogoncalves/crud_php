<?php
require_once '../bd/conexao.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cod = (int) $_POST['cod'];
    $nome = trim($_POST['nome']);
    
    $sql_check_owner = "SELECT usuario_id FROM categoria WHERE cod = ?";
    $stmt_owner = mysqli_prepare($conexao, $sql_check_owner);
    mysqli_stmt_bind_param($stmt_owner, "i", $cod);
    mysqli_stmt_execute($stmt_owner);
    $res_owner = mysqli_stmt_get_result($stmt_owner);
    $cat_owner = mysqli_fetch_assoc($res_owner);

    if ($_SESSION['usuario_perfil'] !== 'Administrador' && $cat_owner['usuario_id'] != $_SESSION['usuario_id']) {
        echo "<script>
                alert('Você não tem permissão para editar esta categoria.');
                window.location.href = 'listar.php';
              </script>";
        exit();
    }
    
    $sql = "UPDATE categoria SET nome = ? WHERE cod = ?";
    $stmt = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($stmt, "si", $nome, $cod);
    
    if (mysqli_stmt_execute($stmt)) {
        registrar_log($conexao, $_SESSION['usuario_id'], 'UPDATE', 'categoria', $cod, "Categoria renomeada para '$nome'");
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
