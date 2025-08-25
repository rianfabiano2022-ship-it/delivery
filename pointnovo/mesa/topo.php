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
					<h4 class="mg-b-10"><span style="color:#FFFFFF; text-shadow: 2px 2px black;">PEDIDO NA MESA</span></h4>	
				</div>


			</div>
		  </div>
      </div>
    </div>