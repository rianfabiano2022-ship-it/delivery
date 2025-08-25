<?php
$servidor = 'localhost';
$usuario  = 'root';
$senha 	  = '';
$banco    = 'pointnovo';

try {
    $pdo = new PDO(
        "mysql:host=$servidor;dbname=$banco;charset=utf8mb4",
        $usuario,
        $senha,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"
        ]
    );

    // Forçar charset em toda a sessão
    $pdo->exec("SET NAMES utf8mb4");
    $pdo->exec("SET CHARACTER SET utf8mb4");
    $pdo->exec("SET character_set_connection=utf8mb4");

} catch (PDOException $e) {
    die("Erro na conexão com o banco de dados: " . $e->getMessage());
}

// FUNCOES DO SISTEMA DE CADASTRO ###########

$nomesite  = 'RFA Solutions';
$urlmaster = 'http://localhost/cardapio'; // APENAS A URL PRINCIPAL SEM A BARRA NO FINAL ---- ----

// Fuso horário
date_default_timezone_set('America/Sao_Paulo');

// Garantir saída PHP em UTF-8
header('Content-Type: text/html; charset=utf-8');

// TOKEN MERCADO PAGO (substituir pelo real)
define('MP_ACCESS_TOKEN', 'APP_USR-1810940714298492-080509-09a7796aab7bf24273372ce0e2b57ee3-256176100');

// Autoload do Mercado Pago (via Composer)
require_once __DIR__ . '/../vendor/autoload.php';

// Inicializa Mercado Pago SDK
MercadoPago\SDK::setAccessToken(MP_ACCESS_TOKEN);
?>
