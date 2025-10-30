<?php
session_start();
require_once __DIR__ . '/../app/config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$nome      = trim($_POST['nome'] ?? '');
$telefone  = trim($_POST['telefone'] ?? '');
$usuario   = trim($_POST['usuario'] ?? '');
$senha     = trim($_POST['senha'] ?? '');
$confirmar = trim($_POST['confirmar'] ?? '');

if ($nome === '' || $telefone === '' || $usuario === '' || $senha === '' || $confirmar === '') {
    $_SESSION['err'] = 'Preencha todos os campos.';
    header('Location: cadastro.php');
    exit;
}

if ($senha !== $confirmar) {
    $_SESSION['err'] = 'As senhas não conferem.';
    header('Location: cadastro.php');
    exit;
}

try {
    $hash = password_hash($senha, PASSWORD_BCRYPT);

    $stmt = $pdo->prepare('INSERT INTO usuarios (nome, telefone, usuario, senha_hash, perfil) 
                           VALUES (:nome, :telefone, :usuario, :hash, :perfil)');
    $stmt->bindValue(':nome', $nome);
    $stmt->bindValue(':telefone', $telefone);
    $stmt->bindValue(':usuario', $usuario);
    $stmt->bindValue(':hash', $hash);
    $stmt->bindValue(':perfil', 'user'); 

    $stmt->execute();

    $_SESSION['ok'] = 'Cadastro realizado! Faça login.';
    header('Location: index.php');
} catch (PDOException $e) {
    if (($e->errorInfo[1] ?? 0) == 1062) {
        $_SESSION['err'] = 'Usuário já existe.';
    } else {
        $_SESSION['err'] = 'Erro ao salvar.';
    }
    header('Location: cadastro.php');
}
