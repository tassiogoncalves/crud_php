<?php require_once '../includes/header.php'; ?>

<div class="card" style="max-width: 600px; margin: 0 auto;">
    <h2>Nova Categoria</h2>
    <p style="margin-bottom: 1.5rem; color: var(--text-muted);">Preencha os dados abaixo para cadastrar uma nova categoria.</p>
    
    <form action="salvar.php" method="POST">
        <div class="form-group">
            <label for="nome">Nome da Categoria</label>
            <input type="text" name="nome" id="nome" required placeholder="Ex: Eletrônicos">
        </div>
        
        <div style="display: flex; gap: 1rem; margin-top: 2rem;">
            <button type="submit" class="btn btn-primary">Salvar Categoria</button>
            <a href="listar.php" class="btn" style="background-color: var(--bg-color); color: var(--text-main);">Cancelar</a>
        </div>
    </form>
</div>

<?php require_once '../includes/footer.php'; ?>
