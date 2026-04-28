<?php
require_once '../bd/conexao.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cod = (int) $_POST['cod'];
    $nome = trim($_POST['nome']);
    $valor = (float) $_POST['valor'];
    $categoria_cod = (int) $_POST['categoria'];
    $descricao = trim($_POST['descricao']);
    $estoque = (int) $_POST['estoque'];
    
    // Verifica se uma nova foto foi enviada
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
        $extensao = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));
        $extensoes_permitidas = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        
        if (in_array($extensao, $extensoes_permitidas)) {
            $nome_foto = uniqid() . '.' . $extensao;
            $destino = '../assets/img/' . $nome_foto;
            
            if (!file_exists('../assets/img')) {
                mkdir('../assets/img', 0777, true);
            }
            
            if (move_uploaded_file($_FILES['foto']['tmp_name'], $destino)) {
                // Busca a foto antiga para apagar
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
                
                // Atualiza com a nova foto
                $sql = "UPDATE produto SET nome = ?, valor = ?, descricao = ?, categoria = ?, foto = ?, estoque = ? WHERE cod = ?";
                $stmt = mysqli_prepare($conexao, $sql);
                mysqli_stmt_bind_param($stmt, "sdsisii", $nome, $valor, $descricao, $categoria_cod, $nome_foto, $estoque, $cod);
                
                if (mysqli_stmt_execute($stmt)) {
                    header("Location: listar.php");
                    exit();
                }
            }
        }
    }
    
    // Atualiza sem mexer na foto
    $sql = "UPDATE produto SET nome = ?, valor = ?, descricao = ?, categoria = ?, estoque = ? WHERE cod = ?";
    $stmt = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($stmt, "sdsiii", $nome, $valor, $descricao, $categoria_cod, $estoque, $cod);
            
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
