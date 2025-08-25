<?php
session_start();

include_once('../../funcoes/Conexao.php');
include_once('../../funcoes/Key.php');

$id_cliente = $_SESSION['id_cliente'];

if(isset($_POST["user_idx"])){

$idu = $_POST["user_idx"];

$empresa 		= $connect->query("SELECT * FROM config WHERE id='$idu'"); 
$dadosempresa 	= $empresa->fetch(PDO::FETCH_OBJ);

$produtosca 	= $connect->query("SELECT * FROM store WHERE idsecao = '$id_cliente' AND status='0' AND idu='$idu' ORDER BY id DESC");
$produtoscx 	= $produtosca->rowCount();
	 
$produtoscax 	= $connect->query("SELECT * FROM store WHERE idsecao = '$id_cliente' AND idu='$idu'");
if($produtoscx>0){
$somando 	= $connect->query("SELECT valor, SUM(valor * quantidade) AS soma FROM store WHERE idsecao='".$id_cliente."' and status='0' and idu='$idu'");
$somando 	= $somando->fetch(PDO::FETCH_OBJ);
$somandop 	= $connect->query("SELECT quantidade, SUM(quantidade) AS somap FROM store WHERE idsecao='".$id_cliente."' and status='0' and idu='$idu'");
$somandop 	= $somandop->fetch(PDO::FETCH_OBJ);
}
	
}	
	?>
			 
			<div class="card card-people-list pd-15 mg-b-10">
				<div class="slim-card-title"><i class="fa fa-caret-right"></i> INFORME SEUS DADOS ABAIXO</div>
					<div class="media-list">
						 
						<form action="balcao_ok" method="post">
						<div class="row">
							<div class="col-6">
								<div class="form-group">
								<label class="form-control-label">Nº Celular: <span class="tx-danger">*</span></label>
								<input type="test" id="cel" placeholder="(99)99999-9999" name="wps" class="form-control" <?php if(isset($_COOKIE['celcli'])){ ?> value="<?php print $_COOKIE['celcli']; ?>" <?php } ?> required>
								</div>
							</div>
							<div class="col-6">
								<div class="form-group">
								<label class="form-control-label">Nome: <span class="tx-danger">*</span></label>
								<input type="text" name="nome" class="form-control" maxlength="30" <?php if(isset($_COOKIE['nomecli'])){?> value="<?php print $_COOKIE['nomecli']; ?>" <?php } ?> required>
								</div>
							</div>
						</div>
						<hr>
						 
						<div class="slim-card-title mg-b-20"><i class="fa fa-caret-right"></i> TEMPO PARA RETIRADA</div>
						<div align="center"><i class="fa fa-hourglass-end" aria-hidden="true"></i></div> 
						<div class="mg-b-10 tx-16" align="center"><?php print $dadosempresa->timerbalcao; ?></div> 
					</div>
			</div>
			 
	   </div>
	   
	   
				   </div>
				</div>
				
						 
						<hr>
						
						
						
						
						
						
						
						
						</div>
			  			
						</div>
						
						 
						<input type="hidden" name="subtotal" class="form-control" value="<?php echo number_format($somando->soma, 2, ',', '.');  ?>">
						<?php
							$opcionais  = $connect->query("SELECT valor, quantidade FROM store_o WHERE ids = '".$id_cliente."' AND status = '0' AND idu='$idu' AND meioameio='0'");
							$sumx=0;
							while ($valork = $opcionais->fetch(PDO::FETCH_OBJ)) {
							$quantop = $valork->quantidade;
							$valorop = $valork->valor;
							$totais = $valorop * $quantop;
						 	$sumx += $totais;
							} 
							?>
						<input type="hidden" name="adcionais" class="form-control" value="<?php echo $opctg = number_format($sumx, 2, ',', '.');?>">
						<?php $geral = $somando->soma + $sumx;?>
						<input type="hidden" name="totalg" class="form-control" value="<?php echo number_format($geral, 2, ',', '.');  ?>">
 					     <button type="submit" class="btn btn-success btn-block">Concluir Pedido <i class="fa fa-arrow-right"></i></button>
						 </form>
						  
						
						  
						
			</div>
			
	   	</div>
	</div>
</div>