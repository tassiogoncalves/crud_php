<?php
require_once '../bd/conexao.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_perfil'] !== 'Administrador') {
    header("Location: ../dashboard.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];
    
    // Trava de segurança: impede excluir a si próprio
    if ($id === $_SESSION['usuario_id']) {
        echo "<script>
                alert('Você não pode excluir o seu próprio usuário enquanto estiver logado.');
                window.location.href = 'listar.php';
              </script>";
        exit();
    }
    
    $sql = "DELETE FROM usuario WHERE id = ?";
    $stmt = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    
    if (mysqli_stmt_execute($stmt)) {
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
