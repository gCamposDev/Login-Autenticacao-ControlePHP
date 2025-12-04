<?php
require_once 'verifica_sessao.php';
require_once __DIR__ . '/../app/config.php';

$user = $_SESSION['user'];
$idUsuario = $user['id'];

$sql = "SELECT v.modelo, v.marca, v.ano, v.placa, v.preco_dia, l.data_locacao
        FROM locacoes l
        JOIN veiculos v ON l.id_veiculo = v.id
        WHERE l.id_usuario = ?
        ORDER BY l.data_locacao DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute([$idUsuario]);
$locacoes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Meu Perfil</title>
  <link rel="stylesheet" href="../assets/css/app.css">
</head>
<body class="bg">
  <main class="content">
    <h1>Perfil do Usuário</h1>
    <section class="card">
      <p><strong>Nome:</strong> <?= htmlspecialchars($user['nome']) ?></p>
      <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
      <p><strong>Perfil:</strong> <?= htmlspecialchars($user['perfil']) ?></p>
    </section>

    <h2>Histórico de Locações</h2>
    <?php if (count($locacoes) > 0): ?>
      <section class="grid">
        <?php foreach ($locacoes as $l): ?>
          <article class="card">
            <h3><?= htmlspecialchars($l['modelo']) ?></h3>
            <p><strong>Marca:</strong> <?= htmlspecialchars($l['marca']) ?></p>
            <p><strong>Ano:</strong> <?= htmlspecialchars($l['ano']) ?></p>
            <p><strong>Placa:</strong> <?= htmlspecialchars($l['placa']) ?></p>
            <p><strong>Data da locação:</strong> <?= date('d/m/Y H:i', strtotime($l['data_locacao'])) ?></p>
          </article>
        <?php endforeach; ?>
      </section>
    <?php else: ?>
      <p class="helper">Nenhuma locação registrada.</p>
    <?php endif; ?>

    <div class="voltar">
      <a href="dashboard.php">← Voltar ao Dashboard</a>
    </div>
  </main>
</body>
</html>
