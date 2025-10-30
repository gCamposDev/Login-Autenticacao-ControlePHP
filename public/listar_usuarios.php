<?php
require_once __DIR__ . '/../app/config.php';
session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['perfil'] !== 'admin') {
    header('Location: acesso_negado.php');
    exit;
}

$stmt = $pdo->query("SELECT id, nome, telefone, usuario, perfil FROM usuarios ORDER BY nome");
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!doctype html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <title>Lista de Usuários</title>
  <link rel="stylesheet" href="../assets/css/app.css">
  <style>
    .tela-usuarios {
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      padding: 32px 16px;
    }

    .titulo-usuarios {
      font-size: 1.6rem;
      color: var(--primary);
      margin-bottom: 16px;
    }

    .table-usuarios {
      width: 100%;
      max-width: 800px;
      border-collapse: collapse;
    }

    .table-usuarios th,
    .table-usuarios td {
      padding: 12px 16px;
      text-align: left;
      font-size: 1rem;
      white-space: nowrap;
    }

    .table-usuarios th {
      color: var(--primary);
      font-weight: bold;
      border-bottom: 1px solid var(--border);
    }

    .table-usuarios tr:not(:last-child) td {
      border-bottom: 1px solid #2e3748;
    }

    .voltar {
      margin-top: 24px;
      color: var(--muted);
    }

    .voltar a {
      color: var(--primary);
      font-weight: bold;
    }
  </style>
</head>
<body>
  <div class="tela-usuarios">
    <h1 class="titulo-usuarios">Usuários Cadastrados</h1>
    <table class="table-usuarios">
      <thead>
        <tr>
          <th>Nome</th>
          <th>Telefone</th>
          <th>Usuário</th>
          <th>Perfil</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($usuarios as $u): ?>
          <tr>
            <td><?= htmlspecialchars($u['nome']) ?></td>
            <td><?= htmlspecialchars($u['telefone']) ?></td>
            <td><?= htmlspecialchars($u['usuario']) ?></td>
            <td><?= htmlspecialchars($u['perfil']) ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <div class="voltar"><a href="dashboard.php">← Voltar</a></div>
  </div>
</body>
</html>
