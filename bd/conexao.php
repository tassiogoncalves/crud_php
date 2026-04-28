<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$servidor = "localhost";
$usuario = "tassio";
$senha = "12345";
$banco = "crud_php";
$porta = 8889; // Porta personalizada do MySQL

$conexao = mysqli_connect($servidor, $usuario, $senha, $banco, $porta);

if (!$conexao) {
    die("Erro na conexão: " . mysqli_connect_error());
}

define('BASE_URL', 'http://localhost:8888/crud_php_html/');
?>
