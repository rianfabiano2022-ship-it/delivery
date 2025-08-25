<?php
session_start();

include_once('../../funcoes/Conexao.php');
include_once('../../funcoes/Key.php');

$id_carrinho_temp = isset($_POST["id_carrinho"]) ? $_POST["id_carrinho"] : session_id();

// Verifica se o ID do usuário (empresa) foi enviado.
if(isset($_POST["user_idx"])){
    $idu = $_POST["user_idx"];

    $empresa = $connect->query("SELECT * FROM config WHERE id='$idu'");
    $dadosempresa = $empresa->fetch(PDO::FETCH_OBJ);

    // Consulta otimizada para buscar todos os itens do carrinho em uma única vez
    $produtosca = $connect->prepare("SELECT * FROM store WHERE idsecao = ? AND status = '0' AND idu = ? ORDER BY id DESC");
    $produtosca->execute([$id_carrinho_temp, $idu]);
    $produtos_carrinho = $produtosca->fetchAll(PDO::FETCH_OBJ);

    $produtoscx = count($produtos_carrinho);
    
    // Calcula as somas a partir dos resultados da consulta
    $soma_total = 0;
    $soma_quantidade = 0;

    foreach ($produtos_carrinho as $produto) {
        $soma_total += ($produto->valor * $produto->quantidade);
        $soma_quantidade += $produto->quantidade;
    }
    
    // Define as variáveis de soma
    $somando = (object) ['soma' => $soma_total];
    $somandop = (object) ['somap' => $soma_quantidade];
} else {
    // Se não houver 'user_idx' no POST, interrompe a execução para evitar erros.
    // Você pode colocar uma mensagem de erro ou um comportamento padrão aqui.
    exit('ID de empresa não fornecido.');
}
?>

<center class="mg-b-5"><span class="tx-14">Como você deseja receber os itens deste pedido?</span></center>
<div class="slim-card-title mg-b-15">
    <?php if($dadosempresa->delivery==1) { ?>
    <a href="./delivery"><button type="button" class="btn btn-success btn-block mg-b-15">No endereço - (Delivery)</button></a>
    <?php } ?>
    <?php if($dadosempresa->balcao==1) { ?>
    <a href="./balcao"><button type="button" class="btn btn-info btn-block mg-b-15">Retirar no Balcão</button></a>
    <?php } ?>
</div>

<?php if($produtoscx > 0){ ?>
    <div class="card card-people-list pd-15" style="background-color:<?php print $dadosempresa->corcarrinho; ?>">
        <div class="media-list">
            <?php 
            foreach ($produtos_carrinho as $carpro) {
                $nomepro = $connect->query("SELECT nome FROM produtos WHERE id = '".$carpro->produto_id."' AND idu='$idu'");
                $nomeprox = $nomepro->fetch(PDO::FETCH_OBJ);
            ?>

            <div id="accordion<?php print $carpro->id;?>" class="accordion-one mg-b-20" role="tablist" aria-multiselectable="true">
                <div>
                    <div role="tab" id="headingTwo">
                        <a class="collapsed tx-gray-800 transition" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo<?php print $carpro->id;?>" aria-expanded="false" aria-controls="collapseTwo"><b>- Item:</b> <?php print $nomeprox->nome;?> <b style="color:#FF0000"><i class="fa fa-angle-down mg-l-5"></i></b></a>
                    </div>
                    <div id="collapseTwo<?php print $carpro->id;?>" class="collapse" role="tabpanel" aria-labelledby="headingTwo">
                        <div>
                            <?php if($carpro->tamanho != "N" ) { ?>
                                <div><span class="tx-12"><i class="fa fa-square tx-8 mg-r-5"></i> Tamanho: <strong><?php print $carpro->tamanho;?></strong></span></div>
                            <?php } ?>
                            <div><span class="tx-12"><i class="fa fa-square tx-8 mg-r-5"></i> Qnt: <strong><?php print $carpro->quantidade; ?></strong></span></div>
                            <div>
                                <span class="tx-12">
                                    <?php echo "<i class=\"fa fa-square tx-8 mg-r-5\"></i> V. Unitário: <strong >R$: ".$carpro->valor."</strong >"; ?>
                                </span>
                            </div>
                            <div>
                                <span class="tx-12">
                                    <?php
                                    $meiom = $connect->query("SELECT * FROM store_o WHERE idp = '".$carpro->id."' AND status = '0' AND idu='$idu' AND meioameio='1'"); 
                                    $meiomc = $meiom->rowCount();
                                    ?>
                                    <?php if($meiomc > 0){ ?>
                                        <i class="fa fa-square mg-r-5"></i> <?=$meiomc;?> Sabores:<br><strong>
                                            <?php while ($meiomv = $meiom->fetch(PDO::FETCH_OBJ)) {
                                                echo "- ".$meiomv->nome."<br>"; 
                                            } ?>
                                        </strong> 
                                    <?php } ?>

                                    <?php
                                    $adcionais = $connect->query("SELECT * FROM store_o WHERE idp = '".$carpro->id."' AND status = '0' AND idu='$idu' AND meioameio='0'"); 
                                    $adcionaisc = $adcionais->rowCount();
                                    ?>
                                    <?php if($adcionaisc>0){ ?>
                                        <i class="fa fa-plus-square mg-r-5"></i> Adicionais/Ingredientes:<br>
                                        <?php while ($adcionaisv = $adcionais->fetch(PDO::FETCH_OBJ)) {
                                            echo "- R$: ".$adcionaisv->valor." | <strong>".$adcionaisv->nome."</strong><br>"; 
                                        } ?>
                                    <?php } ?>
                                </span>
                            </div>
                            <div align="right">
                                <a href="./?retiradop=true&apagaritemp=<?php echo $carpro->id; ?>&idce=<?php echo $id_carrinho_temp;?>" style="color:#CC0000"><i class="fa fa-minus-square mg-r-5 tx-danger tx-9"></i><span class="tx-12">Excluir</span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <?php } ?>
        </div>
        
        <div class="row">
            <div class="col-7">SubTotal</div>
            <div class="col-5">R$: <?php if(isset($somando->soma)){ echo number_format($somando->soma, 2, ',', ' '); } else { print "0,00";} ?></div>
        </div>

        <?php
        $opcionais = $connect->query("SELECT valor, quantidade FROM store_o WHERE ids = '$id_carrinho_temp' AND status = '0' AND idu='$idu' AND meioameio='0'");
        $sumx=0;
        while ($valork = $opcionais->fetch(PDO::FETCH_OBJ)) {
            $quantop = $valork->quantidade;
            $valorop = $valork->valor;
            $totais = $valorop * $quantop;
            $sumx += $totais;
        } 
        $opctg = number_format($sumx, 2, ',', '.'); 
        ?>
        <?php if($opctg > "0,00");{?>
        <div class="row mg-t-10">
            <div class="col-7">Valores Adicionais</div>
            <div class="col-5">R$: <?=$opctg;?></div>
        </div>
        <?php } ?>
        <div class="row  mg-t-10">
            <div class="col-7"><strong>Valor do Pedido</strong></div>
            <div class="col-5"><strong>R$: <?php if(isset($somando->soma)){$geral = $somando->soma + $sumx; echo $gx = number_format($geral, 2, ',', '.');} else { print "0,00";} ?></strong>
            </div>
        </div>
        
        <?php if(isset($geral) && $geral > $dadosempresa->dfree) { ?>
        <hr>
        <div class="alert alert-success" role="alert" style="margin-bottom:-5px">
            <strong class="tx-success"><i class="fa fa-thumbs-o-up mg-r-5"></i> Entrega Grátis.</strong>
        </div>
        <?php } ?>
    </div>
<?php } ?>