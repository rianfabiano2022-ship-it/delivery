<?php
require_once "topo.php";
?>
<div class="slim-mainpanel">
      <div class="container">
	  
<div class="section-wrapper">
          <label class="section-title"><i class="fa fa-check-square-o" aria-hidden="true"></i> Movimentos por Data</label>
		  <hr>
		  <form action="relatorios/pordata.php" method="post">
		  	  <input type="hidden" class="form-control" name="idusr" value="<?=$cod_id;?>">
			  <div class="form-layout">
				
				<div class="row">
				  <div class="col-lg-3">
					<div class="form-group">
					  <label class="form-control-label">Inicial: <span class="tx-danger">*</span></label>
					  <input type="text" class="form-control" id="dateMask" name="data_i" placeholder="MM/DD/YYYY" required>
					</div>
				  </div><!-- col-4 -->
				  <div class="col-lg-3">
					<div class="form-group">
					  <label class="form-control-label">Final: <span class="tx-danger">*</span></label>
					  <input type="text" class="form-control" id="dateMask2" name="data_f" placeholder="MM/DD/YYYY" required>
					</div>
				  </div><!-- col-4 -->
				  <div class="col-lg-3">
					<div class="form-group">
					  <label class="form-control-label">Valor do Caixa (R$):</label>
					  <input type="text" class="form-control" id="valorCaixa" name="saldo_inicial" placeholder="Ex: 200,00" value="200,00">
					</div>
				  </div><!-- col-4 -->
				  <div class="col-lg-3">
					<div class="form-group">
					  <label class="form-control-label" style="color:#FFFFFF">..</label><br />
					  <button class="btn btn-primary bd-0">Gerar <i class="fa fa-arrow-right"></i></button>
					</div>
				  </div><!-- col-4 -->               
				</div><!-- row -->
				 
			  </div><!-- form-layout -->
         </form>
</div><!-- section-wrapper -->
	   
      </div><!-- container -->
    </div><!-- slim-mainpanel -->
    <script src="../lib/jquery/js/jquery.js"></script>
    <script src="../lib/bootstrap/js/bootstrap.js"></script>
    <script src="../lib/jquery.maskedinput/js/jquery.maskedinput.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
	<script>
      $(function(){
        'use strict'

        // Input Masks
        $('#dateMask').mask('99-99-9999');
		$('#dateMask2').mask('99-99-9999');
        $('#valorCaixa').mask('000.000.000,00', {reverse: true});
      });
    </script>
	 
  </body>
</html>