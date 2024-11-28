<?php
// Iniciar a sessão (necessário para identificar o usuário)
session_start();

// Verificar se o usuário está logado
// Isso pressupõe que você tem um sistema de autenticação que define $_SESSION['user_id']
if (!isset($_SESSION['user_id'])) {
    // Redirecionar para a página de login ou exibir uma mensagem de erro
    header("Location: login.html");
    exit();
}

// Configurações do banco de dados
$servername = "localhost";
$username = "root"; // Seu usuário do MySQL
$password = "";     // Sua senha do MySQL
$dbname = "meu_banco";

// Criar conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Receber os dados do formulário com método POST
$first_name = $_POST['Primeiro Nome'] ?? '';
$last_name = $_POST['Ultimo Nome'] ?? '';
$email = $_POST['Email'] ?? '';
$phone = $_POST['Número'] ?? '';
$address = $_POST['Endereço'] ?? '';
$country = $_POST['País'] ?? '';

// Sanitizar os dados para evitar injeção de SQL
$first_name = htmlspecialchars(strip_tags($first_name));
$last_name = htmlspecialchars(strip_tags($last_name));
$email = filter_var($email, FILTER_SANITIZE_EMAIL);
$phone = htmlspecialchars(strip_tags($phone));
$address = htmlspecialchars(strip_tags($address));
$country = htmlspecialchars(strip_tags($country));

// Validar os dados (exemplo básico)
$errors = [];

if (empty($first_name)) {
    $errors[] = "Primeiro nome é obrigatório.";
}

if (empty($last_name)) {
    $errors[] = "Sobrenome é obrigatório.";
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Email inválido.";
}

// Se houver erros, exibir mensagens e encerrar o script
if (!empty($errors)) {
    foreach ($errors as $error) {
        echo "<p style='color:red;'>$error</p>";
    }
    echo "<p><a href='perfil.html'>Voltar</a></p>";
    exit();
}

// Preparar a declaração SQL para evitar injeção de SQL
$stmt = $conn->prepare("UPDATE usuarios SET first_name = ?, last_name = ?, email = ?, phone = ?, address = ?, country = ? WHERE id = ?");
$stmt->bind_param("ssssssi", $first_name, $last_name, $email, $phone, $address, $country, $_SESSION['user_id']);

if ($stmt->execute()) {
    echo "<p style='color:green;'>Perfil atualizado com sucesso!</p>";
    echo "<p><a href='perfil.html'>Voltar ao Perfil</a></p>";
} else {
    // Verificar se o erro é de duplicação de email
    if ($conn->errno === 1062) {
        echo "<p style='color:red;'>O email informado já está em uso.</p>";
    } else {
        echo "<p style='color:red;'>Erro ao atualizar perfil: " . $conn->error . "</p>";
    }
    echo "<p><a href='perfil.html'>Voltar</a></p>";
}

// Fechar a declaração e a conexão
$stmt->close();
$conn->close();
?>
