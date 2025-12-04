<?php

function apiGetFipe(string $baseUrl, string $marca, string $modelo, $ano, int $timeout = 8): ?float {

    $params = http_build_query([
        'marca'  => $marca,
        'modelo' => $modelo,
        'ano'    => $ano
    ]);

    $url = rtrim($baseUrl, '/') . '/fipe?' . $params;

    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_CONNECTTIMEOUT => 4,
        CURLOPT_TIMEOUT => $timeout,
        CURLOPT_HTTPHEADER => ['Accept: application/json'],
        CURLOPT_SSL_VERIFYPEER => false,
    ]);

    $resp = curl_exec($ch);
    $errno = curl_errno($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($errno !== 0 || $httpCode < 200 || $httpCode >= 300 || !$resp) {
        return null;
    }

    if (is_numeric($resp)) {
        return (float) $resp;
    }

    $data = json_decode($resp, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        return null;
    }

    if (isset($data["valor"])) {
        return (float) $data["valor"];
    }

    if (is_numeric($data)) {
        return (float) $data;
    }

    return null;
}
