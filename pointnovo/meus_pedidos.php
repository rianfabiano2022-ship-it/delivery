<?php
include_once "header-pedido.php";

$pedido_unico_id = $_GET['id'] ?? null;
if (!$pedido_unico_id) exit("<div class='text-center p-5'>Nenhum pedido especificado.</div>");

// Pedido
$pedidos = $connect->prepare("SELECT * FROM pedidos WHERE idpedido = :idpedido LIMIT 1");
$pedidos->bindParam(':idpedido', $pedido_unico_id);
$pedidos->execute();
$pedido = $pedidos->fetch(PDO::FETCH_OBJ);
if (!$pedido) exit("<div class='text-center p-5'>Nenhum pedido encontrado.</div>");

// Cliente
$clientedados = $connect->prepare("SELECT * FROM clientes WHERE id = :id_cliente LIMIT 1");
$clientedados->bindParam(':id_cliente', $pedido->id_cliente);
$clientedados->execute();
$cliente = $clientedados->fetch(PDO::FETCH_OBJ);

// Itens
$produtosca = $connect->prepare("SELECT * FROM store WHERE idsecao = :idsecao AND status = '1'");
$produtosca->bindParam(':idsecao', $pedido_unico_id);
$produtosca->execute();

// Status
$statusAtual = $pedido->status;
$status_steps = [
    ['id' => 1, 'text' => 'Pedido Recebido', 'icon' => 'fa-clipboard-list'],
    ['id' => 2, 'text' => 'Em Preparação', 'icon' => 'fa-pizza-slice'],
    ['id' => 3, 'text' => 'Saiu para Entrega', 'icon' => 'fa-truck-fast'],
    ['id' => 4, 'text' => 'Entregue', 'icon' => 'fa-check']
];
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Acompanhar Pedido - Point da Pizza</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.min.css">

<style>
body { background: #f4f6f9; }
.card-premium { border-radius: 15px; box-shadow: 0 8px 20px rgba(0,0,0,0.1); transition: transform .2s; margin-bottom: 1.5rem; }
.card-premium:hover { transform: translateY(-5px); }
.section-title { font-size: 1.2rem; font-weight: 600; display: flex; align-items: center; gap: 8px; margin-bottom: 15px; }
.timeline { position: relative; list-style: none; padding: 0; }
.timeline:before { content: ''; position: absolute; top: 0; bottom: 0; left: 25px; width: 3px; background: #e9ecef; }
.timeline-item { position: relative; padding-left: 60px; margin-bottom: 2rem; }
.timeline-icon { position: absolute; left: 10px; top: 0; width: 35px; height: 35px; border-radius: 50%; background: #fff; border: 2px solid #e9ecef; display: flex; align-items: center; justify-content: center; color: #fff; font-size:1.1rem; transition: border-color 0.3s ease; }
.timeline-icon.active { border-color: #0d6efd; background-color: #0d6efd; color: #fff; }
.timeline-info.active h6 { color: #0d6efd !important; font-weight: bold; }
.badge-item { background-color: #0dcaf0; color: #fff; font-size: 0.8em; margin-left: 4px; }
.badge-tamanho { background-color: #6c757d; font-size: 0.75em; }
</style>
</head>
<body>

<div class="container my-5">

    <div class="text-center mb-4">
        <h2 class="fw-bold">Pedido #<?= $pedido_unico_id ?></h2>
        <p class="text-muted">Acompanhe o status do seu pedido em tempo real:</p>
    </div>

    <!-- Resumo do Pedido -->
    <div class="card card-premium p-4 border-start border-5 border-primary">
        <div class="section-title"><i class="fa fa-receipt"></i> Resumo do Pedido</div>
        <div class="d-flex justify-content-between mb-2"><span>Valor Total:</span><span>R$ <?= number_format($pedido->vtotal,2,',','.') ?></span></div>
        <div class="d-flex justify-content-between mb-2"><span>Data:</span><span><?= $pedido->data ?> às <?= $pedido->hora ?></span></div>
        <?php if ($cliente): ?>
        <div class="mb-0">
            <h6 class="fw-bold">Endereço de Entrega:</h6>
            <p class="mb-0"><?= $cliente->rua ?>, <?= $cliente->numero ?> - <?= $cliente->bairro ?></p>
            <small class="text-muted"><?= $cliente->complemento ? ' - '.$cliente->complemento : '' ?></small>
        </div>
        <?php endif; ?>
    </div>

    <!-- Itens do Pedido -->
    <div class="card card-premium p-4 border-start border-5 border-success">
        <div class="section-title"><i class="fa fa-box"></i> Itens do Pedido</div>
        <ul class="list-group list-group-flush">
            <?php while ($carpro = $produtosca->fetch(PDO::FETCH_OBJ)):
                $nomepro = $connect->prepare("SELECT nome FROM produtos WHERE id = :id_produto");
                $nomepro->bindParam(':id_produto', $carpro->produto_id);
                $nomepro->execute();
                $nomeprox = $nomepro->fetch(PDO::FETCH_OBJ);

                $adcionais = $connect->prepare("SELECT * FROM store_o WHERE ids = :ids AND idp = :idp AND status = '1' AND meioameio = '0'");
                $adcionais->bindParam(':ids', $pedido_unico_id);
                $adcionais->bindParam(':idp', $carpro->id);
                $adcionais->execute();

                $adicionais_info = [];
                $adicionais_valor = 0;
                while ($adcionalv = $adcionais->fetch(PDO::FETCH_OBJ)) {
                    $adicionais_valor += $adcionalv->valor;
                    $adicionais_info[] = $adcionalv->nome . ' (R$ ' . number_format($adcionalv->valor,2,',','.') . ')';
                }

                $valor_total_item = ($carpro->valor * $carpro->quantidade) + $adicionais_valor;
            ?>
            <li class="list-group-item d-flex justify-content-between align-items-start">
                <div>
                    <h6 class="mb-0"><?= $carpro->quantidade ?>x <?= $nomeprox->nome ?></h6>
                    <small class="text-muted">
                        <?php if ($carpro->tamanho != "N") echo "Tamanho: ".$carpro->tamanho; ?>
                        <?php if ($carpro->obs) echo " | Obs: ".$carpro->obs; ?>
                    </small>
                    <?php if (!empty($adicionais_info)) { ?>
                        <br><small class="text-primary fw-bold">Adicionais:</small>
                        <?php foreach ($adicionais_info as $info): ?>
                            <br><small>- <?= $info ?></small>
                        <?php endforeach; ?>
                    <?php } ?>
                </div>
                <span class="fw-bold">R$ <?= number_format($valor_total_item,2,',','.') ?></span>
            </li>
            <?php endwhile; ?>
        </ul>
    </div>

    <!-- Status do Pedido -->
    <div class="card card-premium p-4 border-start border-5 border-warning">
        <div class="section-title"><i class="fa fa-tasks"></i> Status do Pedido</div>
        <div id="timeline-container"></div>
    </div>

    <div class="text-center mt-3">
        <a href="index.php" class="btn btn-outline-secondary btn-lg w-75"><i class="fa fa-arrow-left"></i> Voltar para o Início</a>
    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    let currentStatus = <?= $statusAtual ?>;
    const statusSteps = <?= json_encode($status_steps) ?>;
    const timelineContainer = document.getElementById('timeline-container');

    const renderTimeline = (status) => {
        let html = '<ul class="timeline">';
        statusSteps.forEach(step => {
            const isActive = status >= step.id;
            const isCurrent = status === step.id;
            html += `
            <li class="timeline-item">
                <span class="timeline-icon ${isActive ? 'active' : ''}">
                    <i class="fas ${step.icon}"></i>
                </span>
                <div class="timeline-info ${isCurrent ? 'active' : ''}">
                    <h6 class="mb-0 timeline-title">${step.text}</h6>
                    <small class="text-muted">${isActive ? 'Concluído' : 'Aguardando'}</small>
                </div>
            </li>`;
        });
        html += '</ul>';
        timelineContainer.innerHTML = html;
    };

    const fetchStatus = () => {
        fetch(`get_status.php?id=<?= $pedido_unico_id ?>`)
            .then(r => r.text())
            .then(newStatus => {
                newStatus = parseInt(newStatus);
                if(newStatus !== currentStatus){
                    currentStatus = newStatus;
                    renderTimeline(currentStatus);
                }
            });
    };

    renderTimeline(currentStatus);
    setInterval(fetchStatus,5000);
});
</script>

</body>
</html>
