<?php
session_start();
require_once __DIR__ . '/../app/config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$u = trim($_POST['usuario'] ?? '');
$s = trim($_POST['senha'] ?? '');

if ($u === '' || $s === '') {
    $_SESSION['err'] = 'Informe usuário e senha.';
    header('Location: index.php');
    exit;
}

$stmt = $pdo->prepare('SELECT id, usuario, senha_hash, perfil FROM usuarios WHERE usuario = :u LIMIT 1');
$stmt->bindValue(':u', $u);
$stmt->execute();
$row = $stmt->fetch();

if (!$row || !password_verify($s, $row['senha_hash'])) {
    $_SESSION['err'] = 'Usuário ou senha inválidos.';
    header('Location: index.php');
    exit;
}

session_regenerate_id(true);
$_SESSION['user'] = [
    'id' => $row['id'],
    'usuario' => $row['usuario'],
    'perfil' => $row['perfil']
];

header('Location: dashboard.php');
exit;
