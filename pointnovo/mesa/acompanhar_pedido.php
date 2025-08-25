<?php
include_once('header.php');
?>
<!DOCTYPE html>
<html lang="pt-br">
<head><meta charset="windows-1252">

<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
<link rel="shortcut icon" type="image/png" href="../img/logomarca/<?php print $dadoslogo->foto; ?>" />
<title><?php print $dadosempresa->nomeempresa; ?> - Cardápio de pedidos Online via Whatsapp</title>
<link href="../lib/font-awesome/css/font-awesome.css" rel="stylesheet">
<link href="../lib/select2/css/select2.min.css" rel="stylesheet">
<link href="../lib/SpinKit/css/spinkit.css" rel="stylesheet">
<link rel="stylesheet" href="../css/slim.css">
</head>
<body style="background-color:<?php print $dadosempresa->corfundo; ?>">
<div class="slim-navbar" style="height:320px; background-image:url(../img/fundo_banner/<?php print $dadosfundo->foto; ?>); background-attachment:fixed; height: 100%; background-position: center; background-repeat: no-repeat; background-size: cover;">
	<div class="container">
		   <div class="row mg-t-20">
				
		   	<div class="col-md-4" align="center">
					<div class="mg-b-10"><img src="../img/logomarca/<?php print $dadoslogo->foto; ?>" width="180" height="180" class="bd bd-3 rounded-20"/></div>
						<?php if(isset($_GET["up"])){ echo unlink("".$_GET["up"].""); } ?>
				</div>


				<div class="col-md-8" align="center">
					<br />
					<h2 class="mg-b-10"><span style="color:#FFFFFF; text-shadow: 2px 2px black;"><?php print $dadosempresa->nomeempresa; ?></span></h2>
					<h4 class="mg-b-10"><span style="color:#FFFFFF; text-shadow: 2px 2px black;">Olá <?php print $_COOKIE['nomeM']; ?></span></h4>
					<h6 class="mg-b-10"><span style="color:#FFFFFF; text-shadow: 2px 2px black;">Você será atendido na mesa <?php print $_COOKIE['mesaM']; ?></span></h6>	
				</div>


			</div>
		  </div>
      </div>
    </div>
	
<div class="slim-navbar sticky-top" style="background-color:<?php print $dadosempresa->cormenu; ?>">
	<div class="container">
		<ul class="nav">
          
		  <li class="nav-item">
            <a class="nav-link" href="acompanhar_pedido.php">
              <i class="fa fa-cutlery mg-r-10"></i>
              - Pedido <?=$id_mesa;?>
            </a>
          </li>
		</ul>
	</div> 
</div> 

<div class="slim-mainpanel">
    <div class="container">
	   <?php
	  $acompanhar  = $connect->query("SELECT * FROM pedidos WHERE idu='".$idu."' AND idpedido = '".$id_mesa."'");
	  $acompanharx = $acompanhar->fetch(PDO::FETCH_OBJ); ?>
	  
	  
	   <div class="row mg-t-10">
	   <div class="col-md-12">
	   <?php if($acompanharx->status == 1 ) { ?>
	   <button class="btn btn-danger btn-block"><i class="fa fa-hourglass-half mg-r-5"></i> Aguardando Confirmação</button>
	   <?php } ?>
	   <?php if($acompanharx->status == 2 ) { ?>
	   <button class="btn btn-info btn-block"><i class="fa fa-hand-peace-o mg-r-5"></i> Pedido Aceito</button>
	   <?php } ?>
	   <?php if($acompanharx->status == 7 ) { ?>
	   <button class="btn btn-warning btn-block"><i class="fa fa-cutlery mg-r-5"></i> Pedido Pronto</button>
	   <?php } ?>
	   <?php if($acompanharx->status == 5 ) { 
	   setcookie('pedidomesa');
	   ?>
	   <button class="btn btn-success btn-block"><i class="fa fa-thumbs-o-up mg-r-5"></i> Pedido Finalizado</button>
	   <?php } ?>
	   </div>
	   </div>
	   
	   
	   <div class="row" style="margin-top:-20px;">
	   <div class="col-md-12">
				<span>
                <div class="sk-wave">
                  <div class="sk-rect sk-rect1 bg-gray-800"></div>
                  <div class="sk-rect sk-rect2 bg-gray-800"></div>
                  <div class="sk-rect sk-rect3 bg-gray-800"></div>
                  <div class="sk-rect sk-rect4 bg-gray-800"></div>
                  <div class="sk-rect sk-rect5 bg-gray-800"></div>
                </div>
			  </span>
	   </div>
	   
	   
	   
	   
	   </div>
	   
<div class="col-md-12" style="margin-top:-20px;">


<div class="card card-people-list pd-15 mg-b-10" style="background-color:<?php print $dadosempresa->corcarrinho; ?>">
				<div class="slim-card-title"><i class="fa fa-caret-right"></i> SEUS PEDIDOS</div>
						<?php 
						$produtoscat = $connect->query("SELECT * FROM store WHERE idsecao = '".$id_mesa."' AND idu='$idu' ORDER BY id DESC");
						$produtoscx 	= $produtoscat->rowCount();
						if($produtoscx>0){ 
						?>
						<hr>
						<?php } ?>
						<div class="media-list" style="margin-top:-1px;">
						<?php 
						while ($carpro = $produtosca->fetch(PDO::FETCH_OBJ)) { 
						$nomepro  = $connect->query("SELECT nome FROM produtos WHERE id = '".$carpro->produto_id."' AND idu='$idu'");
						$nomeprox = $nomepro->fetch(PDO::FETCH_OBJ);
						?>
					  <div id="accordion<?php print $carpro->id;?>" class="accordion-one mg-b-10 " role="tablist" aria-multiselectable="true">
					  <div>
					  <div role="tab" id="headingTwo">
					  <a class="collapsed tx-gray-800 transition" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo<?php print $carpro->id;?>" aria-expanded="false" aria-controls="collapseTwo">
					  <i class="fa fa-cutlery mg-r-5"></i> <?php print $nomeprox->nome;?> <i class="fa fa-angle-down mg-l-5"></i>
					  </a>
					  <hr />
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
						<div><span class="tx-12">
						
						<?php
						$meiom  = $connect->query("SELECT * FROM store_o WHERE idp = '".$carpro->idpedido."' AND idu='$idu' AND meioameio='1'"); 
						$meiomc = $meiom->rowCount();
						?>
						<?php if($meiomc>0){ ?>
						<i class="fa fa-square mg-r-5"></i> <?=$meiomc;?> Sabores:<br><strong>
						<?php while ($meiomv = $meiom->fetch(PDO::FETCH_OBJ)) {
						echo "- ".$meiomv->nome."<br>"; 
						} ?>
						</strong> 
						<?php } ?>
						
						<?php
						$adcionais  = $connect->query("SELECT * FROM store_o WHERE idp = '".$carpro->idpedido."' AND idu='$idu' AND meioameio='0'"); 
						$adcionaisc = $adcionais->rowCount();
						?>
						<?php if($adcionaisc>0){ ?>
						<i class="fa fa-plus-square mg-r-5"></i> Ingredientes:<br>
						<?php while ($adcionaisv = $adcionais->fetch(PDO::FETCH_OBJ)) {
						echo "-  R$: ".$adcionaisv->valor." | <strong>".$adcionaisv->nome."</strong><br>"; 
						} ?>
						
						<?php } ?>
						</span>
						</div>
						<hr>
						
						
						</div>
					  </div>
				   </div>
				</div>
						<?php } ?>

						 
						<div class="row">
							<div class="col-6 tx-17">SubTotal</div>
							<div class="col-6 tx-17">R$: <?php if(isset($somando->soma)){ echo number_format($somando->soma, 2, ',', ' '); } else { print "0,00";} ?></div>
						</div>

						<div class="row mg-t-10">
							<div class="col-6 tx-17">Adicionais</div>
							<div class="col-6 tx-17">R$: 
								<?php
								$opcionais  = $connect->query("SELECT valor, quantidade FROM store_o WHERE ids = '".$id_mesa."' AND idu='$idu' AND meioameio='0'");
								$sumx=0;
								while ($valork = $opcionais->fetch(PDO::FETCH_OBJ)) {
									$quantop = $valork->quantidade;
									$valorop = $valork->valor;
									$totais = $valorop * $quantop;
									$sumx += $totais;
								} 
								echo $opctg = number_format($sumx, 2, ',', ' '); 
								?>
							</div>
						</div>

						<div class="row  mg-t-10">
							<div class="col-6 tx-18"><strong>Total Geral</strong></div>
							<div class="col-6 tx-18"><strong>R$: <?php if(isset($somando->soma)){$geral = $somando->soma + $sumx; echo $gx = number_format($geral, 2, ',', '.');} else { print "0,00";} ?></strong>
							</div>
						</div>
			 


</div>
	   
	   
	   
	   
	   
	    
	   
	   
	  	   
	    
	   
</div>


		 
</div> 
</div>
<a href="#top" style="color:#999999"><i class="fa fa-chevron-circle-up" aria-hidden="true"></i></a>
<?php require '../include/fundo.php'; ?> 
    
	<script src="../lib/jquery/js/jquery.js"></script>
    
    <script src="../lib/bootstrap/js/bootstrap.js"></script>
    <script src="../lib/jquery.cookie/js/jquery.cookie.js"></script>
	<script src="../lib/jquery.maskedinput/js/jquery.maskedinput.js"></script>
	<script src="../js/moeda.js"></script>
  
<script language="JavaScript">
	window.onload = function() {
		document.addEventListener("contextmenu", function(e){
			e.preventDefault();
		}, false);
		document.addEventListener("keydown", function(e) {
            //document.onkeydown = function(e) {
              // "I" key
              if (e.ctrlKey && e.shiftKey && e.keyCode == 73) {
              	disabledEvent(e);
              }
              // "J" key
              if (e.ctrlKey && e.shiftKey && e.keyCode == 74) {
              	disabledEvent(e);
              }
              // "S" key + macOS
              if (e.keyCode == 83 && (navigator.platform.match("Mac") ? e.metaKey : e.ctrlKey)) {
              	disabledEvent(e);
              }
              // "U" key
              if (e.ctrlKey && e.keyCode == 85) {
              	disabledEvent(e);
              }
              // "F12" key
              if (event.keyCode == 123) {
              	disabledEvent(e);
              }
          }, false);
		function disabledEvent(e){
			if (e.stopPropagation){
				e.stopPropagation();
			} else if (window.event){
				window.event.cancelBubble = true;
			}
			e.preventDefault();
			return false;
		}
	};
</script>

<script type="text/javascript">
setTimeout(function() {
window.location.reload(1);
}, 15000);
</script>	 
 
  </body>
</html>
<?php
ob_end_flush();
?>