<?php 
require_once '../includes/header.php'; 
require_once '../bd/conexao.php';

if (!isset($_GET['cod'])) {
    header("Location: listar.php");
    exit();
}

$cod = (int) $_GET['cod'];
$sql = "SELECT * FROM categoria WHERE cod = ?";
$stmt = mysqli_prepare($conexao, $sql);
mysqli_stmt_bind_param($stmt, "i", $cod);
mysqli_stmt_execute($stmt);
$resultado = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($resultado) == 0) {
    header("Location: listar.php");
    exit();
}

$categoria = mysqli_fetch_assoc($resultado);

// Verifica permissão (Admin ou Dono)
if ($_SESSION['usuario_perfil'] !== 'Administrador' && $categoria['usuario_id'] != $_SESSION['usuario_id']) {
    echo "<script>
            alert('Você não tem permissão para editar uma categoria criada por outro usuário.');
            window.location.href = 'listar.php';
          </script>";
    exit();
}
?>

<div class="card" style="max-width: 600px; margin: 0 auto;">
    <h2>Editar Categoria</h2>
    <p style="margin-bottom: 1.5rem; color: var(--text-muted);">Altere os dados da categoria selecionada.</p>
    
    <form action="atualizar.php" method="POST">
        <input type="hidden" name="cod" value="<?= $categoria['cod'] ?>">
        
        <div class="form-group">
            <label for="nome">Nome da Categoria</label>
            <input type="text" name="nome" id="nome" value="<?= htmlspecialchars($categoria['nome']) ?>" required>
        </div>
        
        <div style="display: flex; gap: 1rem; margin-top: 2rem;">
            <button type="submit" class="btn btn-primary">Atualizar Categoria</button>
            <a href="listar.php" class="btn" style="background-color: var(--bg-color); color: var(--text-main);">Cancelar</a>
        </div>
    </form>
</div>

<?php require_once '../includes/footer.php'; ?>
