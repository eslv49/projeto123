<?php
// Conexão com o banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "projeto3";

// Criação da conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar se a conexão foi bem sucedida
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Registrar a venda
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capturar os dados do formulário
    $produto_id = $_POST['produto_id'];
    $quantidade_vendida = $_POST['quantidade_vendida'];

    // Verificar se a quantidade é válida
    if (empty($produto_id) || empty($quantidade_vendida)) {
        echo "Por favor, preencha todos os campos.";
    } else {
        // Consultar o estoque atual do produto
        $sql = "SELECT quantidade FROM produtos3 WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $produto_id);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($quantidade_atual);
        $stmt->fetch();

        if ($quantidade_atual >= $quantidade_vendida) {
            // Subtrair a quantidade do estoque
            $nova_quantidade = $quantidade_atual - $quantidade_vendida;

            // Atualizar a quantidade no banco de dados
            $sql_update = "UPDATE produtos3 SET quantidade = ? WHERE id = ?";
            $stmt_update = $conn->prepare($sql_update);
            $stmt_update->bind_param("ii", $nova_quantidade, $produto_id);
            
            if ($stmt_update->execute()) {
                echo "Venda registrada com sucesso. Estoque atualizado.";
            } else {
                echo "Erro ao registrar a venda: " . $stmt_update->error;
            }

            $stmt_update->close();
        } else {
            // Avisar se o estoque é insuficiente
            echo "Estoque insuficiente para realizar a venda.";
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Venda</title>
    <!-- Referência ao arquivo externo de estilo CSS -->
    <link rel="stylesheet" href="estilo.css">
</head>
<body>

<header>
    <h1>Registrar Venda</h1>
</header>

<div class="container">
    <form method="post" action="">
        <label for="produto_id">Produto ID:</label>
        <input type="number" name="produto_id" required><br>

        <label for="quantidade_vendida">Quantidade Vendida:</label>
        <input type="number" name="quantidade_vendida" required><br>

        <input type="submit" value="Registrar Venda">
    </form>

    <div class="links">
        <a href="db1.php">Ir para a tela de Cadastro</a>
    </div>
</div>

</body>
</html>








<!--
<form method="post" action="">
    Produto ID: <input type="number" name="produto_id" required><br>
    Quantidade Vendida: <input type="number" name="quantidade_vendida" required><br>
    <input type="submit" value="Registrar Venda">
    </form>

<a href="db1.php">Ir para a tela de Cadastro</a>

