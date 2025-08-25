<?php
if($produtoscx==0){ header("location: ".$site.""); exit; }
?>
<div class="slim-navbar sticky-top" style="background-color:<?php print $dadosempresa->cormenu; ?>">
	<div class="container">
		<ul class="nav">
          
		  <li class="nav-item">
            <a class="nav-link" href="./delivery" style="color:#FFFFFF; background-color:#00CC00">
              PEDIDO DELIVERY
            </a>
          </li>
		  
		</ul>
	</div> 
</div> 

<div class="slim-mainpanel">
      <div class="container">
	  
	   <div class="row mg-t-10">
	   
	   <div class="col-md-3">
	   			
				<?php if(isset($_GET["erro"])){?>
				<div class="alert alert-warning" role="alert">
            	<i class="fa fa-asterisk" aria-hidden="true"></i> Nº do celular inválido.
          		</div>
				<?php }?>
				<?php if(isset($_GET["troco"])){?>
				<div class="alert alert-warning" role="alert">
            	<i class="fa fa-asterisk" aria-hidden="true"></i> Valor do troco não pode ser menor do que o valor total do pedido.
          		</div>
				<?php }?>
	   
				<div class="card card-people-list pd-15 mg-b-10 d-none d-lg-block">
					<div class="slim-card-title"><i class="fa fa-caret-right"></i> CATEGORIAS</div>
						<div class="media-list">
							<?php while ($cathome = $categorias->fetch(PDO::FETCH_OBJ)) { ?>	
							<div class="media">
							<a href="./#<?php echo $cathome->id;?>">
							<img src="img/categoria/<?php if(!$cathome->url){echo "off.jpg";}else{ print $cathome->url;}?>" style="width:30px; height:30px;" alt="">
							</a>
							<div class="media-body">
							<a href="./#<?php echo $cathome->id;?>" style="color:#000000"><?php print $cathome->nome;?></a>
							</div>
							<a href="./#<?php echo $cathome->id;?>" style="color:#000000"><i class="fa fa-chevron-circle-right"></i></a>
							</div>
							<?php } ?>	
						</div>
				</div>
				
				<div id="accordion" class="accordion-one mg-b-10 d-lg-none" role="tablist" aria-multiselectable="true">
					<div class="card">
					  <div class="card-header" role="tab" id="headingTwo">
						<a class="collapsed tx-gray-800 transition" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
						  <i class="fa fa-bars mg-r-10"></i> CONTINUAR COMPRANDO
						</a>
					  </div>
					  <div id="collapseTwo" class="collapse" role="tabpanel" aria-labelledby="headingTwo">
						<div class="card-body">
							  <div class="card-people-list pd-5">	
								  <div class="media-list" style="margin-top:-10px">
									<?php while ($cathomem = $categoriasm->fetch(PDO::FETCH_OBJ)) { ?>	
									<div class="media">
									<a href="./#<?php echo $cathomem->id;?>">
									<img src="img/categoria/<?php if(!$cathomem->url){echo "off.jpg";}else{ print $cathomem->url;}?>" style="width:30px; height:30px;" alt="">
									</a>
									<div class="media-body">
									<a href="./#<?php echo $cathomem->id;?>" style="color:#000000"><?php print $cathomem->nome;?></a>
									</div>
									<a href="./#<?php echo $cathomem->id;?>" style="color:#000000"><i class="fa fa-chevron-circle-right"></i></a>
									</div>
									<?php } ?>	
								 </div>
							 </div>
						</div>
					  </div>
				   </div>
				</div>
			
	   </div>
	   
	   <div class="col-md-6">
	   		
			<div class="card card-people-list pd-15 mg-b-10">
				
					
					
					   <div class="row">
							<div class="col-lg-12">
							<div align="center"><i class="fa fa-hourglass-end mg-r-5" aria-hidden="true"></i>O Tempo aproximado para entrega é de <b><?php print $dadosempresa->timerdelivery; ?></b></div> 
							</div>
					    </div>
					
					<hr>
					
					<?php if($somando->soma > $dadosempresa->dfree ) { ?>
						<div class="row mg-b-10">
						    <div align="center" class="col-lg-12">
    						    <div class="alert alert-success" role="alert">
                                    <strong class="tx-success"><i class="fa fa-thumbs-o-up mg-r-5"></i> Entrega Grátis.</strong>
                                </div>
						    </div>
						</div>
					<?php } ?>
					
					<div class="media-list">
					
					    <div class="row" style="margin-top:-30px">
							<div class="col-lg-12">
							<div class="slim-card-title"><i class="fa fa-caret-right"></i> INFORME OS DADOS ABAIXO</div>
							</div>
					    </div>
						<br>
						<form action="delivery_ok" method="post">
						
					<div class="row">
							
							
							<div class="col-lg-12">
								<div class="form-group">
								<label class="form-control-label">Bairros e Regiões atendidas : <span class="tx-danger">*</span></label>
								<?php if(empty($_GET["bairro"])){ ?>
                        		  <select id="select-taxa" class="form-control select2-show-search" required>
                        		  <?php } else { ?>
                        		  <select id="select-taxa" class="form-control select2-show-search">
                        		  <?php  } ?>
								<option value="">Selecione...</option>								
								<?php
								$lerbanco  = $connect->query("SELECT * FROM bairros WHERE idu='".$idu."'");
								while ($taxabairro = $lerbanco->fetch(PDO::FETCH_OBJ)) { 
								?>
								<option value="delivery&bairro=<?=$taxabairro->id;?>">Taxa de R$: <?php echo $taxabairro->taxa;?> - <?php echo $taxabairro->bairro;?></option> 
								
								<?php } ?>
								</select>
								</div>
							</div>
							
						</div>	
						<?php $taxa = "0.00"; ?>
						<?php if(isset($_GET["bairro"])){ ?>
						
						<div class="row">
							
							<div class="col-lg-8">
								<div class="form-group">
									<label class="form-control-label">Bairro/Região: </label>
									<div class="input-group">
									<?php if(isset($_GET["bairro"])){ $idbairro = $_GET["bairro"]; 
									$pegabairro = $connect->query("SELECT * FROM bairros WHERE id='".$idbairro."'");
									$pegabairro	= $pegabairro->fetch(PDO::FETCH_OBJ); ?>
									<input type="text" class="form-control" value="<?=$pegabairro->bairro;?>" disabled="disabled">
									<input  type="hidden" name="bairro" value="<?=$pegabairro->bairro;?>">
									<?php } else { ?>
									<input type="text" class="form-control" value="Aguardando" disabled="disabled">
									<input  type="hidden" name="bairro" value="0">
									<?php } ?>
									</div>
								</div>
							</div>
							
									<?php if(isset($_GET["bairro"])){ 
									$idbairro = $_GET["bairro"];
									$pegataxa = $connect->query("SELECT * FROM bairros WHERE id='".$idbairro."'");
									$pegataxa	= $pegataxa->fetch(PDO::FETCH_OBJ); 
									?>
									
									<?php if($somando->soma > $dadosempresa->dfree ) { ?>
									<input  type="hidden" name="taxa" value="0.00">
									<?php $taxa = "0.00"; ?>
									<?php } else { ?>
									<input  type="hidden" name="taxa" value="<?=$pegataxa->taxa;?>">
									<?php $taxa = $pegataxa->taxa;?>
									<?php } ?>
									
									<?php } ?>
									
							
						<div class="col-lg-4">
							<div class="form-group">
								<label class="form-control-label">Informe seu CEP: </label>
								<div class="input-group">
								<input type="text" class="form-control" name="cep" id="cep" value="" maxlength="8">
								</div>
							</div>
						</div>
						 
						</div>
						
						<div class="row">
							<div class="col-lg-12">
								<div class="form-group">
								<label class="form-control-label">Endereço: </label>
								<div class="input-group">
								<input type="text" class="form-control" name="rua" id='rua' value="" required>
								</div>
							</div>
						</div>
						
						</div>
						
						<div class="row">
							
							<div class="col-lg-3">
								<div class="form-group">
									<label class="form-control-label">Nº: <span class="tx-danger">*</span></label>
									<div class="input-group">
									<input type="number" class="form-control" name="numero" maxlength="5" <?php if(isset($_COOKIE['numero'])){ ?> value="<?php print $_COOKIE['numero']; ?>" <?php } ?> required>
								 	</div>
								</div>
							</div>
							
							<div class="col-lg-9">
								<div class="form-group">
									<label class="form-control-label">Complemento/Ponto de Referência: </label>
									<input class="form-control" type="text" name="complemento" <?php if(isset($_COOKIE['comp'])){ ?> value="<?php print $_COOKIE['comp']; ?>" <?php } ?> maxlength="50">
								</div>
							</div>
							
						</div>
						
						<hr>
						
						<div class="row">
							<div class="col-lg-6">
								<div class="form-group">
								<label class="form-control-label">Nº do seu WhatsApp: <span class="tx-danger">*</span></label>
								<div class="input-group">
									</div>
									<input type="text" id="cel" placeholder="(99)99999-9999" name="wps" class="form-control" <?php if(isset($_COOKIE['celcli'])){ ?> value="<?php print $_COOKIE['celcli']; ?>" <?php } ?> required>
									</div>
								</div>
							<div class="col-lg-6">
								<div class="form-group">
								<label class="form-control-label">Primeiro Nome: <span class="tx-danger">*</span></label>
								<div class="input-group">
									<input type="text" name="nome" class="form-control" maxlength="30" <?php if(isset($_COOKIE['nomecli'])){?> value="<?php print $_COOKIE['nomecli']; ?>" <?php } ?> required>
								 </div>
								</div>
							</div>
						</div>
						<hr>
						<div class="row">
							<div class="col-lg-6">
								<div class="form-group">
								<label class="form-control-label">Forma de Pagamento: <span class="tx-danger">*</span></label>
								<select id="options" class="form-control select2" onchange="verifica(this.value)" name="fmpgto" required>
								<option value="" disabled selected><b>Selecione...</b></option>
								<option value="DINHEIRO">Dinheiro</option>
								<option value="PIX">PIX</Option>
								<option value="CARTAO">Cartão</option>
								</select>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
								<label class="form-control-label">Troco?: </label>
								<div class="input-group">
									<input type="text" name="troco" id="troco" value="0,00" class="dinheiro form-control">
								  </div>
								</div>
							</div>
						</div> 
						 
						 
						
						 
							
							
							 
						<input type="hidden" name="cidade" value="<?php echo $dadosempresa->cidade;?>">
						<input type="hidden" name="uf" value="<?php echo $dadosempresa->uf;?>">
						 
 								    
						<?php } ?>		
									 
								
								 
						
					</div>
			</div>
			 
	   </div>
	   
	   <div class="col-md-3">
	   		<div class="card card-people-list pd-15 mg-b-10" style="background-color:<?php print $dadosempresa->corcarrinho; ?>">
				 <input type="hidden" name="subtotal" class="form-control" value="<?php echo $subtotal = number_format($somando->soma, 2, ',', ' ');  ?>">
				 <?php
							// AQUI ESTÁ A CORREÇÃO
							$opcionais  = $connect->query("SELECT valor, quantidade FROM store_o WHERE ids = '".session_id()."' AND status = '0' AND idu='$idu' AND meioameio='0'");
							$sumx=0;
							while ($valork = $opcionais->fetch(PDO::FETCH_OBJ)) {
							$quantop = $valork->quantidade;
							$valorop = $valork->valor;
							$totais = $valorop * $quantop;
						 	$sumx += $totais;
							} 
							?>		
				  <input type="hidden" name="adcionais" class="form-control" value="<?php echo number_format($sumx, 2, ',', ' ');  ?>">	 
			 			 <?php if($taxa > 0){?>
 						 <div class="row mg-t-10" style="color: #FF3333">
							 <div class="col-7"><strong>Taxa de Entrega</strong></div>
							 <div class="col-5"><strong>R$: <?=$taxa;?> </strong></div>
						 </div>
						 <?php } ?>
						 
						 <div class="row  mg-t-10">
							 <div class="col-7 tx-16"><strong>Total Geral</strong></div>
							 <div class="col-5 tx-16"><strong>R$:<?php if(isset($somando->soma)){$geral = $somando->soma + $sumx + $taxa; echo $gx = number_format($geral, 2, ',', '.');} else { print "0,00";} ?> 
							 </strong>
							 </div>
						 </div>
						 
						<input type="hidden" name="totalg" class="form-control" value="<?=$geral;?>">	 
						 
					 	 <hr>
					     <button type="submit" class="btn btn-success" name="cart">Concluir Pedido <i class="fa fa-arrow-right mg-l-5"></i></button>
						 </form>
						 
						   
			</div>
			 
	   	</div>
	</div>
</div>