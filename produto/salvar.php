<?php
require_once '../bd/conexao.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = trim($_POST['nome']);
    $valor = (float) $_POST['valor'];
    $categoria_cod = (int) $_POST['categoria'];
    $descricao = trim($_POST['descricao']);
    $estoque = (int) $_POST['estoque'];
    
    $nome_foto = null;
    
    // Processamento da imagem
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
        $extensao = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));
        $extensoes_permitidas = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        
        if (in_array($extensao, $extensoes_permitidas)) {
            $nome_foto = uniqid() . '.' . $extensao;
            $destino = '../assets/img/' . $nome_foto;
            
            // Cria o diretório se não existir
            if (!file_exists('../assets/img')) {
                mkdir('../assets/img', 0777, true);
            }
            
            if (!move_uploaded_file($_FILES['foto']['tmp_name'], $destino)) {
                $nome_foto = null; // Falha no upload
            }
        }
    }
    
    // Inserção no banco com Prepared Statements
    if ($nome_foto) {
        $sql = "INSERT INTO produto (nome, valor, descricao, categoria, foto, estoque) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conexao, $sql);
        mysqli_stmt_bind_param($stmt, "sdsisi", $nome, $valor, $descricao, $categoria_cod, $nome_foto, $estoque);
    } else {
        $sql = "INSERT INTO produto (nome, valor, descricao, categoria, estoque) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conexao, $sql);
        mysqli_stmt_bind_param($stmt, "sdsii", $nome, $valor, $descricao, $categoria_cod, $estoque);
    }
    
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
