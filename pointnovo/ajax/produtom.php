<?php
include_once('../../funcoes/Conexao.php');
include_once('../../funcoes/Key.php');
include_once('../db/Mobile_Detect.php');

$detect = new Mobile_Detect;

if(isset($_POST["user_id"])){

	$idpro = $_POST["user_id"];

// dados do produto

	$cpro	= $connect->query("SELECT * FROM produtos WHERE id = '$idpro' AND status='1'");
	$cpro 	= $cpro->fetch(PDO::FETCH_OBJ);

// verifica se tem tamanho

	$ctamx	= $connect->query("SELECT * FROM tamanhos WHERE idp = '$idpro' AND status='1'");
	$qntta  = $ctamx->rowCount();

// verifica se tem meio a meio

	$opcio 	= $connect->query("SELECT * FROM limite_op WHERE idp='$idpro' AND meioameio='3'");
	$opcionaisxk  = $opcio->rowCount();
	$opcionaisxl  = $opcio->fetch(PDO::FETCH_OBJ);

// verifica se tem opcionais

	$opcionaisxy 	= $connect->query("SELECT * FROM limite_op WHERE idp='".$idpro."'"); 
	$opcionaisxky 	= $opcionaisxy->rowCount();

// ?????

	$grupos 	= $connect->query("SELECT * FROM limite_op WHERE idp='$idpro' AND meioameio < '3'");
	$qntgrupos 	= $grupos->rowCount();

}

$cont = 0;

?>

<script type="text/javascript">
	arrayOpcionais = []; // Inicia o Array para fazer as verificações

	function checksOpcionais() {
		console.log(arrayOpcionais);
		try {
			arrayOpcionais.forEach(function(element, index, array) {
				// console.log("a[" + index + "] = " + element + " SIZE: " + $( "input[id='"+index+"']" ).filter( ':checked' ).size());

				if ($( "input[id='"+index+"']" ).filter( ':checked' ).size() < element) {
					$("#btn-incluir-pedido").attr("disabled", true);
					throw BreakException;	
				} else {
					$("#btn-incluir-pedido").attr("disabled", false);
				}
			})
		} catch(e) {
			// console.log("Saiu da função");
		}

		return false;
	}
</script>

<script type="text/javascript">
document.getElementById('btn-incluir-pedido').addEventListener('click', function() {
    // Desabilita o botão para impedir múltiplos cliques
    this.disabled = true;
    this.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Incluindo...';
    
    // Submete o formulário (se não for feito automaticamente)
    this.form.submit();
});
</script>

<center><img src="img/fotos_produtos/<?php if(!$cpro->foto){echo "off.jpg";}else{ print $cpro->foto; }?>" style="width:100%;" class="img-thumbnail"></center>

<div class="row">
	
	<div class="col-12 mg-t-10">
		<span class="tx-18 "><strong><?=$cpro->nome;?></strong></span>
		
		<?php if($cpro->ingredientes != 'N'){?>
		<div class="tx-15" align="justify"><strong>Ingredientes: </strong><?=$cpro->ingredientes;?></div>
		<?php } ?>
	 
		<?php if($cpro->valor > "0.00") { ?>
		<div class="tx-18 tx-info mg-t-5"><strong>R$: </strong><?=number_format($cpro->valor, 2, ',', '.');?></div>
		<?php } ?>
	
 	</div>
</div>

<form action="ajax/produtoi.php" method="post">
	<input type="hidden" name="idcat" value="<?php print $cpro->categoria; ?>">
	<input type="hidden" name="produto" value="<?php print $cpro->id; ?>">
	<input type="hidden" name="valor" value="<?php print $cpro->valor; ?>">
	<input type="hidden" name="idsecao" value="<?= session_id(); ?>">
	<input type="hidden" name="iduser" value="<?php print $cpro->idu; ?>">
	

	<?php if($opcionaisxk >=1){ include_once('meioameio.php'); } ?>
	<?php if($qntta >='1'){ include_once('tamanhos.php'); } ?>
	<?php if($qntgrupos >='1'){ include_once('opcionais.php'); } ?>
	
	<hr>
	<div class="row mg-t-10">
		<div class="col-12">
			<label>Alguma observação?</label>
			<textarea rows="3" name="observacoes" class="form-control"></textarea>
		</div>
	</div>
	<hr>
	
	<div class="row mg-t-10">
		<div class="col-6">
			<div class="input-group number-spinner">
				
				<div class="col-xs-3 col-xs-offset-3">
					<div class="input-group number-spinner">
						<span class="input-group-btn">
							<button type="button" class="btn btn-default" data-dir="dwn"><i class="fa fa-minus" aria-hidden="true"></i></span></button>
						</span>
						<input type="text" name="quantidade" class="form-control text-center" value="1" required>
						<span class="input-group-btn">
							<button type="button" class="btn btn-default" data-dir="up"><i class="fa fa-plus" aria-hidden="true"></i></span></button>
						</span>
					</div>
				</div>
			</div>
		</div>
		
		<div class="col-6">
			<button id="btn-incluir-pedido" type="submit" class="btn btn-primary btn-block"><i class="fa fa-plus-square"></i> Incluir Pedido</button>
		</div>
	</form>
</div>