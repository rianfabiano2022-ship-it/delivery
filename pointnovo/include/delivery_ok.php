<?php
// Aqui NÃO precisa de session_start()

$data = date("d-m-Y");
$hora = date("H:i:s");

if (isset($_POST["totalg"])) {
    $nome = strtoupper($_POST['nome']);
    $wps = str_replace(["(", ")", "-"], "", $_POST['wps']);
    if (strlen($wps) < 11) {
        header("location: ".$site."delivery&erro=");
        exit;
    }

    $fmpgto = $_POST['fmpgto'];
    $troco = ($fmpgto == "CARTAO") ? "0.00" : str_replace(",", ".", $_POST['troco']);
    $cidade = $_POST['cidade'];
    $uf = $_POST['uf'];
    $numero = $_POST['numero'];
    $rua = $_POST['rua'];
    $bairro = $_POST['bairro'];
    $complemento = $_POST['complemento'] ?? "";

    setcookie("nomecli", $nome, time() + (86400 * 90));
    setcookie("celcli", $wps, time() + (86400 * 90));
    setcookie("numero", $numero, time() + (86400 * 90));
    setcookie("rua", $rua, time() + (86400 * 90));
    setcookie("comp", $complemento, time() + (86400 * 90));

    $subtotalx  = str_replace(",", ".", $_POST['subtotal']);
    $adcionaisx = str_replace(",", ".", $_POST['adcionais']);
    $totalgx    = str_replace(",", ".", $_POST['totalg']);
    $taxa       = str_replace(",", ".", $_POST['taxa']);
    if (!$taxa) $taxa = "0.00";

    if ($troco > 0 && $troco < $totalgx) {
        header("location: ".$site."delivery&troco=");
        exit;
    }

    $stmt = $connect->prepare("SELECT id FROM clientes WHERE telefone = ?");
    $stmt->execute([$wps]);
    $cliente = $stmt->fetch(PDO::FETCH_OBJ);
    $id_cliente_novo = $cliente ? $cliente->id : null;

    if (!$cliente) {
        $stmt = $connect->prepare("INSERT INTO clientes (nome, telefone, rua, numero, bairro, complemento, cidade, uf) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$nome, $wps, $rua, $numero, $bairro, $complemento, $cidade, $uf]);
        $id_cliente_novo = $connect->lastInsertId();
    }

    $id_pedido_unico = uniqid();

    $stmt = $connect->prepare("INSERT INTO pedidos(idu, idpedido, id_cliente, fpagamento, troco, data, hora, taxa, vsubtotal, vadcionais, vtotal, status)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([
        $idu, $id_pedido_unico, $id_cliente_novo, $fmpgto, $troco, $data, $hora, $taxa, $subtotalx, $adcionaisx, $totalgx, '1'
    ]);

    $connect->query("UPDATE store SET status='1', idsecao='$id_pedido_unico' WHERE idsecao='".session_id()."' AND idu='$idu'");
    $connect->query("UPDATE store_o SET status='1', ids='$id_pedido_unico' WHERE ids='".session_id()."' AND idu='$idu'");

    header("Location: pedido_finalizado.php?id_pedido=$id_pedido_unico");
    exit;
}
?>