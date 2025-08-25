<?php
header('Content-Type: text/html; charset=UTF-8');
ob_start();
session_start();
if((!isset ($_SESSION['cod_id']) == true)) { unset($_SESSION['cod_id']); header('location: ./'); }
$cod_id = $_SESSION['cod_id'];
require_once "../../funcoes/Conexao.php";
require_once "../../funcoes/Key.php";
require_once "db/Funcoes.php";
date_default_timezone_set( ''.$dadosgerais->fuso.'' );
require_once "db/Mobile_Detect.php";
$detect = new Mobile_Detect;
require_once "../db/base.php";
$sitexx = HOME;
?>
<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <!-- Required meta tags -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Painel Administrativo.">
    <meta name="author" content="MDINELLY">
    <title>:: PAINEL ADMINISTRATIVO ::</title>
    <link href="../lib/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="../lib/Ionicons/css/ionicons.css" rel="stylesheet">
	<link href="../lib/datatables/css/jquery.dataTables.css" rel="stylesheet">
    <link href="../lib/select2/css/select2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/slim.css">
	<?php if($prazo <= 5){?> 
	<style>
	@keyframes fa-blink {
     0% { opacity: 1; }
     50% { opacity: 0.5; }
     100% { opacity: 0; }
	 }
	.fa-blink {
	   -webkit-animation: fa-blink .95s linear infinite;
	   -moz-animation: fa-blink .95s linear infinite;
	   -ms-animation: fa-blink .95s linear infinite;
	   -o-animation: fa-blink .95s linear infinite;
	   animation: fa-blink .95s linear infinite;
	}
	</style>
	<?php } ?>
  </head>
  <body>

    <div class="slim-header with-sidebar">
      <div class="container-fluid">
        <div class="slim-header-left">
          <h3 class="slim-logo"><a href="index.html">Painel Admin<span></span></a></h3>
          <a href="" id="slimSidebarMenu" class="slim-sidebar-menu"><span></span></a>
        </div><!-- slim-header-left -->
        <div class="slim-header-right">
          
         
          <div class="dropdown dropdown-c">
            <a href="#" class="logged-user" data-toggle="dropdown">
              <span>ADMINISTRADOR MASTER</span>
              <i class="fa fa-angle-down"></i>
            </a>
           
          </div><!-- dropdown -->
        </div><!-- header-right -->
      </div><!-- container-fluid -->
    </div><!-- slim-header -->

    <div class="slim-body">
      <div class="slim-sidebar">
        <label class="sidebar-label">MENU</label>

        <ul class="nav nav-sidebar">
          <li class="sidebar-nav-item">
            <a href="home.php" class="sidebar-nav-link active"><i class="icon ion-ios-home-outline"></i> Dashboard</a>
          </li>
		  <?php if($configadmin->statuslink == 1){?>
		  <?php if($prazo <= 5 && $prazo >= 1){?> 
		  <li class="sidebar-nav-item">
            <a href="pagamento.php" class="sidebar-nav-link fa-blink" style="background-color:#FF6633; color:#FFFFFF"><i class="fa fa-usd mg-r-10" style="font-size:16px; color:#FFFFFF"></i><?php print $prazo;?> Dias para o Vencimento</a>
          </li>
		  <?php } ?>
		  <?php if($prazo <= 0){?> 
		  <li class="sidebar-nav-item">
            <a href="pagamento.php" class="sidebar-nav-link fa-blink" style="background-color:#FF6633; color:#FFFFFF"><i class="fa fa-usd mg-r-10" style="font-size:16px; color:#FFFFFF"></i>CONTA EXPIRADA</a>
          </li>
		  <?php } ?>
		  <?php } ?> 
          <li class="sidebar-nav-item">
            <a href="dadosempresa.php" class="sidebar-nav-link"><i class="fa fa-cogs mg-r-10" style="font-size:16px"></i> Dados Gerais</a>
          </li>
		   <li class="sidebar-nav-item">
            <a href="bannerelogo.php" class="sidebar-nav-link"><i class="fa fa-cutlery mg-r-10" style="font-size:16px"></i> Personalizações</a>
          </li>
	 <li class="sidebar-nav-item">
            <a href="clientes.php" class="sidebar-nav-link"><i class="fa fa-user mg-r-10" style="font-size:16px"></i> Clientes</a>
          </li>
          <li class="sidebar-nav-item">
            <a href="mesas.php" class="sidebar-nav-link"><i class="fa fa-qrcode mg-r-10" style="font-size:16px"></i> QRCode para Mesa</a>
          </li>
		   <li class="sidebar-nav-item">
            <a href="bairros.php" class="sidebar-nav-link"><i class="fa fa-car mg-r-10" style="font-size:16px"></i> Delivery e Taxas</a>
          </li>
		   <li class="sidebar-nav-item">
            <a href="categorias.php" class="sidebar-nav-link"><i class="fa fa-server mg-r-10" style="font-size:16px"></i> Categorias</a>
          </li>
		  <li class="sidebar-nav-item">
            <a href="grupos.php" class="sidebar-nav-link"><i class="fa fa-object-group mg-r-10" style="font-size:16px"></i> Grupos e Opcionais</a>
          </li>
		  <li class="sidebar-nav-item">
            <a href="produtos.php" class="sidebar-nav-link"><i class="fa fa-shopping-bag mg-r-10" style="font-size:16px"></i> Produtos</a>
          </li>	  
		  <li class="sidebar-nav-item">
            <a href="usuario.php" class="sidebar-nav-link"><i class="fa fa-user mg-r-10" style="font-size:16px"></i> Dados do Usuários</a>
          </li>
		  <li class="sidebar-nav-item">
            <a href="funcionarios.php" class="sidebar-nav-link"><i class="fa fa-users mg-r-10" style="font-size:16px"></i> Acesso Funcionários</a>
          </li>
          <li class="sidebar-nav-item">
            <a href="relatorios.php" class="sidebar-nav-link"><i class="fa fa-print mg-r-10" style="font-size:16px"></i> Relatórios</a>
          </li>
          <li class="sidebar-nav-item">
            <a href="sair.php" class="sidebar-nav-link"><i class="fa fa-sign-out mg-r-10" style="font-size:16px"></i> Sair</a>
          </li>
        </ul>
      </div>