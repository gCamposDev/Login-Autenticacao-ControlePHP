<?php
require_once 'verifica_sessao.php';
require_once __DIR__ . '/../app/config.php';

$usuarioLogado = $_SESSION['user']['usuario'] ?? 'Usuário';
$idUsuario = $_SESSION['user']['id'] ?? 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $numero_cnh = trim($_POST['numero_cnh'] ?? '');
    $categoria  = trim($_POST['categoria'] ?? '');
    $validade   = trim($_POST['validade'] ?? '');

    if ($numero_cnh === '' || $categoria === '' || $validade === '') {
        $erro = "Preencha todos os campos.";
    } else {
        try {
            $stmt = $pdo->prepare("
                INSERT INTO cnhs (id_usuario, numero_cnh, categoria, validade)
                VALUES (:id_usuario, :numero_cnh, :categoria, :validade)
            ");
            $stmt->bindValue(':id_usuario', $idUsuario, PDO::PARAM_INT);
            $stmt->bindValue(':numero_cnh', $numero_cnh);
            $stmt->bindValue(':categoria', $categoria);
            $stmt->bindValue(':validade', $validade);
            $stmt->execute();

            $sucesso = "CNH cadastrada com sucesso!";
        } catch (PDOException $e) {
            $erro = "Erro ao cadastrar CNH: " . $e->getMessage();
        }
    }
}
?>
<!doctype html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <title>Cadastrar CNH • AlugaFácil</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../assets/css/app.css">
</head>
<body class="bg">
  <header class="topbar">
    <div class="brand">AlugaFácil</div>
    <div class="user">
      <span>Olá, <strong><?= htmlspecialchars($usuarioLogado) ?></strong></span>
      <a class="button button-danger" href="logout.php">Sair</a>
    </div>
  </header>

  <main class="content">
    <div class="cardlarge">
      <h1>Cadastrar CNH</h1>

      <?php if (!empty($erro)): ?>
        <div class="alert alert-err"><?= htmlspecialchars($erro) ?></div>
      <?php elseif (!empty($sucesso)): ?>
        <div class="alert alert-ok"><?= htmlspecialchars($sucesso) ?></div>
      <?php endif; ?>

      <form method="post" class="form">
        <input class="input" 
               type="text" 
               name="numero_cnh" 
               placeholder="Número da CNH" 
               required 
               maxlength="20">

        <select class="input" name="categoria" required>
          <option value="">Selecione a categoria</option>
          <option value="A">A</option>
          <option value="B">B</option>
          <option value="AB">AB</option>
          <option value="C">C</option>
          <option value="D">D</option>
          <option value="E">E</option>
        </select>

        <input class="input" 
               type="date" 
               name="validade" 
               required>

        <button class="button" type="submit">Salvar CNH</button>
      </form>

      <div class="helper">
        <a href="dashboard.php">← Voltar</a>
      </div>
    </div>
  </main>

  <footer class="footer">
    © <?= date('Y') ?> AlugaFácil — Todos os direitos reservados.
  </footer>
</body>
</html>
