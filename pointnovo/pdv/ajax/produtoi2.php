<?php
ob_start();
session_start();
if(isset($_COOKIE['pdvx'])){
$idu = $_COOKIE['pdvx'];
} else {
header("location: sair.php"); 
}
$id_cliente = $_SESSION['id_cliente'];

include_once('../../../funcoes/Conexao.php');
include_once('../../../funcoes/Key.php');

if(isset($_POST["produto"])){

$iduser		= $_POST["iduser"];
$idcat		= $_POST["idcat"];
$produto 	= $_POST["produto"];
$valor 		= "0.00";
$valor 		= $_POST["valor"];
$idsecao	= $_POST["idsecao"];
$idpedido	= $_POST["idpedido"];
$quantidade = $_POST["quantidade"];
$obser		= $_POST["observacoes"];

if(isset($_POST['tamanho'])){

$taman = $_POST['tamanho'];
$array = explode(',',$taman);

$inserpro = $connect->query("INSERT INTO store (idu, idsecao, idpedido, produto_id, data, valor, quantidade, tamanho, status, obs) VALUES ('".$iduser."','".$id_cliente."','".$idpedido."','".$produto."','".date("d-m-Y")."','".$array[1]."','".$quantidade."','".$array[0]."','1','".$obser."')");

} else {

$inserpro = $connect->query("INSERT INTO store (idu, idsecao, idpedido, produto_id, data, valor, quantidade, obs, status) VALUES ('".$iduser."','".$id_cliente."','".$idpedido."','".$produto."','".date("d-m-Y")."','".$valor."','".$quantidade."','".$obser."', '1')");

}

if(isset($_POST['meioameios'])){

foreach($_POST['meioameios'] as $valueo){
$text = $valueo;
$array = explode(',',$text);	
$inserpro = $connect->query("INSERT INTO store_o (idu, ids, idp, nome, valor, quantidade, meioameio, status) VALUES ('".$iduser."','".$id_cliente."','".$idpedido."','".$array[0]."','".$array[1]."','".$quantidade."','1','1')");

}

$pegarmaiorvalor = $connect->query("SELECT MAX(valor) AS valor FROM store_o WHERE idp='".$idpedido."' AND meioameio='1'");
$pegarmaiorvalorx		= $pegarmaiorvalor->fetch(PDO::FETCH_OBJ);
$idlXd  		 		= $pegarmaiorvalorx->valor;

$alteravalor = $connect->query("UPDATE store SET valor='$idlXd' WHERE idpedido='$idpedido'");
}


if(isset($_POST['opcionais'])){
    
foreach ($_POST['opcionais'] as $Id => $valueo){
$text = $valueo;    

//foreach ($_POST['opcionais'] as $valueo){
//$text = $valueo;

$array = explode(',',$text);
$inserpro = $connect->query("INSERT INTO store_o (idu, ids, idp, nome, valor, quantidade, meioameio, status) VALUES ('".$iduser."','".$id_cliente."','".$idpedido."','".$array[0]."','".$array[1]."','".$quantidade."','0','1')");
	}

}

if($inserpro){ header("location: ../pdvpedido.php?idpedido=".$id_cliente.""); exit; }

}

if(isset($_GET["up"])){ echo unlink("".$_GET["up"].""); }

ob_end_flush();
?>