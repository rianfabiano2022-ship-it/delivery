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
		  
		 
		  <?php if(!$produtoscx){ ?>
				<li class="nav-item">
				<a class="nav-link" href="#">
					<i class="fa fa-shopping-basket tx-20 tx-danger"></i>
				</a>	
				</li>
				
				 
					<?php } ?>
					<?php if($produtoscx){ ?>
					
					<li class="nav-item">
					<a class="nav-link" href="pedido">
					<i class="fa fa-shopping-bag tx-20 tx-danger mg-r-10"></i>
					<?php print $somandop->somap;?> un
					</a>	
					</li>
					
					<li class="nav-item">
					<a class="nav-link" href="pedido.php">
					<button type="submit" class="btn btn-primary btn-block" name="cart">Ver pedido <i class="fa fa-arrow-right mg-l-5"></i></button>
					</li>
					</a>	
				
			<?php } ?>
			
		  
		</ul>
	</div> 
</div> 

<div class="slim-mainpanel">
    <div class="container">
	  
	   <div class="row mg-t-10">
	   
	   <div class="col-md-3">
	   			
				<div id="accordion" class="accordion-one mg-b-10" role="tablist" aria-multiselectable="true">
				<div class="card">
					  <div class="card-header" role="tab" id="headingOne">
                			<a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne" class="tx-gray-800 transition" style="color:#000000">
						  	<i class="fa fa-bars mg-r-10"></i> MENU
							</a>
					  </div>
              		<div id="collapseOne" class="collapse show" role="tabpanel" aria-labelledby="headingOne">
						<div class="card-body">
							  <div class="card-people-list pd-5">	
								  <div class="media-list" style="margin-top:-10px">
									<?php
									if(isset($_GET["up"])){ echo unlink("".$_GET["up"].""); } 
									while ($cathomem = $categoriasm->fetch(PDO::FETCH_OBJ)) { 
									$qntpx = $connect->query("SELECT id FROM produtos WHERE categoria = '".$cathomem->id."' AND status='1'");
									$qntpx = $qntpx->rowCount();
									?>	
									<div class="media">
									<a href="#<?php echo $cathomem->id;?>">
									<img src="../img/categoria/<?php if(!$cathomem->url){echo "off.jpg";}else{ print $cathomem->url;}?>" style="width:30px; height:30px; border-radius: 100%;" alt="">
									</a>
									<div class="media-body">
									<a href="#<?php echo $cathomem->id;?>" style="color:#000000"><?php print $cathomem->nome;?> (<?php print $qntpx;?>)</a>
									</div>
									<a href="#<?php echo $cathomem->id;?>" style="color:#000000"><i class="fa fa-chevron-circle-right"></i></a>
									</div>
									<?php } ?>
								 </div>
							 </div>
						</div>
					  </div>
				   </div>
				</div>
			
	   </div>
	   
<div class="col-md-9">
			 
<?php 
$buscacategorias 	= $connect->query("SELECT * FROM categorias WHERE idu='$idu' ORDER BY posicao ASC");
while ($exibircategoria = $buscacategorias->fetch(PDO::FETCH_OBJ)) { 
?>	
 
			<div class="card card-people-list pd-15 mg-b-10" id="<?php echo $exibircategoria->id;?>">
				<div class="slim-card-title"><i class="fa fa-caret-right"></i> <?php print $exibircategoria->nome; ?></div>
					<div class="media-list">
						
						<?php 
						$buscaprodutos = $connect->query("SELECT * FROM produtos WHERE categoria = '".$exibircategoria->id."' AND (visivel='G' OR visivel='$dataatual') AND status='1'");
						while ($exibirlista = $buscaprodutos->fetch(PDO::FETCH_OBJ)) { 
						?>
						
						<div class="media">
						<a href="#" class="view_data" id="<?php echo $exibirlista->id; ?>">
	      				<img src="../img/fotos_produtos/<?php if(!$exibirlista->foto){echo "off.jpg";}else{ print $exibirlista->foto;}?>" style="width:80px; height:65px;" class="img-thumbnail"></a>
						
						
						<div class="media-body">
						<a href="#" class="view_data" id="<?php echo $exibirlista->id; ?>" style="color:#666666"> 
						<span class="tx-15"><strong><?php print $exibirlista->nome;?></strong></span>
						<?php if($exibirlista->ingredientes != "N"){?>
						<p class="tx-12 mg-r-5"><?php print $exibirlista->ingredientes;?></p>
						<?php } ?>
						<p class="tx-14"><strong ><?php if($exibirlista->valor > "0.00") { ?>
						<?php print "<strong>R$:</strong> ".number_format($exibirlista->valor, 2, ',', '.');}?></strong></p>
						</div>
						</a>
						 
						
						<?php if($exibirlista->valor > "0.00") { ?>
						<div align="left"><button type="button" class="btn btn-success btn-sm view_data" id="<?php echo $exibirlista->id; ?>">
						<i class="fa fa-cart-plus mg-r-5"></i> Incluir</button>
						</div>
						<?php } else { ?>
						<div align="left"><button type="button" class="btn btn-info btn-sm view_data" id="<?php echo $exibirlista->id; ?>">
						<i class="fa fa-plus-circle mg-r-5"></i>Opções</button>
						</div>
						<?php } ?>
						
						 
						 
						
						
						</div>
						<?php } ?>
					</div>
			</div>
			 <?php }  ?>


</div>
	   
	   
	   
	   
	   
	    
	   
	   
	  	   
	    
	   
</div>


		<div id="visulUsuarioModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h6 class="modal-title" id="visulUsuarioModalLabel">Detalhes do Produto</h6>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						  <span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<span id="visul_usuario"></span>
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