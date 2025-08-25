<?php  
require_once "topo.php";
?>


<div class="slim-mainpanel">
        <div class="container">
		  
		  <div class="row row-sm mg-t-20">
           
				<div class="col-lg-12">
				
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
						
			<div class="card-body pd-40" align="justify" style="margin-top:-40px">
			<label class="section-title"><i class="fa fa-check-square-o" aria-hidden="true"></i> Formas de Atendimento</label>
			<hr>
			<?php  
			$atende = $connect->query("SELECT * FROM config WHERE id='$cod_id'"); 
			while ($dadosatende = $atende->fetch(PDO::FETCH_OBJ)) { 
			?>
			<form action="" method="post">
			<input type="hidden" name="atendimento" value="ok">
			
			<div class="row" align="justify">
				<div class="col-md-6">
					<div class="form-group">
						Delivery:
						<select name="delivery" class="form-control selec2" required>
						<option value="<?php print $dadosatende->delivery; ?>"><?php if($dadosatende->delivery==1) { print "Ativo"; } else { print "Desativado";} ?></option>								
						<option value="1">- Ativar</option>
						<option value="2">- Desativar</option>
						</select> 
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						Balcão:
						<select name="balcao" class="form-control selec2" required>
						<option value="<?php print $dadosatende->balcao; ?>"><?php if($dadosatende->balcao==1) { print "Ativo"; } else { print "Desativado";} ?></option>								
						<option value="1">- Ativar</option>
						<option value="2">- Desativar</option>
						</select>
					</div>
				</div>
				
			</div>
			<div class="row">
				<div class="col-md-12">
				<hr>
					<div class="form-group">
						<div align="center"> <button type="submit" class="btn btn-primary" name="cart">Salvar <i class="fa fa-arrow-right"></i></button></div>
					</div>
				</div>
			</div>
			</div>
			</form>
<?php } ?>
				
			
			</div>	
			<br>			
			<div class="card card-info">
						
			<div class="card-body pd-40" align="justify" style="margin-top:-40px">
			<label class="section-title"><i class="fa fa-check-square-o" aria-hidden="true"></i> Cores do Sistema</label>
			<hr>
			<?php  
			$editarcat = $connect->query("SELECT * FROM config WHERE id='$cod_id'"); 
			while ($dadoscat = $editarcat->fetch(PDO::FETCH_OBJ)) { 
			?>
			<form action="" method="post">
			<input type="hidden" name="editarempresacor" value="ok">
			<div class="row" align="justify">
				<div class="col-md-3">
					<div class="form-group">
						Fundo do Menu: 
<input type="text" class="form-control" name="cormenu" value="<?php print $dadoscat->cormenu; ?>" style="background-color:<?php print $dadoscat->cormenu; ?>" maxlength="7" required>
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						Fundo do sistema:
						<input type="text" class="form-control" name="corfundo" value="<?php print $dadoscat->corfundo; ?>" style="background-color:<?php print $dadoscat->corfundo; ?>" maxlength="7" required>
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						Rodapé:
						<input type="text" class="form-control" name="corrodape" value="<?php print $dadoscat->corrodape; ?>" style="background-color:<?php print $dadoscat->corrodape; ?>" maxlength="7" required>
						</div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						Cor Carrinho:
						<input type="text" class="form-control" name="corcarrinho" value="<?php print $dadoscat->corcarrinho; ?>" style="background-color:<?php print $dadoscat->corcarrinho; ?>" maxlength="7" required>
						</div>
				</div>
				
			</div>
			<div class="row">
				<div class="col-md-12">
				<hr>
					<div class="form-group">
						<div align="center"> <button type="submit" class="btn btn-primary" name="cart">Salvar <i class="fa fa-arrow-right"></i></button></div>
					</div>
				</div>
			</div>
			</div>
			</form>
<?php } ?>
						</div>
					</div>
				</div>
				
			
		  
		  
		  <div class="row row-sm mg-t-20">
           
				<div class="col-lg-12">
					<div class="card card-info">
						<div class="card-body pd-40" align="justify" style="margin-top:-40px">
							<label class="section-title"><i class="fa fa-check-square-o" aria-hidden="true"></i> Imagem de Fundo</label>
							<hr>
							<?php while ($dadosfundo = $fundotopo->fetch(PDO::FETCH_OBJ)) { ?>
							<form action="" method="post" enctype="multipart/form-data">
							<input type="hidden" name="idbanner" value="<?php print $dadosfundo->id;?>">
							<input type="hidden" name="bannerfundo" value="ok">
							
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label>Imagem sera cortada no tamanho 1400x400 pixels</label>
										<input type="file" name="imagem" id="imagem" class="form-control" required>
									</div>
								</div>
							</div>	
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<div align="center"><button type="submit" class="btn btn-primary" name="cart">Salvar <i class="fa fa-arrow-right"></i></button></div>
									</div>
								</div>
							</div>
							<!-- /row-->
							</form>
							<hr>
							<div class="row">
								<div class="col-md-12">
									<div class="form-group" align="center">
										<img src="../img/fundo_banner/<?php print $dadosfundo->foto; ?>" width="100%"/>
										<?php }?> 
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				
			</div>
			
			<div class="row row-sm mg-t-20">
           
				<div class="col-lg-12">
					<div class="card card-info">
						<div class="card-body pd-40" align="justify" style="margin-top:-40px">
						<label class="section-title"><i class="fa fa-check-square-o" aria-hidden="true"></i> Logo</label>
						<hr>
						<form action="" method="post" enctype="multipart/form-data">
						<input type="hidden" name="idlogo" value="<?php print $dlogo->id;?>">
						<input type="hidden" name="logo" value="ok">
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label>Imagem sera cortada no tamanho 400x400 pixels</label>
									<input type="file" name="imagem" id="imagem" class="form-control" required>
								</div>
							</div>
						</div>
							 
						<!-- /row-->
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<div align="center"><button type="submit" class="btn btn-primary" name="cart">Salvar <i class="fa fa-arrow-right"></i></button></div>
								</div>
							</div>
						</div>
						<!-- /row-->
						</form>
						<hr>
						<div class="row">
							<div class="col-md-12" align="center">
								<div class="form-group" align="center">
									<img src="../img/logomarca/<?php print $dlogo->foto; ?>" width="200" class="img-thumbnail"/>
								</div>
							</div>
						</div>
							
						</div>
					</div>
				</div>
				
			</div>
			
			
			
			<div class="row row-sm mg-t-20">
           
				<div class="col-lg-12">
					<div class="card card-info">
						<div class="card-body pd-40" align="justify" style="margin-top:-40px">
							<label class="section-title"><i class="fa fa-check-square-o" aria-hidden="true"></i> Banner Promocional</label>
							<hr>
							<?php while ($bannerp = $bannerpromo->fetch(PDO::FETCH_OBJ)) { ?>
							<form action="" method="post" enctype="multipart/form-data">
							<input type="hidden" name="idbannerp" value="<?php print $bannerp->id;?>">
							<input type="hidden" name="bannerpromo" value="ok">
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label>Imagem sera cortada no tamanho 300x150 pixels</label>
										<input type="file" name="imagem" id="imagem" class="form-control" required>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<div align="center"><button type="submit" class="btn btn-primary" name="cart">Salvar <i class="fa fa-arrow-right"></i></button></div>
									</div>
								</div>
							</div>
							<!-- /row-->
							</form>
							<hr>
							<div class="row">
								<div class="col-md-12">
									<div class="form-group" align="center">
										<img src="../img/banner/<?php print $bannerp->img; ?>" width="350"/>
										<?php }?> 
									</div>
								</div>
							</div>	
							
						</div>
					</div>
				</div>
				
			</div>

						<div class="row row-sm mg-t-20">
           
				<div class="col-lg-12">
					<div class="card card-info">
						<div class="card-body pd-40" align="justify" style="margin-top:-40px">
							<label class="section-title"><i class="fa fa-check-square-o" aria-hidden="true"></i> Resetar Banco de Dados</label>
							<hr>
							<form action="" method="post">
							<input type="hidden" name="resetarb" value="ok">
							<div class="row">
								<div class="col-md-12">
									<center>ATENÇÃO AO EXECUTAR ESTA FUNÇÃO TODOS OS DADOS DE SUA LOJA SERÃO RESETADOS EXCEÇÃO DAS CONFIGURAÇÕES GERAIS E PERSONALIZAÇÕES</center>
									<br />
									<div class="form-group">
										<div align="center"><button type="submit" class="btn btn-danger" name="cart">Resetar Banco <i class="fa fa-arrow-right"></i></button></div>
									</div>
								</div>
							</div>
							<!-- /row-->
							</form>
							</div>
							
						</div>
					</div>
				</div>
				
			</div>
			
        </div>
		
      </div><!-- slim-mainpanel -->
    </div><!-- slim-body -->
    <script src="../lib/jquery/js/jquery.js"></script>
    <script src="../js/slim.js"></script>
   </body>
</html>
<?php
ob_end_flush();
?>