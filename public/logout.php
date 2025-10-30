<?php
session_start();
session_unset();
session_destroy();

session_start(); 
$_SESSION['ok'] = 'Você saiu do sistema.';
header('Location: index.php');
exit;
