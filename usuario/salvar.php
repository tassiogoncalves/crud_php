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
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $senha = $_POST['senha'];
    $perfil_id = (int) $_POST['perfil_id'];
    
    // Hash da senha
    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
    
    // Verifica se e-mail já existe
    $sql_check = "SELECT id FROM usuario WHERE email = ?";
    $stmt_check = mysqli_prepare($conexao, $sql_check);
    mysqli_stmt_bind_param($stmt_check, "s", $email);
    mysqli_stmt_execute($stmt_check);
    $res_check = mysqli_stmt_get_result($stmt_check);
    
    if (mysqli_num_rows($res_check) > 0) {
        echo "<script>
                alert('Este e-mail já está em uso.');
                window.location.href = 'form_inserir.php';
              </script>";
        exit();
    }
    
    $sql = "INSERT INTO usuario (nome, email, senha, perfil_id) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($stmt, "sssi", $nome, $email, $senha_hash, $perfil_id);
    
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
