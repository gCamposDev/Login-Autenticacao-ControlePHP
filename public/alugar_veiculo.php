<?php
require_once 'verifica_sessao.php';
require_once __DIR__ . '/../app/config.php';
require_once __DIR__ . '/api_client.php';

if (!isset($_GET['id'])) {
    header('Location: veiculos_disponiveis.php');
    exit;
}

$idUsuario = $_SESSION['user']['id'];
$veiculoId = (int) $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM veiculos WHERE id = ? AND disponivel = 1");
$stmt->execute([$veiculoId]);
$veiculo = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$veiculo) {
    $_SESSION['err'] = 'Veículo não encontrado ou já alugado.';
    header('Location: veiculos_disponiveis.php');
    exit;
}

$apiBase = 'http://localhost:8080';

$marca  = $veiculo['marca'];
$modelo = $veiculo['modelo'];
$ano    = $veiculo['ano'];

$valorFipe = apiGetFipe($apiBase, $marca, $modelo, $ano);

$fipeFormatado = $valorFipe !== null 
    ? round(floatval($valorFipe), 2)
    : null;

$fipeJson = json_encode(
    [
        "marca"  => $marca,
        "modelo" => $modelo,
        "ano"    => $ano,
        "valor"  => $fipeFormatado
    ],
    JSON_UNESCAPED_UNICODE
);

$pdo->beginTransaction();
try {

    $ins = $pdo->prepare("
        INSERT INTO locacoes (id_usuario, id_veiculo, data_locacao, valor_fipe, fipe_json)
        VALUES (:user, :carro, NOW(), :fipe, :json)
    ");

    $ins->execute([
        ':user'  => $idUsuario,
        ':carro' => $veiculoId,
        ':fipe'  => $fipeFormatado,
        ':json'  => $fipeJson
    ]);

    $upd = $pdo->prepare("UPDATE veiculos SET disponivel = 0 WHERE id = ?");
    $upd->execute([$veiculoId]);

    $pdo->commit();

    $_SESSION['ok'] = 'Veículo alugado com sucesso!';
    header('Location: minhas_locacoes.php');
    exit;

} catch (Exception $e) {

    $pdo->rollBack();
    error_log('Erro ao registrar locacao: ' . $e->getMessage());

    $_SESSION['err'] = 'Erro ao processar locação.';
    header('Location: veiculos_disponiveis.php');
    exit;
}
