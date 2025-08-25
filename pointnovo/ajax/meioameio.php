<?php if($opcionaisxk >=1){ ?>
<?php
$qnts  = $connect->query("SELECT * FROM grupos WHERE Id='".$opcionaisxl->idgrupo."' AND obrigatorio='3' AND status='1'");
$qnts  = $qnts->fetch(PDO::FETCH_OBJ);
?>
		<hr>
		<div class="slim-card-title" style="color:#CC3300">Escolha até <?php print $qnts->quantidade; ?> sabores<span style="color:#FF0000"> *</span></div>
			<p style="font-size:12px">- Será cobrado o maior valor do item selecionado.</p>
			<center style="font-size:12px; color:#FF0000" id="Mensagemmeioameio"></center>
			<div class="row mg-t-10">
					<?php
					$grupomeio  = $connect->query("SELECT * FROM grupos WHERE Id='".$opcionaisxl->idgrupo."' AND obrigatorio='3' AND status='1'");
					$grupomeios	= $grupomeio->fetch(PDO::FETCH_OBJ);
					$opcionaismeio  = $connect->query("SELECT * FROM opcionais WHERE idg='".$grupomeios->Id."' AND status='1'");
					while ($opcionaismeios = $opcionaismeio->fetch(PDO::FETCH_OBJ)) { 
					?>
					<div class="col-9">
					<input type="checkbox"name="meioameios[]" id="idmeioameio" value="<?php print $opcionaismeios->opnome; ?>,<?php print $opcionaismeios->valor;?>"> - <span><?php print $opcionaismeios->opnome; ?></span>
					
					<?php if($opcionaismeios->opdescricao != "N") { ?>
					<p style="font-size:10px; color:#CCCC00">- <?php print $opcionaismeios->opdescricao; ?></p>
					<?php } ?>
					
					</div>
					
					
					<div class="col-3 tx-13 mg-t-10">R$: <?php print $opcionaismeios->valor; ?>
					</div>
				<?php } ?>	 
			</div>
			<script>
				$( document ).ready( function( )
					{
						var NumeroMaximo = <?php print $qnts->quantidade; ?>;
						$( "input[id='idmeioameio']" ).click( function( )
							{
							$( "#Mensagemmeioameio" ).empty( );
							if( $( "input[id='idmeioameio']" ).filter( ':checked' ).size( ) > NumeroMaximo )
							{
						$( '#Mensagemmeioameio' ).html( 'Máximo de  ' + NumeroMaximo + ' sabores.');
							return false;
						}
					} )
				} );
			</script>	

<?php } ?>