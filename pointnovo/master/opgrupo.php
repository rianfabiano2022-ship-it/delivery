<?php  
require_once "topo.php";
$idpp = $_GET["idpp"];
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
          <label class="section-title"><i class="fa fa-check-square-o" aria-hidden="true"></i> GRUPOS DE OPCIONAIS</label>
		  <hr>
		  <form action="" method="post">
		  <input type="hidden" name="cadgruposx" value="ok">
		  <input type="hidden" name="cadgruposxy" value="<?php print $idpp;?>">
          <div class="form-layout">
            <div class="row mg-b-25">
              <div class="col-lg-6">
                <div class="form-group">
                  <label class="form-control-label">Selecione o Grupo: <span class="tx-danger">*</span></label>
                  	<select class="form-control" name="cad_obrigt" required>
					<option value="" disabled selected><b>Selecione...</b></option>
					<?php
					if(isset($_GET["up"])){ echo unlink("".$_GET["up"].""); }
					$listagrupo = $connect->query("SELECT * FROM grupos WHERE idu = '$cod_id'");
					while ($dadcatef = $listagrupo->fetch(PDO::FETCH_OBJ)) { ?>
					<option value="<?php print $dadcatef->Id;?>,<?php print $dadcatef->obrigatorio;?>"><?php print $dadcatef->nomeinterno;?></option>
					<?php } ?>
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
	  
		<div class="section-wrapper">
          <label class="section-title"><i class="fa fa-check-square-o" aria-hidden="true"></i> Lista</label>
		  <hr>
          <div class="table-wrapper">
            <table id="datatable1" class="table display responsive nowrap" width="100%">
              <thead>
                <tr>
				  <th>#</th>
                  <th>Grupo</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                
			    <?php
				$listaop = $connect->query("SELECT * FROM limite_op WHERE idp = '$idpp'");
			  	while ($dadcate = $listaop->fetch(PDO::FETCH_OBJ)) {
				$idgpro = $dadcate->idgrupo;
				$listagp = $connect->query("SELECT * FROM grupos WHERE Id = '$idgpro'");
			  	while ($dadcgp = $listagp->fetch(PDO::FETCH_OBJ)) {
			  	?>
                <tr>
				  <td width="5%"><?php print $dadcgp->Id;?></td>
                  <td><?php print $dadcgp->nomeinterno;?></td>
                  <td align="center">
				  <form action="" method="post">
				  <input type="hidden" name="idpp" value="<?php print $idpp;?>"/>
	              <input type="hidden" name="deletarcatx" value="<?php print $dadcate->Id;?>"/>
	              <button type="submit" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Excluir Grupo"><i class="icon fa fa-times"></i></button>
	              </form>
				  </td>
                </tr>
                <?php } } ?>    
                 
              </tbody>
            </table>
          </div> 
        </div> 

      </div><!-- container -->
    </div><!-- slim-mainpanel -->
    <script src="../lib/jquery/js/jquery.js"></script>
    <script src="../lib/datatables/js/jquery.dataTables.js"></script>
    <script src="../lib/datatables-responsive/js/dataTables.responsive.js"></script>
    <script src="../lib/select2/js/select2.min.js"></script>
    <script>
      $(function(){
        'use strict';

        $('#datatable1').DataTable({
          responsive: true,
          language: {
            searchPlaceholder: 'Buscar...',
            sSearch: '',
            lengthMenu: '_MENU_ ítens',
          }
        });

        $('#datatable2').DataTable({
          bLengthChange: false,
          searching: false,
          responsive: true
        });

        // Select2
        $('.dataTables_length select').select2({ minimumResultsForSearch: Infinity });

      });
    </script>
	<script src="../js/slim.js"></script>
	<script src="../js/moeda.js"></script>
	<script>
	$('.dinheiro').mask('#.##0,00', {reverse: true});
	</script>
  </body>
</html>
