<?php  
require_once "topo.php";
$editarcat = $connect->query("SELECT * FROM config WHERE id='$cod_id'"); 
while ($dadoscat = $editarcat->fetch(PDO::FETCH_OBJ)) {
$dom 			= $dadoscat->dom;
$seg 			= $dadoscat->seg;
$ter 			= $dadoscat->ter;
$qua 			= $dadoscat->qua;
$qui 			= $dadoscat->qui;
$sex 			= $dadoscat->sex;
$sab 			= $dadoscat->sab;
?>

<div class="slim-mainpanel">
	<div class="container">
	
		<div class="row">
			<div class="col-md-12">
			
				<?php if(isset($_GET["erro"])){?>
				<div class="alert alert-warning" role="alert">
            	<i class="fa fa-asterisk" aria-hidden="true"></i> Erro ao editar o cadastro.
          		</div>
				<?php }?>
				<?php if(isset($_GET["ok"])){?>
				<div class="alert alert-success" role="alert">
            	<i class="fa fa-thumbs-o-up" aria-hidden="true"></i> Cadastro editado com sucesso.
          		</div>
				<?php }?>
	
				<div class="card card-info">
					<div class="card-body" align="justify">
					
					<label class="section-title"><i class="fa fa-check-square-o" aria-hidden="true"></i> Dados Gerais</label>
					
					<hr>
					
					<form action="" method="post">
					<input type="hidden" name="editarempresa" value="ok">
					
					<div class="row">
				
						<div class="col-md-4">
							<div class="form-group">
								<label>Nome da Empresa</label>
								<input type="text" class="form-control" name="nome" value="<?php print $dadoscat->nomeempresa; ?>" maxlength="60" required>
							</div>
						</div>
						
						<div class="col-md-2">
							<div class="form-group">
								<label>Nº com WhatsApp</label>
								<div class="styled-select">
								<input type="text" name="celular" class="form-control" value="<?php print $dadoscat->celular; ?>" maxlength="11" required>
								</div>
							</div>
						</div>

						<div class="col-md-2">
    					          <div class="form-group">
      						  <label>Chave Pix</label>
      						  <input type="text" class="form-control" name="chave_pix" value="<?php print $dadoscat->Chave_Pix; ?>" maxlength="50" placeholder="E-mail, CPF ou telefone">
   						 </div>
						</div>
						
						<div class="col-md-2">
							<div class="form-group">
								<label style="color:#FF0000">Tempo Delivery</label>
								<input type="text" class="form-control" name="timerdelivery" value="<?php print $dadoscat->timerdelivery; ?>" required>
							</div>
						</div>
						<div class="col-md-1">
							<div class="form-group">
								<label style="color:#FF0000">Tempo Balção</label>
								<input type="text" class="form-control" name="timerbalcao" value="<?php print $dadoscat->timerbalcao; ?>" required>
							</div>
						</div>
						<div class="col-md-1">
							<div class="form-group">
								<label style="color:#FF0000">Entrega Free?</label>
								<input type="text" class="dinheiro form-control" id="dinheiro" name="dfree" value="<?php print $dadoscat->dfree; ?>" required>
							</div>
						</div>
						
					</div>
					
					<hr>
					
					<div class="row">
					
						<div class="col-md-2">
						<div class="form-group">
							<label>CEP</label>
							<input type="text" class="form-control" name="cep" id="cep" value="<?php print $dadoscat->cep; ?>" maxlength="8" required>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label>Bairro</label>
								<input type="text" class="form-control" name="bairro" id="bairro" value="<?php print $dadoscat->bairro; ?>" required>
							</div>
						</div>
						<div class="col-md-2">
							<div class="form-group">
								<label>Número</label>
								<input type="number" class="form-control" name="numero" value="<?php print $dadoscat->numero; ?>" maxlength="5" required>
							</div>
						</div>
						<div class="col-md-5">
							<div class="form-group">
								<label>Complemento</label>
								<input type="text" class="form-control" name="complemento" value="<?php print $dadoscat->complemento; ?>">
							</div>
						</div>
					
					</div>
					
					<div class="row">
					
						<div class="col-md-5">
						<div class="form-group">
							<label>Endereço</label>
							<input type="text" class="form-control" name="rua" id='rua' value="<?php print $dadoscat->rua; ?>" required>
							</div>
						</div>
						<div class="col-md-2">
							<div class="form-group">
								<label>Cidade</label>
								<div class="styled-select">
								<input type="text" class="form-control" name="cidade" id="cidade" value="<?php print $dadoscat->cidade; ?>" required>
								</div>
							</div>
						</div>
						<div class="col-md-2">
							<div class="form-group">
								<label>UF</label>
								<div class="styled-select">
								<input type="text" class="form-control" name="uf" id="uf" value="<?php print $dadoscat->uf; ?>" maxlength="2" required>
								</div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label>Fuso Horário</label>
								<div class="styled-select">
								<select class="form-control" name="fuso" required>
								<option value="<?php print $dadoscat->fuso;?>" selected><b>Hora Atual: <?=date("H:i:s");?></b></option>
								<option></option>
								<option value="America/Rio_branco">AC</option>
								<option value="America/Maceio">AL</option>
								<option value="America/Belem">AP</option>
								<option value="America/Manaus">AM</option>
								<option value="America/Bahia">BA</option>
								<option value="America/Fortaleza">CE</option>
								<option value="America/Sao_Paulo">DF</option>
								<option value="America/Sao_Paulo">ES</option>
								<option value="America/Sao_Paulo">GO</option>
								<option value="America/Fortaleza">MA</option>
								<option value="America/Cuiaba">MT</option>
								<option value="America/Campo_Grande">MS</option>
								<option value="America/Sao_Paulo">MG</option>
								<option value="America/Sao_Paulo">PR</option>
								<option value="America/Fortaleza">PB</option>
								<option value="America/Belem">PA</option>
								<option value="America/Recife">PE</option>
								<option value="America/Fortaleza">PI</option>
								<option value="America/Sao_Paulo">RJ</option>
								<option value="America/Fortaleza">RN</option>
								<option value="America/Sao_Paulo">RS</option>
								<option value="America/Porto_Velho">RO</option>
								<option value="America/Boa_Vista">RR</option>
								<option value="America/Sao_Paulo">SC</option>
								<option value="America/Maceio">SE</option>
								<option value="America/Sao_Paulo">SP</option>
								<option value="America/Araguaia">TO</option>
								</select>
								</div>
							</div>
						</div>
					
					</div>
					
					<label class="section-title"><i class="fa fa-check-square-o" aria-hidden="true"></i> Horário de Funcionamento</label>
					
					<hr>					
					
					<div class="row">
					<div class="col-md-2">
						<label class="fix_spacing">Segunda</label>
					</div>
					<div class="col-md-2">
						<div class="form-group">
							<?php $arrayx = explode(',',$seg); ?>
							AM: <input type="text" class="form-control" name="seg1" value="<?php echo $arrayx[0]; ?>" maxlength="8" required>
						</div>
					</div>
					<div class="col-md-2">
						<div class="form-group">
							<input type="text" class="form-control" name="seg2" value="<?php echo $arrayx[1]; ?>" maxlength="8" required>
						</div>
					</div>
					<div class="col-md-2">
						<div class="form-group">
							PM: <input type="text" class="form-control" name="seg3" value="<?php echo $arrayx[2]; ?>" maxlength="8" required>
							</div>
					</div>
					<div class="col-md-2">
						<div class="form-group">
							<input type="text" class="form-control" name="seg4" value="<?php echo $arrayx[3]; ?>" maxlength="8" required>
						</div>
					</div>
					
				</div>
				<!-- /row-->
				<hr>
				<div class="row">
					<div class="col-md-2">
						<label class="fix_spacing">Terça</label>
					</div>
					<div class="col-md-2">
						<div class="form-group">
							<?php $arrayx = explode(',',$ter); ?>
							AM: <input type="text" class="form-control" name="ter1" value="<?php echo $arrayx[0]; ?>" maxlength="8" required>
						</div>
					</div>
					<div class="col-md-2">
						<div class="form-group">
							<input type="text" class="form-control" name="ter2" value="<?php echo $arrayx[1]; ?>" maxlength="8" required>
						</div>
					</div>
					<div class="col-md-2">
						<div class="form-group">
							PM: <input type="text" class="form-control" name="ter3" value="<?php echo $arrayx[2]; ?>" maxlength="8" required>
							</div>
					</div>
					<div class="col-md-2">
						<div class="form-group">
							<input type="text" class="form-control" name="ter4" value="<?php echo $arrayx[3]; ?>" maxlength="8" required>
						</div>
					</div>
					
				</div>
				<!-- /row-->
				<hr>
				<div class="row">
					<div class="col-md-2">
						<label class="fix_spacing">Quarta</label>
					</div>
					<div class="col-md-2">
						<div class="form-group">
							<?php $arrayx = explode(',',$qua); ?>
							AM: <input type="text" class="form-control" name="qua1" value="<?php echo $arrayx[0]; ?>" maxlength="8" required>
						</div>
					</div>
					<div class="col-md-2">
						<div class="form-group">
							<input type="text" class="form-control" name="qua2" value="<?php echo $arrayx[1]; ?>" maxlength="8" required>
						</div>
					</div>
					<div class="col-md-2">
						<div class="form-group">
							PM: <input type="text" class="form-control" name="qua3" value="<?php echo $arrayx[2]; ?>" maxlength="8" required>
							</div>
					</div>
					<div class="col-md-2">
						<div class="form-group">
							<input type="text" class="form-control" name="qua4" value="<?php echo $arrayx[3]; ?>" maxlength="8" required>
						</div>
					</div>
					
				</div>
				<!-- /row-->
				<hr>
				<div class="row">
					<div class="col-md-2">
						<label class="fix_spacing">Quinta</label>
					</div>
					<div class="col-md-2">
						<div class="form-group">
							<?php $arrayx = explode(',',$qui); ?>
							AM: <input type="text" class="form-control" name="qui1" value="<?php echo $arrayx[0]; ?>" maxlength="8" required>
						</div>
					</div>
					<div class="col-md-2">
						<div class="form-group">
							<input type="text" class="form-control" name="qui2" value="<?php echo $arrayx[1]; ?>" maxlength="8" required>
						</div>
					</div>
					<div class="col-md-2">
						<div class="form-group">
							PM: <input type="text" class="form-control" name="qui3" value="<?php echo $arrayx[2]; ?>" maxlength="8" required>
							</div>
					</div>
					<div class="col-md-2">
						<div class="form-group">
							<input type="text" class="form-control" name="qui4" value="<?php echo $arrayx[3]; ?>" maxlength="8" required>
						</div>
					</div>
					
				</div>
				<!-- /row-->
				<hr>
				<div class="row">
					<div class="col-md-2">
						<label class="fix_spacing">Sexta</label>
					</div>
					<div class="col-md-2">
						<div class="form-group">
							<?php $arrayx = explode(',',$sex); ?>
							AM: <input type="text" class="form-control" name="sex1" value="<?php echo $arrayx[0]; ?>" maxlength="8" required>
						</div>
					</div>
					<div class="col-md-2">
						<div class="form-group">
							<input type="text" class="form-control" name="sex2" value="<?php echo $arrayx[1]; ?>" maxlength="8" required>
						</div>
					</div>
					<div class="col-md-2">
						<div class="form-group">
							PM: <input type="text" class="form-control" name="sex3" value="<?php echo $arrayx[2]; ?>" maxlength="8" required>
							</div>
					</div>
					<div class="col-md-2">
						<div class="form-group">
							<input type="text" class="form-control" name="sex4" value="<?php echo $arrayx[3]; ?>" maxlength="8" required>
						</div>
					</div>
					
				</div>
				<!-- /row-->
				<hr>
				<div class="row">
					<div class="col-md-2">
						<label class="fix_spacing">Sábado</label>
					</div>
					<div class="col-md-2">
						<div class="form-group">
							<?php $arrayx = explode(',',$sab); ?>
							AM: <input type="text" class="form-control" name="sab1" value="<?php echo $arrayx[0]; ?>" maxlength="8" required>
						</div>
					</div>
					<div class="col-md-2">
						<div class="form-group">
							<input type="text" class="form-control" name="sab2" value="<?php echo $arrayx[1]; ?>" maxlength="8" required>
						</div>
					</div>
					<div class="col-md-2">
						<div class="form-group">
							PM: <input type="text" class="form-control" name="sab3" value="<?php echo $arrayx[2]; ?>" maxlength="8" required>
							</div>
					</div>
					<div class="col-md-2">
						<div class="form-group">
							<input type="text" class="form-control" name="sab4" value="<?php echo $arrayx[3]; ?>" maxlength="8" required>
						</div>
					</div>
					
				</div>
				<!-- /row-->
				<hr>
				<div class="row">
					<div class="col-md-2">
						<label class="fix_spacing">Domingo</label>
					</div>
					<div class="col-md-2">
						<div class="form-group">
							<?php $arrayx = explode(',',$dom); ?>
							AM: <input type="text" class="form-control" name="dom1" value="<?php echo $arrayx[0]; ?>" maxlength="8" required>
						</div>
					</div>
					<div class="col-md-2">
						<div class="form-group">
							<input type="text" class="form-control" name="dom2" value="<?php echo $arrayx[1]; ?>" maxlength="8" required>
						</div>
					</div>
					<div class="col-md-2">
						<div class="form-group">
							PM: <input type="text" class="form-control" name="dom3" value="<?php echo $arrayx[2]; ?>" maxlength="8" required>
							</div>
					</div>
					<div class="col-md-2">
						<div class="form-group">
							<input type="text" class="form-control" name="dom4" value="<?php echo $arrayx[3]; ?>" maxlength="8" required>
						</div>
					</div>
					
				</div>
				
				<hr>
				
				<div class="row">
					<div class="col-md-12">
					
						<div align="center"> <button type="submit" class="btn btn-primary" name="cart">Salvar <i class="fa fa-arrow-right"></i></button></div>
					
					</div>		
				</div>		
				</form>	
					
					</div>
				</div>	
		
			</div>
		</div>
	
		
	</div>
</div>		
<?php } ?>	
    <script src="../lib/jquery/js/jquery.js"></script>
    <script src="../js/slim.js"></script>
    <script src="../js/moeda.js"></script>
	<script>
	$('.dinheiro').mask('#.##0.00', {reverse: true});
	</script>
  </body>
</html>
<?php
ob_end_flush();
?>