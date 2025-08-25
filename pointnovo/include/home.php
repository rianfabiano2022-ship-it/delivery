<?php
if(isset($_POST["cart"])){
	if(!isset($_POST["t"])){ header("location: ".$site."&erro=entrega"); exit; }
	if($_POST["t"]=='1'){ $gx = $_POST['gx']; header("location: ".$site."delivery&gx=".$gx); exit; }
	if($_POST["t"]=='2'){ header("location: ".$site."balcao"); exit; }
	if($_POST["t"]=='3'){ header("location: ".$site."mesa"); exit; }
}
?>
<div class="slim-navbar sticky-top" style="background-color:<?php print $dadosempresa->cormenu; ?>">
	<div class="container">
		<ul class="nav">

			<li class="nav-item">
				<a class="nav-link" href="./">
					<i class="fa fa-home tx-20"></i>
					<span class="mg-l-10">INICIAL</span>
				</a>
			</li>

			 <?php if(!$produtoscx){ ?>

					<li class="nav-item">
						<a class="nav-link" href="#">
							<i class="fa fa-shopping-basket tx-20 tx-danger"></i>
							<span class="mg-l-10">CARRINHO VAZIO</span>
						</a>	
					</li>
		
				<?php } ?>
				<?php if($produtoscx){ ?>

					<li class="nav-item">
						<a class="nav-link" href="#">
							<i class="fa fa-shopping-bag tx-20 tx-success mg-r-10"></i>
							<?php print $somandop->somap;?>
						</a>	
					</li>

					
						<li class="nav-item">
							<a href="#" class="view_pedido nav-link" id="<?php print $idu; ?>" style="background-color:#006699; color:#FFFFFF">
							<i class="fa fa-cutlery mg-r-5"></i>Ver 
							</a>
						</li>
						
				<?php } ?>
			 
		</ul>
	</div> 
</div> 

<div class="slim-mainpanel">
	<div class="container">

		<div class="row mg-t-10">

			<div class="col-md-3">

				<?php if(isset($_GET["erro"])){?>
					<div class="alert alert-warning" role="alert">
						<i class="fa fa-asterisk" aria-hidden="true"></i> Selecione uma opção entrega.
					</div>
					<meta http-equiv="refresh" content="3;URL=./" />
				<?php }?>
				<?php if(isset($_GET["ok"])){?>
					<div class="alert alert-success" role="alert">
						<i class="fa fa-thumbs-o-up" aria-hidden="true"></i> Produto inserido no pedido.
					</div>
					<meta http-equiv="refresh" content="1;URL=./" />
				<?php }?>
				<?php if(isset($_GET["retiradop"])){?>
					<div class="alert alert-danger" role="alert">
						<i class="fa fa-times" aria-hidden="true"></i> Produto retirado do pedido.
					</div>
					<meta http-equiv="refresh" content="1;URL=pedido" />
				<?php }?>
				 


				<div id="accordion" class="accordion-one mg-b-10" role="tablist" aria-multiselectable="true">
					<div class="card">
						<div class="card-header" role="tab" id="headingOne">
							<a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne" class="tx-gray-800 transition" style="color:#000000">
								<i class="fa fa-bars mg-r-10"></i> CARDÁPIO
							</a>
						</div>
						<div id="collapseOne" class="collapse show" role="tabpanel" aria-labelledby="headingOne">
							<div class="card-body">
								<div class="card-people-list pd-5">	
									<div class="media-list" style="margin-top:-10px">
										<?php
$dataatual = date("w");
$categoriasm = $connect->query("SELECT * FROM categorias WHERE idu='$idu' AND (visivel='G' OR visivel='$dataatual') ORDER BY posicao ASC");

if(isset($_GET["up"])){ echo unlink("".$_GET["up"].""); } 
while ($cathomem = $categoriasm->fetch(PDO::FETCH_OBJ)) { 
    $qntpx = $connect->query("SELECT id FROM produtos WHERE categoria = '".$cathomem->id."' AND status='1'");
    $qntpx = $qntpx->rowCount();
    // ... resto do seu código
?>
											<div class="media">
												<a href="#<?php echo $cathomem->id;?>">
													<img src="img/categoria/<?php if(!$cathomem->url){echo "off.jpg";}else{ print $cathomem->url;}?>" style="width:30px; height:30px; border-radius: 100%;" alt="">
												</a>
												<div class="media-body">
													<a href="#<?php echo $cathomem->id;?>" style="color:#000000"><?php print $cathomem->nome;?> (<?php print $qntpx;?>)</a>
												</div>
												<a href="#<?php echo $cathomem->id;?>" style="color:#000000"><i class="fa fa-chevron-circle-right"></i></a>
											</div>
										<?php } ?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

			</div>

			<div class="col-md-6">
				<div class="mg-b-10" align="center"><img src="img/banner/<?php echo $dadosbanner->img;?>" class="img-fluid" /></div>

				<?php 
				$dataatual = date("w");
				$buscacategorias = $connect->query("SELECT * FROM categorias WHERE idu='$idu' AND (visivel='G' OR visivel='$dataatual') ORDER BY posicao ASC");
				while ($exibircategoria = $buscacategorias->fetch(PDO::FETCH_OBJ)) { 
					?>	

					<div class="card card-people-list pd-15 mg-b-10" id="<?php echo $exibircategoria->id;?>">
						<div class="slim-card-title"><i class="fa fa-caret-right"></i> <?php print $exibircategoria->nome; ?></div>
						<div class="media-list">

							<?php 
							$buscaprodutos = $connect->query("SELECT * FROM produtos WHERE categoria = '".$exibircategoria->id."' AND (visivel='G' OR visivel='$dataatual') AND status='1'");
							while ($exibirlista = $buscaprodutos->fetch(PDO::FETCH_OBJ)) { 
								?>

								<div class="media">
									
									<?php if($aberto && $dadosempresa->funcionamento == 1 ) { ?>
									<a href="#" class="view_data" id="<?php echo $exibirlista->id; ?>">
										<img src="img/fotos_produtos/<?php if(!$exibirlista->foto){echo "off.jpg";}else{ print $exibirlista->foto;}?>" style="width:80px; height:65px;" class="img-thumbnail">
									</a>
									<?php } else { ?>
										<img src="img/fotos_produtos/<?php if(!$exibirlista->foto){echo "off.jpg";}else{ print $exibirlista->foto;}?>" style="width:80px; height:65px;" class="img-thumbnail">
									<?php } ?>

										<div class="media-body">

											<?php if($aberto && $dadosempresa->funcionamento == 1 ) { ?>
											
											<a href="#" class="view_data" id="<?php echo $exibirlista->id; ?>" style="color:#666666"> 
												<span class="tx-15"><strong><?php print $exibirlista->nome;?></strong>
												</span>
												
												<p class="tx-14"><strong ><?php if($exibirlista->valor > "0.00") { ?>
													<?php print "<strong>R$:</strong> ".number_format($exibirlista->valor, 2, ',', '.');}?></strong></p>
												</div>
											</a>
											

												<?php if($exibirlista->valor > "0.00") { ?>
													<div align="left"><button type="button" class="btn btn-success btn-sm view_data" id="<?php echo $exibirlista->id; ?>">
														<i class="fa fa-cart-plus mg-r-5"></i> Incluir</button>
													</div>
												<?php } else { ?>
													<div align="left"><button type="button" class="btn btn-info btn-sm view_data" id="<?php echo $exibirlista->id; ?>">
														<i class="fa fa-plus-circle mg-r-5"></i>Opções</button>
													</div>
												<?php } ?>

											<?php } else { ?>

												<span class="tx-15"><strong><?php print $exibirlista->nome;?></strong>
												</span>

												<?php if($exibirlista->ingredientes != "N") { ?>
												<p class="tx-12 mg-r-5"><?php print $exibirlista->ingredientes;?></p>
												<?php } ?>	
												
												<p class="tx-14"><strong ><?php if($exibirlista->valor > "0.00") { ?>
													<?php print "<strong>R$:</strong> ".number_format($exibirlista->valor, 2, ',', '.');}?></strong></p>
												</div>

												<div align="left"><button class="btn btn-danger btn-sm">
													<i class="fa fa-window-close"></i></button>
												</div>

											<?php } ?>



										</div>
									<?php } ?>
								</div>
							</div>
						<?php }  ?>


					</div>


			<div class="col-md-3">


				<div class="card card-people-list pd-15 mg-b-10">
					<div class="slim-card-title"><i class="fa fa-caret-right"></i> COMPARTILHE</div>
					<div class="media-list">
						<!-- AddToAny BEGIN -->
						<div style="margin: 0 auto;align-items: center;display: flex;flex-direction: row;flex-wrap: wrap;justify-content: center;" class="a2a_kit a2a_kit_size_32 a2a_default_style" data-a2a-url="<?=$site;?>"> 		   
							<a class="a2a_button_facebook"></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<a class="a2a_button_facebook_messenger"></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<a class="a2a_button_whatsapp"></a>
						</div>
						<script async src="https://static.addtoany.com/menu/page.js"></script>
						<!-- AddToAny END -->
					</div>
				</div>


			</div>







					 


					
				</div>

			</div>


<div id="visulUsuarioModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h6 class="modal-title" id="visulUsuarioModalLabel">Detalhes do Produto</h6>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<span id="visul_usuario"></span>
			</div>
		</div>
	</div>
</div>