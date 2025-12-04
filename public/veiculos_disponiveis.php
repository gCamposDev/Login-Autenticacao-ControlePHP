<?php
require_once 'verifica_sessao.php';
require_once __DIR__ . '/../app/config.php';

$id_usuario = $_SESSION['user']['id'] ?? 0;

$sql = "SELECT * FROM veiculos WHERE id_usuario != ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id_usuario]);
$veiculos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Veículos Disponíveis</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../assets/css/app.css">
</head>
<body class="bg">
  <main class="content">
    <section class="hero">
      <h1>Veículos Disponíveis para Aluguel</h1>
      <p>Confira os veículos disponíveis cadastrados por outros usuários.</p>
    </section>

    <?php if (count($veiculos) > 0): ?>
      <section class="grid">
        <?php foreach ($veiculos as $v): ?>
          <article class="card">
            <h2><?= htmlspecialchars($v['modelo']) ?></h2>
            <p><strong>Marca:</strong> <?= htmlspecialchars($v['marca']) ?></p>
            <p><strong>Ano:</strong> <?= htmlspecialchars($v['ano']) ?></p>
            <p><strong>Placa:</strong> <?= htmlspecialchars($v['placa']) ?></p>
            <p><strong>Preço por dia:</strong> R$ <?= number_format($v['preco_dia'], 2, ',', '.') ?></p>
            <a class="button" href="alugar_veiculo.php?id=<?= $v['id'] ?>">Alugar</a>
          </article>
        <?php endforeach; ?>
      </section>
    <?php else: ?>
      <p class="helper">Nenhum veículo disponível no momento.</p>
    <?php endif; ?>

    <div class="voltar">
      <a href="dashboard.php">← Voltar para o Dashboard</a>
    </div>
  </main>
</body>
</html>
