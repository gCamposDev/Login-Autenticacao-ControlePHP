<?php
require_once 'verifica_sessao.php';
require_once __DIR__ . '/../app/config.php';

$idUsuario = $_SESSION['user']['id'] ?? 0;
$mensagem = "";

// Buscar CNH atual
$stmt = $pdo->prepare("SELECT * FROM cnhs WHERE id_usuario = ?");
$stmt->execute([$idUsuario]);
$cnh = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['excluir'])) {
        // Excluir CNH
        $excluir = $pdo->prepare("DELETE FROM cnhs WHERE id_usuario = ?");
        $excluir->execute([$idUsuario]);
        header("Location: visualizar_cnh.php");
        exit;
    } else {
        // Atualizar CNH
        $numero = $_POST['numero_cnh'] ?? '';
        $categoria = $_POST['categoria'] ?? '';
        $validade = $_POST['validade'] ?? '';

        if ($cnh) {
            $update = $pdo->prepare("UPDATE cnhs SET numero_cnh = ?, categoria = ?, validade = ? WHERE id_usuario = ?");
            $update->execute([$numero, $categoria, $validade, $idUsuario]);
        } else {
            $insert = $pdo->prepare("INSERT INTO cnhs (id_usuario, numero_cnh, categoria, validade) VALUES (?, ?, ?, ?)");
            $insert->execute([$idUsuario, $numero, $categoria, $validade]);
        }

        header("Location: visualizar_cnh.php");
        exit;
    }
}
?>
<!doctype html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <title>Editar CNH</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../assets/css/app.css">
</head>
<body class="bg">
  <div class="container">
    <div class="card">
      <h1><?= $cnh ? "Editar CNH" : "Cadastrar CNH" ?></h1>

      <form method="post">
        <label>Número da CNH:
          <input type="text" name="numero_cnh" value="<?= htmlspecialchars($cnh['numero_cnh'] ?? '') ?>" required>
        </label>

        <label>Categoria:
          <select name="categoria" required>
            <?php
            $categorias = ['A', 'B', 'AB', 'C', 'D', 'E'];
            foreach ($categorias as $cat) {
              $selected = ($cnh['categoria'] ?? '') === $cat ? 'selected' : '';
              echo "<option value=\"$cat\" $selected>$cat</option>";
            }
            ?>
          </select>
        </label>

        <label>Validade:
          <input type="date" name="validade" value="<?= htmlspecialchars($cnh['validade'] ?? '') ?>" required>
        </label>

        <div style="margin-top: 1rem;">
          <button class="button" type="submit">Salvar</button>
          <?php if ($cnh): ?>
            <button class="button button-danger" type="submit" name="excluir" onclick="return confirm('Tem certeza que deseja excluir sua CNH?')">Excluir</button>
          <?php endif; ?>
        </div>
      </form>

      <div class="helper"><a href="visualizar_cnh.php">← Voltar</a></div>
    </div>
  </div>
</body>
</html>
