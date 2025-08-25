<?php
include_once "header-pedido.php";

if (!isset($_GET['id_pedido'])) {
    header("Location: index.php");
    exit;
}

$id_pedido = $_GET['id_pedido'];

// Busca o pedido
$stmt = $connect->prepare("SELECT * FROM pedidos WHERE idpedido = :idpedido");
$stmt->execute([':idpedido' => $id_pedido]);
$pedido = $stmt->fetch(PDO::FETCH_OBJ);
if (!$pedido) exit("Pedido não encontrado!");

// Busca cliente
$stmt = $connect->prepare("SELECT * FROM clientes WHERE id = :id");
$stmt->execute([':id' => $pedido->id_cliente]);
$cliente = $stmt->fetch(PDO::FETCH_OBJ);

// Config empresa
$stmt_empresa = $connect->prepare("SELECT Chave_Pix, timerdelivery, celular FROM config WHERE id = :id LIMIT 1");
$stmt_empresa->execute([':id' => $pedido->idu]);
$dadosempresa = $stmt_empresa->fetch(PDO::FETCH_OBJ);

// Produtos do pedido
$stmt_produtos = $connect->prepare("SELECT s.*, p.nome FROM store s 
    JOIN produtos p ON p.id = s.produto_id AND p.idu = s.idu 
    WHERE s.idsecao = :idsecao AND s.status = 1 AND s.idu = :idu ORDER BY s.id DESC");
$stmt_produtos->execute([':idsecao'=>$id_pedido, ':idu'=>$pedido->idu]);
$produtosca = $stmt_produtos->fetchAll(PDO::FETCH_OBJ);

// Monta mensagem WhatsApp
$msg = "NOVO PEDIDO - ".$id_pedido."\n*Data:* ".$pedido->data."\n*Hora:* ".$pedido->hora."\n\nDADOS DO PEDIDO\n\n";
foreach ($produtosca as $p){
    $msg .= "*Item:* ".$p->nome."\n";
    if ($p->tamanho != "N") $msg .= "*Tamanho:* ".$p->tamanho."\n";
    $msg .= "*Qnt:* ".$p->quantidade."\n";
    $msg .= "*V. Unitário:* ".$p->valor."\n";

    // Busca adicionais do produto
    $stmt_adicionais = $connect->prepare("SELECT * FROM store_o WHERE ids = :ids AND idp = :idp AND status = '1' AND meioameio = '0'");
    $stmt_adicionais->execute([':ids'=>$id_pedido, ':idp'=>$p->id]);
    $adicionais_info = $stmt_adicionais->fetchAll(PDO::FETCH_OBJ);

    if(!empty($adicionais_info)){
        $msg .= "*Adicionais:*\n";
        foreach($adicionais_info as $ad){
            $msg .= "- ".$ad->nome." (R$ ".number_format($ad->valor,2,',','.').")\n";
        }
    }

    if ($p->obs) $msg .= "*Obs:* ".$p->obs."\n";
}

$msg .= "\nDADOS DA ENTREGA\n*Cliente:* ".$cliente->nome."\n*Contato:* ".$cliente->telefone."\n*Endereço:* ".$cliente->rua." - ".$cliente->numero." - ".$cliente->bairro."\n\n";
$msg .= "DADOS DO PAGAMENTO\n*Pagamento:* ".$pedido->fpagamento."\n*Subtotal:* R$ ".number_format($pedido->vsubtotal,2,',',' ')."\n";
if ($pedido->vadcionais>0) $msg .= "*Adicionais:* R$ ".$pedido->vadcionais."\n";
$msg .= ($pedido->taxa>0)? "*Taxa:* R$ ".$pedido->taxa."\n":"*Taxa:* Grátis\n";
$msg .= "*Total:* R$ ".number_format($pedido->vtotal,2,',',' ')."\n";
if ($pedido->troco>0) $msg .= "*Troco para:* R$ ".$pedido->troco."\n";
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.min.css">

<style>
body { background: #f4f6f9; }
.card-premium { border-radius: 15px; box-shadow: 0 8px 20px rgba(0,0,0,0.1); transition: transform .2s; }
.card-premium:hover { transform: translateY(-5px); }
.section-title { font-size: 1.2rem; font-weight: 600; display: flex; align-items: center; gap: 8px; margin-bottom: 15px; }
.badge-item { background-color: #0dcaf0; color: #fff; font-size: 0.8em; margin-left: 4px; }
.badge-tamanho { background-color: #6c757d; font-size: 0.75em; }
.table-striped > tbody > tr:nth-of-type(odd) { background-color: #f1f3f6; }
.btn-whatsapp { background-color: #25d366; color: white; border: none; }
.btn-whatsapp:hover { background-color: #1ebe5d; }
</style>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-9 col-md-10">

            <!-- Status Pedido -->
            <div class="text-center mb-4">
                <div class="rounded-circle bg-success d-inline-flex align-items-center justify-content-center mb-3" style="width:100px; height:100px;">
                    <i class="fa fa-check fa-3x text-white"></i>
                </div>
                <h1 class="fw-bold text-success mb-2">Pedido Recebido!</h1>
                <p class="text-muted fs-6">Seu pedido está sendo preparado.</p>
            </div>

            <!-- Cliente & Entrega -->
            <div class="card card-premium mb-4 p-4" style="border-left:5px solid #0d6efd;">
                <div class="section-title"><i class="fa fa-user"></i> Cliente & Entrega</div>
                <p><b>Nome:</b> <?= htmlspecialchars($cliente->nome) ?></p>
                <p><b>Endereço:</b> <?= htmlspecialchars($cliente->rua) ?>, <?= htmlspecialchars($cliente->numero) ?> - <?= htmlspecialchars($cliente->bairro) ?></p>
                <p><b>Contato:</b> <?= htmlspecialchars($cliente->telefone) ?></p>
                <p><b>Pagamento:</b> <?= htmlspecialchars($pedido->fpagamento) ?></p>
                <?php if(strtoupper($pedido->fpagamento)=="PIX" && !empty($dadosempresa->Chave_Pix)): ?>
                    <p><b>Chave Pix:</b> <span class="text-primary"><?= htmlspecialchars($dadosempresa->Chave_Pix) ?></span></p>
                <?php endif; ?>
            </div>

            <!-- Itens do Pedido -->
            <div class="card card-premium mb-4 p-4" style="border-left:5px solid #198754;">
                <div class="section-title"><i class="fa fa-box"></i> Itens do Pedido</div>
                <div class="table-responsive">
                    <table class="table table-sm table-striped mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Produto</th>
                                <th class="text-center">Qnt</th>
                                <th class="text-end">Valor</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($produtosca as $p): ?>
                            <?php
                                // Busca adicionais
                                $stmt_adicionais = $connect->prepare("SELECT * FROM store_o WHERE ids = :ids AND idp = :idp AND status = '1' AND meioameio = '0'");
                                $stmt_adicionais->execute([':ids'=>$id_pedido, ':idp'=>$p->id]);
                                $adicionais_info = $stmt_adicionais->fetchAll(PDO::FETCH_OBJ);

                                $valor_adicionais = 0;
                                foreach($adicionais_info as $ad) $valor_adicionais += $ad->valor;
                                $valor_total_item = ($p->valor * $p->quantidade) + $valor_adicionais;
                            ?>
                            <tr>
                                <td>
                                    <?= htmlspecialchars($p->nome) ?>
                                    <?php if($p->tamanho!="N"): ?>
                                        <span class="badge badge-tamanho"><?= htmlspecialchars($p->tamanho) ?></span>
                                    <?php endif; ?>
                                    <?php if($p->obs): ?>
                                        <br><small class="text-muted fst-italic"><?= htmlspecialchars($p->obs) ?></small>
                                    <?php endif; ?>
                                    <?php if(!empty($adicionais_info)): ?>
                                        <br><small class="text-primary fw-bold">Adicionais:</small>
                                        <?php foreach($adicionais_info as $ad): ?>
                                            <br><small>- <?= htmlspecialchars($ad->nome) ?> (R$ <?= number_format($ad->valor,2,',','.') ?>)</small>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center"><?= htmlspecialchars($p->quantidade) ?></td>
                                <td class="text-end">R$ <?= number_format($valor_total_item,2,',','.') ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Totais -->
            <div class="card card-premium mb-4 p-4" style="border-left:5px solid #ffc107;">
                <div class="section-title"><i class="fa fa-dollar-sign"></i> Totais</div>
                <div class="d-flex justify-content-between mb-1"><span>Subtotal:</span><span>R$ <?= number_format($pedido->vsubtotal,2,',','.') ?></span></div>
                <div class="d-flex justify-content-between mb-1"><span>Adicionais:</span><span>R$ <?= number_format($pedido->vadcionais,2,',','.') ?></span></div>
                <div class="d-flex justify-content-between mb-1"><span>Taxa de Entrega:</span><span><?= ($pedido->taxa>0)?'R$ '.number_format($pedido->taxa,2,',','.'):'Grátis' ?></span></div>
                <div class="d-flex justify-content-between fw-bold fs-5 mt-2"><span>Total:</span><span>R$ <?= number_format($pedido->vtotal,2,',','.') ?></span></div>
                <?php if($pedido->troco>0): ?>
                    <div class="alert alert-info py-2 mt-3 mb-0">
                        <i class="fa fa-money-bill-wave"></i> Troco para: <b>R$ <?= number_format($pedido->troco,2,',','.') ?></b>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Botões -->
            <div class="d-grid gap-2 mb-3">
                <button class="btn btn-whatsapp btn-lg" onclick="enviarMensagem(this)"><i class="fab fa-whatsapp"></i> Enviar Pedido no WhatsApp</button>
                <a href="meus_pedidos.php?id=<?= $id_pedido ?>" class="btn btn-outline-primary btn-lg"><i class="fa fa-eye"></i> Acompanhar Pedido</a>
                <a href="index.php" class="btn btn-outline-secondary btn-lg"><i class="fa fa-arrow-left"></i> Voltar</a>
            </div>

            <input type="hidden" id="celular" value="<?= htmlspecialchars($dadosempresa->celular) ?>">
            <input type="hidden" id="mensagem" value="<?= htmlspecialchars($msg) ?>">

            <div class="text-center text-muted mt-2" style="font-size:0.95em;">Se precisar de ajuda, fale conosco pelo WhatsApp.</div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
<script>
function enviarMensagem(btn){
    btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Abrindo WhatsApp...';
    btn.disabled = true;
    let celular = document.querySelector("#celular").value.replace(/\D/g,'');
    if(celular.length<13) celular="55"+celular;
    let texto = encodeURIComponent(document.querySelector("#mensagem").value);
    confetti({particleCount:150, spread:80, origin:{y:0.6}});
    window.open("https://api.whatsapp.com/send?phone="+celular+"&text="+texto,"_blank");
    setTimeout(()=>{ btn.innerHTML='<i class="fa fa-whatsapp"></i> Enviar Pedido no WhatsApp'; btn.disabled=false; },1000);
}
</script>
