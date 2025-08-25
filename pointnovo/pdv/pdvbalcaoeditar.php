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

$_GET['idpedido'] = preg_replace("/[^0-9]/", "", $_GET['idpedido']);
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

if(isset($_POST["pedidobalcao"])){
$nome 			= $_POST['nome'];
$wps  			= $_POST['wps'];
$subtotal 		= $_POST['subtotal'];
$adcionais  	= $_POST['adcionais'];
$totalg  		= $_POST['totalg'];
$editarcor 		= $connect->query("UPDATE pedidos SET nome='$nome', celular='$wps', fpagamento='BALCAO', vsubtotal='$subtotal', vadcionais='$adcionais', vtotal='$totalg' WHERE idpedido='$id_cliente'");
if ( $editarcor ) {
header("location: pdv.php"); 
exit;
}
}

$taxa = "0,00";

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
						<input type="hidden" name="pedidobalcao">
						<?php 
						$dadospedido 	= $connect->query("SELECT * FROM pedidos WHERE idpedido='$id_cliente'"); 
						$dadospedido 	= $dadospedido->fetch(PDO::FETCH_OBJ);
						
						?>
						<div class="row">
										
							<div class="col-lg-6">
								<div class="form-group">
									<label class="form-control-label">Nº do seu WhatsApp: <span class="tx-danger">*</span></label>
									<input type="text" placeholder="DDD+Número" maxlength="11" name="wps" class="form-control" value="<?=$dadospedido->celular;?>" required>
								</div>
							</div>
							
							<div class="col-lg-6">
								<div class="form-group">
									<label class="form-control-label">Primeiro Nome: <span class="tx-danger">*</span></label>
									<input type="text" name="nome" class="form-control" maxlength="60" value="<?=$dadospedido->nome;?>" required>
								</div>
							</div>
							
						</div>
						
						
						
						

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