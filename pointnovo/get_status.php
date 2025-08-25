<?php
// Inclua o arquivo de conexão. Use o mesmo caminho que funcionou no meus_pedidos.php
include_once "header-pedido.php";

// Obtenha o ID do pedido da requisição
$id_pedido = $_GET['id'] ?? null;

if ($id_pedido) {
    // Busque o status atual do pedido no banco de dados
    $stmt = $connect->prepare("SELECT status FROM pedidos WHERE idpedido = ? LIMIT 1");
    $stmt->execute([$id_pedido]);
    $status = $stmt->fetchColumn();

    // Retorna o status. Se não encontrar, retorna 0 (ou um valor padrão)
    echo $status ?: 0;
} else {
    // Retorna um erro ou 0 se o ID não for fornecido
    echo 0;
}
?>