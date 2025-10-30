<?php
session_start();

$ok  = $_SESSION['ok']  ?? '';
$err = $_SESSION['err'] ?? '';
unset($_SESSION['ok'], $_SESSION['err']);

if (isset($_SESSION['user'])) {
    header('Location: dashboard.php');
    exit;
}
?>
<!doctype html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login • AlugaFácil</title>
  <link rel="stylesheet" href="../assets/css/app.css">
</head>
<body class="bg">
  <main class="container">
    <section class="card">
      <h1 class="title">AlugaFácil</h1>

      <?php if ($ok): ?>
        <div class="alert alert-ok"><?= htmlspecialchars($ok) ?></div>
      <?php endif; ?>
      <?php if ($err): ?>
        <div class="alert alert-err"><?= htmlspecialchars($err) ?></div>
      <?php endif; ?>

      <form class="form" method="post" action="autentica.php" autocomplete="off">
        <div class="form-group">
          <input class="input" type="text" name="usuario" placeholder="Usuário" required minlength="3" maxlength="80">
        </div>
        <div class="form-group">
          <input class="input" type="password" name="senha" placeholder="Senha" required minlength="4" maxlength="64">
        </div>
        <button class="button" type="submit">Acessar</button>
      </form>

      <p class="helper">
        Ainda não é inscrito?
        <a class="link" href="cadastro.php">Inscreva-se</a>
      </p>
    </section>
  </main>
</body>
</html>
