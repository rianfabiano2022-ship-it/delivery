<?php
$connect->exec("SET NAMES utf8mb4");
$connect->exec("SET CHARACTER SET utf8mb4");
$connect->exec("SET character_set_connection=utf8mb4");
$configadmin		= $connect->query("SELECT * FROM adm"); 
$configadmin 		= $configadmin->fetch(PDO::FETCH_OBJ);
$grupop 			= $connect->query("SELECT * FROM grupos WHERE idu = '$cod_id'");
$fundotopo 			= $connect->query("SELECT * FROM fundotopo WHERE idu = '$cod_id'");
$logotopo 			= $connect->query("SELECT * FROM logo WHERE idu = '$cod_id'");
$dlogo 				= $logotopo->fetch(PDO::FETCH_OBJ);
$bannerpromo 		= $connect->query("SELECT * FROM banner WHERE idu = '$cod_id'"); 
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

$data_inicial = date("Y-m-d");
$data_final = $dadosgerais->expiracao;
$diferenca = strtotime($data_final) - strtotime($data_inicial);
$prazo = floor($diferenca / (60 * 60 * 24));

//

if(isset($_POST["cadmesa"]))  {
$numero 		= $_POST['numero'];
$cadfunc = $connect->query("INSERT INTO mesas (idu, numero) VALUES ('$cod_id','$numero')");
if ( $cadfunc ) { header("location: mesas.php?ok=ok"); exit; } else { header("location: mesas.php?erro=erro"); exit; }
}

//

if(isset($_POST["delmesa"]))  {
$delb = $connect->query("DELETE FROM mesas WHERE id='".$_POST['delmesa']."'");
if ( $delb ) { header("location: mesas.php?ok=ok"); exit; } else { header("location: mesas.php?erro=erro"); exit; }
}


//

if(isset($_POST["cadfuncionarios"]))  {
$cad_nome 		= $_POST['cad_nome'];
$cad_login 		= $_POST['cad_login'];
$cad_senha 		= sha1($_POST['cad_senha']); 
$cad_acesso 	= $_POST['cad_acesso'];
$cadfunc = $connect->query("INSERT INTO funcionarios (idu, nome, login, senha, acesso) VALUES ('$cod_id','$cad_nome','$cad_login','$cad_senha','$cad_acesso')");
if ( $cadfunc ) { header("location: funcionarios.php?ok=ok"); exit; } else { header("location: funcionarios.php?erro=erro"); exit; }
}

//

if(isset($_POST["delfun"]))  {
$delb = $connect->query("DELETE FROM funcionarios WHERE id='".$_POST['delfun']."'");
if ( $delb ) { header("location: funcionarios.php?ok=ok"); exit; } else { header("location: funcionarios.php?erro=erro"); exit; }
}

//

if(isset($_POST["editarempresa"]))  {

$nome 			= $_POST['nome'];
$bairro 		= $_POST['bairro'];
$rua 			= $_POST['rua'];
$complemento 	= $_POST['complemento'];
$cidade 		= $_POST['cidade'];
$uf 			= $_POST['uf'];
$celular 		= $_POST['celular'];
$chave_pix 		= $_POST['chave_pix'];
$cep 			= $_POST['cep'];
$numero 		= $_POST['numero'];
$seg1 			= $_POST['seg1'];
$seg2 			= $_POST['seg2'];
$seg3 			= $_POST['seg3'];
$seg4 			= $_POST['seg4'];
$ter1 			= $_POST['ter1'];
$ter2 			= $_POST['ter2'];
$ter3 			= $_POST['ter3'];
$ter4 			= $_POST['ter4'];
$qua1 			= $_POST['qua1'];
$qua2 			= $_POST['qua2'];
$qua3 			= $_POST['qua3'];
$qua4 			= $_POST['qua4'];
$qui1 			= $_POST['qui1'];
$qui2 			= $_POST['qui2'];
$qui3 			= $_POST['qui3'];
$qui4 			= $_POST['qui4'];
$sex1 			= $_POST['sex1'];
$sex2 			= $_POST['sex2'];
$sex3 			= $_POST['sex3'];
$sex4 			= $_POST['sex4'];
$sab1 			= $_POST['sab1'];
$sab2 			= $_POST['sab2'];
$sab3 			= $_POST['sab3'];
$sab4 			= $_POST['sab4'];
$dom1 			= $_POST['dom1'];
$dom2 			= $_POST['dom2'];
$dom3 			= $_POST['dom3'];
$dom4 			= $_POST['dom4'];
$fuso 			= $_POST['fuso'];
$timerdelivery	= $_POST['timerdelivery'];
$timerbalcao	= $_POST['timerbalcao'];
$dfree	 		= $_POST['dfree'];
$dfree    		= str_replace(",", ".", $dfree);
$editarcad 		= $connect->query("UPDATE config SET nomeempresa='$nome', celular='$celular', cep='$cep', numero='$numero', Chave_Pix='$chave_pix', rua='$rua', bairro='$bairro', cidade='$cidade', uf='$uf', complemento='$complemento',seg='$seg1,$seg2,$seg3,$seg4',ter='$ter1,$ter2,$ter3,$ter4',qua='$qua1,$qua2,$qua3,$qua4',qui='$qui1,$qui2,$qui3,$qui4',sex='$sex1,$sex2,$sex3,$sex4',sab='$sab1,$sab2,$sab3,$sab4',dom='$dom1,$dom2,$dom3,$dom4',timerdelivery='$timerdelivery',timerbalcao='$timerbalcao',dfree='$dfree',fuso='$fuso' WHERE id='$cod_id'");
if ( $editarcad ) { header("location: dadosempresa.php?emp=&ok="); exit; } else { header("location: dadosempresa.php?emp=&erro=erro"); exit; }
} 

//

if(isset($_POST["atendimento"]))  {
$delivery		= $_POST['delivery'];
$balcao 		= $_POST['balcao'];
$mesa 			= $_POST['mesa'];
$editarcad 		= $connect->query("UPDATE config SET delivery='$delivery', balcao='$balcao', mesa='$mesa' WHERE id='$cod_id'");
if ( $editarcad ) { header("location: bannerelogo.php?ok=ok"); exit; } else { header("location: bannerelogo.php?erro=erro"); exit; }
} 

//

if(isset($_POST["editarempresacor"]))  {
$cormenu 		= $_POST['cormenu'];
$corfundo 		= $_POST['corfundo'];
$corrodape 	    = $_POST['corrodape'];
$corcarrinho	= $_POST['corcarrinho'];
$editarcor 		= $connect->query("UPDATE config SET cormenu='$cormenu', corfundo='$corfundo', corrodape='$corrodape', corcarrinho='$corcarrinho' WHERE id='$cod_id'");
if ( $editarcor ) { header("location: bannerelogo.php?ok=ok"); exit; } else { header("location: bannerelogo.php?erro=erro"); exit; }
} 


//

if(isset($_POST["bannerfundo"]))  {
$imagem 		= $_FILES['imagem']['name'];
$dir 			= "../img/fundo_banner/";
$salva 			= $dir."/".$imagem;
move_uploaded_file($_FILES['imagem']['tmp_name'],$salva );
$info_imagem 	= pathinfo($salva);
$nova_imagem 	= time().rand(1000,5000).".".$info_imagem['extension'];
require_once "resize2.php";
$resizeObj 		= new resize($salva);
$resizeObj -> resizeImage(1400, 400, 'crop');
$resizeObj -> saveImage($dir."/".$nova_imagem, 100);
unlink($salva);

$bannerfundob 	= $connect->query("UPDATE fundotopo SET foto='$nova_imagem' WHERE id='".$_POST['idbanner']."' AND idu='$cod_id'");
if ( $bannerfundob ) { header("location: bannerelogo.php?ok=ok"); exit; } else { header("location: bannerelogo.php?erro=erro"); exit; }
}
if(isset($_GET["up"])){ echo unlink("".$_GET["up"].""); }
//

if(isset($_POST["logo"]))  {
$imagem 		= $_FILES['imagem']['name'];
$dir 			= "../img/logomarca/";
$salva 			= $dir."/".$imagem;
move_uploaded_file($_FILES['imagem']['tmp_name'],$salva );
$info_imagem 	= pathinfo($salva);
$nova_imagem 	= time().rand(1000,5000).".".$info_imagem['extension'];
require_once "resize2.php";
$resizeObj 		= new resize($salva);
$resizeObj -> resizeImage(400, 400, 'crop');
$resizeObj -> saveImage($dir."/".$nova_imagem, 100);
unlink($salva);
$logotopo 		= $connect->query("UPDATE logo SET foto='$nova_imagem' WHERE id='".$_POST['idlogo']."' AND idu='$cod_id'");
if ( $logotopo ) { header("location: bannerelogo.php?ok=ok"); exit; } else { header("location: bannerelogo.php?erro=erro"); exit; }
}

//

if(isset($_POST["bannerpromo"]))  {
$imagem 		= $_FILES['imagem']['name'];
$dir			= "../img/banner/";
$salva 			= $dir."/".$imagem;
move_uploaded_file($_FILES['imagem']['tmp_name'],$salva );
$info_imagem 	= pathinfo($salva);
$nova_imagem 	= time().rand(1000,5000).".".$info_imagem['extension'];
require_once "resize2.php";
$resizeObj 		= new resize($salva);
$resizeObj -> resizeImage(600, 200, 'crop');
$resizeObj -> saveImage($dir."/".$nova_imagem, 100);
unlink($salva);
$bannerpromo 	= $connect->query("UPDATE banner SET img='$nova_imagem' WHERE id='".$_POST['idbannerp']."' AND idu='$cod_id'");
if ( $bannerpromo ) { header("location: bannerelogo.php?ok=ok"); exit; } else { header("location: bannerelogo.php?erro=erro"); exit; }
}

//

if(isset($_POST["cadbairro"]))  {
$cad_nome 		= $_POST['cad_nome'];
$cad_taxa 		= $_POST['cad_taxa'];
$cad_taxa       = str_replace(",", ".", $cad_taxa);
$cadbairro = $connect->query("INSERT INTO bairros(bairro, idu, taxa) VALUES ('$cad_nome','$cod_id','$cad_taxa')");
if ( $cadbairro ) { header("location: bairros.php?ok=ok"); exit; } else { header("location: bairros.php?erro=erro"); exit; }
}

//

if(isset($_POST["delbairro"]))  {
$delb = $connect->query("DELETE FROM bairros WHERE id='".$_POST['delbairro']."'");
if ( $delb ) { header("location: bairros.php?ok=ok"); exit; } else { header("location: bairros.php?erro=erro"); exit; }
}

//

if(isset($_POST["cadcate"]))  {
$cad_nome 		= $_POST['cad_nome'];
$cad_pos 		= $_POST['cad_posicao'];
if ($_FILES['pic']['size'] >= 1) {
$imagem 		= $_FILES['pic']['name'];
$dir 			= "../img/categoria/";
$salva 			= $dir."/".$imagem;
move_uploaded_file($_FILES['pic']['tmp_name'],$salva );
$info_imagem 	= pathinfo($salva);
$nova_imagem 	= time().rand(1000,5000).".".$info_imagem['extension'];
require_once "resize2.php";
$resizeObj 		= new resize($salva);
$resizeObj -> resizeImage(100, 100, 'crop');
$resizeObj -> saveImage($dir."/".$nova_imagem, 100);
unlink($salva);
} else { $nova_imagem = "off.jpg"; }
$cadcat 		= $connect->query("INSERT INTO categorias(nome, url, idu, posicao) VALUES ('$cad_nome','$nova_imagem','$cod_id','$cad_pos')");
if ( $cadcat ) { header("location: categorias.php?ok=ok"); exit; } else { header("location: categorias.php?erro=erro"); exit; }
}

//

if(isset($_POST["deletarcat"]))  {
$delb 			= $connect->query("DELETE FROM categorias WHERE id='".$_POST['deletarcat']."'");
$delp 			= $connect->query("DELETE FROM produtos WHERE categoria='".$_POST['deletarcat']."'");
if ( $delb ) { header("location: categorias.php?ok=ok"); exit; } else { header("location: categorias.php?erro=erro"); exit; }
}

//

if(isset($_POST["editcate"]))  {
$cad_nome 		= $_POST['cad_nome'];
$cad_pos 		= $_POST['cad_posicao'];
$cad_img 		= $_POST['img'];
$cad_iduc 		= $_POST['iduc'];
if ($_FILES['pic2']['size'] >= 1) {
$imagem 		= $_FILES['pic2']['name'];
$dir 			= "../img/categoria/";
$salva 			= $dir."/".$imagem;
move_uploaded_file($_FILES['pic2']['tmp_name'],$salva );
$info_imagem 	= pathinfo($salva);
$nova_imagem 	= time().rand(1000,5000).".".$info_imagem['extension'];
require_once "resize2.php";
$resizeObj 		= new resize($salva);
$resizeObj -> resizeImage(100, 100, 'crop');
$resizeObj -> saveImage($dir."/".$nova_imagem, 100);
unlink($salva);
} else { 
echo $nova_imagem = $cad_img; 
}
$editarcad = $connect->query("UPDATE categorias SET nome='$cad_nome', posicao='$cad_pos', url='$nova_imagem' WHERE id='$cad_iduc'");
if ( $editarcad ) { header("location: categorias.php?ok=123"); exit; } else { header("location: categorias.php?erro=erro"); exit; }
}

//

if(isset($_POST["cadpro"]))  {
$cad_nome 		= $_POST['cad_nome'];
$cad_ing 		= $_POST['cad_ingrediente'];
$cad_dest 		= "0";
$cad_cat 		= $_POST['cad_cat'];
$cad_val 		= $_POST['cad_valor'];
$cad_val    	= str_replace(",", ".", $cad_val);
if ($_FILES['pic']['size'] >= 1) {
$imagem 		= $_FILES['pic']['name'];
$dir 			= "../img/fotos_produtos/";
$salva 			= $dir."/".$imagem;
move_uploaded_file($_FILES['pic']['tmp_name'],$salva );
$info_imagem 	= pathinfo($salva);
$nova_imagem 	= time().rand(1000,5000).".".$info_imagem['extension'];
require_once "resize2.php";
$resizeObj 	 	= new resize($salva);
$resizeObj -> resizeImage(600, 400, 'crop');
$resizeObj -> saveImage($dir."/".$nova_imagem, 100);
unlink($salva);
} else { $nova_imagem = "off.jpg"; }
$novocad = $connect->query("INSERT INTO produtos(nome, valor, ingredientes, categoria, idu, foto, destaques) VALUES ('$cad_nome','$cad_val','$cad_ing','$cad_cat','$cod_id','$nova_imagem','$cad_dest')");
if ( $novocad ) { header("location: produtos.php?ok=ok"); exit; } else { header("location: produtos.php?erro=erro"); exit; }
}

//

if(isset($_GET["exedias"]))  {
$edit_dias 		= $_GET['exedias'];
$edit_idp 		= $_GET['idpp'];
$editardias 	= $connect->query("UPDATE produtos SET visivel='$edit_dias' WHERE id='$edit_idp' AND idu='$cod_id'");
if ( $editardias ) { header("location: produtos.php?ok=ok"); exit; } else { header("location: produtos.php?erro=erro"); exit; }
}

//

// Dias de exibição para CATEGORIAS
if(isset($_GET["exediascat"]))  {
    $edit_dias = $_GET['exediascat'];
    $edit_idc = $_GET['idcat'];
    $editardias = $connect->query("UPDATE categorias SET visivel='$edit_dias' WHERE id='$edit_idc' AND idu='$cod_id'");
    if ( $editardias ) { header("location: exibirdiascat.php?idcat=$edit_idc&ok=ok"); exit; } else { header("location: exibirdiascat.php?idcat=$edit_idc&erro=erro"); exit; }
}

//

if(isset($_POST["deletarproduto"]))  {
$delproduto 	= $connect->query("DELETE FROM produtos WHERE id='".$_POST['deletarproduto']."'");
$delopc 		= $connect->query("DELETE FROM limite_op WHERE idp='".$_POST['deletarproduto']."'");
$deltamanhos 	= $connect->query("DELETE FROM tamanhos WHERE idp='".$_POST['deletarproduto']."'");
if ( $delproduto ) { header("location: produtos.php?ok=ok"); exit; } else { header("location: produtos.php?erro=erro"); exit; }
}

//

if(isset($_POST["editarproduto"]))  {
$cad_nome 	= $_POST['cad_nome'];
$cad_ing 	= $_POST['cad_ingrediente'];
$cad_dest 	= "0";
$cad_cat 	= $_POST['cad_cat'];
$cad_val 	= $_POST['cad_valor'];
$cad_val    = str_replace(",", ".", $cad_val);
$cad_img 	= $_POST['cad_img'];
$codigopro 	= $_POST['codigopro'];

if ($_FILES['pic']['size'] >= 1) {

$imagem 		= $_FILES['pic']['name'];
$dir 			= "../img/fotos_produtos/";
$salva 			= $dir."/".$imagem;
move_uploaded_file($_FILES['pic']['tmp_name'],$salva );
$info_imagem 	= pathinfo($salva);
$nova_imagem 	= time().rand(1000,5000).".".$info_imagem['extension'];
require_once "resize2.php";
$resizeObj 	 	= new resize($salva);
$resizeObj -> resizeImage(600, 400, 'crop');
$resizeObj -> saveImage($dir."/".$nova_imagem, 100);
unlink($salva);
} else { 
echo $nova_imagem = $cad_img; 
}
$editarprod = $connect->query("UPDATE produtos SET nome='$cad_nome', valor='$cad_val', ingredientes='$cad_ing', categoria='$cad_cat', foto='$nova_imagem', destaques='$cad_dest' WHERE id='$codigopro' AND idu='$cod_id'");
if ( $editarprod ) { header("location: produtos.php?ok=ok"); exit; } else { header("location: produtos.php?erro=erro"); exit; }
}

//

if(isset($_POST["variacoes"]))  {
$cad_nome 		= $_POST['descvariacoes'];
$codvar 		= $_POST['codvar'];
$cad_val 		= $_POST['valorvariacoes'];
$cad_val    	= str_replace(",", ".", $cad_val);
$novocadv = $connect->query("INSERT INTO tamanhos(idu, idp, descricao, valor) VALUES ('$cod_id','$codvar','$cad_nome','$cad_val')");
$valpro = $connect->query("UPDATE produtos SET valor='0.00' WHERE id='$codvar' AND idu='$cod_id'");
if ( $novocadv ) { header("location: variacoes.php?idpp=".$codvar."&ok=ok"); exit; } else { header("location: variacoes.php?idpp=".$codvar."&erro=ok"); exit; }
}

//

if(isset($_POST["editarstatustamanho"]))  {
$idtamnho 		= $_POST['editarstatustamanho'];
$statusta 		= $_POST['editarstatustamanhov'];
$codvar 		= $_POST['codvar'];
$novocadv 		= $connect->query("UPDATE tamanhos SET status='$statusta'WHERE id='$idtamnho' AND idu='$cod_id'");
if ( $novocadv ) { header("location: variacoes.php?idpp=".$codvar."&ok=ok"); exit; } else { header("location: variacoes.php?idpp=".$codvar."&erro=ok"); exit; }
}

//

if(isset($_POST["deletartamanho"]))  {
$iddeltamnho 	= $_POST['deletartamanho'];
$codvar 		= $_POST['codvar'];
$novocadv 		= $connect->query("DELETE FROM tamanhos WHERE id='$iddeltamnho'");
if ( $novocadv ) { header("location: variacoes.php?idpp=".$codvar."&ok=ok"); exit; } else { header("location: variacoes.php?idpp=".$codvar."&erro=ok"); exit; }
}

//

if(isset($_POST["opcionaisv"]))  {
$cad_nome 		= $_POST['nomeopcionais'];
$cad_desc 		= $_POST['descopcionais'];
$codvar 		= $_POST['codvar'];
$cad_val 		= $_POST['valoropcionais'];
$cad_val    	= str_replace(",", ".", $cad_val);
$novocado = $connect->query("INSERT INTO opcionais(idu, idg, opnome, opdescricao, valor) VALUES ('$cod_id','$codvar','$cad_nome','$cad_desc','$cad_val')");
if ( $novocado ) { header("location: opcionais.php?idpp=".$codvar."&ok=ok"); exit; } else { header("location: opcionais.php?idpp=".$codvar."&erro=ok"); exit; }
}

//

if(isset($_POST["editarstatusopcionais"]))  {
$idtamnho 		= $_POST['editarstatusopcionais'];
$statusta 		= $_POST['editarstatusopc'];
$codvar 		= $_POST['codvar'];
$novocadvo = $connect->query("UPDATE opcionais SET status='$statusta'WHERE id='$idtamnho' AND idu='$cod_id'");
if ( $novocadvo ) { header("location: opcionais.php?idpp=".$codvar."&ok=ok"); exit; } else { header("location: opcionais.php?idpp=".$codvar."&erro=ok"); exit; }
}

//

if(isset($_POST["deletaropcionais"]))  {
$iddeltamnho 	= $_POST['deletaropcionais'];
$codvar 		= $_POST['codvar'];
$delopc 		= $connect->query("DELETE FROM opcionais WHERE id='$iddeltamnho'");
if ( $delopc ) { header("location: opcionais.php?idpp=".$codvar."&ok=ok"); exit; } else { header("location: opcionais.php?idpp=".$codvar."&erro=ok"); exit; }
}

//

if(isset($_POST["idcpes"]))  {
$idc 			= $_POST['idcpes'];
$nome 			= $_POST['nome'];
$email     		= $_POST['email'];
$cpf     		= $_POST['cpf'];
$senha 			= $_POST['senha']; 
if($senha) { 
$senha 			= sha1($_POST['senha']); 
$editarcad = $connect->query("UPDATE config SET nomeadmin='$nome', cpf='$cpf', senha='$senha', email='$email' WHERE id='$idc'");
} else {
$editarcad = $connect->query("UPDATE config SET nomeadmin='$nome', cpf='$cpf', email='$email' WHERE id='$idc'");
}
if ( $editarcad ) { header("location: sair.php"); exit; } else { header("location: sair.php"); exit; }
}

//

if(isset($_POST["limitopc"]))  {
$codpr 		= $_POST['codpr'];
$qntopc 	= $_POST['qntopc'];
$limitopc = $connect->query("INSERT INTO limite_op(idp, limite) VALUES ('$codpr','$qntopc')");
if ( $limitopc ) { header("location: opcionais.php?idpp=$codpr"); exit; } else { header("location: opcionais.php?idpp=$codpr&erro=erro"); exit; }
}

//

if(isset($_POST["edlimitopc"]))  {
$codprx 		= $_POST['codprx'];
$qntopcx 	= $_POST['qntopcx'];
$editlimi = $connect->query("UPDATE limite_op SET limite='$qntopcx' WHERE idp='$codprx'");
if ( $editlimi ) { header("location: opcionais.php?idpp=$codprx&ok=ok"); exit; } else { header("location: opcionais.php?idpp=$codprx&erro=erro"); exit; }
}

//

if(isset($_GET["fechar"]))  {
$idl 	= $_GET['idl'];
$fecharemp = $connect->query("UPDATE config SET funcionamento='2' WHERE id='$idl'");
if ( $fecharemp ) { header("location: home.php"); exit; }
}

//

if(isset($_GET["abrir"]))  {
$idl 	= $_GET['idl'];
$abriremp = $connect->query("UPDATE config SET funcionamento='1' WHERE id='$idl'");
if ( $abriremp ) { header("location: home.php"); exit; }
}

//

if(isset($_GET["desativar"]))  {
$id_desativar 	= $_GET['desativar'];
$desativar = $connect->query("UPDATE produtos SET status='2' WHERE id='$id_desativar'");
if ( $desativar ) { header("location: produtos.php?ok=ok"); exit; } else { header("location: produtos.php?erro=erro"); exit; }
}

//

if(isset($_GET["ativarp"]))  {
$id_ativarp 	= $_GET['ativarp'];
$ativarp = $connect->query("UPDATE produtos SET status='1' WHERE id='$id_ativarp'");
if ( $ativarp ) { header("location: produtos.php?ok=ok"); exit; } else { header("location: produtos.php?erro=erro"); exit; }
}

//

if(isset($_POST["cadgrupo"]))  {
$cad_nomex 		= $_POST['cad_nomex'];
$cad_nome 		= $_POST['cad_nome'];
$cad_posicao	= $_POST['cad_posicao'];
$cad_obri 		= $_POST['cad_obri'];
$cad_mopcoes	= $_POST['cad_mopcoes'];
$cad_minopcoes	= $_POST['cad_minopcoes'];
$cadgrupo = $connect->query("INSERT INTO grupos(nomeinterno, nomegrupo, idu, obrigatorio, posicao, status, quantidade_minima, quantidade) VALUES ('$cad_nomex','$cad_nome','$cod_id','$cad_obri','$cad_posicao','1','$cad_minopcoes','$cad_mopcoes')");
if ( $cadgrupo ) { header("location: grupos.php?ok=ok"); exit; } else { header("location: grupos.php?erro=erro"); exit; }
}

if(isset($_POST["deletarcatx"]))  {
$idpp 		= $_POST['idpp'];
$delb 			= $connect->query("DELETE FROM limite_op WHERE Id='".$_POST['deletarcatx']."'");
if ( $delb ) { header("location: opgrupo.php?idpp=$idpp&ok=ok"); exit; } else { header("location: opgrupo.php?idpp=$idpp&erro=erro"); exit; }
}

//

if(isset($_POST["editgrupo"]))  {
$idgrup 		= $_POST['idgrup'];
$cad_nomex 		= $_POST['cad_nomex'];
$cad_nome 		= $_POST['cad_nome'];
$cad_posicao	= $_POST['cad_posicao'];
$cad_obri 		= $_POST['cad_obri'];
$cad_minopcoes	= $_POST['cad_minopcoes'];
$cad_mopcoes	= $_POST['cad_mopcoes'];
$editardias 	= $connect->query("UPDATE grupos SET nomeinterno='$cad_nomex', nomegrupo='$cad_nome', posicao='$cad_posicao', obrigatorio='$cad_obri', quantidade_minima='$cad_minopcoes', quantidade='$cad_mopcoes' WHERE Id='$idgrup' AND idu='$cod_id'");
if ( $editardias ) { header("location: grupos.php?ok=ok"); exit; } else { header("location: grupos.php?erro=erro"); exit; }
}

//

if(isset($_POST["deletargrupo"]))  {
$delb 			= $connect->query("DELETE FROM grupos WHERE Id='".$_POST['deletargrupo']."'");
$delp 			= $connect->query("DELETE FROM opcionais WHERE idg='".$_POST['deletargrupo']."'");
$delc 			= $connect->query("DELETE FROM limite_op WHERE idgrupo='".$_POST['deletargrupo']."'");
if ( $delc ) { header("location: grupos.php?ok=ok"); exit; } else { header("location: grupos.php?erro=erro"); exit; }
}

// 

if(isset($_GET["desativarg"]))  {
$id_desativar 	= $_GET['desativarg'];
$desativarg = $connect->query("UPDATE grupos SET status='2' WHERE Id='$id_desativar'");
if ( $desativarg ) { header("location: grupos.php?ok=ok"); exit; } else { header("location: grupos.php?erro=erro"); exit; }
}

//

if(isset($_GET["ativarpg"]))  {
$id_ativarp 	= $_GET['ativarpg'];
$ativarpg = $connect->query("UPDATE grupos SET status='1' WHERE Id='$id_ativarp'");
if ( $ativarpg ) { header("location: grupos.php?ok=ok"); exit; } else { header("location: grupos.php?erro=erro"); exit; }
}

//

if(isset($_POST["cadgruposx"]))  {
$cad_obrigt 	= $_POST['cad_obrigt'];
$array 			= explode(',',$cad_obrigt);
$cadgruposxy	= $_POST['cadgruposxy'];
$cadgrupof = $connect->query("INSERT INTO limite_op(idp, idgrupo, meioameio) VALUES ('$cadgruposxy','".$array[0]."','".$array[1]."')");
if($array[1] == 3){
$zerapreco = $connect->query("UPDATE produtos SET valor='0.00' WHERE id='$cadgruposxy'");
}
if ( $cadgrupof ) { header("location: opgrupo.php?idpp=".$cadgruposxy."&ok=ok"); exit; } else { header("location: opgrupo.php?idpp=".$cadgruposxy."&erro=erro"); exit; }
}

//

if(isset($_POST["duplicargrupo"]))  {
$duplicargrupo 	= $_POST['duplicargrupo'];

$selecionagrupo = $connect->query("SELECT * FROM grupos WHERE Id='$duplicargrupo'");
$selecionagrupo	= $selecionagrupo->fetch(PDO::FETCH_OBJ);

$cadgrupo = $connect->query("INSERT INTO grupos(nomegrupo, nomeinterno, obrigatorio, posicao, status, quantidade_minima, quantidade, idu) VALUES ('copia-".$selecionagrupo->nomegrupo."','copia-".$selecionagrupo->nomeinterno."','$selecionagrupo->obrigatorio','$selecionagrupo->posicao','$selecionagrupo->status','$selecionagrupo->quantidade_minima','$selecionagrupo->quantidade','$selecionagrupo->idu')");

$selecionagrupoid 	= $connect->query("SELECT * FROM grupos WHERE nomegrupo='copia-".$selecionagrupo->nomegrupo."'");
$selecionagrupoid	= $selecionagrupoid->fetch(PDO::FETCH_OBJ);
$idgn 				= $selecionagrupoid->Id;

$selecionaopcionais = $connect->query("SELECT * FROM opcionais WHERE idg='$duplicargrupo'");
while ($selecionaopcionaisx = $selecionaopcionais->fetch(PDO::FETCH_OBJ)) {

$novocado = $connect->query("INSERT INTO opcionais(idu, idg, opnome, opdescricao, valor) VALUES ('$selecionaopcionaisx->idu','$idgn','$selecionaopcionaisx->opnome','$selecionaopcionaisx->opdescricao','$selecionaopcionaisx->valor')");

	}

if ( $cadgrupo ) { header("location: grupos.php?ok=ok"); exit; } else { header("location: grupos.php?erro=erro"); exit; }
	
}

//

if(isset($_POST["editopcional"]))  {
$idopcional 		= $_POST['idopcional'];
$nomeopcionais 		= $_POST['nomeopcionais'];
$descopcionais 		= $_POST['descopcionais'];
$valoropcionais		= $_POST['valoropcionais'];
$valoropcionais    	= str_replace(",", ".", $valoropcionais);
$editaropcionais 	= $connect->query("UPDATE opcionais SET opnome='$nomeopcionais', opdescricao='$descopcionais', valor='$valoropcionais' WHERE id='$idopcional' AND idu='$cod_id'");
if ( $editaropcionais ) { header("location: grupos.php?ok=ok"); exit; } else { header("location: grupos.php?erro=erro"); exit; }
}

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

if(isset($_POST["resetarb"]))  {

$bairros 	= $connect->query("DELETE FROM bairros WHERE idu='$cod_id'");
$categorias = $connect->query("DELETE FROM categorias WHERE idu='$cod_id'");
$grupos 	= $connect->query("DELETE FROM grupos WHERE idu='$cod_id'");
$opcionais 	= $connect->query("DELETE FROM opcionais WHERE idu='$cod_id'");
$produtos 	= $connect->query("DELETE FROM produtos WHERE idu='$cod_id'");
$tamanhos 	= $connect->query("DELETE FROM tamanhos WHERE idu='$cod_id'");
$final = "ok";

if ( $final ) { header("location: bannerelogo.php?ok=ok"); exit; } else { header("location: bannerelogo.php?erro=erro"); exit; }
}