<?php
function registrar_log($conexao, $usuario_id, $acao, $tabela, $registro_id, $detalhes = '') {
    $sql = "INSERT INTO logs (usuario_id, acao, tabela, registro_id, detalhes) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($stmt, "issis", $usuario_id, $acao, $tabela, $registro_id, $detalhes);
    mysqli_stmt_execute($stmt);
}
?>
