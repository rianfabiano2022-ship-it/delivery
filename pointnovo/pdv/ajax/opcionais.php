<?php 
while ($limite_opx = $grupos->fetch(PDO::FETCH_OBJ)) {
	$idgp = $limite_opx->idgrupo;
	
	$grupo_opxx  = $connect->query("SELECT * FROM grupos WHERE Id='$idgp' AND status='1' ORDER BY posicao ASC");
while ($grupo_opx = $grupo_opxx->fetch(PDO::FETCH_OBJ)) {
	$idgpx = $grupo_opx->Id;
?>


		
		<hr>
		<center class="mg-b-10" style="font-size:12px; color:#FF0000" id="Mensagem"></center>
		
		<div class="slim-card-title" <?php if($grupo_opx->obrigatorio == 1) { ?> style="color:#CC3300" <?php } ?> <?php if($grupo_opx->obrigatorio == 2) { ?> style="color:#0066FF" <?php } ?>> <?php print $grupo_opx->nomegrupo;?> - <?php if($grupo_opx->quantidade > 1) { print $grupo_opx->quantidade; ?> opções <?php } else { print $grupo_opx->quantidade; ?> opção <?php } ?> <?php if($grupo_opx->obrigatorio == 1) { ?> <span style="color:#FF0000">*</span><?php } ?>
		</div>
		<p style="font-size:12px">- Selecione as opções e quantidades abaixo.</p>		
		
		<div class="row">
						 
<?php
$opc_dados   = $connect->query("SELECT * FROM opcionais WHERE idg='$idgpx' AND status='1'");
	while ($opc_dadosx = $opc_dados->fetch(PDO::FETCH_OBJ)) {
$cont++;
?>

		<div class="col-8 mg-t-10">
		
		<?php if($grupo_opx->obrigatorio == 1) { ?>
		<input type='radio' name="opcionais[<?php print $grupo_opx->Id; ?>]" value="<?php print $opc_dadosx->opnome; ?>,<?php print $opc_dadosx->valor; ?>," required> - <span><?php print $opc_dadosx->opnome; ?></span>
		<?php } ?>
						 
		 <?php if($grupo_opx->obrigatorio == 2) { ?>
		
		 <input type='checkbox' name="opcionais[<?php print $opc_dadosx->id; ?>]" value="<?php print $opc_dadosx->opnome; ?>,<?php print $opc_dadosx->valor; ?>," id="<?php print $grupo_opx->Id; ?>"> - <span> <?php print $opc_dadosx->opnome; ?></span>
		 
		 <?php if($opc_dadosx->opdescricao != "N") { ?>
		 <br>
		 <span style="color:#FFCC33; font-size:12px">- <?=$opc_dadosx->opdescricao;?></span>
		 <?php } ?>
		 
 		 <?php } ?>
		</div>
						 
		<div class="col-4 tx-14 mg-t-10">
		<?php if($opc_dadosx->valor == "0.00") { ?>Grátis<?php } else { print "+ R$: ".$opc_dadosx->valor; } ?>
		</div>
		
		<script>
				$( document ).ready( function( )
					{
						var NumeroMaximo = <?php print $grupo_opx->quantidade; ?>;
						$( "input[id='<?php print $grupo_opx->Id; ?>']" ).click( function( )
							{
							$( "#Mensagem" ).empty( );
							if( $( "input[id='<?php print $grupo_opx->Id; ?>']" ).filter( ':checked' ).size( ) > NumeroMaximo )
							{
						$( '#Mensagem' ).html( 'Selecione no máximo ' + NumeroMaximo + '');
							return false;
						}
					} )
				} );
			</script>	
		
		
		 
		
		
							 
<?php } ?>	
						 </div>			 
		 			 
						 
						 
			
			
			
			
			
			
			
			
			
						 
						 
<?php
	}
}
?>