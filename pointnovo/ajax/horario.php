<?php
include_once('../../funcoes/Conexao.php');
include_once('../../funcoes/Key.php');

if(isset($_POST["user_idx"])){
$idpro = $_POST["user_idx"];
	 
$empresa 		= $connect->query("SELECT * FROM config WHERE id='$idpro'"); 
$dadosempresa 	= $empresa->fetch(PDO::FETCH_OBJ);

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
	
}	
	?>
			 <div class="row">
				 
				 <?php $arrayxw = explode(',',$seg); ?>
				 <div class="col-12">
					 <div class="card pd-15 mg-b-10">
						<div class="slim-card-title"><i class="fa fa-caret-right"></i> Segunda - Feira:</div>
						<center>
						<br>
						<strong>Dia:</strong> 
						<?php if($arrayxw[0] === "00:00:00") { print "<span style=\"color:#FF0000\">Fechado</span>"; } else { print $arrayxw[0]; }?> /
						<?php if($arrayxw[1] === "00:00:00") { print "<span style=\"color:#FF0000\">Fechado</span>"; } else { print $arrayxw[1]; }?><br><br>
						<strong>Noite:</strong> 
						<?php if($arrayxw[2] === "00:00:00") { print "<span style=\"color:#FF0000\">Fechado</span>"; } else { print $arrayxw[2]; }?> /
						<?php if($arrayxw[3] === "00:00:00") { print "<span style=\"color:#FF0000\">Fechado</span>"; } else { print $arrayxw[3]; }?>
						</center>
					 </div>
				 </div>
			
			</div>
				 
			<div class="row">	 
				 
				 <?php $arrayxq = explode(',',$ter); ?>
				 <div class="col-12">
					 <div class="card pd-15 mg-b-10">
						<div class="slim-card-title"><i class="fa fa-caret-right"></i> Terça - Feira:</div>
						<center>
						<br>
						<strong>Dia:</strong> 
						<?php if($arrayxq[0] === "00:00:00") { print "<span style=\"color:#FF0000\">Fechado</span>"; } else { print $arrayxq[0]; }?> /
						<?php if($arrayxq[1] === "00:00:00") { print "<span style=\"color:#FF0000\">Fechado</span>"; } else { print $arrayxq[1]; }?><br><br>
						<strong>Noite:</strong> 
						<?php if($arrayxq[2] === "00:00:00") { print "<span style=\"color:#FF0000\">Fechado</span>"; } else { print $arrayxq[2]; }?> /
						<?php if($arrayxq[3] === "00:00:00") { print "<span style=\"color:#FF0000\">Fechado</span>"; } else { print $arrayxq[3]; }?>
						</center>
					 </div>
				 </div>
			 
			 </div>
			
			
			 <div class="row">
				 
				 <?php $arrayxr = explode(',',$qua); ?>
				 <div class="col-12">
					 <div class="card pd-15 mg-b-10">
						<div class="slim-card-title"><i class="fa fa-caret-right"></i> Quarta - Feira:</div>
						<center>
						<br>
						<strong>Dia:</strong> 
						<?php if($arrayxr[0] === "00:00:00") { print "<span style=\"color:#FF0000\">Fechado</span>"; } else { print $arrayxr[0]; }?> /
						<?php if($arrayxr[1] === "00:00:00") { print "<span style=\"color:#FF0000\">Fechado</span>"; } else { print $arrayxr[1]; }?><br><br>
						<strong>Noite:</strong> 
						<?php if($arrayxr[2] === "00:00:00") { print "<span style=\"color:#FF0000\">Fechado</span>"; } else { print $arrayxr[2]; }?> /
						<?php if($arrayxr[3] === "00:00:00") { print "<span style=\"color:#FF0000\">Fechado</span>"; } else { print $arrayxr[3]; }?>
						</center>
					 </div>
				 </div>
				 
				 </div>
				 
			     <div class="row">	
				 
				<?php $arrayxl = explode(',',$qui); ?>
				 <div class="col-12">
					 <div class="card pd-15 mg-b-10">
						<div class="slim-card-title"><i class="fa fa-caret-right"></i> Quinta - Feira:</div>
						<center>
						<br>
						<strong>Dia:</strong> 
						<?php if($arrayxl[0] === "00:00:00") { print "<span style=\"color:#FF0000\">Fechado</span>"; } else { print $arrayxl[0]; }?> /
						<?php if($arrayxl[1] === "00:00:00") { print "<span style=\"color:#FF0000\">Fechado</span>"; } else { print $arrayxl[1]; }?><br><br>
						<strong>Noite:</strong> 
						<?php if($arrayxl[2] === "00:00:00") { print "<span style=\"color:#FF0000\">Fechado</span>"; } else { print $arrayxl[2]; }?> /
						<?php if($arrayxl[3] === "00:00:00") { print "<span style=\"color:#FF0000\">Fechado</span>"; } else { print $arrayxl[3]; }?>
						</center>
					 </div>
				 </div>
			 
			 </div>
			 
			 <div class="row">
				 
				 <?php $arrayxs = explode(',',$sex); ?>
				 <div class="col-12">
					 <div class="card pd-15 mg-b-10">
						<div class="slim-card-title"><i class="fa fa-caret-right"></i> Sexta - Feira:</div>
						<center>
						<br>
						<strong>Dia:</strong> 
						<?php if($arrayxs[0] === "00:00:00") { print "<span style=\"color:#FF0000\">Fechado</span>"; } else { print $arrayxs[0]; }?> /
						<?php if($arrayxs[1] === "00:00:00") { print "<span style=\"color:#FF0000\">Fechado</span>"; } else { print $arrayxs[1]; }?><br><br>
						<strong>Noite:</strong> 
						<?php if($arrayxs[2] === "00:00:00") { print "<span style=\"color:#FF0000\">Fechado</span>"; } else { print $arrayxs[2]; }?> /
						<?php if($arrayxs[3] === "00:00:00") { print "<span style=\"color:#FF0000\">Fechado</span>"; } else { print $arrayxs[3]; }?>
						</center>
					 </div>
				 </div>
				 
				 </div>
				 
			     <div class="row">	
				 
				<?php $arrayxk = explode(',',$sab); ?>
				 <div class="col-12">
					 <div class="card pd-15 mg-b-10">
						<div class="slim-card-title"><i class="fa fa-caret-right"></i> Sábado:</div>
						<center>
						<br>
						<strong>Dia:</strong> 
						<?php if($arrayxk[0] === "00:00:00") { print "<span style=\"color:#FF0000\">Fechado</span>"; } else { print $arrayxk[0]; }?> /
						<?php if($arrayxk[1] === "00:00:00") { print "<span style=\"color:#FF0000\">Fechado</span>"; } else { print $arrayxk[1]; }?><br><br>
						<strong>Noite:</strong> 
						<?php if($arrayxk[2] === "00:00:00") { print "<span style=\"color:#FF0000\">Fechado</span>"; } else { print $arrayxk[2]; }?> /
						<?php if($arrayxk[3] === "00:00:00") { print "<span style=\"color:#FF0000\">Fechado</span>"; } else { print $arrayxk[3]; }?>
						</center>
					 </div>
				 </div>
			 
			 </div>			
		
			<div class="row">
				 
				 <?php $arrayxy = explode(',',$dom); ?>
				 <div class="col-12">
					 <div class="card pd-15 mg-b-10">
						<div class="slim-card-title"><i class="fa fa-caret-right"></i> Domingo:</div>
						<center>
						<br>
						<strong>Dia:</strong> 
						<?php if($arrayxy[0] === "00:00:00") { print "<span style=\"color:#FF0000\">Fechado</span>"; } else { print $arrayxy[0]; }?> /
						<?php if($arrayxy[1] === "00:00:00") { print "<span style=\"color:#FF0000\">Fechado</span>"; } else { print $arrayxy[1]; }?><br><br>
						<strong>Noite:</strong> 
						<?php if($arrayxy[2] === "00:00:00") { print "<span style=\"color:#FF0000\">Fechado</span>"; } else { print $arrayxy[2]; }?> /
						<?php if($arrayxy[3] === "00:00:00") { print "<span style=\"color:#FF0000\">Fechado</span>"; } else { print $arrayxy[3]; }?>
						</center>
					 </div>
				 </div>
				 			 
			 </div>