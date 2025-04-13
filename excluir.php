<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "projeto3";

// Conectar ao banco
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Verifica se o ID foi enviado pela URL
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Verifica se o produto existe
    $checkSql = "SELECT * FROM produtos3 WHERE id = ?";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->bind_param("i", $id);
    $checkStmt->execute();
    $result = $checkStmt->get_result();

    if ($result->num_rows > 0) {
        // Se existe, deletar
        $deleteSql = "DELETE FROM produtos3 WHERE id = ?";
        $deleteStmt = $conn->prepare($deleteSql);
        $deleteStmt->bind_param("i", $id);

        if ($deleteStmt->execute()) {
            echo "Produto excluído com sucesso.";
        } else {
            echo "Erro ao excluir produto: " . $conn->error;
        }

        $deleteStmt->close();
    } else {
        echo "Produto não encontrado.";
    }

    $checkStmt->close();
} else {
    echo "ID do produto não fornecido.";
}

$conn->close();

?>
<a href="db1.php" style="display: inline-block; padding: 10px 20px; background-color: #4CAF50; color: white; text-decoration: none; border-radius: 5px; font-weight: bold;">
    Voltar para a lista de produtos
</a>

    