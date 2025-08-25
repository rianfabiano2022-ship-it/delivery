<?php 
if(isset($_COOKIE['pdvx'])){
$cod_id = $_COOKIE['pdvx'];
} else {
header("location: sair.php"); 
}
include_once('../../funcoes/Conexao.php');
include_once('../../funcoes/Key.php');


if(isset($_GET["confirmar"]))  {
$update = $connect->query("UPDATE pedidos SET status='7' WHERE id='".$_GET["confirmar"]."'");
header("location: tela.php");  
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
              <i class="icon ion-ios-home-outline"></i>
              <span>RECEBIMENTO DE PEDIDOS</span>
            </a>
          </li>
		  <li class="nav-item">
            <a class="nav-link" href="#">
              <span>
                <div class="sk-wave">
                  <div class="sk-rect sk-rect1 bg-gray-800"></div>
                  <div class="sk-rect sk-rect2 bg-gray-800"></div>
                  <div class="sk-rect sk-rect3 bg-gray-800"></div>
                  <div class="sk-rect sk-rect4 bg-gray-800"></div>
                  <div class="sk-rect sk-rect5 bg-gray-800"></div>
                </div>
			  </span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="sair.php">
              <i class="icon ion-ios-analytics-outline"></i>
              <span>SAIR</span>
            </a>
          </li>
        </ul>
      </div>
    </div>

    <div class="slim-mainpanel">
      <div class="container">
          
          
          <div class="row row-sm mg-t-20">
           
				<?php
				$dia 	 = date("d-m-Y"); 
	            $pedidoss = $connect->query("SELECT * FROM pedidos WHERE idu='".$cod_id."' AND data = '".$dia."' AND status='2' ORDER BY id ASC");
				while ($pedidossx = $pedidoss->fetch(PDO::FETCH_OBJ)) {
				?>
				
				<div class="col-lg-12 mg-b-20">
					<div class="card card-info" style="background-color:#fdfbe3">
						<div class="card-body pd-40">
						    
						  <div class="row">
						      
						       <div class="col-md-2" align="left">
								    <center><span class="tx-18" style="color:#00CC00"><b>PEDIDO</b></span></center>
								    <center><span class="tx-13"><?=$pedidossx->idpedido;?></span></center>
	 
								</div>
								
								<div class="col-md-3" align="left">
                                    <span class="tx-12"><b>Cliente: </b><?=$pedidossx->nome;?></span><br />
	                                <span class="tx-12"><b>Celular: </b><?=$pedidossx->celular;?></span><br />
								</div>

								<div class="col-md-3" align="left">
								    <span class="tx-12"><?=$pedidossx->data;?></span><br />
	                                <span class="tx-12"><?=$pedidossx->hora;?></span><br />
									 
								</div> 
								
								<div class="col-md-4" align="left">
								    
	                                <a href="tela.php?confirmar=<?=$pedidossx->id;?>"><button class="btn btn-success btn-block mg-t-10"> CONFIRMAR PREPARO</button></a>
									 
								</div> 
						        
						        
						  </div>
							
							
						<hr />	
							
							
							<div class="row">
								
								
								<?php
								$produtoscaxy 	= $connect->query("SELECT * FROM store WHERE idsecao = '$pedidossx->idpedido' AND status = '1' ORDER BY id ASC");
                				while ($carpro2 = $produtoscaxy->fetch(PDO::FETCH_OBJ)) { 
                				$nomepro2  = $connect->query("SELECT nome FROM produtos WHERE id = '".$carpro2->produto_id."'");
                				$nomeprox2 = $nomepro2->fetch(PDO::FETCH_OBJ); 
                				?>
				
								<div class="col-md-3" align="left">
									
	<span class="tx-14" style="color:#FF0000"><i class="fa fa-chevron-circle-right" aria-hidden="true"></i> <b>Ítem:</b> <?php print $nomeprox2->nome;?></span><br />
	
	<?php if($carpro2->tamanho != "N" ) { ?>
	
	<span class="tx-12"><b>- Tamanho:</b> <?php print $carpro2->tamanho;?></span><br />
	
	<?php } ?>
	
	<span class="tx-12"><b>- Qnt:</b> <?php print $carpro2->quantidade; ?></span><br />
	
	<?php if($carpro2->obs) {?>
	<span class="tx-12"><b>- Obs:</b> <?php echo $carpro2->obs; ?></span><br />
	<?php } else { ?>
	<span class="tx-12"><b>- Obs:</b> Não</span><br />
	<?php } ?>
	
	<?php
	$meiom2  = $connect->query("SELECT * FROM store_o WHERE idp = '".$carpro2->idpedido."' AND status = '1' AND idu='$cod_id' AND meioameio='1'"); 
	$meiomc2 = $meiom2->rowCount();
	?>
	
	<?php if($meiomc2>0){ ?>
	<span class="tx-12"><b>* <?=$meiomc2;?> Sabores:</b></span><br />
	<span class="tx-12">
	<?php while ($meiomv2 = $meiom2->fetch(PDO::FETCH_OBJ)) { ?>
	<?=$meiomv2->nome."<br>";?>
	<?php } ?>
	</span>
	<?php } ?>
	
	<?php
	$adcionais2  = $connect->query("SELECT * FROM store_o WHERE idp = '".$carpro2->idpedido."' AND status = '1' AND idu='$cod_id' AND meioameio='0'"); 
	$adcionaisc2 = $adcionais2->rowCount();
	?>
	
	<?php if($adcionaisc2>0){ ?>
	<span class="tx-12"><b>* Adicionais/Ingredientes:</b></span><br />
    <span class="tx-12">
	<?php while ($adcionaisv2 = $adcionais2->fetch(PDO::FETCH_OBJ)) { ?>
	<?="-  R$: ".$adcionaisv2->valor." | ".$adcionaisv2->nome."<br>";?>
	<?php } ?>
	</span><br />
	<?php } ?>
	
	
	
		<br />
		<br />
	</div>

							<?php } ?>			
									
								
							</div>
						</div>
					</div>
				</div>
	
	<?php } ?>			
			 
		 	 	 
				
			</div>
	  
          
          
          
          
          
          
           
      </div><!-- container -->
    </div><!-- slim-mainpanel -->
	
	 

    <script src="../lib/jquery/js/jquery.js"></script>
     <script src="../lib/datatables/js/jquery.dataTables.js"></script>
    <script src="../lib/datatables-responsive/js/dataTables.responsive.js"></script>
    <script src="../lib/select2/js/select2.min.js"></script>
    
    <script>
      $(function(){
        'use strict';

        $('#datatable1').DataTable({
          responsive: true,
          language: {
            searchPlaceholder: 'Buscar...',
            sSearch: '',
            lengthMenu: '_MENU_ ítens',
          }
        });

        $('#datatable2').DataTable({
          bLengthChange: false,
          searching: false,
          responsive: true
        });

        // Select2
        $('.dataTables_length select').select2({ minimumResultsForSearch: Infinity });

      });
    </script>
	<script type="text/javascript">
  setTimeout(function() {
    window.location.reload(1);
  }, 15000);
</script>	
  </body>
</html>