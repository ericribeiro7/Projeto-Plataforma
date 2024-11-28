_<?php
// Configurações do banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "meu_banco";

// Cria a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->query($sql) === TRUE) {
    $last_id = $conn->insert_id;
    $sql_last = "SELECT id, nome, tipo, quantidade, descricao, infoAdicional, 
                 DATE_FORMAT(data_criacao, '%d/%m/%Y') as data_criacao, status 
                 FROM demandas_doacoes WHERE id = $last_id";
    $result_last = $conn->query($sql_last);

    if ($result_last->num_rows > 0) {
        $nova_demanda = $result_last->fetch_assoc();
        echo json_encode([
            "success" => true,
            "demanda" => $nova_demanda
        ]);
    } else {
        echo json_encode(["success" => false, "message" => "Erro ao buscar demanda criada."]);
    }
} else {
    echo json_encode(["success" => false, "message" => $conn->error]);
}
$conn->close();

