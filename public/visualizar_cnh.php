<?php
require_once 'verifica_sessao.php';
require_once __DIR__ . '/../app/config.php';

$idUsuario = $_SESSION['user']['id'] ?? 0;

// Buscar CNH vinculada ao usuário
$stmt = $pdo->prepare("SELECT numero_cnh, categoria, validade FROM cnhs WHERE id_usuario = ?");
$stmt->execute([$idUsuario]);
$cnh = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<!doctype html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <title>Visualizar CNH</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../assets/css/app.css">
</head>
<body class="bg">
  <div class="container">
    <div class="card">
      <h1>Minha CNH</h1>

      <?php if ($cnh): ?>
        <p><strong>Número:</strong> <?= htmlspecialchars($cnh['numero_cnh']) ?></p>
        <p><strong>Categoria:</strong> <?= htmlspecialchars($cnh['categoria']) ?></p>
        <p><strong>Validade:</strong> <?= date('d/m/Y', strtotime($cnh['validade'])) ?></p>

        <a href="editar_cnh.php" class="button">Editar CNH</a>
      <?php else: ?>
        <p>Você ainda não cadastrou sua CNH.</p>
        <a href="cadastrar_cnh.php" class="button">Cadastrar agora</a>
      <?php endif; ?>

      <div class="helper"><a href="dashboard.php">← Voltar ao dashboard</a></div>
    </div>
  </div>
</body>
</html>
