<?php
require_once __DIR__ . "/funcoes/Conexao.php"; // Conex���o + SDK Mercado Pago

// Valor esperado para a renova������o (mesmo que no pagamento.php)
define('VALOR_RENOVACAO', 50.00); 

// L��� a requisi������o recebida
$input = file_get_contents('php://input');
$data = json_decode($input, true);

// Log da notifica������o recebida
file_put_contents(__DIR__ . '/webhook_log.txt', date('Y-m-d H:i:s') . " - Recebido: " . $input . "\n", FILE_APPEND);

// S��� processa notifica������es de pagamento
if (!isset($data['type']) || $data['type'] !== 'payment') {
    http_response_code(200);
    exit("Ignorado: n���o ��� pagamento");
}

$paymentId = $data['data']['id'];

try {
    $payment = MercadoPago\Payment::find_by_id($paymentId);
} catch (Exception $e) {
    file_put_contents(__DIR__ . '/webhook_error_log.txt', date('Y-m-d H:i:s') . " - Erro SDK: " . $e->getMessage() . "\n", FILE_APPEND);
    http_response_code(500);
    exit("Erro ao buscar pagamento");
}

// Verifica se o pagamento foi aprovado
if (!$payment || $payment->status !== 'approved') {
    file_put_contents(__DIR__ . '/webhook_log.txt', date('Y-m-d H:i:s') . " - Pagamento n���o aprovado para ID: {$paymentId}\n", FILE_APPEND);
    http_response_code(200);
    exit("Pagamento n���o aprovado");
}

// Valida o valor pago
if ((float)$payment->transaction_amount !== VALOR_RENOVACAO) {
    file_put_contents(__DIR__ . '/webhook_error_log.txt', date('Y-m-d H:i:s') . " - Valor inv���lido: {$payment->transaction_amount}\n", FILE_APPEND);
    http_response_code(400);
    exit("Valor inv���lido");
}

$externalReference = $payment->external_reference;

// Confere se o cliente existe no banco
$stmt = $pdo->prepare("SELECT id FROM config WHERE id = :id LIMIT 1");
$stmt->execute(['id' => $externalReference]);
$cliente = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$cliente) {
    file_put_contents(__DIR__ . '/webhook_error_log.txt', date('Y-m-d H:i:s') . " - Cliente n���o encontrado para ID: {$externalReference}\n", FILE_APPEND);
    http_response_code(400);
    exit("Cliente inv���lido");
}

// Atualiza o status e a data de expira������o
$stmt = $pdo->prepare("
    UPDATE config 
    SET 
        status = 1, 
        expiracao = DATE_ADD(GREATEST(expiracao, CURDATE()), INTERVAL 30 DAY) 
    WHERE id = :id
");
$stmt->execute(['id' => $externalReference]);

file_put_contents(__DIR__ . '/webhook_log.txt', date('Y-m-d H:i:s') . " - Plano renovado com sucesso para cliente ID: {$externalReference}\n", FILE_APPEND);

http_response_code(200);
echo "OK";
