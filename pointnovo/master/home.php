<?php
require_once "topo.php";

$msg =  "🙋‍♀️ 😍 *".$nomeempresa."* 😱 😎\n";
$msg .= "\n";
$msg .= "Click no link abaixo 👇 para você acessar e fazer seu pedido com mais agilidade.\n";
$msg .= "\n";
$msg .= "🍱 ".$sitexx."\n";
$msg .= "\n";
$msg .= "Estamos aguardando o seu pedido.\n";
$msg .= "🍟 🍔 🍕 🥟 🍧 🍽\n";
$msg;

?>
	<div class="slim-mainpanel">
        <div class="container">
		  
		  <div class="row row-sm mg-t-20">
           
				<div class="col-lg-12">
					<div class="card card-info">
						<div class="card-body pd-40">
							<div class="row">
								<div class="col-md-3" ></a>
									<img src="../img/wp.png" width="210" class="img-thumbnail"/>
								</div>
								<div class="col-md-9" align="justify">
									<br>
									<span style="font-size:18px"><i class="fa fa-external-link" aria-hidden="true"></i> ENVIAR LINK NO WHATSAPP</span><br><br>
										<form action="" method="post">
										<input type="hidden" id="mensagem" value="<?php echo $msg; ?>">
										<div class="row">
													<div class="col-md-4">
														<div class="form-group">
															<label>Número do Cliente</label>
															<input type="text" class="form-control" id="celular" name="celular" maxlength="11" required>
														</div>
													</div>
													<div class="col-md-5">
														<div class="form-group">
															<label style="color:#FFFFFF">.</label>
															<button type="submit" class="btn btn-success btn-block" onclick="enviarMensagem()">Enviar no WhatsApp <i class="fa fa-arrow-right"></i></button>
														</div>
													</div>
										</div>
										</form>
								</div>
							</div>
						</div>
					</div>
				</div>
				
			</div>
		  
		  
		  <div class="row row-sm mg-t-20">
           
				<div class="col-lg-12">
					<div class="card card-info">
						<div class="card-body pd-40">
							<div class="row">
								<div class="col-md-3" ></a>
									<a href="https://api.qrserver.com/v1/create-qr-code/?data=<?php print $sitexx;?>&amp;size=400x400" target="_blank"><img src="https://api.qrserver.com/v1/create-qr-code/?data=<?php print $sitexx;?>&amp;size=200x200" alt="" title="" class="img-thumbnail"/></a>
								</div>
								<div class="col-md-9" align="justify">
									<br>
									<span style="font-size:18px"><i class="fa fa-qrcode" aria-hidden="true"></i> SEU QRCODE PARA DELIVERY E RETIRADA</span><br><br>
									<span>Este é o QR code para seus clientes acessarem o cardápio de delivery e retirada. Utilize-o em materiais, impressos ou onde você quiser!</span><br><br>
									<span><i class="fa fa-arrow-left" aria-hidden="true"></i> Clique na imagem para para baixar em maior resolução.</span><br>
								</div>
							</div>
						</div>
					</div>
				</div>
				
			</div>
			
			<div class="row row-sm mg-t-20">
           
				<div class="col-lg-12">
					<div class="card card-info">
						<div class="card-body pd-40">
							<div class="row">
								<div class="col-md-3" ></a>
									<img src="../img/logomarca/<?php print $dlogo->foto; ?>" width="210" class="img-thumbnail"/>
								</div>
								<div class="col-md-9" align="justify">
									<span style="font-size:18px"><i class="fa fa-external-link" aria-hidden="true"></i> URLs DE ACESSO AO SEU SISTEMA</span><br><br>
									<span style="color:#FF0000"><i class="fa fa-link" aria-hidden="true"></i> <?php print substr($sitexx,0,-1);?></span><br><br>
									<span>Utilize a URL acima para que seus clientes possam acessar seu cardápio através do whatasapp ou suas redes sociais preferidas.</span><br>
									<hr />
									<span>URL do seu PDV: <span style="color:#0099CC"><i class="fa fa-link" aria-hidden="true"></i> <?=$sitexx;?>pdv</span><br>
									<span>URL Tela Cozinha: <span style="color:#00CC99"><i class="fa fa-link" aria-hidden="true"></i> <?=$sitexx;?>cozinha</span><br>
									
								</div>
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
 	
	<script type="text/javascript">
	function enviarMensagem(){
	var celular = document.querySelector("#celular").value;
    celular = celular.replace(/\D/g,'');
	  if(celular.length < 13){
		celular = "55" + celular;
	  }
	  var texto = document.querySelector("#mensagem").value;
	  texto = window.encodeURIComponent(texto);
	  window.open("https://api.whatsapp.com/send?phone=" + celular + "&text=" + texto, "_blank");
	}
</script>
  </body>
</html>
<?php
ob_end_flush();
?>