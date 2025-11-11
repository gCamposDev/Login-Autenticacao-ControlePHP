<?php
require_once 'verifica_sessao.php';
require_once __DIR__ . '/../app/config.php';

$idUsuario = $_SESSION['user']['id'] ?? 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $marca = trim($_POST['marca']);
  $modelo = trim($_POST['modelo']);
  $ano = (int) $_POST['ano'];
  $placa = trim($_POST['placa']);
  $preco_dia = (float) $_POST['preco_dia'];

  if ($marca && $modelo && $ano && $placa && $preco_dia > 0) {
    $stmt = $pdo->prepare("INSERT INTO veiculos (id_usuario, marca, modelo, ano, placa, preco_dia) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$idUsuario, $marca, $modelo, $ano, $placa, $preco_dia]);
    header("Location: veiculos_disponiveis.php");
    exit;
  }
}
?>
<!doctype html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <title>Cadastrar Veículo</title>
  <link rel="stylesheet" href="../assets/css/app.css">
</head>
<body class="bg-center">
  <div class="card large">
    <h1>Cadastrar Veículo</h1>
    <form method="post" class="form">
      <input class="input" type="text" name="marca" placeholder="Marca" required>
      <input class="input" type="text" name="modelo" placeholder="Modelo" required>
      <input class="input" type="number" name="ano" placeholder="Ano" required>
      <input class="input" type="text" name="placa" placeholder="Placa" required>
      <input class="input" type="number" step="0.01" min="0" name="preco_dia" placeholder="Preço por dia (R$)" required>

      <button class="button" type="submit">Salvar Veículo</button>
      <div class="helper"><a href="dashboard.php">← Voltar para o Dashboard</a></div>
    </form>
  </div>
</body>
</html>
