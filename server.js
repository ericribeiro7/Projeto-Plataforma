// server.js
const express = require('express');
const bodyParser = require('body-parser');
const cors = require('cors');

// Inicializa o app Express
const app = express();
const PORT = process.env.PORT || 3000;

// Middleware
app.use(cors());
app.use(bodyParser.json()); // Para analisar o corpo das requisições no formato JSON

// Rota para salvar as informações do perfil
app.post('/salvarPerfil', (req, res) => {
    const { nome, sobrenome, email, telefone, endereco } = req.body;

    // Aqui você adiciona a lógica para salvar os dados
    // Você pode usar um banco de dados, como MongoDB, MySQL, etc.
    // Por enquanto, vamos simular o salvamento e retornar uma resposta de sucesso

    console.log('Dados recebidos:', { nome, sobrenome, email, telefone, endereco });

    // Simula uma operação de salvamento bem-sucedida
    res.status(200).json({ message: 'Perfil salvo com sucesso!' });
});

// Inicia o servidor
app.listen(PORT, () => {
    console.log(`Servidor rodando na porta ${PORT}`);
});
