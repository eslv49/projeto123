<?php
session_start();
if (!isset($_SESSION["logado"]) || $_SESSION["logado"] !== true) {
    header("Location: login.php");
    exit();
}
?>





<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Produto</title>
    <!-- Referência ao arquivo externo de estilo CSS -->
    <link rel="stylesheet" href="estilo.css">
</head>
<body>

<header>
    <img src="logo.png" alt="Logotipo">
    <h1>Cadastrar Produto</h1>
</header>

<div class="container">


    <form method="post" action="">
        <label for="nome">Nome:</label>
        <input type="text" name="nome" required><br>
        
        <label for="quantidade">Quantidade:</label>
        <input type="number" name="quantidade" required><br>
        
        <label for="valor">Valor:</label>
        <input type="text" name="valor" required><br>
        
        <input type="submit" value="Adicionar produto">
    </form>


<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "projeto3";

//conexão com o banco de dados
$conn = new mysqli($servername,$username,$password,$dbname);
//verifica se a conexão foi bem sucedida
if($conn->connect_error){
die("Conexão falhou:".$conn->connect_error);

}

# Adicionar produto ao estoque
if($_SERVER["REQUEST_METHOD"] =="POST"){
   //captura os dados do formulário
$nome=$_POST['nome'];
$quantidade=$_POST['quantidade'];
$valor=$_POST['valor'];

//Verifica se os campos não estão vazios

if (empty($nome) || empty($quantidade) || empty($valor)) {
   echo "Por favor, preencha todos os campos.";
} else {
   //usando prepared statement para evitar SQL injection

$sql="INSERT INTO produtos3(nome,quantidade,valor) VALUES(?,?,?)";
// preparando a consulta
$stmt = $conn->prepare($sql);

//LIgando os parametros ao statement

$stmt->bind_param("sis" , $nome,$quantidade,$valor);
//Executando a consulta
if ($stmt->execute()){
    echo"Novo Produto adicionado com sucesso";
}else{

   echo"Erro ao adicionar o produto: ". stmt->error;
}
//fechar o statement
$stmt->close();
}
}


/*
?>  

<form method="post" action="">
Nome:<input type="text" name="nome" required><br>
Quantidade:<input type="number" name="quantidade" required><br>
Valor:<input type="text" name="valor" required><br>
<input type="submit" value="Adicionar produto">
</form>
*/

//visualizar produtos



$sql="SELECT id,nome,quantidade,valor FROM PRODUTOS3";
$result=$conn->query($sql);

if($result->num_rows>0){
/*echo"<table><tr><th>ID</th><th>Nome</th><th>Quantidade</th><th>Valor</th></tr>";
while($row=$result->fetch_assoc()){
      echo"<tr><td>".$row["id"] ."</td><td>". $row["nome"] ."</td><td>".
           $row["quantidade"]."</td><td>". $row["valor"] ."</td></tr>";
}
*/
echo "<table><tr><th>ID</th><th>Nome</th><th>Quantidade</th><th>Valor</th><th>Ações</th></tr>";
while($row = $result->fetch_assoc()) {
    echo "<tr>
            <td>" . $row["id"] . "</td>
            <td>" . $row["nome"] . "</td>
            <td>" . $row["quantidade"] . "</td>
            <td>" . $row["valor"] . "</td>
            <td><a href='excluir.php?id=" . $row["id"] . "' onclick=\"return confirm('Tem certeza que deseja excluir este produto?');\">Excluir</a></td>
          </tr>";
}

       
       echo"</table>";
       }else{
            echo "0 resultados";

            }
?>

<div class="links">
<a href="venda.php">Registrar Vendas</a>
<a href="compra.php">Registrar Compras</a>

</div>


</body>
</html>


