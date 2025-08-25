<?php
if(isset($_COOKIE['pdvx'])){
$cod_id = $_COOKIE['pdvx'];
} else {
header("location: sair.php"); 
}
include_once('../../funcoes/Conexao.php');
include_once('../../funcoes/Key.php');

if(!isset($_GET['id']) or $_GET['id'] == '') {
header("location: pdv.php"); 
exit;
}

$_GET['id'] = preg_replace("/[^0-9]/", "", $_GET['id']); 
$idPedido = $_GET['id'];
?>

<!DOCTYPE html>
<html lang="en">
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
    <link rel="stylesheet" href="../css/slim.css"><style type="text/css">
	.card-produto-edit {
		padding: 10px !important;
	}
	.img-produto-edit {
		margin-right: 10px !important;
	}
	.btn-adicionar-item, .div-card-adicionar-item {
		margin-top: 20px !important;
	}
	.card-categorias {
		margin-top: 10px !important;
	}
</style>
  </head>
  <body>
  
  	<div class="slim-navbar">
      <div class="container">
        <ul class="nav">
		  <li class="nav-item">
            <a class="nav-link" href="#">
              <span>
			   Editar pedido n° <?=$idPedido;?>
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
	
	
	<div class="section-wrapper mg-t-20 mg-b-20">
	
	<?php 
			    $item = $connect->query("SELECT * FROM store WHERE `idsecao` = $idPedido ORDER BY id DESC");
			  	while ($itemx = $item->fetch(PDO::FETCH_OBJ)) {
			  	$produto = $connect->query("SELECT * FROM produtos WHERE `id` = ".$itemx->produto_id." ORDER BY id DESC");
			  	while ($produtox = $produto->fetch(PDO::FETCH_OBJ)) {
				$opcionaisSelecionados = $connect->query("SELECT * FROM store_o WHERE idp = '".$itemx->idpedido."'");
				$opcionaisSelecionadosx = $opcionaisSelecionados->fetchAll(PDO::FETCH_ASSOC);
			    ?>
			<div class="row">
		 		
				
				<div class="col-md-6 col-12">
		 			<div class="card card-people-list pd-5 mg-b-10">
						<div class="media-list" style="margin-top:-1px">							
							<div class="media card-produto-edit">
								<img src="../img/fotos_produtos/<?php print $produtox->foto; ?>" style="width:80px; height:65px;" class="img-thumbnail img-produto-edit">
								<div class="media-body">
								<a href="" style="color:#666666">
									<span class="tx-15"><strong><?php print $produtox->nome; ?></strong></span><br>
									<span class="tx-14"><strong>R$ <?php print number_format($itemx->valor, 2, ',', '.'); ?></strong></span><br>
									<span class="tx-14"><strong><?php $itemx->tamanho = ($itemx->tamanho == "N") ? "" : $itemx->tamanho ; print $itemx->tamanho; ?></strong></span>
									<p class="tx-14">
										<?php
											$limite_op = $connect->query("SELECT * FROM limite_op WHERE idp='$produtox->id'");
											while ($limite_opx = $limite_op->fetch(PDO::FETCH_OBJ)) {
												$idgp = $limite_opx->idgrupo;
											 	$grupo_opxx  = $connect->query("SELECT * FROM grupos WHERE Id='$idgp' AND status='1' ORDER BY posicao ASC");
												while ($grupo_opx = $grupo_opxx->fetch(PDO::FETCH_OBJ)) {
											 		$idgpx = $grupo_opx->Id;

											 	print "<label>".$grupo_opx->nomegrupo."</label>";

												$opcionais = $connect->query("SELECT * FROM opcionais WHERE idg='$idgpx' AND status='1'");
												while ($opcionaisx = $opcionais->fetch(PDO::FETCH_OBJ)) {
													// print "<pre>"; print_r($opcionaisx); print "</pre>";
													// $opcionaisx->opnome
										?>
										 <div class="col-12 mg-t-10">
										 	<input <?php 
										 	if (!empty($opcionaisSelecionadosx)) {
											 	foreach ($opcionaisSelecionadosx as $key => $opcionalSelecionado) {
												 	$taman = $opcionalSelecionado['nome'];
													$array = explode(',',$taman); 
													$nome = $array[0];
	
													// print_r($nome)."<br>";

											 		// print "<pre>"; print_r($opcionaisSelecionadosx); print "</pre>";
											 		if ($opcionaisx->opnome == $nome) { // Aqui adiciona se o campo foi selecionado ou não
											 			print "checked";
											 		}	
											 		// print $opcionaisx->id."<br>";
											 		// print $opcionalSelecionado['id']."<br>"; 
											 	} 
										 	}
										 	?> type="checkbox" class='op_<?php print $opcionaisx->id; ?>' name="opcionais_edit_<?php print $itemx->id; ?>" value="<?php print $opcionaisx->opnome; ?>,<?php print $opcionaisx->valor; ?>," id="op_<?php print $opcionaisx->id; ?>">
										 	<label for="op_<?php print $opcionaisx->id; ?>"><?php print $opcionaisx->opnome; ?><strong> + <?php $valor = ($opcionaisx->valor == 0) ? "Grátis" : "R$ ".number_format($opcionaisx->valor, 2, ',', '.'); print $valor; ?></strong></label>
										 </div>
										
										<?php } ?>
										<?php
										  	}
										}
										?>
									</p>
								</a>
								</div>
								
								
								
							</div>
						</div>
					</div>	
		 		</div>
				
				<div class="col-md-2 col-12">
		 			<label>Observação</label>
			 		<textarea name="observacao_<?php print $itemx->id; ?>" id="observacao_<?php print $itemx->id; ?>" class="form-control"><?php print $itemx->obs; ?></textarea>
		 		</div>
				
		 		<div class="col-md-2 col-12">
		 			<label>Quantidade</label>
		 			<div class="col-xs-3 col-xs-offset-3">
						<div class="input-group number-spinner">
							<span class="input-group-btn">
								<button style="cursor: pointer;" onClick="fnPainel.removeQuantidade('quantidade_<?php print $itemx->id; ?>')" type="button" class="btn btn-default" data-dir="dwn"><i class="fa fa-minus" aria-hidden="true"></i></span></button>
							</span>
							<input type="number" id="quantidade_<?php print $itemx->id; ?>" name="quantidade_<?php print $itemx->id; ?>" class="form-control text-center" value="<?php print $itemx->quantidade; ?>" required>
							<span class="input-group-btn">
								<button style="cursor: pointer;" onClick="fnPainel.addQuantidade('quantidade_<?php print $itemx->id; ?>')" type="button" class="btn btn-default" data-dir="up"><i class="fa fa-plus" aria-hidden="true"></i></span></button>
							</span>
						</div>
					</div>
		 		</div>
		 		
				
				

		 		

		 		<div class="col-md-1 col-12">
		 			<label> </label><br>
		 			<button onClick="fnPainel.updateItemPedido(<?php print $itemx->id; ?>, '<?php print $itemx->idpedido; ?>')" class="btn btn-success"><span class="fa fa-save"></span></button>
		 		</div>
				
				
				<div class="col-md-1 col-12">
		 		<label> </label><br>
				<button onClick="fnPainel.deleteItemPedido('<?php print $itemx->idpedido; ?>')" type="button" class="btn btn-danger"><span class="fa fa-trash"></span></button>
				</div>
				
				
				
				
		 	
			</div>		

			
	
	
	
	
	
	
	<?php }
				}?>
		</div>
	
		<div class="row">
		
		
			<div class="col-md-6 col-12">
	
				<div id="accordion">
						<?php 
							$categorias = $connect->query("SELECT * FROM categorias WHERE idu = '$cod_id'");
							while ($categoriasx = $categorias->fetch(PDO::FETCH_OBJ)) {
						?>	
						<div class="col-md-12 col-12">

						  <div style="cursor: pointer;" class="card card-categorias">
						  	<div  data-toggle="collapse" data-target="#categoria_<?php print $categoriasx->id; ?>" aria-expanded="false" aria-controls="#categoria_<?php print $categoriasx->id; ?>" class="card-header" id="headingOne">
						      <h5 class="mb-0">
						      	<img style="width:80px; height:65px;" class="img-thumbnail" src="../img/categoria/<?php print $categoriasx->url; ?>">
						        <?php print $categoriasx->nome ?>
						      </h5>
						    </div>

						    <div id="categoria_<?php print $categoriasx->id; ?>" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
						      <div class="card-body">
						       	<!-- Lista de fotos_produtos -->
						       	<?php 
						       		$produtos = $connect->query("SELECT * FROM produtos WHERE idu = '$cod_id' AND categoria = ".$categoriasx->id." AND status='1'");

									while ($produtox = $produtos->fetch(PDO::FETCH_OBJ)) {
										// print "<pre>"; print_r($produtox); print "</pre>";
						       	?>
								<div class="col-md-12 col-12">
						 			<div class="card card-people-list pd-15 mg-b-10">
										<div class="media-list">							
											<div class="media card-produto-edit">
												<img src="../img/fotos_produtos/<?php print $produtox->foto; ?>" style="width:80px; height:65px;" class="img-thumbnail img-produto-edit">
												<div class="media-body">
													<a style="color:#666666">
													<span class="tx-15"><strong><?php print $produtox->nome; ?></strong></span><br>
													<span class="tx-15"><strong>R$ <?php print number_format($produtox->valor, 2, ',', '.'); ?></strong></span><br>

													<?php 
														$ctamx	= $connect->query("SELECT * FROM tamanhos WHERE idp = '$produtox->id' AND idu='$cod_id' AND status='1'");
														$qntta  = $ctamx->rowCount();
													?>
													<?php if($qntta >='1'){ ?>
													<hr>
													<div class="slim-card-title" style="color:#CC3300">Escolha o Tamanho <span style="color:#FF0000">*</span></div>
													<div class="row  mg-t-10">
													<?php while ($protam = $ctamx->fetch(PDO::FETCH_OBJ)) { ?>
													<div class="col-6 mg-t-10"><input type="radio" name="tamanho_<?php print $produtox->id ?>" checked value="<?php print $protam->descricao; ?>,<?php print $protam->valor;?>" required> - <span><span for=""><?php print $protam->descricao; ?></span></span></div>
													<div class="col-6 tx-14 mg-t-10">R$: <?php print $protam->valor; ?></div>
													<?php } ?>	 
													</div>
													<?php } ?>
													<?php
														$limite_op = $connect->query("SELECT * FROM limite_op WHERE idp='$produtox->id'");
														while ($limite_opx = $limite_op->fetch(PDO::FETCH_OBJ)) {
															$idgp = $limite_opx->idgrupo;
														 	$grupo_opxx  = $connect->query("SELECT * FROM grupos WHERE Id='$idgp' AND status='1' ORDER BY posicao ASC");
															while ($grupo_opx = $grupo_opxx->fetch(PDO::FETCH_OBJ)) {
														 		$idgpx = $grupo_opx->Id;

														 	print "<label>".$grupo_opx->nomegrupo."</label>";

															$opcionais = $connect->query("SELECT * FROM opcionais WHERE idg='$idgpx' AND status='1'");
															while ($opcionaisx = $opcionais->fetch(PDO::FETCH_OBJ)) {
																// print "<pre>"; print_r($opcionaisx); print "</pre>";
																// $opcionaisx->opnome
													?>
													 <div class="col-12 mg-t-10">
													 	<input <?php 
													 	if (!empty($opcionaisSelecionadosx)) {
														 	foreach ($opcionaisSelecionadosx as $key => $opcionalSelecionado) {
															 	$taman = $opcionalSelecionado['nome'];
																$array = explode(',',$taman); 
																$nome = $array[0];
				
																// print_r($nome)."<br>";

														 		// print "<pre>"; print_r($opcionaisSelecionadosx); print "</pre>";
														 		if ($opcionaisx->opnome == $nome) { // Aqui adiciona se o campo foi selecionado ou não
														 			print "checked";
														 		}	
														 		// print $opcionaisx->id."<br>";
														 		// print $opcionalSelecionado['id']."<br>"; 
														 	} 
													 	}
													 	?> type="checkbox" class='op_edit_<?php print $opcionaisx->id; ?>' name="opcionais_<?php print $produtox->id; ?>" value="<?php print $opcionaisx->opnome; ?>,<?php print $opcionaisx->valor; ?>," id="op_edit_<?php print $opcionaisx->id; ?>">
													 	<label for="op_edit_<?php print $opcionaisx->id; ?>"><?php print $opcionaisx->opnome; ?><strong> + <?php $valor = ($opcionaisx->valor == 0) ? "Grátis" : "R$ ".number_format($opcionaisx->valor, 2, ',', '.'); print $valor; ?></strong></label>
													 </div>
													
													<?php } ?>
													<?php
													  	}
													}
													?>
													</a>

													<div class="col-xs-3 col-xs-offset-3">
														<div class="input-group number-spinner">
															<span class="input-group-btn">
																<button style="cursor: pointer;" onClick="fnPainel.removeQuantidade('quantidade_add_<?php print $produtox->id; ?>')" type="button" class="btn btn-default btn-danger" data-dir="dwn"><i class="fa fa-minus" aria-hidden="true"></i></span></button>
															</span>
															<input type="number" id="quantidade_add_<?php print $produtox->id; ?>" name="quantidade_add_<?php print $produtox->id; ?>" class="form-control text-center" value="1" required>
															<span class="input-group-btn">
																<button style="cursor: pointer;" onClick="fnPainel.addQuantidade('quantidade_add_<?php print $produtox->id; ?>')" type="button" class="btn btn-default btn-success" data-dir="up"><i class="fa fa-plus" aria-hidden="true"></i></span></button>
															</span>
														</div>
													</div>
												</div>
												<button onClick="fnPainel.addItemPedido(<?php print $produtox->id; ?>)" class="btn btn-success btn-sm">
													<i class="fa fa-plus mg-r-5"></i> Adicionar
												</button>
											</div>
										</div>
									</div>	
			 					</div> 
								<?php } ?>	

						      </div>
						    </div>
						  </div>
						</div>
						<?php } ?>
					</div>
				
				</div>
				
				<div class="col-md-6 col-12">
	
				<div class="section-wrapper mg-t-20 mg-b-20">
				33333
				</div>
				
				</div>
	
	 </div>
			
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
	</div>	
</div>	  
	  
	  
	  
	  
	  
	  
	  
	  
	  
	  
	  
	  


    	 
	 
</body>
</html>