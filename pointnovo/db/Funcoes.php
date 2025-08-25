<?php
$connect->exec("SET NAMES utf8mb4");
$connect->exec("SET CHARACTER SET utf8mb4");
$connect->exec("SET character_set_connection=utf8mb4");
$configadmin	= $connect->query("SELECT * FROM adm"); 
$configadmin 	= $configadmin->fetch(PDO::FETCH_OBJ);

if(isset($_GET["up"])){ echo unlink("".$_GET["up"].""); }

$empresa 		= $connect->query("SELECT * FROM config WHERE url='$xurl'"); 
$dadosempresa 	= $empresa->fetch(PDO::FETCH_OBJ);
$idu 			= $dadosempresa->id;
$bloc 			= $dadosempresa->status;

if($bloc == 3){ header("location: ../site/indisponivel/"); exit; }

if($configadmin->bloquear == 1){
$blocx			= date("Y-m-d");
if( $blocx > $dadosempresa->expiracao ) { header("location: ../site/indisponivel/"); exit; }
}

$dataatual  	=   date('w');
$horaatual  	=   date('H:i:s');

$dom 			= $dadosempresa->dom;
$seg 			= $dadosempresa->seg;
$ter 			= $dadosempresa->ter;
$qua 			= $dadosempresa->qua;
$qui 			= $dadosempresa->qui;
$sex 			= $dadosempresa->sex;
$sab 			= $dadosempresa->sab;

$aberto = "";

if($dataatual ==0) {
$arrayx = explode(',',$dom);

if($horaatual >= $arrayx[0] AND $horaatual <= $arrayx[1]) { $aberto = "1"; }
if($horaatual >= $arrayx[2] AND $horaatual <= $arrayx[3]) { $aberto = "1"; }

}

if($dataatual ==1) {
$arrayx = explode(',',$seg);

if($horaatual >= $arrayx[0] AND $horaatual <= $arrayx[1]) { $aberto = "1"; }
if($horaatual >= $arrayx[2] AND $horaatual <= $arrayx[3]) { $aberto = "1"; }

}

if($dataatual ==2) {
$arrayx = explode(',',$ter);

if($horaatual >= $arrayx[0] AND $horaatual <= $arrayx[1]) { $aberto = "1"; }
if($horaatual >= $arrayx[2] AND $horaatual <= $arrayx[3]) { $aberto = "1"; }

}

if($dataatual ==3) {
$arrayx = explode(',',$qua);

if($horaatual >= $arrayx[0] AND $horaatual <= $arrayx[1]) { $aberto = "1"; }
if($horaatual >= $arrayx[2] AND $horaatual <= $arrayx[3]) { $aberto = "1"; }

}

if($dataatual ==4) {
$arrayx = explode(',',$qui);

if($horaatual >= $arrayx[0] AND $horaatual <= $arrayx[1]) { $aberto = "1"; }
if($horaatual >= $arrayx[2] AND $horaatual <= $arrayx[3]) { $aberto = "1"; }

}

if($dataatual ==5) {
$arrayx = explode(',',$sex);

if($horaatual >= $arrayx[0] AND $horaatual <= $arrayx[1]) { $aberto = "1"; }
if($horaatual >= $arrayx[2] AND $horaatual <= $arrayx[3]) { $aberto = "1"; }

}

if($dataatual ==6) {
$arrayx = explode(',',$sab);

if($horaatual >= $arrayx[0] AND $horaatual <= $arrayx[1]) { $aberto = "1"; }
if($horaatual >= $arrayx[2] AND $horaatual <= $arrayx[3]) { $aberto = "1"; }

}

$banner 		= $connect->query("SELECT img FROM banner WHERE idu='$idu' ORDER BY RAND() LIMIT 1;");
$dadosbanner 	= $banner->fetch(PDO::FETCH_OBJ);

$logo 			= $connect->query("SELECT foto FROM logo WHERE idu='$idu' ORDER BY id DESC LIMIT 1"); 
$dadoslogo 		= $logo->fetch(PDO::FETCH_OBJ);

$fundo 			= $connect->query("SELECT * FROM fundotopo WHERE idu='$idu' ORDER BY id DESC LIMIT 1"); 
$dadosfundo 	= $fundo->fetch(PDO::FETCH_OBJ);

$categorias 	= $connect->query("SELECT * FROM categorias WHERE idu='$idu' ORDER BY posicao ASC");

$categoriasm 	= $connect->query("SELECT * FROM categorias WHERE idu='$idu' ORDER BY posicao ASC");

$categoriasd 	= $connect->query("SELECT * FROM categorias WHERE idu='$idu' ORDER BY posicao ASC");

$destaques	 	= $connect->query("SELECT * FROM produtos WHERE destaques = '1' AND idu='$idu' AND (visivel='G' OR visivel='$dataatual') AND status='1' ORDER BY nome ASC");

$produtosca = $connect->query("SELECT * FROM store WHERE idsecao = '".session_id()."' AND status='0' AND idu='$idu' ORDER BY id DESC");
$produtoscx 	= $produtosca->rowCount();

$produtosca = $connect->query("SELECT * FROM store WHERE idsecao = '".session_id()."' AND idu='$idu'");

//

if($produtoscx>0){
$somando = $connect->query("SELECT SUM(valor * quantidade) AS soma FROM store WHERE idsecao='".session_id()."' and status='0' and idu='$idu'");
$somando 	= $somando->fetch(PDO::FETCH_OBJ);
$somandop = $connect->query("SELECT SUM(quantidade) AS somap FROM store WHERE idsecao='".session_id()."' and status='0' and idu='$idu'");
$somandop 	= $somandop->fetch(PDO::FETCH_OBJ);
}

//

if(isset($_GET["apagaritemp"])){
    $id_item = $_GET['apagaritemp'];
    
    // Deleta apenas o item específico
    $delitem = $connect->prepare("DELETE FROM store WHERE id = ?");
    $delitem->execute([$id_item]);
    
    // Deleta os adicionais/meio a meio relacionados a esse item
    $delopci = $connect->prepare("DELETE FROM store_o WHERE idp = ?");
    $delopci->execute([$id_item]);

    if ($delitem) {
        header("Location: ./&retiradop=ok"); 
        exit;
    }
}

//

if(isset($_POST["balcao"])){
header("location: ./"); 
exit;
}

//

if(isset($_POST["pedidomesa"])){
header("location: ./"); 
exit;
}

//

if(isset($_POST["pedidodelivery"])){
header("location: ./"); 
exit;
}