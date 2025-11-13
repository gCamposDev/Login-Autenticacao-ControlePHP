<?php
require_once 'verifica_sessao.php';
require_once __DIR__ . '/../app/config.php';

if (!isset($_GET['id'])) {
    header('Location: veiculos_disponiveis.php');
    exit;
}

$veiculoId = (int) $_GET['id'];

// Atualiza veículo para "indisponível"
$stmt = $pdo->prepare("UPDATE veiculos SET disponivel = 0 WHERE id = ?");
$stmt->execute([$veiculoId]);

// Exibe mensagem simples (você pode redirecionar ou registrar o aluguel depois)
echo "<p style='text-align:center; margin-top: 50px; font-family: sans-serif; font-size: 1.2rem; color: green;'>Veículo alugado com sucesso!</p>";
echo "<p style='text-align:center;'><a href='veiculos_disponiveis.php'>← Voltar</a></p>";
