<?php
require_once "topo.php";
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
          <label class="section-title"><i class="fa fa-check-square-o" aria-hidden="true"></i> Dados do Usuário</label>
		  <hr>
		  <form action="" method="post">
		  <input type="hidden" name="idcpes" value="<?php print $dadosgerais->id; ?>">
          <div class="form-layout">
            <div class="row mg-b-25">
              
			  <div class="col-lg-5">
                <div class="form-group">
                  <label class="form-control-label">Nome: <span class="tx-danger">*</span></label>
                  <input type="text" class="form-control" name="nome" value="<?php print $dadosgerais->nomeadmin; ?>">
                </div>
              </div><!-- col-4 -->
			  
			  <div class="col-lg-3">
                <div class="form-group">
                  <label class="form-control-label">Email: <span class="tx-danger">*</span></label>
                  <input type="text" class="form-control" name="email" value="<?php print $dadosgerais->email; ?>" maxlength="60">
                </div>
              </div><!-- col-4 -->
			  
			  <div class="col-lg-2">
                <div class="form-group">
                  <label class="form-control-label">CPF/CNPJ: <span class="tx-danger">*</span></label>
                  <input type="text" class="form-control" name="cpf" value="<?php print $dadosgerais->cpf; ?>" maxlength="14">
                </div>
              </div><!-- col-4 -->
			  
			  <div class="col-lg-2">
                <div class="form-group">
                  <label class="form-control-label">Senha: <span class="tx-danger">*</span></label>
                  <input type="password" class="form-control" name="senha" maxlength="8">
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
