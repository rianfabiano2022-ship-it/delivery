<?php
session_start();

$data = date("d-m-Y");
$hora = date("H:i:s");

if (isset($_POST["totalg"])) {

    $nome = strtoupper($_POST['nome']);
    $wps = str_replace(["(", ")", "-"], "", $_POST['wps']);
    if (strlen($wps) < 11) {
        header("location: ".$site."balcao&erro=");
        exit;
    }

    $subtotalx  = str_replace(",", ".", $_POST['subtotal']);
    $adcionaisx = str_replace(",", ".", $_POST['adcionais']);
    $totalgx    = str_replace(",", ".", $_POST['totalg']);

    setcookie("nomecli", $nome, time() + (86400 * 90));
    setcookie("celcli", $wps, time() + (86400 * 90));

    $stmt = $connect->prepare("SELECT id FROM clientes WHERE telefone = ?");
    $stmt->execute([$wps]);
    $cliente = $stmt->fetch(PDO::FETCH_OBJ);
    $id_cliente_novo = $cliente ? $cliente->id : null;

    if (!$cliente) {
        $stmt = $connect->prepare("INSERT INTO clientes (nome, telefone) VALUES (?, ?)");
        $stmt->execute([$nome, $wps]);
        $id_cliente_novo = $connect->lastInsertId();
    }

    $id_pedido_unico = uniqid();

    $stmt = $connect->prepare("INSERT INTO pedidos(idu, idpedido, id_cliente, fpagamento, troco, data, hora, taxa, vsubtotal, vadcionais, vtotal, status)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([
        $idu, $id_pedido_unico, $id_cliente_novo, 'BALCAO', '0.00', $data, $hora, '0.00', $subtotalx, $adcionaisx, $totalgx, '1'
    ]);

    $connect->query("UPDATE store SET status='1', idsecao='$id_pedido_unico' WHERE idsecao='".session_id()."' AND idu='$idu'");
    $connect->query("UPDATE store_o SET status='1', ids='$id_pedido_unico' WHERE ids='".session_id()."' AND idu='$idu'");

    // Monta mensagem WhatsApp
    $msg = "NOVO PEDIDO - ".$id_pedido_unico."\n";
    $msg .= "*Data:* ".$data."\n";
    $msg .= "*Hora:* ".$hora."\n\n";
    $msg .= "DADOS DO PEDIDO\n\n";

    $produtosca = $connect->query("SELECT * FROM store WHERE idsecao = '".$id_pedido_unico."' AND status='1' AND idu='$idu' ORDER BY id DESC");
    while ($carpro = $produtosca->fetch(PDO::FETCH_OBJ)) { 
        $nomepro = $connect->query("SELECT nome FROM produtos WHERE id = '".$carpro->produto_id."' AND idu='$idu'");
        $nomeprox = $nomepro->fetch(PDO::FETCH_OBJ);
        $msg .= "*Item:* ".$nomeprox->nome."\n";
        if($carpro->tamanho != "N") { $msg .= "*Tamanho:* ".$carpro->tamanho."\n"; }
        $msg .= "*Qnt:* ".$carpro->quantidade."\n";
        $msg .= "*V. Unitário:* ".$carpro->valor."\n";
        if($carpro->obs) { $msg .= "*Obs:* ".$carpro->obs."\n"; }

        // Meio a meio
        $meiom = $connect->query("SELECT * FROM store_o WHERE idp='".$carpro->idpedido."' AND status='1' AND idu='$idu' AND meioameio='1'");
        $meiomc = $meiom->rowCount();
        if($meiomc > 0){
            $msg .= "*".$meiomc." Sabores:*\n";
            while ($meiomv = $meiom->fetch(PDO::FETCH_OBJ)) {
                $msg .= "".$meiomv->nome."\n";
            }
        }

        // Adicionais
        $adcionais = $connect->query("SELECT * FROM store_o WHERE idp='".$carpro->idpedido."' AND status='1' AND idu='$idu' AND meioameio='0'");
        $adcionaisc = $adcionais->rowCount();
        if($adcionaisc > 0){
            $msg .= "*Ingredientes/Adicionais:*\n";
            while ($adcionaisv = $adcionais->fetch(PDO::FETCH_OBJ)) {
                $msg .= "- R$: ".$adcionaisv->valor." | ".$adcionaisv->nome."\n";
            }
        }
        $msg .= "\n";
    }

    $msg .= "DADOS DA ENTREGA\n\n";
    $msg .= "*Tipo:* Retirada no Balcão\n";
    $msg .= "*Tempo de Entrega:* ".$dadosempresa->timerbalcao."\n";
    $msg .= "*Cliente:* ".$nome."\n";
    $msg .= "*Contato:* ".$wps."\n\n";

    $msg .= "DADOS DO PAGAMENTO\n\n";
    $msg .= "*Subtotal:* R$: ".$subtotalx."\n";
    if($adcionaisx > 0) { $msg .= "*Adicionais:* R$: ".$adcionaisx."\n"; }
    $msg .= "*Valor Total:* R$: ".$totalgx."\n\n";

    $msg .= "ENDEREÇO DE RETIRADA\n\n";
    $msg .= "*".$dadosempresa->nomeempresa."*\n";
    $msg .= "".$dadosempresa->rua." - nº ".$dadosempresa->numero."\n";
    $msg .= "".$dadosempresa->bairro."\n";

    header("Location: pedido_balcao.php?id_pedido=$id_pedido_unico");
    exit;
}
?>
