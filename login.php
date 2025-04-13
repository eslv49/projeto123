<?php
session_start();

$senha_correta = "MinhaSenha1234";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $senha = $_POST["senha"];

    if ($senha === $senha_correta) {
        $_SESSION["logado"] = true;
        header("Location: db1.php");
        exit();
    } else {
        $erro = "Senha incorreta!";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <style>
        body {
            font-family: sans-serif;
            background-color: #f2f2f2;
            text-align: center;
            padding-top: 100px;
        }
        form {
            background: white;
            display: inline-block;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px #aaa;
        }
        input[type="password"] {
            padding: 10px;
            margin-bottom: 10px;
            width: 200px;
        }
        input[type="submit"] {
            padding: 10px 20px;
            background-color: #4CAF50;
            border: none;
            color: white;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <form method="post">
        <h2>Digite a senha para acessar</h2>
        <input type="password" name="senha" required><br>
        <input type="submit" value="Entrar"><br>
        <?php if(isset($erro)) echo "<p style='color:red;'>$erro</p>"; ?>
    </form>
</body>
</html>