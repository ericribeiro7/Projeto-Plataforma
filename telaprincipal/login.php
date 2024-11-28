<?php
session_start();

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

// Verificar se o formulário de login foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';

    // Sanitizar os dados
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    $senha = htmlspecialchars(strip_tags($senha));

    // Validar os dados
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Email inválido.";
        exit();
    }

    // Consultar o usuário no banco de dados
    $stmt = $conn->prepare("SELECT id, senha FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    // Verificar se o usuário existe
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($user_id, $hashed_password);
        $stmt->fetch();

        // Verificar a senha
        if (password_verify($senha, $hashed_password)) {
            // Senha correta, definir a sessão
            $_SESSION['user_id'] = $user_id;
            header("Location: perfil.html");
            exit();
        } else {
            echo "Senha incorreta.";
        }
    } else {
        echo "Usuário não encontrado.";
    }

    $stmt->close();
}

$conn->close();
?>
