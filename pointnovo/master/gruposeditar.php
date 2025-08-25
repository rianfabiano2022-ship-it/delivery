<?php  
require_once "topo.php";
$codgrupo = $_POST['codgrupo'];
$editarcat = $connect->query("SELECT * FROM grupos WHERE Id='$codgrupo' AND idu='$cod_id'"); 
$dadoscat		= $editarcat->fetch(PDO::FETCH_OBJ);
?>
<div class="slim-mainpanel">
      <div class="container">
	  
	  <div class="section-wrapper mg-b-20">
          <label class="section-title"><i class="fa fa-check-square-o" aria-hidden="true"></i> EDITAR GRUPOS DE OPCIONAIS</label>
		  <hr>
		  <form action="" method="post">
		  <input type="hidden" name="editgrupo" value="ok">
		  <input type="hidden" name="idgrup" value="<?php print $codgrupo; ?>">
          <div class="form-layout">
		  
            <div class="row mg-b-25">
			
              <div class="col-lg-6">
                <div class="form-group">
                  <label class="form-control-label">Nome Interno: <span class="tx-danger">*</span></label>
                  <input type="text" class="form-control" value="<?php print $dadoscat->nomeinterno; ?>" name="cad_nomex" maxlength="60" required>
				  <p>Apenas para controle administrativo.</p>
                </div>
              </div><!-- col-4 -->
              <div class="col-lg-6">
                <div class="form-group">
                  <label class="form-control-label">Nome Externo: <span class="tx-danger">*</span></label>
                  <input type="text" class="form-control" value="<?php print $dadoscat->nomegrupo; ?>" name="cad_nome" maxlength="60" required>
				  <p>Será exibido para seu cliente.</p>
                </div>
              </div><!-- col-4 --> 
			              
            </div><!-- row -->
			
			<div class="row mg-b-25">
			
              <div class="col-lg-2">
                <div class="form-group">
                  <label class="form-control-label">Posição: <span class="tx-danger">*</span></label>
                  <input type="number" class="form-control" value="<?php print $dadoscat->posicao; ?>" name="cad_posicao" maxlength="1" required>
                </div>
              </div><!-- col-4 -->
			  <input type="hidden" name="cad_minopcoes" value="0" >
			  
			  <div class="col-lg-2">
                <div class="form-group">
                  <label class="form-control-label">Máximo de Seleção: <span class="tx-danger">*</span></label>
                  <input type="number" value="<?php print $dadoscat->quantidade; ?>" class="form-control" name="cad_mopcoes" maxlength="2" required>
                </div>
              </div><!-- col-4 -->
			  
              <div class="col-lg-6">
                <div class="form-group">
                  <label class="form-control-label">Opçoes do Grupo: <span class="tx-danger">*</span></label>
					<select class="form-control" name="cad_obri" required>
					<option value="<?php print $dadoscat->obrigatorio; ?>">
					<?php if($dadoscat->obrigatorio ==1) { print "Seleção do ítem obrigatória (Uma opção)"; }?>
					<?php if($dadoscat->obrigatorio ==2) { print "Seleção do ítem por quantidade máxima"; }?>
					<?php if($dadoscat->obrigatorio ==3) { print "Sabores - 2 ou mais sabores"; }?>
					</option>
					<option value="1">Seleção do ítem obrigatória (Uma opção)</option>
					<option value="2">Seleção do ítem por quantidade máxima</option>
					<option value="3">Sabores - 2 ou mais sabores</option>
					</select>
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
  </body>
</html>
