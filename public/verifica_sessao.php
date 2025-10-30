<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: sem_permissao.php');
    exit;
}

if (!isset($_SESSION['last_regenerate'])) {
    $_SESSION['last_regenerate'] = time();
} elseif (time() - $_SESSION['last_regenerate'] > 300) {
    session_regenerate_id(true);
    $_SESSION['last_regenerate'] = time();
}
