<?php  
require_once "topo.php";
$codgrupo = $_POST['codgrupo'];
$editarcat = $connect->query("SELECT * FROM opcionais WHERE id='$codgrupo' AND idu='$cod_id'"); 
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
          <label class="section-title"><i class="fa fa-check-square-o" aria-hidden="true"></i>EDITAR OPCIONAL</label>
		  <hr>
		  <form action="" method="post">
		  <input type="hidden" name="editopcional" value="ok">
		  <input type="hidden" name="idopcional" value="<?php print $codgrupo; ?>">
          <div class="form-layout">
            <div class="row mg-b-25">
              <div class="col-lg-4">
                <div class="form-group">
                  <label class="form-control-label">Nome do Opcional: <span class="tx-danger">*</span></label>
                  <input type="text" class="form-control" name="nomeopcionais" value="<?php print $dadoscat->opnome; ?>" required>
                </div>
              </div><!-- col-4 -->
			  <div class="col-lg-5">
                <div class="form-group">
                  <label class="form-control-label">Descrição: <span class="tx-danger">*</span></label>
                  <input type="text" class="form-control" name="descopcionais" value="<?php print $dadoscat->opdescricao; ?>" required>
                </div>
              </div><!-- col-4 -->
              <div class="col-lg-3">
                <div class="form-group">
                  <label class="form-control-label">Valor: <span class="tx-danger">*</span></label>
                  <input type="text" class="dinheiro form-control" name="valoropcionais" id="dinheiro2" value="<?php print $dadoscat->valor; ?>" required>
				  <p>Atenção: Se for grátis deixar 0.00</p>
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
