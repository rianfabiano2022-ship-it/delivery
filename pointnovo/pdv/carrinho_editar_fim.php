	   		<div class="card card-people-list pd-15 mg-b-10">
				<div class="slim-card-title"><i class="fa fa-caret-right"></i> FECHAR PEDIDO</div>
						<?php 
						if($produtoscx>0){ ?>
						<div align="center"><span class="tx-11">Comanda nº <?php print $id_cliente; ?></span></div>
						<?php } ?>
						
						
						
						
						
						<?php if($produtoscx >=1) { ?>
						 <hr>
						<div class="row">
							 <div class="col-6">SubTotal</div>
							 <div class="col-6">R$: <?php if(isset($somando->soma)){ echo number_format($somando->soma, 2, ',', ' '); } else { print "0,00";} ?></div>
						</div>
					    <input type="hidden" name="subtotal" class="form-control" value="<?php echo $somando->soma;?>">
						
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
							<input type="hidden" name="adcionais" class="form-control" value="<?php echo $sumx;?>">
							</div>
						 </div>
						 
						 <?php if(isset($_GET["free"])){?>
						 <div class="row mg-t-10">
							 <div class="col-6">Taxa de Entrega</div>
							 <div class="col-6">R$: <?php echo $_GET["taxa"];?> 
							<input type="hidden" name="taxa" value="<?php echo $_GET["taxa"];?>">
							</div>
						 </div>
						 <?php } ?>
						 
						 <?php if(isset($_GET["pago"])){?>
						 <div class="row mg-t-10">
							 <div class="col-6">Taxa de Entrega</div>
							 <div class="col-6">R$: <?php echo $_GET["taxa"];?> 
							<input type="hidden" name="taxa" value="<?php echo $_GET["taxa"];?>">
							</div>
						 </div>
						 <?php } ?>
						 
						 
						 
						 
					 <?php if(isset($_GET["free"])){?>
						 <div class="row  mg-t-10">
							 <div class="col-6 tx-16"><strong>Total Geral</strong></div>
							 <div class="col-6 tx-16"><strong>R$:<?php if(isset($somando->soma)){$geral = $somando->soma + $sumx + $_GET["taxa"]; echo $gx = number_format($geral, 2, ',', '.');} else { print "0,00";} ?> 
							 </strong>
							 </div>
						 </div>
					<?php } ?>
							 
					<?php if(isset($_GET["pago"])){?>
						<div class="row  mg-t-10">
							 <div class="col-6 tx-16"><strong>Total Geral</strong></div>
							 <div class="col-6 tx-16"><strong>R$:<?php if(isset($somando->soma)){$geral = $somando->soma + $sumx + $_GET["taxa"]; echo $gx = number_format($geral, 2, ',', '.');} else { print "0,00";} ?>
							  </strong>
							 </div>
						 </div>
					<?php } ?>
					
					
							 
						 
					<input type="hidden" name="totalg" class="form-control" value="<?php echo $geral;?>">
					<input type="hidden" name="id_pedido" class="form-control" value="<?php echo $id_cliente;?>">
					<input type="hidden" name="idu" class="form-control" value="<?php echo $idu;?>">
						 						 
						<div class="media-list">
							   
							  
							  <label class="rdiobox ckbox-success">
							  <button type="submit" class="btn btn-success btn-block" name="cart">Confirmar Pedido<i class="fa fa-arrow-right mg-l-5"></i></button>
							  
							   <a href="pdvpedido.php?idpedido=<?=$id_cliente;?>"><button type="button" class="btn btn-purple btn-block mg-t-10" name="cart"><i class="fa fa-arrow-left mg-r-5"></i> Continuar Pedido </button></a>
							  
							  
							  </label>
							 
							  
					    </div>
						 
						  </form>
					      
						</div>
						 <?php } else { ?>
						  <div align="center" style="margin-top:-10px; margin-bottom:10px;"><img src="../img/cart_off.png" style="width:55px; height:50px;"/><br>Carrinho Vazio</div>
						 <?php } ?>
			</div>
			</div>		