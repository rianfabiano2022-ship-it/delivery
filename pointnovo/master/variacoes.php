<?php
require_once "topo.php";
$codigoc = $_GET['idpp'];
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
          <label class="section-title"><i class="fa fa-check-square-o" aria-hidden="true"></i> Tamanhos e Variações</label>
		  <hr>
		  
          <div class="form-layout">
		  
		  <div class="alert alert-danger" role="alert">
          <i class="fa fa-thumbs-o-up" aria-hidden="true"></i> ATENÇÃO - O valor do produto será o mesmo que for definido nas variações ou tamanhos abaixo. Esse compo é de selecção obrigatória para o cliente final.
          </div>
		  
		  <div class="row">
				
				<div class="col-md-6">
					<div class="form-group">
						<label>Produto</label>
						<input type="text" class="form-control" value="<?php print $dadoscat->nome; ?>" disabled>
					</div>
				</div>
				<div class="col-md-2">
					<div class="form-group">
						<label>Valor Base</label>
						<input type="text" class="form-control" value="<?php print $dadoscat->valor; ?>" disabled>
					</div>
				</div>
				
			</div>
			
			<hr>
		  
		  
		  <form action="" method="post">
		  <input type="hidden" name="variacoes" value="ok">
		  <input type="hidden" name="codvar" value="<?php print $codigoc;?>">
            <div class="row mg-b-25">
              <div class="col-lg-6">
                <div class="form-group">
                  <label class="form-control-label">Descrição: <span class="tx-danger">*</span></label>
                  <input type="text" class="form-control" name="descvariacoes" required>
                </div>
              </div><!-- col-4 -->
              <div class="col-lg-4">
                <div class="form-group">
                  <label class="form-control-label">Novo Valor: <span class="tx-danger">*</span></label>
                  <input type="text" class="dinheiro form-control" name="valorvariacoes" id="dinheiro" value="0.00" required>
				  <p>Atenção: Obrigatório informar um novo valor</p>
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
				  <th>Descrição</th>
                  <th>Valor</th>
				  <th>Status</th>
                  <th></th>
				  <th></th>
                </tr>
              </thead>
              <tbody>
                
			  <?php
			  	$bustam = $connect->query("SELECT * FROM tamanhos WHERE idp =  '$codigoc' ORDER BY descricao ASC");
			  	while ($dadtam = $bustam->fetch(PDO::FETCH_OBJ)) {
			  	?>
                <tr>
				  <td><?php print $dadtam->descricao;?></td>
                  <td><?php print $dadtam->valor;?></td>
				  <td>
				  <?php if($dadtam->status ==1){ ?> ATIVO <?php } else { ?> INATIVO <?php } ?>
				  </td>
				  </td>
				  <td align="center" width="6%">
				  <form action="" method="post">
	              <input type="hidden" name="editarstatustamanho" value="<?php print $dadtam->id;?>"/>
				  <input type="hidden" name="codvar" value="<?php print $codigoc;?>">
				  <?php if($dadtam->status ==1){ ?>
				  <input type="hidden" name="editarstatustamanhov" value="2"/>
	              <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-eye-slash" aria-hidden="true"></i></button>
				  <?php } else { ?>
				  <input type="hidden" name="editarstatustamanhov" value="1"/>
	              <button type="submit" class="btn btn-success btn-sm"><i class="fa fa-eye" aria-hidden="true"></i></button>
				  <?php } ?>
	              </form>
				  </td>
                  <td align="center" width="6%">
				  <form action="" method="post">
				  <input type="hidden" name="deletartamanho" value="<?php print $dadtam->id;?>"/>
				  <input type="hidden" name="codvar" value="<?php print $codigoc;?>">
	              <button type="submit" class="btn btn-warning btn-sm"><i class="icon fa fa-times"></i></button>
	              </form>
				  </td>
                </tr>
                <?php }?>
                 
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
