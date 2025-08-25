<hr>
<div class="slim-card-title" style="color:#CC3300">Escolha uma das opções abaixo <span style="color:#FF0000">*</span></div>
	<div class="row mg-t-10">
	<?php while ($protam = $ctamx->fetch(PDO::FETCH_OBJ)) { ?>
		<div class="col-8 mg-t-10">
		<input type="radio" name="tamanho" value="<?php print $protam->descricao; ?>,<?php print $protam->valor;?>" required> - <span><?php print $protam->descricao; ?></span>
		</div>
		<div class="col-4 tx-14 mg-t-10">R$: <?php print $protam->valor; ?>
		</div>
	<?php } ?>	 
</div>