<?php
include_once('header.php');
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="utf-8">
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
            <a class="nav-link" href="./">
              <i class="fa fa-home tx-20"></i>
              <span class="mg-l-10">INICIAL</span>
            </a>
          </li>
		</ul>
	</div> 
</div> 

<div class="slim-mainpanel">
      <div class="container">
	  
	   <div class="row mg-t-10">
	   
	   <div class="col-md-6">
	   
	   			<?php if(isset($_GET["ok"])){?>
				<div class="alert alert-danger" role="alert">
            	<i class="fa fa-times" aria-hidden="true"></i> Produto excluído do pedido.
          		</div>
				<meta http-equiv="refresh" content="2;URL=./pedido" />
				<?php }?>
	   			
				<div id="accordion" class="accordion-one sticky-top mg-b-10" role="tablist" aria-multiselectable="true">
					<div class="card">
					  <div class="card-header" role="tab" id="headingTwo">
						<a class="collapsed tx-gray-800 transition" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
						  <i class="fa fa-bars mg-r-10"></i> ACRESCENTAR MAIS ÍTENS
						</a>
					  </div>
					  <div id="collapseTwo" class="collapse" role="tabpanel" aria-labelledby="headingTwo">
						<div class="card-body">
							  <div class="card-people-list pd-5">	
								  <div class="media-list" style="margin-top:-10px">
									<?php 
									while ($cathomem = $categoriasm->fetch(PDO::FETCH_OBJ)) { 
									$qntpx = $connect->query("SELECT id FROM produtos WHERE categoria = '".$cathomem->id."' AND status='1'");
									$qntpx = $qntpx->rowCount();
									?>	
									<div class="media">
									<a href="menu.php#<?php echo $cathomem->id;?>">
									<img src="../img/categoria/<?php if(!$cathomem->url){echo "off.jpg";}else{ print $cathomem->url;}?>" style="width:30px; height:30px; border-radius: 100%;" alt="">
									</a>
									<div class="media-body">
									<a href="menu.php#<?php echo $cathomem->id;?>" style="color:#000000"><?php print $cathomem->nome;?> (<?php print $qntpx;?>)</a>
									</div>
									<a href="menu.php#<?php echo $cathomem->id;?>" style="color:#000000"><i class="fa fa-chevron-circle-right"></i></a>
									</div>
									<?php } ?>	
								 </div>
							 </div>
						</div>
					  </div>
				   </div>
				</div>
			
	   </div>
	   
	   
	   
	   <div class="col-md-6">
	   <?php if($produtoscx>0){ ?>
	   <div class="card card-people-list pd-15 mg-b-10" style="background-color:<?php print $dadosempresa->corcarrinho; ?>">
				<div class="slim-card-title tx-14"><i class="fa fa-caret-right"></i> SEU PEDIDO</div>
						
						<div align="center"><span class="tx-12">Comanda nº <?php print $id_mesa; ?></span></div>
						<hr />
						<div class="media-list" style="margin-top:-1px;">
						<?php 
						while ($carpro = $produtosca->fetch(PDO::FETCH_OBJ)) { 
						$nomepro  = $connect->query("SELECT nome FROM produtos WHERE id = '".$carpro->produto_id."' AND idu='$idu'");
						$nomeprox = $nomepro->fetch(PDO::FETCH_OBJ);
						?>
						
					  <div id="accordion<?php print $carpro->id;?>" class="accordion-one mg-b-10 " role="tablist" aria-multiselectable="true">
					  <div>
					  <div role="tab" id="headingTwo">
					  <a class="collapsed tx-gray-800 transition" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo<?php print $carpro->id;?>" aria-expanded="false" aria-controls="collapseTwo"><span class="tx-14"><i class="fa fa-cutlery mg-r-5"></i> <?php print $nomeprox->nome;?> <i class="fa fa-angle-down mg-l-5"></i></span></a>
					  </div>
					  <div id="collapseTwo<?php print $carpro->id;?>" class="collapse" role="tabpanel" aria-labelledby="headingTwo">
					  <div>
					  <hr />
						
						
						
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
						$meiom  = $connect->query("SELECT * FROM store_o WHERE idp = '".$carpro->idpedido."' AND status = '0' AND idu='$idu' AND meioameio='1'"); 
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
						$adcionais  = $connect->query("SELECT * FROM store_o WHERE idp = '".$carpro->idpedido."' AND status = '0' AND idu='$idu' AND meioameio='0'"); 
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
						<div align="right">
						<a href="pedido.php?apagaritem=<?php print $carpro->idpedido;?>&idce=<?=$id_cliente;?>" style="color:#CC0000"><i class="fa fa-minus-square mg-r-5 tx-danger tx-9"></i><span class="tx-12">Excluir</span></a>
						</div>
						<hr>
						
						
						</div>
					  </div>
				   </div>
				</div>
						
						<hr>
						<?php } ?>
						
						<div class="row">
							 <div class="col-6 tx-17">SubTotal</div>
							 <div class="col-6 tx-17">R$: <?php if(isset($somando->soma)){ echo number_format($somando->soma, 2, ',', ' '); } else { print "0,00";} ?></div>
						</div>
					 
						<div class="row mg-t-10">
							 <div class="col-6 tx-17">Adicionais</div>
							 <div class="col-6 tx-17">R$: 
							<?php
							$opcionais  = $connect->query("SELECT valor, quantidade FROM store_o WHERE ids = '".$id_mesa."' AND status = '0' AND idu='$idu' AND meioameio='0'");
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
					 
						 <div class="row mg-t-10">
							 <div class="col-6 tx-18"><strong>Total Parcial</strong></div>
							 <div class="col-6 tx-18"><strong>R$: <?php if(isset($somando->soma)){$geral = $somando->soma + $sumx; echo $gx = number_format($geral, 2, ',', '.');} else { print "0,00";} ?></strong>
						</div>
						</div>
					 	<hr>
						
						</div>
						 
						<div class="tx-12">
						<form action="" method="post">
						<input type="hidden" name="mesapedido" value="ok">
						<input type="hidden" name="idloja" value="<?=$id_mesa;?>">
						<input type="hidden" name="pnome" value="<?php print $_COOKIE['nomeM']; ?>">
						<input type="hidden" name="mesa" value="<?php print $_COOKIE['mesaM']; ?>">
						<input type="hidden" name="ppessoas" value="<?php print $_COOKIE['pessoasM']; ?>">
						<input type="hidden" name="pcelular" value="<?php print $_COOKIE['celularM']; ?>">
						<input type="hidden" name="subtotal" class="form-control" value="<?=$somando->soma;?>">
						<input type="hidden" name="adcionais" class="form-control" value="<?=$sumx;?>">
						<input type="hidden" name="totalg" class="form-control" value="<?=$geral; ?>">
						<button type="submit" class="btn btn-success btn-block mg-b-10">ENVIAR PEDIDO</button>
						</form>
						
						
						<span>Até o fechamento de sua comanda o valor do pedido poderá sofrer alteração caso haja pedidos adicionais.</span>
					     
					    </div>
						
						
					     
						 
						
						 
						 
						 </div>
						  
			</div>
			</div>		
			
			<?php } else { ?>			
			<div class="alert alert-danger" role="alert">
            <i class="fa fa-times" aria-hidden="true"></i> Você não possui nenhum pedido.
          	</div>
			<meta http-equiv="refresh" content="3;URL=./" />			
			<?php } ?>	
			
			
			
			
			
			
			
			
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
<script>
      $(function(){
        'use strict';
		
		// Input Masks
        $('#cel').mask('(99)99999-9999');
				
		// Input Masks
        $('#numb').mask('9999');
		
      });
</script>
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
      $(document).on('click', '.number-spinner button', function () {    
	var btn = $(this),
		oldValue = btn.closest('.number-spinner').find('input').val().trim(),
		newVal = 0;
	
	if (btn.attr('data-dir') == 'up') {
		newVal = parseInt(oldValue) + 1;
	} else {
		if (oldValue > 1) {
			newVal = parseInt(oldValue) - 1;
		} else {
			newVal = 1;
		}
	}
	btn.closest('.number-spinner').find('input').val(newVal);
});
</script>
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
<script>
      $(document).ready(function(){
    $(window).scroll(function(){
        if ($(this).scrollTop() > 100) {
            $('a[href="#top"]').fadeIn();
        } else {
            $('a[href="#top"]').fadeOut();
        }
    });

    $('a[href="#top"]').click(function(){
        $('html, body').animate({scrollTop : 0},800);
        return false;
    });
});
</script>
<script>

			$(document).ready(function(){
				$(document).on('click','.view_data', function(){
					var user_id = $(this).attr("id");
					//alert(user_id);
					//Verificar se há valor na variável "user_id".
					if(user_id !== ''){
						var dados = {
							user_id: user_id
						};
						$.post('ajax/produtom.php', dados, function(retorna){
							//Carregar o conteúdo para o usuário
							$("#visul_usuario").html(retorna);
							$('#visulUsuarioModal').modal('show'); 
						});
					}
				});
			});
			
		</script>
<script>
	$('.dinheiro').mask('#.##0,00', {reverse: true});
	</script>
<script>
	$('#select-taxa').change(function() {
		window.location = $(this).val();
	});
	</script>
  </body>
</html>
<?php
ob_end_flush();
?>