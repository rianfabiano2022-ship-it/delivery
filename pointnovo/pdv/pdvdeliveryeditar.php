<?php
//ob_start();
session_start();
if(isset($_COOKIE['pdvx'])){
$idu = $_COOKIE['pdvx'];
} else {
header("location: sair.php"); 
}
include_once('../../funcoes/Conexao.php');
include_once('../../funcoes/Key.php');

//$_GET['idpedido'] = preg_replace("/[^0-9]/", "", $_GET['idpedido']);
$_SESSION["id_cliente"] = $_GET['idpedido'];

$id_cliente     = $_SESSION['id_cliente'];
$tipo_pedido     = $_GET['tipo'];

$empresa 		= $connect->query("SELECT * FROM config WHERE id='$idu'"); 
$dadosempresa 	= $empresa->fetch(PDO::FETCH_OBJ);

$categorias 	= $connect->query("SELECT * FROM categorias WHERE idu='$idu' ORDER BY posicao ASC");

$produtosca 	= $connect->query("SELECT * FROM store WHERE idsecao = '$id_cliente' AND status='1' AND idu='$idu' ORDER BY id DESC");
$produtoscx 	= $produtosca->rowCount();

if($produtoscx>0){
$somando 	= $connect->query("SELECT valor, SUM(valor * quantidade) AS soma FROM store WHERE idsecao='".$id_cliente."' and status='1' and idu='$idu'");
$somando 	= $somando->fetch(PDO::FETCH_OBJ);
$somandop 	= $connect->query("SELECT quantidade, SUM(quantidade) AS somap FROM store WHERE idsecao='".$id_cliente."' and status='1' and idu='$idu'");
$somandop 	= $somandop->fetch(PDO::FETCH_OBJ);
} 

//

if(isset($_POST["pedidodelivery"])){
$nome 			= $_POST['nome'];
$wps  			= $_POST['wps'];

if(empty($_POST['fmpgto'])){ header("javascript:history.back()"); }
$fmpgto  		= $_POST['fmpgto'];
if(empty($_POST['troco'])){
$troco  		= '0.00';
} else {
$troco  		= $_POST['troco'];
}
if(empty($_POST['complemento'])){
$complemento	= "Não";
} else {
$complemento	= $_POST['complemento'];
}
$troco    		= str_replace(",", ".", $troco);
$cidade  		= $_POST['cidade'];
$uf  			= $_POST['uf'];
$numero  		= $_POST['numero'];
$bairro  		= $_POST['bairro'];
$rua  			= $_POST['rua'];
$taxa  			= $_POST['taxa'];
$numero  		= $_POST['numero'];
$subtotal 		= $_POST['subtotal'];
$adcionais  	= $_POST['adcionais'];
$totalg  		= $_POST['totalg'];
$data			= date("d-m-Y");
$hora			= date("H:i:s");
$editarcor 		= $connect->query("UPDATE pedidos SET fpagamento='$fmpgto', cidade='$cidade', numero='$numero', complemento='complemento', rua='$rua', bairro='$bairro', troco='$troco', nome='$nome', celular='$wps', taxa='$taxa', vsubtotal='$subtotal', vadcionais='$adcionais', vtotal='$totalg' WHERE idpedido='$id_cliente'");
if ( $editarcor ) {
header("location: pdv.php"); 
exit;
}
}


?>

<!DOCTYPE html>
<html lang="pt-br">
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
			   Novo Pedido n° <?=$id_cliente;?>
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
	   
	   <div class="col-md-9">
	   		
			<div class="card card-people-list pd-15 mg-b-10">
				
					<div class="media-list">
					
					    <div class="row" style="margin-top:-30px">
							<div class="col-lg-12">
							<div class="slim-card-title"><i class="fa fa-caret-right"></i> DADOS DO CLIENTE</div>
							</div>
					    </div>
						 <br>
						<form action="" method="post">
						<input type="hidden" name="pedidodelivery">
						<input type="hidden" name="cidade" value="<?php echo $dadosempresa->cidade;?>">
						<input type="hidden" name="uf" value="<?php echo $dadosempresa->uf;?>">
						
						<?php 
						$dadospedido 	= $connect->query("SELECT * FROM pedidos WHERE idpedido='$id_cliente'"); 
						$dadospedido 	= $dadospedido->fetch(PDO::FETCH_OBJ);
						?>
						
						<?php if($somando->soma > $dadosempresa->dfree ) { ?>
						<div class="row mg-b-10">
						    <div align="center" class="col-lg-12">
    						    <div class="alert alert-success" role="alert">
                                    <strong class="tx-success"><i class="fa fa-thumbs-o-up mg-r-5"></i> Entrega Grátis.</strong>
                                </div>
						    </div>
						</div>
						<?php } ?>
						
						
						<div class="row">
							
							
							<div class="col-lg-6">
								<div class="form-group">
								<label class="form-control-label">Bairros e Regiões atendidas : <span class="tx-danger">*</span></label>
								<select id="select-taxa" class="form-control selec2">
								
								<?php if($somando->soma > $dadosempresa->dfree ) { ?>
								<option value="">Selecione</option>								
								<?php
								$lerbanco  = $connect->query("SELECT * FROM bairros WHERE idu='".$idu."'");
								while ($taxabairro = $lerbanco->fetch(PDO::FETCH_OBJ)) { 
								?>
								<option value="pdvdeliveryeditar.php?idpedido=<?=$id_cliente;?>&tipo=delivery&bairro=<?=$taxabairro->id;?>"><?php echo $taxabairro->bairro;?></option> 
								<?php } ?>
								<?php } else { ?>
								<option value="">Selecione</option>								
								<?php
								$lerbanco  = $connect->query("SELECT * FROM bairros WHERE idu='".$idu."'");
								while ($taxabairro = $lerbanco->fetch(PDO::FETCH_OBJ)) { 
								?>
								<option value="pdvdeliveryeditar.php?idpedido=<?=$id_cliente;?>&tipo=delivery&bairro=<?=$taxabairro->id;?>">Taxa de R$: <?php echo $taxabairro->taxa;?></span> - <?php echo $taxabairro->bairro;?></option> 
								<?php } ?>
								<?php } ?>
								</select>
								</div>
							</div>
							
							
							
							
							
							<div class="col-lg-4">
								<div class="form-group">
									<label class="form-control-label">Bairro ou Região: </label>
									<div class="input-group">
									<?php if(isset($_GET["bairro"])){ $idbairro = $_GET["bairro"];
									$pegabairro = $connect->query("SELECT * FROM bairros WHERE id='".$idbairro."'");
									$pegabairro	= $pegabairro->fetch(PDO::FETCH_OBJ); ?>
									<input type="text" class="form-control" value="<?=$pegabairro->bairro;?>" disabled="disabled">
									<input  type="hidden" name="bairro" value="<?=$pegabairro->bairro;?>">
									<?php } else { ?>
									<input type="text" class="form-control" value="<?=$dadospedido->bairro;?>" disabled="disabled">
									<input  type="hidden" name="bairro" value="<?=$dadospedido->bairro;?>">
									<?php } ?>
									</div>
								</div>
							</div>
							
							<div class="col-lg-2">
								<div class="form-group">
									<label class="form-control-label">Taxa: </label>
									<div class="input-group">
									<?php  if(isset($_GET["bairro"])){ $idbairro2 = $_GET["bairro"];
									$pegataxa = $connect->query("SELECT * FROM bairros WHERE id='".$idbairro."'");
									$pegataxa	= $pegataxa->fetch(PDO::FETCH_OBJ); ?>
									<?php if($somando->soma > $dadosempresa->dfree ) { ?>
									<input type="text" class="form-control" value="0.00" disabled="disabled">
									<input  type="hidden" name="taxa" value="0.00">
									<?php $taxa = "0.00"; ?>
									<?php } else { ?>
									<input type="text" class="form-control" value="<?=$pegataxa->taxa;?>" disabled="disabled">
									<input  type="hidden" name="taxa" value="<?=$pegataxa->taxa;?>">
									<?php $taxa = $pegataxa->taxa;?>
									<?php } ?>
									<?php } else { ?>
									<?php $taxa = $dadospedido->taxa; ?>
									<input type="text" class="form-control" value="<?=$taxa;?>" disabled="disabled">
									<input  type="hidden" name="taxa" value="<?=$taxa;?>">
									<?php } ?>

									</div>
								</div>
							</div>
							
							
							
							
							
							
							
							
							
							
							
						</div>
						
						
						
						<div class="row">
							
							<div class="col-lg-9">
								<div class="form-group">
									<label class="form-control-label">Endereço: <span class="tx-danger">*</span></label>
									<div class="input-group">
									<input class="form-control" type="text" name="rua" maxlength="100" value="<?=$dadospedido->rua;?>" required>
									</div>
								</div>
							</div>
							<div class="col-lg-3">
								<div class="form-group">
									<label class="form-control-label">Número: <span class="tx-danger">*</span></label>
									<div class="input-group">
									<input type="text" class="form-control" name="numero" value="<?=$dadospedido->numero;?>" maxlength="5" required>	
								 	</div>
								</div>
							</div>
							
						</div>
						
						<div class="row">
						
							<div class="col-lg-6">
								<div class="form-group">
									<label class="form-control-label">Complemento: </label>
									<input class="form-control" type="text" name="complemento" value="<?=$dadospedido->complemento;?>" maxlength="160">
								</div>
							</div>
						
							<div class="col-lg-3">
								<div class="form-group">
									<label class="form-control-label">Nº do seu WhatsApp: <span class="tx-danger">*</span></label>
									<input type="text" placeholder="DDD+Número" maxlength="11" name="wps" class="form-control" value="<?=$dadospedido->celular;?>" required>
								</div>
							</div>
							
							<div class="col-lg-3">
								<div class="form-group">
									<label class="form-control-label">Primeiro Nome: <span class="tx-danger">*</span></label>
									<input type="text" name="nome" class="form-control" maxlength="60" value="<?=$dadospedido->nome;?>" required>
								</div>
							</div>
							
						</div>
						
						<hr>
						
						<div class="row">
						
							<div class="col-lg-6">
								<div class="form-group">
								<label class="form-control-label">Forma de Pagamento: <span class="tx-danger">*</span></label>
								<select id="options" class="form-control" onChange="verifica(this.value)" name="fmpgto" required>
								<option value="<?=$dadospedido->fpagamento;?>" selected><b><?=$dadospedido->fpagamento;?></b></option>
								<option value="DINHEIRO">Dinheiro</option>
								<option value="CARTAO">Cartão</option>
								</select>
								</div>
							</div>
							
							<div class="col-lg-6">
								<div class="form-group">
									<label class="form-control-label">Precisa de Troco?: </label>
									<input type="text" name="troco" id="troco" value="<?=$dadospedido->troco;?>" class="dinheiro form-control">
								</div>
							</div>
							
						</div> 
						
						<hr>
						
						

					</div>
				</div>
	   		</div>
	    
	   <div class="col-md-3 d-none d-lg-block">
	   		<?php include('carrinho_fim.php'); ?>
	   </div>
	   
	  	   
	   
	</div>	   
</div>

	<script src="../lib/jquery/js/jquery.js"></script>  
    <script src="../lib/bootstrap/js/bootstrap.js"></script>
	<script src="../js/moeda.js"></script>
	<script>
		  function verifica(value){
			var input = document.getElementById("troco");
	
		  if(value == 'DINHEIRO'){
			input.disabled = false;
		  }else if(value == 'CARTAO'){
			input.disabled = true;
		}
	};
	</script> 
	
	<script>
	$('#select-taxa').change(function() {
		window.location = $(this).val();
	});
	</script>
	
	<script>
	$('.dinheiro').mask('#.##0,00', {reverse: true});
	</script>
  </body>
</html>