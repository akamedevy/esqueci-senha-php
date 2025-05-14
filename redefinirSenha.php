<?php
require './DB/Database.php';

$token = $_GET['token'];

switch($_SERVER['REQUEST_METHOD']){
    case 'POST':
        $senha = $_POST['nova_senha'];
        $db = new Database('usuario');
        $db->update('token_recuperacao =' . '"' . $token . '"' , [
            'senha' => $senha,
            'token_recuperacao' => null,
        ]);

        echo('<script> alert("Senha alterada com sucesso") </script>');
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
        <input type="hidden" name="token" value="<?php echo($token); ?>">
        <h1>Nova senha: </h1>
        <input type="password" name="nova_senha" required>
        <input type="submit">
    </form>
</body>
</html>