<?php
// Detalhes da conexão com o banco de dados
$servername = "localhost"; // Nome do servidor (geralmente localhost)
$username = "root"; // Usuário do banco de dados
$password = ""; // Senha do banco de dados
$dbname = "meu_banco"; // Nome do banco de dados

// Criação da conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar se a conexão foi bem-sucedida
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Capturar os dados do formulário
$nome = $_POST['nome'];
$tipo = $_POST['tipo'];
$quantidade = $_POST['quantidade'];
$descricao = $_POST['descricao'];
$infoAdicional = $_POST['infoAdicional'];

// Inserir os dados no banco de dados
$sql = "INSERT INTO demandas_doacoes (nome, tipo, quantidade, descricao, infoAdicional) 
        VALUES ('$nome', '$tipo', $quantidade, '$descricao', '$infoAdicional')";

if ($conn->query($sql) === TRUE) {
    // Mensagem de sucesso
    echo "<div style='display: flex; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.8); color: #fff; align-items: center; justify-content: center; font-size: 24px; font-weight: bold;'>
            Demanda criada com sucesso.
          </div>";
    
    // Ocultar a mensagem automaticamente após 1.5 segundos
    echo "<script>
            setTimeout(function() {
                document.querySelector('div').style.display = 'none';
                window.location.href = 'doacao.html'; // Redireciona para o formulário (mude o nome do arquivo conforme necessário)
            }, 1500);
          </script>";
} else {
    echo "Erro ao fazer a doação: " . $conn->error;
}

// Fechar a conexão com o banco de dados
$conn->close();
?>
