<?php
require 'vendor/autoload.php';
require './DB/Database.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

switch($_SERVER['REQUEST_METHOD']){
    case 'POST':
        $db = new Database('usuario');
        $email = $_POST['email'];

        $usuario = $db->select(
            table: "usuario",
            fields: 'email',
            where: "email = '$email'"
        );

        if($usuario){

            $token = bin2hex(random_bytes(32));

            $db->update('email =' . '"' . $email . '"' , [
                'token_recuperacao' => $token,
            ]);

            $link = "http://localhost/esqueci_senha/redefinirSenha.php?token=$token";
            
            try {
                $mail = new PHPMailer(true);
            
                $mail->isSMTP();                                          // Configura o envio via SMTP
                $mail->Host       = 'smtp.gmail.com';                    // Defina o servidor SMTP
                $mail->SMTPAuth   = true;                                   // Habilita autenticação SMTP
                $mail->Username   = 'ezspecconta@gmail.com';                  // Usuário SMTP
                $mail->Password   = 'lzow asnq phpq rftx';                                // Senha SMTP
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Habilita criptografia TLS
                $mail->Port       = 587;                                    // Porta SMTP
            
                // Remetente e destinatário
                $mail->setFrom('ezspecconta@gmail.com', 'Tweeb');
                $mail->addAddress('joaofavel@gmail.com'); // Adiciona destinatário
            
                // Conteúdo do e-mail
                $mail->isHTML(true);                                        // Define que o e-mail será enviado como HTML
                $mail->Subject = 'Redefinir Senha';
                $mail->Body = 'Clique no link para redefinir sua senha: ' . $link;
            
                // Enviar o e-mail
                $mail->send();
                echo 'E-mail enviado com sucesso!';
            } catch (Exception $e) {
                echo "Erro ao enviar o e-mail: {$mail->ErrorInfo}";
            }
        }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form method="POST">
        <h1>Insira o email:</h1>
        <input type="email" name="email" required>
        <input type="submit">
    </form>
</body>
</html>