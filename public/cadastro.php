<?php
session_start();

$ok  = $_SESSION['ok']  ?? '';
$err = $_SESSION['err'] ?? '';
unset($_SESSION['ok'], $_SESSION['err']);
?>
<!doctype html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Cadastre-se</title>
  <link rel="stylesheet" href="../assets/css/app.css">
</head>
<body>
  <div class="container">
    <div class="card">
      <h1>Cadastre-se</h1>

      <?php if ($ok): ?>
        <div class="success alert"><?= htmlspecialchars($ok) ?></div>
      <?php endif; ?>

      <?php if ($err): ?>
        <div class="alert alert-err"><?= htmlspecialchars($err) ?></div>
      <?php endif; ?>

      <form class="form" method="post" action="salvar_usuario.php" autocomplete="off">
        <input class="input" type="text" name="nome" placeholder="Nome Completo" required minlength="3" maxlength="120">
        <input class="input" type="tel" name="telefone" placeholder="Telefone" required minlength="8" maxlength="30">
        <input class="input" type="text" name="usuario" placeholder="Usuário" required minlength="3" maxlength="80">

        <input class="input" type="password" name="senha" placeholder="Senha" required minlength="4" maxlength="64">
        <input class="input" type="password" name="confirmar" placeholder="Confirmar Senha" required minlength="4" maxlength="64">

        <button class="button" type="submit">CADASTRAR</button>
      </form>

      <div class="helper">
        <a href="index.php">Já tem conta? Entrar</a>
      </div>
    </div>
  </div>
</body>
</html>
