<?php
include_once('../../funcoes/Conexao.php');
include_once('../../funcoes/Key.php');

if(isset($_POST["user_idx"])){

$idpro = $_POST["user_idx"];
	 
$empresa 		= $connect->query("SELECT * FROM config WHERE id='$idpro'"); 
$dadosempresa 	= $empresa->fetch(PDO::FETCH_OBJ);
	
}	
	?>
  
			 
	   		  
				 <div class="mg-b-10" align="center">
					<img src="img/local.jpg" class="img-fluid" />
				 </div>
			 
			<div class="card card-people-list pd-15 mg-b-10">
				<div class="slim-card-title"><i class="fa fa-caret-right"></i> <?php print $dadosempresa->nomeempresa; ?></div>
					<div class="media-list">
						<div class="mg-b-10 tx-14" align="center"><?php print $dadosempresa->rua; ?> - Nº <?php print $dadosempresa->numero; ?></div>
						<div class="mg-b-10 tx-14" align="center"><?php print $dadosempresa->bairro; ?> - <?php print $dadosempresa->cidade; ?> / <?php print $dadosempresa->uf; ?></div>
					</div>
				</div>
		    </div>

			