<?php
require_once __DIR__ . '/../app/config.php';

$nome     = 'Administrador';
$telefone = '31999999999';
$usuario  = 'admin';
$senha    = '1234';
$perfil   = 'admin';

$hash = password_hash($senha, PASSWORD_BCRYPT);

try {
    $stmt = $pdo->prepare("INSERT INTO usuarios (nome, telefone, usuario, senha_hash, perfil)
                           VALUES (:nome, :telefone, :usuario, :senha, :perfil)");
    $stmt->execute([
        ':nome'     => $nome,
        ':telefone' => $telefone,
        ':usuario'  => $usuario,
        ':senha'    => $hash,
        ':perfil'   => $perfil,
    ]);

    echo "<h2 style='color:green'>Usuário administrador criado com sucesso!</h2>";
} catch (PDOException $e) {
    if (($e->errorInfo[1] ?? 0) === 1062) {
        echo "<h2 style='color:red'>Erro: Usuário já existe.</h2>";
    } else {
        echo "<h2 style='color:red'>Erro ao criar admin: " . htmlspecialchars($e->getMessage()) . "</h2>";
    }
}
?>
