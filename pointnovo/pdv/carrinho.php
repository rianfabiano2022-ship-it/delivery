	   		<div class="card card-people-list pd-15 mg-b-10">
				<div class="slim-card-title"><i class="fa fa-caret-right"></i> PEDIDOS</div>
						<?php 
						if($produtoscx>0){ ?>
						<div align="center"><span class="tx-11">Comanda nº <?php print $id_cliente; ?></span></div>
						<?php } ?>
						<div class="media-list">
						<?php 
						while ($carpro = $produtosca->fetch(PDO::FETCH_OBJ)) { 
						$nomepro  = $connect->query("SELECT nome FROM produtos WHERE id = '".$carpro->produto_id."' AND idu='$idu'");
						$nomeprox = $nomepro->fetch(PDO::FETCH_OBJ);
						?>
						<div><span class="tx-12"><i class="fa fa-square tx-8 mg-r-5"></i> Ítem: <strong><?php print $nomeprox->nome;?></strong></span></div>
						<?php if($carpro->tamanho != "N" ) { ?>
						<div><span class="tx-12"><i class="fa fa-square tx-8 mg-r-5"></i> Tamanho: <strong><?php print $carpro->tamanho;?></strong></span></div>
						<?php } ?>
						<div><span class="tx-12"><i class="fa fa-square tx-8 mg-r-5"></i> Qnt: <strong><?php print $carpro->quantidade; ?></strong></span></div>
						<div>
						<span class="tx-12">
						<?php echo "<i class=\"fa fa-square tx-8 mg-r-5\"></i> V. Unitário: <strong >R$: ".$carpro->valor."</strong >"; ?>
						</span>
						</div>
						<div>
						<span class="tx-12">
						
						<?php
						$meiom  = $connect->query("SELECT * FROM store_o WHERE idp = '".$carpro->idpedido."' AND status = '1' AND idu='$idu' AND meioameio='1'"); 
						$meiomc = $meiom->rowCount();
						?>
						<?php if($meiomc>0){ ?>
						<i class="fa fa-square tx-8 mg-r-5"></i> <?=$meiomc;?> Sabores:<br><strong>
						<?php while ($meiomv = $meiom->fetch(PDO::FETCH_OBJ)) {
						echo "- ".$meiomv->nome."<br>"; 
						} ?>
						</strong> 
						<?php } ?>
						
						<?php
						$adcionais  = $connect->query("SELECT * FROM store_o WHERE idp = '".$carpro->idpedido."' AND status = '1' AND idu='$idu' AND meioameio='0'"); 
						$adcionaisc = $adcionais->rowCount();
						?>
						<?php if($adcionaisc>0){ ?>
						<i class="fa fa-square tx-8 mg-r-5"></i> Adicionais:<br><strong>
						<?php while ($adcionaisv = $adcionais->fetch(PDO::FETCH_OBJ)) {
						echo "-  R$: ".$adcionaisv->valor." | <strong>".$adcionaisv->nome."</strong><br>";
						} ?>
						</strong> 
						<?php } ?>
						</span>
						</div>
						<div align="right">
						<a href="pdvpedido.php?apagaritem=<?php print $carpro->idpedido;?>&idce=<?=$id_cliente;?>" style="color:#CC0000"><i class="fa fa-minus-square mg-r-5 tx-danger tx-9"></i><span class="tx-12">Excluir</span></a>
						</div>
						<hr>
						<?php } ?>
						
						
						
						<?php if($produtoscx >=1) { ?>
						</div>
						<div class="row">
							 <div class="col-6">SubTotal</div>
							 <div class="col-6">R$: <?php if(isset($somando->soma)){ echo number_format($somando->soma, 2, ',', ' '); } else { print "0,00";} ?></div>
						</div>
					 
						<div class="row mg-t-10">
							 <div class="col-6">Adicionais</div>
							 <div class="col-6">R$: 
							<?php
							$opcionais  = $connect->query("SELECT valor, quantidade FROM store_o WHERE ids = '".$id_cliente."' AND status = '1' AND idu='$idu' AND meioameio='0'");
							$sumx=0;
							while ($valork = $opcionais->fetch(PDO::FETCH_OBJ)) {
							$quantop = $valork->quantidade;
							$valorop = $valork->valor;
							$totais = $valorop * $quantop;
						 	$sumx += $totais;
							} 
							echo $opctg = number_format($sumx, 2, ',', ' '); 
							?>
							</div>
						 </div>
					 
						 <div class="row  mg-t-10">
							 <div class="col-6 tx-16"><strong>Total Geral</strong></div>
							 <div class="col-6 tx-16"><strong>R$: <?php if(isset($somando->soma)){$geral = $somando->soma + $sumx; echo $gx = number_format($geral, 2, ',', '.');} else { print "0,00";} ?></strong></div>
						 </div>
						 <?php if($geral > $dadosempresa->dfree) { $_SESSION["ent_gratis"] = "okg"; ?>
						 <hr>
						 <div class="alert alert-success" role="alert" style="margin-bottom:-5px">
                         <strong class="tx-success"><i class="fa fa-thumbs-o-up mg-r-5"></i> Entrega Grátis.</strong>
                         </div>
						 <?php } else { unset( $_SESSION['ent_gratis'] ); }?>
						 						 
						<div class="media-list">
							   
							  <?php if($dadosempresa->delivery==1) { ?>
							  <label class="rdiobox ckbox-success">
								<a href="pdvdelivery.php?idpedido=<?=$id_cliente;?>&tipo=delivery"><button class="btn btn-success btn-block" name="cart">Pedido Delivery <i class="fa fa-arrow-right mg-l-10"></i></button></a>
							  </label>
							  <?php } ?>
							  <?php if($dadosempresa->balcao==1) { ?>
							  <label class="rdiobox ckbox-success mg-t-15">
								<a href="pdvbalcao.php?idpedido=<?=$id_cliente;?>&tipo=balcao"><button class="btn btn-purple btn-block" name="cart">Pedido no Balcão <i class="fa fa-arrow-right mg-l-10"></i></button></a>
							  </label>
							  <?php } ?>
							  <?php if($dadosempresa->mesa==1) { ?>
							  <label class="rdiobox ckbox-success mg-t-15">
								<a href="pdvmesa.php?idpedido=<?=$id_cliente;?>&tipo=mesa"><button class="btn btn-danger btn-block" name="cart">Pedido na Mesa <i class="fa fa-arrow-right mg-l-10"></i></button></a>
							  </label>
							   <?php } ?>
							  <hr>
					    </div>
						 
						 
					      
						</div>
						 <?php } else { ?>
						  <div align="center" style="margin-top:-10px; margin-bottom:10px;"><img src="../img/cart_off.png" style="width:55px; height:50px;"/><br>Carrinho Vazio</div>
						 <?php } ?>
			</div>
			</div>		