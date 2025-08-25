<?php
include_once('header.php');
if($produtoscx>0){
header("location: acompanhar_pedido.php"); exit;
}
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
					<h4 class="mg-b-10"><span style="color:#FFFFFF; text-shadow: 2px 2px black;">PEDIDO NA MESA</span></h4>	
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

    <div class="signin-wrapper">

      <div class="signin-box" align="center">
        <h4 style="margin-bottom:-1px;">ABRIR COMANDA<span></h4>
        <center>Nº <?=$id_mesa;?></center>
		<hr />
		<form action="" method="post">
		<input type="hidden" name="mesainicial" value="ok">
		
		
		<div class="row mg-t-10">
	   
			<div class="col-6">
			<div class="form-group">
			<label>Nº. Mesa</label>
			<?php if(isset($_GET["idmesa"])) { ?>
			<input type="text" class="form-control display-1 pd-30 bg-gray-200 tx-inverse tx-center mg-b-15" style="font-size:36px" maxlength="3" value="<?=$_GET["idmesa"];?>" disabled>
			<input type="hidden" name="mesa" value="<?=$_GET["idmesa"];?>">
			<?php } else { header("location: erro.php"); }?>
			</div><!-- form-group -->
			</div>
			 
			<div class="col-6">
			<div class="form-group">
			<label>Qnt. Pessoas</label>
          	<input type="number" class="form-control display-1 pd-30 bg-gray-200 tx-inverse tx-center mg-b-15" name="pessoas" style="font-size:36px" maxlength="2" required>
        	</div><!-- form-group -->
			</div>
		 
		 </div>
		
		    <div class="form-group">
			<label>Nome</label>
			<input type="text" class="form-control" name="nome" style="font-size:26px" maxlength="20" required>
			</div><!-- form-group -->
			
			 <div class="form-group">
			<label>Nº Celular</label>
			<input type="text" class="form-control" name="celular" style="font-size:26px" maxlength="11" required>
			<p>DDD+Número</p>
			</div><!-- form-group -->

        <button type="submit" class="btn btn-primary btn-block btn-signin">Fazer Pedido</button>
		</form>
      </div>
    </div>





</div> 
</div>
<a href="#top" style="color:#999999"><i class="fa fa-chevron-circle-up" aria-hidden="true"></i></a>
<?php require '../include/fundo.php'; ?> 
    
	<script src="../lib/jquery/js/jquery.js"></script>
    <script src="../lib/bootstrap/js/bootstrap.js"></script>
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
</body>
</html>
<?php
ob_end_flush();
?>