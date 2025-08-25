<?php

$grupop 			= $connect->query("SELECT * FROM grupos WHERE idu = '$cod_id'");
$bairrosetaxas 		= $connect->query("SELECT * FROM bairros WHERE idu = '$cod_id' ORDER BY bairro ASC");
$pegadadosgerais 	= $connect->query("SELECT * FROM config WHERE id='$cod_id'");
$dadosgerais		= $pegadadosgerais->fetch(PDO::FETCH_OBJ);
$idlX		 		= $dadosgerais->id;
$funcionamento		= $dadosgerais->funcionamento;
$nomeX		 		= $dadosgerais->nomeadmin;
$nomeempresa 		= $dadosgerais->nomeempresa;
$dadcat 			= $connect->query("SELECT * FROM categorias WHERE idu =  '$cod_id' ORDER BY posicao ASC");
$dadpro 			= $connect->query("SELECT * FROM produtos WHERE idu =  '$cod_id' ORDER BY nome ASC");
$func               = $connect->query("SELECT * FROM funcionarios WHERE idu='$cod_id' ORDER BY nome ASC");

//


if(isset($_POST["pedidodelivery"])){
$nome 			= $_POST['nome'];
$wps  			= $_POST['wps'];
$fmpgto  		= $_POST['fmpgto'];
$troco  		= $_POST['troco'];
$cidade  		= $_POST['cidade'];
$uf  			= $_POST['uf'];
$numero  		= $_POST['numero'];
$bairro  		= $_POST['bairro'];
$rua  			= $_POST['rua'];
$complemento	= $_POST['complemento'];
$taxa  			= $_POST['taxa'];
$numero  		= $_POST['numero'];
$subtotal 		= $_POST['subtotal'];
$adcionais  	= $_POST['adcionais'];
$totalg  		= $_POST['totalg'];
$data			= date("d-m-Y");
$hora			= date("H:i:s");
$idus			= $_POST["idu"];
$idpedidos		= $_POST["id_pedido"];
$inst = $connect->query("INSERT INTO pedidos(idu, idpedido, fpagamento, cidade, numero, complemento, rua, bairro, troco, nome, data, hora, celular, taxa, mesa, pessoas, obs, vsubtotal, vadcionais, vtotal) VALUES ('$idus','$idpedidos','$fmpgto','cidade','$numero','$complemento','$rua','$bairro','$troco','$nome','$data','$hora','$wps','$taxa','0','0','0','$subtotal','$adcionais','$totalg')");
$update = $connect->query("UPDATE store SET status='1' WHERE idsecao='$idpedidos'");
$update = $connect->query("UPDATE store_o SET status='1' WHERE ids='$idpedidos'");
if ( $update ) {
header("location: pdv.php"); 
exit;
}
}



