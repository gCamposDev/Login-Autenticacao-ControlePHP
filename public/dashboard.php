<?php
require_once 'verifica_sessao.php';
require_once __DIR__ . '/../app/config.php';

$usuarioLogado = $_SESSION['user']['usuario'] ?? 'Usuário';
$perfilLogado  = $_SESSION['user']['perfil']  ?? 'user';
$idUsuario     = $_SESSION['user']['id'] ?? 0;

// Verifica se a CNH já está cadastrada para o usuário atual
$stmt = $pdo->prepare("SELECT id FROM cnhs WHERE id_usuario = ?");
$stmt->execute([$idUsuario]);
$temCNH = $stmt->fetchColumn();
?>
<!doctype html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <title>Dashboard • AlugaFácil</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../assets/css/app.css">
</head>
<body class="bg">
  <header class="topbar">
    <div class="brand">AlugaFácil</div>
    <div class="user">
      <span>Olá, <strong><?= htmlspecialchars($usuarioLogado) ?></strong></span>
      <a class="button button-danger" href="logout.php" title="Sair">Sair</a>
    </div>
  </header>

  <main class="content">
    <section class="hero">
      <h1>Dashboard</h1>
      <p>Escolha uma ação abaixo para começar.</p>
    </section>

    <section class="grid">
      <article class="card">
        <h2><?= $temCNH ? 'Visualizar CNH' : 'Cadastrar CNH' ?></h2>
        <p><?= $temCNH 
              ? 'Veja os dados da sua CNH cadastrada ou edite.' 
              : 'Armazene e valide os dados de habilitação do cliente.' ?></p>
        <a class="button" href="<?= $temCNH ? 'visualizar_cnh.php' : 'cadastrar_cnh.php' ?>">
          <?= $temCNH ? 'Visualizar CNH' : 'Cadastrar CNH' ?>
        </a>
      </article>

      <article class="card">
        <h2>Alugar Carro</h2>
        <p>Inicie um novo contrato de locação rapidamente.</p>
        <a class="button button-disabled" href="javascript:void(0)">Alugar Carro (Botão inativo)</a>
      </article>

      <article class="card">
        <h2>Cadastrar Veículo</h2>
        <p>Cadastre seu carro para disponibilizar no sistema.</p>
        <a class="button" href="cadastrar_veiculo.php">Cadastrar Veículo</a>
      </article>
      
      <article class="card">
        <h2>Perfil</h2>
        <p>Veja e atualize suas informações de acesso.</p>
        <a class="button button-disabled" href="javascript:void(0)">Perfil (Botão inativo)</a>
      </article>

      


      <?php if ($perfilLogado === 'admin'): ?>
      <article class="card">
        <h2>Listar Usuários</h2>
        <p>Visualize todos os usuários cadastrados no sistema.</p>
        <a class="button" href="listar_usuarios.php">Listar Usuários</a>
      </article>
      <?php endif; ?>
    </section>
  </main>

  <footer class="footer">
    © <?= date('Y') ?> AlugaFácil — Todos os direitos reservados.
  </footer>
</body>
</html>
