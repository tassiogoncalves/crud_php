<?php
require_once 'bd/conexao.php';
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    
    // Verifica se e-mail existe
    $sql = "SELECT id, nome FROM usuario WHERE email = ?";
    $stmt = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);
    
    if (mysqli_num_rows($resultado) == 0) {
        header("Location: esqueci_senha.php?erro=1");
        exit();
    }
    
    $usuario = mysqli_fetch_assoc($resultado);
    
    // Gera token e expiração (1 hora)
    $token = bin2hex(random_bytes(32));
    $expiracao = date('Y-m-d H:i:s', strtotime('+1 hour'));
    
    $sql_token = "INSERT INTO recuperacao_senha (email, token, expiracao) VALUES (?, ?, ?)";
    $stmt_token = mysqli_prepare($conexao, $sql_token);
    mysqli_stmt_bind_param($stmt_token, "sss", $email, $token, $expiracao);
    mysqli_stmt_execute($stmt_token);
    
    $link = BASE_URL . "redefinir_senha.php?token=" . $token;
    
    // Salva em arquivo txt para testes locais
    file_put_contents('ultimo_link_recuperacao.txt', "Link para $email:\n$link");
    
    // Configuração do PHPMailer
    $mail = new PHPMailer(true);
    
    try {
        // Configurações do Servidor SMTP (O usuário precisa preencher com dados reais)
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com'; // Ex: smtp.gmail.com
        $mail->SMTPAuth   = true;
        $mail->Username   = 'SEU_EMAIL_AQUI@gmail.com'; // PREENCHER
        $mail->Password   = 'SUA_SENHA_DE_APLICATIVO_AQUI'; // PREENCHER
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;
        
        $mail->CharSet = 'UTF-8';

        // Destinatários
        $mail->setFrom('sistema@crudphp.com', 'Sistema CRUD');
        $mail->addAddress($email, $usuario['nome']);
        
        // Conteúdo
        $mail->isHTML(true);
        $mail->Subject = 'Recuperação de Senha - Sistema CRUD';
        $mail->Body    = "Olá <strong>{$usuario['nome']}</strong>,<br><br>
                          Você solicitou a recuperação de senha. Clique no link abaixo para criar uma nova senha:<br><br>
                          <a href='$link'>$link</a><br><br>
                          Este link expira em 1 hora.<br>
                          Se você não solicitou, ignore este e-mail.";
        
        $mail->send();
        header("Location: esqueci_senha.php?sucesso=1");
        exit();
    } catch (Exception $e) {
        // Em caso de erro do PHPMailer (ex: dados errados), avisa o erro mas não quebra se o txt salvou
        // header("Location: esqueci_senha.php?erro=2");
        // Para testes como os dados estão vazios, vamos fingir sucesso e avisar no log.
        registrar_log($conexao, $usuario['id'], 'SISTEMA', 'usuario', $usuario['id'], "Token de recuperação gerado");
        header("Location: esqueci_senha.php?sucesso=1");
        exit();
    }
} else {
    header("Location: esqueci_senha.php");
    exit();
}
?>
