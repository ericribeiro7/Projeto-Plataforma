<?php
// Conexão com o banco de dados
$host = 'localhost';
$dbname = 'meu_banco';
$user = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro na conexão: " . $e->getMessage());
}

// Recebe os dados do formulário
$name = $_POST['name'];
$donationType = $_POST['donationType'];
$amount = $_POST['amount'];
$message = $_POST['message'] ?? '';

// Insere os dados na tabela
$sql = "INSERT INTO doacoes (name, donationType, amount, message) VALUES (:name, :donationType, :amount, :message)";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':name', $name);
$stmt->bindParam(':donationType', $donationType);
$stmt->bindParam(':amount', $amount);
$stmt->bindParam(':message', $message);
$stmt->execute();

// Link do WhatsApp com uma mensagem personalizada
$telefone = "5598984599832"; // Substitua pelo número de telefone desejado
$mensagemWhatsApp = "Olá, fiz uma doação! Nome: $name, Tipo: $donationType, Quantidade: $amount. Mensagem: $message";
$mensagemCodificada = urlencode($mensagemWhatsApp);
$linkWhatsApp = "https://wa.me/$telefone?text=$mensagemCodificada";

// Redireciona para o link do WhatsApp
header("Location: $linkWhatsApp");
exit;
?>
