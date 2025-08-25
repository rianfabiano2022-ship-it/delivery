<?php
require_once "topo.php";
$codigoc = $_POST['codigoc'];
$editarcat = $connect->query("SELECT * FROM categorias WHERE id='$codigoc' AND idu='$cod_id'"); 
$dadoscat = $editarcat->fetch(PDO::FETCH_OBJ);
?>
<div class="slim-mainpanel">
      <div class="container">
	  
	  <div class="section-wrapper mg-b-20">
          <label class="section-title"><i class="fa fa-check-square-o" aria-hidden="true"></i> Editar Categoria</label>
		  <hr>
		  <form action="" method="post" enctype="multipart/form-data">
		  <input type="hidden" name="editcate" value="ok">
		  <input type="hidden" name="iduc" value="<?php print $codigoc; ?>">
		  <input type="hidden" name="img" value="<?php print $dadoscat->url; ?>">
          <div class="form-layout">
            <div class="row mg-b-25">
              <div class="col-lg-4">
                <div class="form-group">
                  <label class="form-control-label">Nome: <span class="tx-danger">*</span></label>
                  <input type="text" class="form-control" name="cad_nome" value="<?php print $dadoscat->nome; ?>" maxlength="50" required>
                </div>
              </div><!-- col-4 -->
              <div class="col-lg-2">
                <div class="form-group">
                  <label class="form-control-label">Posição: <span class="tx-danger">*</span></label>
                  <input type="number" class="form-control" name="cad_posicao" value="<?php print $dadoscat->posicao; ?>" maxlength="1" required>
                </div>
              </div><!-- col-4 --> 
			  <div class="col-lg-6">
                <div class="form-group">
                  <label class="form-control-label">Sua imagem será diminuida para 100x100px. <span class="tx-danger">*</span></label>
                  <input type="file" name="pic2" class="form-control">
                </div>
              </div><!-- col-4 -->               
            </div><!-- row -->

            <div class="form-layout-footer" align="center">
              <button class="btn btn-primary bd-0">Editar <i class="fa fa-arrow-right"></i></button>
            </div><!-- form-layout-footer -->
          </div><!-- form-layout -->
        </div><!-- section-wrapper -->
	    </form>
		
      </div><!-- container -->
    </div><!-- slim-mainpanel -->
    <script src="../lib/jquery/js/jquery.js"></script>
	<script src="../js/slim.js"></script>
  </body>
</html>
