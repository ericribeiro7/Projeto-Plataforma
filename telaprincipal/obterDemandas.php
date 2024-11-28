<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "meu_banco";

// Cria a conexão com o banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica se a conexão foi bem-sucedida
if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

// Seleciona todas as demandas do banco de dados
$sql = "SELECT nome, tipo, quantidade, descricao, infoAdicional FROM demandas_doacoes";
$result = $conn->query($sql);

$demandas = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $demandas[] = $row;
    }
}

// Retorna os dados em formato JSON
header('Content-Type: application/json');
echo json_encode($demandas);

$conn->close();
?>
