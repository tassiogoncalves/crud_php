<?php
require_once '../bd/conexao.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_perfil'] !== 'Administrador') {
    header("Location: ../dashboard.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = (int) $_POST['id'];
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $senha = $_POST['senha'];
    $perfil_id = (int) $_POST['perfil_id'];
    
    // Verifica se o e-mail já existe em outro usuário
    $sql_check = "SELECT id FROM usuario WHERE email = ? AND id != ?";
    $stmt_check = mysqli_prepare($conexao, $sql_check);
    mysqli_stmt_bind_param($stmt_check, "si", $email, $id);
    mysqli_stmt_execute($stmt_check);
    $res_check = mysqli_stmt_get_result($stmt_check);
    
    if (mysqli_num_rows($res_check) > 0) {
        echo "<script>
                alert('Este e-mail já está sendo usado por outro usuário.');
                window.location.href = 'form_editar.php?id=$id';
              </script>";
        exit();
    }
    
    if (!empty($senha)) {
        // Atualiza a senha
        $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
        $sql = "UPDATE usuario SET nome = ?, email = ?, senha = ?, perfil_id = ? WHERE id = ?";
        $stmt = mysqli_prepare($conexao, $sql);
        mysqli_stmt_bind_param($stmt, "ssssi", $nome, $email, $senha_hash, $perfil_id, $id);
    } else {
        // Mantém a senha
        $sql = "UPDATE usuario SET nome = ?, email = ?, perfil_id = ? WHERE id = ?";
        $stmt = mysqli_prepare($conexao, $sql);
        mysqli_stmt_bind_param($stmt, "ssii", $nome, $email, $perfil_id, $id);
    }
    
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
