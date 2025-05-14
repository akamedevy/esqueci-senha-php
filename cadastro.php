<?php
require_once './Entity/Usuario.php';

switch($_SERVER['REQUEST_METHOD']){
    case 'POST':
        $User = new Usuario();
        $User->nome = $_POST['nome'];
        $User->email = $_POST['email'];
        $User->senha = $_POST['senha'];

        $User->cadastrar();
        echo 'Usuario cadastrado';
        break;
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
        <input type="text" name="nome" placeholder="Nome: ">
        <input type="email" name="email" placeholder="Email: ">
        <input type="password" name="senha" placeholder="Senha: ">
        <input type="submit">
    </form>
</body>
</html>