<?php
require_once 'verifica_sessao.php';
require_once __DIR__ . '/../app/config.php';

$idUsuario = $_SESSION['user']['id'];

$sql = "SELECT l.*, v.marca, v.modelo, v.ano, v.placa 
        FROM locacoes l
        JOIN veiculos v ON l.id_veiculo = v.id
        WHERE l.id_usuario = ?
        ORDER BY l.data_locacao DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute([$idUsuario]);
$locacoes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Minhas Locações</title>
<link rel="stylesheet" href="../assets/css/app.css">
</head>
<body>

<main class="content">
<h1>Minhas Locações</h1>

<?php foreach ($locacoes as $l): ?>
  <article class="card">
    <h2><?= htmlspecialchars($l['modelo']) ?> — <?= htmlspecialchars($l['marca']) ?></h2>

    <p><strong>Placa:</strong> <?= htmlspecialchars($l['placa']) ?></p>
    <p><strong>Data:</strong> <?= date('d/m/Y H:i', strtotime($l['data_locacao'])) ?></p>

    <?php if ($l['valor_fipe'] !== null): ?>
        <p><strong>Valor FIPE:</strong> R$ 
        <?= number_format($l['valor_fipe'], 2, ',', '.') ?>
        </p>
    <?php else: ?>
        <p class="helper">Valor FIPE indisponível.</p>
    <?php endif; ?>

    <!-- opcional:
    <pre><?= htmlspecialchars($l['fipe_json']) ?></pre>
    -->
  </article>
<?php endforeach; ?>

<div class="voltar">
  <a href="dashboard.php">← Voltar</a>
</div>

</main>
</body>
</html>
