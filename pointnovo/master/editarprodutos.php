<?php
require_once "topo.php";
$codigoc = $_POST['codigoc'];
$editarcat = $connect->query("SELECT * FROM produtos WHERE id='$codigoc' AND idu='$cod_id'"); 
$dadoscat		= $editarcat->fetch(PDO::FETCH_OBJ);
?>
<div class="slim-mainpanel">
      <div class="container">
	  
		<?php if(isset($_GET["erro"])){?>
		<div class="alert alert-warning" role="alert">
		<i class="fa fa-asterisk" aria-hidden="true"></i> Erro.
		</div>
		<?php }?>
		<?php if(isset($_GET["ok"])){?>
		<div class="alert alert-success" role="alert">
		<i class="fa fa-thumbs-o-up" aria-hidden="true"></i> Sucesso.
		</div>
		<?php }?>
	  
	  <div class="section-wrapper mg-b-20">
          <label class="section-title"><i class="fa fa-check-square-o" aria-hidden="true"></i> EDITAR PRODUTO</label>
		  <hr>
		  <form action="" method="post" enctype="multipart/form-data">
		  <input type="hidden" name="editarproduto" value="ok">
		  <input type="hidden" name="codigopro" value="<?php print $codigoc; ?>">
          <div class="form-layout">
            <div class="row mg-b-25">
              <div class="col-lg-4">
                <div class="form-group">
                  <label class="form-control-label">Nome: <span class="tx-danger">*</span></label>
                  <input type="text" class="form-control" name="cad_nome" value="<?php print $dadoscat->nome; ?>" required>
                </div>
              </div><!-- col-4 -->
			  <div class="col-lg-8">
                <div class="form-group">
                  <label class="form-control-label">Ingredientes: <span class="tx-danger">*</span></label>
                  <input type="text" class="form-control" name="cad_ingrediente" value="<?php print $dadoscat->ingredientes; ?>" required>
                </div>
              </div><!-- col-4 -->
			 </div> 
			  <div class="row mg-b-25"> 
              <div class="col-lg-3">
                <div class="form-group">
                  <label class="form-control-label">Categoria: <span class="tx-danger">*</span></label>
                   		<select class="form-control" name="cad_cat" required>
						<?php 
						$selcatx = $connect->query("SELECT * FROM categorias WHERE id = '".$dadoscat->categoria."'");
						while ($dadosselx = $selcatx->fetch(PDO::FETCH_OBJ)) { 
						?>
						<option value="<?php print $dadosselx->id; ?>"><?php print $dadosselx->nome; ?></option>
						<?php } ?>
						<?php 
						$selcat = $connect->query("SELECT * FROM categorias WHERE idu = '$cod_id' ORDER BY posicao ASC");
						while ($dadossel = $selcat->fetch(PDO::FETCH_OBJ)) { 
						?>
						<option value="<?php print $idca = $dadossel->id;?>">- <?php print $nomca = $dadossel->nome;?></option>
						<?php } ?>
						</select>
                </div>
              </div><!-- col-4 --> 
			  <div class="col-lg-2">
                <div class="form-group">
                  <label class="form-control-label">Valor: <span class="tx-danger">*</span></label>
                  <input type="text" class="dinheiro form-control" id="dinheiro" name="cad_valor" value="<?php print $dadoscat->valor; ?>" required>
                </div>
              </div><!-- col-4 -->
			  <div class="col-lg-7">
                <div class="form-group">
                  <label class="form-control-label">Sua imagem será diminuida para 600x400px. <span class="tx-danger">*</span></label>
                  <input type="hidden" name="cad_img" value="<?php print $dadoscat->foto; ?>">
				  <input type="file" name="pic" class="form-control">
                </div>
              </div><!-- col-4 -->               
            </div><!-- row -->

            <div class="form-layout-footer" align="center">
              <button class="btn btn-primary bd-0">Salvar <i class="fa fa-arrow-right"></i></button>
            </div><!-- form-layout-footer -->
          </div><!-- form-layout -->
        </div><!-- section-wrapper -->
	    </form>
			  
      </div><!-- container -->
    </div><!-- slim-mainpanel -->

     

    <script src="../lib/jquery/js/jquery.js"></script>
    <script src="../js/slim.js"></script>
	<script src="../js/moeda.js"></script>
	<script>
	$('.dinheiro').mask('#.##0,00', {reverse: true});
	</script>
  </body>
</html>
