<?php
if(isset($_COOKIE['pdvx'])){
    $cod_id = $_COOKIE['pdvx'];
} else {
    header("location: sair.php");
}
include_once('../../funcoes/Conexao.php');
include_once('../../funcoes/Key.php');

$pegadadosgerais = $connect->query("SELECT * FROM config WHERE id='$cod_id'");
$dadosgerais = $pegadadosgerais->fetch(PDO::FETCH_OBJ);
$nomeempresa = $dadosgerais->nomeempresa;

date_default_timezone_set(''.$dadosgerais->fuso.'');

// === NOVO BLOCO DE LÓGICA PARA OBTER O ID DO PEDIDO ===
$codigop = null;

if (isset($_POST['codigop'])) {
    // Caso 1: O ID vem da página pdv.php (formulário com name="codigop")
    $codigop = $_POST['codigop'];
} elseif (isset($_POST['andamento'])) {
    // Caso 2: O ID vem do botão "Aceitar Pedido"
    $codigop = $_POST['andamento'];
} elseif (isset($_POST['entrega'])) {
    // Caso 3: O ID vem do botão "Saiu para entrega"
    $codigop = $_POST['entrega'];
} elseif (isset($_POST['retirada'])) {
    // Caso 4: O ID vem do botão "Disp. para retirada"
    $codigop = $_POST['retirada'];
} elseif (isset($_POST['finalizado'])) {
    // Caso 5: O ID vem do botão "Finalizar"
    $codigop = $_POST['finalizado'];
} elseif (isset($_POST['cancelado'])) {
    // Caso 6: O ID vem do botão "Cancelar"
    $codigop = $_POST['cancelado'];
}

// Verifica se o ID do pedido foi passado de alguma forma
if (empty($codigop)) {
    echo "ID do pedido não especificado.";
    exit;
}
// === FIM DO NOVO BLOCO ===

// Agora, a consulta já está correta, não precisa mudar mais nada aqui
$query = "
    SELECT
        p.*,
        c.nome AS nome_cliente,
        c.telefone AS celular_cliente,
        c.rua AS rua_cliente,
        c.numero AS numero_cliente,
        c.bairro AS bairro_cliente,
        c.complemento AS complemento_cliente
    FROM pedidos AS p
    JOIN clientes AS c ON p.id_cliente = c.id
    WHERE p.idpedido = ?
";
$stmt = $connect->prepare($query);
$stmt->execute([$codigop]);
$pedido = $stmt->fetch(PDO::FETCH_OBJ);

// Verifica se o pedido existe
if (!$pedido) {
    echo "Pedido não encontrado.";
    exit;
}

// Agora você pode acessar os dados do cliente usando as novas colunas
$celcli = $pedido->celular_cliente;

$produtoscay = $connect->query("SELECT * FROM store WHERE idsecao = '$codigop' ORDER BY id DESC");
$produtoscaxy = $connect->query("SELECT * FROM store WHERE idsecao = '$codigop' ORDER BY id DESC");
$produtosca = $connect->query("SELECT * FROM store WHERE idsecao = '$codigop' ORDER BY id DESC");
$produtoscx = $produtosca->rowCount();

$item = $connect->query("SELECT * FROM store WHERE idsecao='$codigop'");
$opcionais = $connect->query("SELECT * FROM store_o WHERE ids='$codigop'");

// andamento
if ($pedido->fpagamento == "PIX") {
    $msg1 = "Olá! O Seu pedido foi aceito e já foi encaminhado para o preparo.\n";
    $msg1 .= "Favor realizar o pagamento via PIX utilizando a chave:\n";
    $msg1 .= "*" . $dadosgerais->Chave_Pix . "*\n";
    $msg1 .= "Valor a pagar: *R$ " . number_format($pedido->vtotal, 2, ',', '.') . "* \n";
    $msg1 .= "\n*" . $nomeempresa . "*\n";
} else {
    $msg1 = "Olá! O Seu pedido foi aceito e já foi encaminhado para o preparo.\n";
    $msg1 .= "\n*" . $nomeempresa . "*\n";
}

if (isset($_POST["andamento"])) {
    $update = $connect->query("UPDATE pedidos SET status='2' WHERE idpedido='" . $_POST["andamento"] . "'");
    header("location: pdv.php?ok=");
}

// saiu para entrega
$msg2 = "Olá! O seu pedido está a caminho.\n";
$msg2 .= "\n";
$msg2 .= "*" . $nomeempresa . "*\n";

if (isset($_POST["entrega"])) {
    $update = $connect->query("UPDATE pedidos SET status='3' WHERE idpedido='" . $_POST["entrega"] . "'");
    header("location: pdv.php?ok=");
}

// disponivel para retirada
$msg3 = "Olá! Seu pedido já esta disponível para retirada em nosso estabelecimento.\n";
$msg3 .= "\n";
$msg3 .= "*" . $nomeempresa . "*\n";

if (isset($_POST["retirada"])) {
    $update = $connect->query("UPDATE pedidos SET status='4' WHERE idpedido='" . $_POST["retirada"] . "'");
    header("location: pdv.php?ok=");
}

// finalizado
$msg4 = "Pedido entregue! Obrigado pela preferência.\n";
$msg4 .= "\n";
$msg4 .= "*" . $nomeempresa . "*\n";

if (isset($_POST["finalizado"])) {
    $update = $connect->query("UPDATE pedidos SET status='5' WHERE idpedido='" . $_POST["finalizado"] . "'");
    header("location: pdv.php?ok=");
}

// cancelado
$msg5 = "Olá! Infelizmente o seu pedido foi cancelado.\n";
$msg5 .= "\n";
$msg5 .= "*" . $nomeempresa . "*\n";

if (isset($_POST["cancelado"])) {
    $update = $connect->query("UPDATE pedidos SET status='6' WHERE idpedido='" . $_POST["cancelado"] . "'");
    header("location: pdv.php?ok=");
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Premium Quality and Responsive UI for Dashboard.">
    <meta name="author" content="ThemePixels">
    <title>RECEBIMENTO DE PEDIDOS</title>
    <link href="../lib/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="../lib/Ionicons/css/ionicons.css" rel="stylesheet">
    <link href="../lib/datatables/css/jquery.dataTables.css" rel="stylesheet">
    <link href="../lib/select2/css/select2.min.css" rel="stylesheet">
    <link href="../lib/SpinKit/css/spinkit.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/slim.css">
  </head>
  <body>

    <div class="slim-navbar">
      <div class="container">
        <ul class="nav">
          <li class="nav-item">
            <a class="nav-link" href="#">
              <span>
              <?php
              if($pedido->status == 1){print $statusxx = "Status Atual - Pedido Novo";}
                if($pedido->status == 2){print $statusxx = "Status Atual - Em Andamento";}
                if($pedido->status == 3){print $statusxx = "Status Atual - Saiu para entrega";}
                if($pedido->status == 4){print $statusxx = "Status Atual - Disp. para retirada";}
                if($pedido->status == 5){print $statusxx = "Status Atual - Finalizado";}
                if($pedido->status == 6){print $statusxx = "Status Atual - Cancelado";}
                if($pedido->status == 7){print $statusxx = "Status Atual - Confirmado pela Cozinha";}
              ?>
              </span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="pdv.php">
              <i class="icon ion-ios-analytics-outline"></i>
              <span> VOLTAR </span>
            </a>
          </li>
        </ul>
      </div>
    </div>

    <div class="slim-mainpanel">
      <div class="container">

          <div class="row mg-t-10">

          <div class="col-md-6">
            <div class="card card-people-list pd-15 mg-b-10">
                <label class="section-title" style="margin-top:-1px"><i class="fa fa-check-square-o" aria-hidden="true"></i> ALTERAR STATUS DO PEDIDO</label>
                <hr>
                <div class="row mg-t-10">
                    <div class="col-md-4 mg-b-10">
                    <form action="" method="post">
                    <input type="hidden" name="andamento" value="<?=$codigop;?>">
                    <input type="hidden" id="celular" value="<?=$celcli;?>">
                    <input type="hidden" id="mensagem" value="<?=$msg1; ?>">
                    <button type="submit" class="btn btn-warning btn-block" onClick="enviarMensagem()">Aceitar Pedido</button>
                    </form>
                    </div>
                    <div class="col-md-4 mg-b-10">
                    <form action="" method="post">
                    <input type="hidden" name="entrega" value="<?=$codigop;?>">
                    <input type="hidden" id="celular2" value="<?=$celcli;?>">
                    <input type="hidden" id="mensagem2" value="<?=$msg2; ?>">
                    <button type="submit" class="btn btn-success btn-block" onClick="enviarMensagem2()">Saiu para entrega</button>
                    </form>
                    </div>
                    <div class="col-md-4 mg-b-10">
                    <form action="" method="post">
                    <input type="hidden" name="retirada" value="<?=$codigop;?>">
                    <input type="hidden" id="celular3" value="<?=$celcli;?>">
                    <input type="hidden" id="mensagem3" value="<?php echo $msg3; ?>">
                    <button type="submit" class="btn btn-info btn-block" onClick="enviarMensagem3()">Disp. para retirada</button>
                    </form>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                    <form action="" method="post">
                    <input type="hidden" name="finalizado" value="<?=$codigop;?>">
                    <input type="hidden" id="celular4" value="<?=$celcli;?>">
                    <input type="hidden" id="mensagem4" value="<?php echo $msg4; ?>">
                    <button type="submit" class="btn btn-purple btn-block" onClick="enviarMensagem4()">Finalizar</button>
                    </form>
                    </div>
                    <div class="col-md-4" align="center" style="font-size:20px; margin-top:5px;"><i class="fa fa-arrow-left mg-r-10" aria-hidden="true"></i><i class="fa fa-cutlery" aria-hidden="true"><i class="fa fa-arrow-right mg-l-10" aria-hidden="true"></i></i>
                    </div>
                    <div class="col-md-4">
                    <form action="" method="post">
                    <input type="hidden" name="cancelado" value="<?=$codigop;?>">
                    <input type="hidden" id="celular5" value="<?=$celcli;?>">
                    <input type="hidden" id="mensagem5" value="<?php echo $msg5; ?>">
                    <button type="submit" class="btn btn-danger btn-block" onClick="enviarMensagem5()">Cancelar</button>
                    </form>
                    </div>
                </div>



            </div>
          </div>

<div class="col-md-3">
          <center>
             <a href="#" class="btn btn-primary btn-block invoice-print" name="btnprint" onClick="PrintMe('print')"><i class="fa fa-print" aria-hidden="true"></i> Balcão</a>
          </center>
<div class="card card-people-list pd-15 mg-b-10" style="background-color:#fdfbe3">

<div id="print" style="font-family: Arial;">
    <center><p class="tx-15"><strong>RESUMO DO PEDIDO</strong></p></center>
    <center><p class="tx-12">Comanda Balcão</span></p>
    <center><p class="tx-12"><?=$pedido->data;?> às <?=$pedido->hora;?></span></p>
    <center><p class="tx-12">Nº <?=$codigop;?></span></p>
    <hr />
    <?php
    while ($carpro = $produtosca->fetch(PDO::FETCH_OBJ)) {
    $nomepro = $connect->query("SELECT nome FROM produtos WHERE id = '".$carpro->produto_id."'");
    $nomeprox = $nomepro->fetch(PDO::FETCH_OBJ);
    ?>

    <p style="margin-left:10px;" align="left"><span class="tx-12"><b>** Item: </b><?php print $nomeprox->nome;?></span></p>

    <?php if($carpro->tamanho != "N" ) { ?>
    <p style="margin-left:10px;" align="left"><span class="tx-12"><b>- Tamanho: </b><?php print $carpro->tamanho;?></span></p>
    <?php } ?>

    <p style="margin-left:10px;" align="left"><span class="tx-12"><b>- Qnt:</b> <?php print $carpro->quantidade; ?></span></p>

    <p style="margin-left:10px;" align="left"><span class="tx-12"><b>- V. Unitário:</b> <?php echo "R$: ".$carpro->valor; ?></span></p>

    <?php if($carpro->obs) {?>
    <p style="margin-left:10px;" align="left"><span class="tx-12"><b>- Obs:</b> <?php echo $carpro->obs; ?></span></p>
    <?php } else { ?>
    <p style="margin-left:10px;" align="left"><span class="tx-12"><b>- Obs:</b> Não</span></p>
    <?php } ?>

    <?php
    $meiom = $connect->query("SELECT * FROM store_o WHERE idp = '".$carpro->id."' AND status = '1' AND idu='$cod_id' AND meioameio='1'");
    $meiomc = $meiom->rowCount();
    ?>

    <?php if($meiomc>0){ ?>
    <p style="margin-left:10px;" align="left"><span class="tx-12"><b>* <?=$meiomc;?> Sabores:</b></span></p>
    <p style="margin-left:10px;" align="left"><span class="tx-12">
    <?php while ($meiomv = $meiom->fetch(PDO::FETCH_OBJ)) { ?>
    <?=$meiomv->nome."<br>";?>
    <?php } ?>
    </span></p>
    <?php } ?>

    <?php
    $adcionais = $connect->query("SELECT * FROM store_o WHERE idp = '".$carpro->id."' AND status = '1' AND idu='$cod_id' AND meioameio='0'");
    $adcionaisc = $adcionais->rowCount();
    ?>

    <?php if($adcionaisc>0){ ?>
    <p style="margin-left:10px;" align="left"><span class="tx-12"><b>* Adicionais/Ingredientes:</b></p>
    <p style="margin-left:10px;" align="left"><span class="tx-12">
    <?php while ($adcionaisv = $adcionais->fetch(PDO::FETCH_OBJ)) { ?>
    <?="- R$: ".$adcionaisv->valor." | ".$adcionaisv->nome."<br>";?>
    <?php } ?>
    </span></p>
    <?php } ?>
    <center>=========================</center></p>
    <?php } ?>

    <br>
    <center><strong>DADOS DO CLIENTE</strong></center>
    <hr />
    <p style="margin-left:10px;" align="left"><span class="tx-12"><b>Nome: </b><?=$pedido->nome_cliente;?></span></p>
    <p style="margin-left:10px;" align="left"><span class="tx-12"><b>Celular: </b><?=$pedido->celular_cliente;?></span></p>
    <?php if($pedido->mesa > 0 ){ ?>
    <p style="margin-left:10px;" align="left"><span class="tx-12"><b>Mesa: </b><?=$pedido->mesa;?></span></p>
    <p style="margin-left:10px;" align="left"><span class="tx-12"><b>Pessoa na Mesa: </b><?=$pedido->pessoas;?></span></p>
    <p style="margin-left:10px;" align="left"><span class="tx-12"><b>Obs: </b><?=$pedido->obs;?></span></p>
    <?php } ?>
    <?php if(!empty($pedido->rua_cliente)) { ?>
    <p style="margin-left:10px;" align="left"><span class="tx-12"><b>Rua: </b><?=$pedido->rua_cliente;?></span></p>
    <p style="margin-left:10px;" align="left"><span class="tx-12"><b>Nº: </b><?=$pedido->numero_cliente;?></span></p>
    <p style="margin-left:10px;" align="left"><span class="tx-12"><b>Bairro: </b><?=$pedido->bairro_cliente;?></span></p>
    <p style="margin-left:10px;" align="left"><span class="tx-12"><b>Complemento: </b><?=$pedido->complemento_cliente;?></span></p>
    <?php } ?>
<br>
    <center><strong>PAGAMENTO</strong></center>
    <hr />
    <?php
            function formatCurrency($num) {
                if (preg_match('/' . "," . '/', $num)) {
                    return formatValorMoedaDatabase($num);
                } else {
                    $num = formatMoedaBr($num);
                    return formatValorMoedaDatabase($num);
                }
            }
            function formatValorMoedaDatabase($num) {
                return str_replace(',','.',preg_replace('#[^\d\,]#is','', $num));
            }
            function formatMoedaBr($num) {
                return number_format($num, 2, ',', '.');
            }
    if($pedido->fpagamento == "DINHEIRO"){print $delivery = "<p style=\"margin-left:10px;\" align=\"left\"><span class=\"tx-12\"><b>Dinheiro na Entrega</b></span></p>";}
    if($pedido->fpagamento == "CARTAO" || $pedido->fpagamento == "CARTÃO"){print $delivery = "<p style=\"margin-left:10px;\" align=\"left\"><span class=\"tx-12\"><b>Cartão na Entrega</b></span></p>";}
    if($pedido->fpagamento == "PIX"){print $delivery = "<p style=\"margin-left:10px;\" align=\"left\"><span class=\"tx-12\"><b>Pagamento via PIX</b></span></p>";}
    if($pedido->fpagamento == "MESA"){print $delivery = "<p style=\"margin-left:10px;\" align=\"left\"><span class=\"tx-12\"><b>Na Mesa</b></span></p>";}
    if($pedido->fpagamento == "BALCAO"){print $delivery = "<p style=\"margin-left:10px;\" align=\"left\"><span class=\"tx-12\"><b>No Balcão</b></span></p>";}
    ?>
    <p style="margin-left:10px;" align="left"><span class="tx-12"><b>Subtotal: R$: </b><?=formatMoedaBr(formatCurrency($pedido->vsubtotal))?></span></p>
    <?php if($pedido->vadcionais > 0.00) { ?>
    <p style="margin-left:10px;" align="left"><span class="tx-12"><b>Adicionais: R$: </b><?=formatMoedaBr(formatCurrency($pedido->vadcionais))?></span></p>
    <?php } ?>
    <?php if($pedido->taxa > 0) { ?>
    <p style="margin-left:10px;" align="left"><span class="tx-12"><b>Taxa de Entrega: R$: </b><?=formatMoedaBr(formatCurrency($pedido->taxa))?></span></p>
    <p style="margin-left:10px;" align="left"><span class="tx-12"><b>Total Geral: </b> R$: <?=formatMoedaBr(formatCurrency(($pedido->vtotal)))?></span></p>
    <?php } else { ?>
    <p style="margin-left:10px;" align="left"><span class="tx-12"><b>Total Geral: </b> R$: <?=formatMoedaBr(formatCurrency($pedido->vtotal))?></span></p>
    <?php } ?>
    <?php if($pedido->troco > 0) { ?>
    <p style="margin-left:10px;" align="left"><span class="tx-12"><b>Troco para: R$: </b><?=formatMoedaBr(formatCurrency($pedido->troco))?></span></p>
    <?php $ValorDoTroco = $pedido->troco - $pedido->vtotal?>
    <p style="margin-left:10px;" align="left"><span class="tx-12"><b>Valor do Troco: R$: </b><?=formatMoedaBr(formatCurrency($ValorDoTroco))?></span></p>
    <?php } ?>
    <br>
    <p style="margin-left:10px;" align="right"><span class="tx-11"><b><?=date("d-m-Y H:i:s");?></b></span></p>

</div>
</div>
</div>

<div class="col-md-3">

    <center>
    <a href="#" class="btn btn-info btn-block invoice-print" name="btnprint" onClick="PrintMe2('print2')"><i class="fa fa-print" aria-hidden="true"></i> Cozinha</a>
    </center>

<div class="card card-people-list pd-15 mg-b-10" style="background-color:#fdfbe3">

<div id="print2" style="font-family: Arial;">

    <center><p class="tx-15"><strong>RESUMO DO PEDIDO</strong></p></center>
    <center><p class="tx-12">Comanda Cozinha</p></center>
    <center><p class="tx-12"><?=$pedido->data;?> às <?=$pedido->hora;?></span></p>
    <center><p class="tx-12">Nº <?=$codigop;?></p></center>
    <hr />

    <?php
    while ($carpro2 = $produtoscaxy->fetch(PDO::FETCH_OBJ)) {
    $nomepro2 = $connect->query("SELECT nome FROM produtos WHERE id = '".$carpro2->produto_id."'");
    $nomeprox2 = $nomepro2->fetch(PDO::FETCH_OBJ);
    ?>

    <p style="margin-left:10px;" align="left"><span class="tx-12"><b>** Item:</b> <?php print $nomeprox2->nome;?></span></p>

    <?php if($carpro2->tamanho != "N" ) { ?>

    <p style="margin-left:10px;" align="left"><span class="tx-12"><b>- Tamanho:</b> <?php print $carpro2->tamanho;?></span></p>

    <?php } ?>

    <p style="margin-left:10px;" align="left"><span class="tx-12"><b>- Qnt:</b> <?php print $carpro2->quantidade; ?></span></p>

    <?php if($carpro2->obs) {?>
    <p style="margin-left:10px;" align="left"><span class="tx-12"><b>- Obs:</b> <?php echo $carpro2->obs; ?></span></p>
    <?php } else { ?>
    <p style="margin-left:10px;" align="left"><span class="tx-12"><b>- Obs:</b> Não</span></p>
    <?php } ?>

    <?php
    $meiom2 = $connect->query("SELECT * FROM store_o WHERE idp = '".$carpro2->id."' AND status = '1' AND idu='$cod_id' AND meioameio='1'");
    $meiomc2 = $meiom2->rowCount();
    ?>

    <?php if($meiomc2>0){ ?>
    <p style="margin-left:10px;" align="left"><span class="tx-12"><b>* <?=$meiomc2;?> Sabores:</b></span></p>
    <p style="margin-left:10px;" align="left"><span class="tx-12">
    <?php while ($meiomv2 = $meiom2->fetch(PDO::FETCH_OBJ)) { ?>
    <?=$meiomv2->nome."<br>";?>
    <?php } ?>
    </span></p>
    <?php } ?>

    <?php
    $adcionais2 = $connect->query("SELECT * FROM store_o WHERE idp = '".$carpro2->id."' AND status = '1' AND idu='$cod_id' AND meioameio='0'");
    $adcionaisc2 = $adcionais2->rowCount();
    ?>

    <?php if($adcionaisc2>0){ ?>
    <p style="margin-left:10px;" align="left"><span class="tx-12"><b>* Adicionais/Ingredientes:</b></p>
    <p style="margin-left:10px;" align="left"><span class="tx-12">
    <?php while ($adcionaisv2 = $adcionais2->fetch(PDO::FETCH_OBJ)) { ?>
    <?="- ".$adcionaisv2->nome."<br>";?>
    <?php } ?>
    </span></p>
    <?php } ?>
    <center>=========================</center></p>
    <?php } ?>

    <br>
    <center><strong>DADOS DO CLIENTE</strong></center>
    <hr />
    <p style="margin-left:10px;" align="left"><span class="tx-12"><b>Nome: </b><?=$pedido->nome_cliente;?></span></p>
    <p style="margin-left:10px;" align="left"><span class="tx-12"><b>Celular: </b><?=$pedido->celular_cliente;?></span></p>
    <?php if($pedido->mesa > 0 ){ ?>
    <p style="margin-left:10px;" align="left"><span class="tx-12"><b>Mesa: </b><?=$pedido->mesa;?></span></p>
    <p style="margin-left:10px;" align="left"><span class="tx-12"><b>Pessoa na Mesa: </b><?=$pedido->pessoas;?></span></p>
    <p style="margin-left:10px;" align="left"><span class="tx-12"><b>Obs: </b><?=$pedido->obs;?></span></p>
    <?php } ?>
    <br>
    <p style="margin-left:10px;" align="right"><span class="tx-11"><b><?=date("d-m-Y H:i:s");?></b></span></p>


</div>
</div>
</div>


    </div>
</div>



    <script src="../lib/jquery/js/jquery.js"></script>
       <script src="../lib/datatables/js/jquery.dataTables.js"></script>
    <script src="../lib/datatables-responsive/js/dataTables.responsive.js"></script>
    <script src="../lib/select2/js/select2.min.js"></script>

<script language="javascript">
    function PrintMe(DivID) {
    var disp_setting="toolbar=yes,location=no,";
    disp_setting+="directories=yes,menubar=yes,";
    disp_setting+="scrollbars=yes,width=450, height=600, left=100, top=25";
    var content_vlue = document.getElementById(DivID).innerHTML;
    var docprint=window.open("","",disp_setting);
    docprint.document.open();
    docprint.document.write('<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"');
    docprint.document.write('"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">');
    docprint.document.write('<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">');
    docprint.document.write('<head><title>COMANDA BALCAO</title>');
    docprint.document.write('<style type="text/css">body{ margin:0px;');
    docprint.document.write('font-family:verdana,Arial;color:#000;');
    docprint.document.write('font-family:Verdana, Geneva, sans-serif; font-size:12px;}');
    docprint.document.write('a{color:#000;text-decoration:none;} </style>');
    docprint.document.write('</head><body onLoad="self.print()">');
    docprint.document.write(content_vlue);
    docprint.document.write('</body></html>');
    docprint.document.close();
    docprint.focus();
}
</script>

<script language="javascript">
    function PrintMe2(DivID) {
    var disp_setting="toolbar=yes,location=no,";
    disp_setting+="directories=yes,menubar=yes,";
    disp_setting+="scrollbars=yes,width=450, height=600, left=100, top=25";
    var content_vlue = document.getElementById(DivID).innerHTML;
    var docprint=window.open("","",disp_setting);
    docprint.document.open();
    docprint.document.write('<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"');
    docprint.document.write('"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">');
    docprint.document.write('<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">');
    docprint.document.write('<head><title>COMANDA MESA</title>');
    docprint.document.write('<style type="text/css">body{ margin:0px;');
    docprint.document.write('font-family:verdana,Arial;color:#000;');
    docprint.document.write('font-family:Verdana, Geneva, sans-serif; font-size:12px;}');
    docprint.document.write('a{color:#000;text-decoration:none;} </style>');
    docprint.document.write('</head><body onLoad="self.print()"><center>');
    docprint.document.write(content_vlue);
    docprint.document.write('</center></body></html>');
    docprint.document.close();
    docprint.focus();
}
</script>
<script type="text/javascript">
function enviarMensagem(){
    var celular = document.querySelector("#celular").value;
    celular = celular.replace(/\D/g,'');
      if(celular.length < 13){
        celular = "55" + celular;
      }
      var texto = document.querySelector("#mensagem").value;
      texto = window.encodeURIComponent(texto);
      window.open("https://api.whatsapp.com/send?phone=" + celular + "&text=" + texto, "_blank");
}
</script>
<script type="text/javascript">
function enviarMensagem2(){
    var celular = document.querySelector("#celular2").value;
    celular = celular.replace(/\D/g,'');
      if(celular.length < 13){
        celular = "55" + celular;
      }
      var texto = document.querySelector("#mensagem2").value;
      texto = window.encodeURIComponent(texto);
      window.open("https://api.whatsapp.com/send?phone=" + celular + "&text=" + texto, "_blank");
}
</script>
<script type="text/javascript">
function enviarMensagem3(){if($pedido->fpagamento == "DINHEIRO")
    var celular = document.querySelector("#celular3").value;
    celular = celular.replace(/\D/g,'');
      if(celular.length < 13){
        celular = "55" + celular;
      }
      var texto = document.querySelector("#mensagem3").value;
      texto = window.encodeURIComponent(texto);
      window.open("https://api.whatsapp.com/send?phone=" + celular + "&text=" + texto, "_blank");
}
</script>
<script type="text/javascript">
function enviarMensagem4(){
    var celular = document.querySelector("#celular4").value;
    celular = celular.replace(/\D/g,'');
      if(celular.length < 13){
        celular = "55" + celular;
      }
      var texto = document.querySelector("#mensagem4").value;
      texto = window.encodeURIComponent(texto);
      window.open("https://api.whatsapp.com/send?phone=" + celular + "&text=" + texto, "_blank");
}
</script>
<script type="text/javascript">
function enviarMensagem5(){
    var celular = document.querySelector("#celular5").value;
    celular = celular.replace(/\D/g,'');
      if(celular.length < 13){
        celular = "55" + celular;
      }
      var texto = document.querySelector("#mensagem5").value;
      texto = window.encodeURIComponent(texto);
      window.open("https://api.whatsapp.com/send?phone=" + celular + "&text=" + texto, "_blank");
}
</script>
    </body>
</html>