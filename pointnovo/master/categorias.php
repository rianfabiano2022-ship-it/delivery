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
          <label class="section-title"><i class="fa fa-check-square-o" aria-hidden="true"></i> Cadastrar Categoria</label>
		  <hr>
		  <form action="" method="post" enctype="multipart/form-data">
		  <input type="hidden" name="cadcate" value="ok">
          <div class="form-layout">
            <div class="row mg-b-25">
              <div class="col-lg-4">
                <div class="form-group">
                  <label class="form-control-label">Nome: <span class="tx-danger">*</span></label>
                  <input type="text" class="form-control" name="cad_nome" maxlength="120" required>
                </div>
              </div><!-- col-4 -->
              <div class="col-lg-2">
                <div class="form-group">
                  <label class="form-control-label">Posição: <span class="tx-danger">*</span></label>
                  <input type="number" class="form-control" name="cad_posicao" maxlength="1" required>
                </div>
              </div><!-- col-4 --> 
			  <div class="col-lg-6">
                <div class="form-group">
                  <label class="form-control-label">Sua imagem será diminuida para 100x100px. <span class="tx-danger">*</span></label>
                  <input type="file" name="pic" id="pic" class="form-control">
                </div>
              </div><!-- col-4 -->               
            </div><!-- row -->

            <div class="form-layout-footer" align="center">
              <button class="btn btn-primary bd-0">Salvar <i class="fa fa-arrow-right"></i></button>
            </div><!-- form-layout-footer -->
          </div><!-- form-layout -->
        </div><!-- section-wrapper -->
	    </form>
		
		<div class="alert alert-danger" role="alert">
        <i class="fa fa-thumbs-o-up" aria-hidden="true"></i> ATENÇÃO - Ao excluir uma categoria, todos os produtos relacionados a mesma serão apagados.
        </div>
	  
		<div class="section-wrapper">
          <label class="section-title"><i class="fa fa-check-square-o" aria-hidden="true"></i> Lista</label>
		  <hr>
          <div class="table-wrapper">
            <table id="datatable1" class="table display responsive nowrap" width="100%">
              <thead>
                <tr>
				  <th>#</th>
                  <th>IMG</th>
                  <th>Nome</th>
                  <th>Posição</th>
                  <th>Editar</th>
                  <th>Apagar</th>
                  <th>Dias Exibição</th>
                </tr>
              </thead>
              <tbody>
                
			    <?php
			  	while ($dadcate = $dadcat->fetch(PDO::FETCH_OBJ)) { 
			  	?>
                <tr>
				  <td width="5%"><?php print $dadcate->id;?></td>
                  <th width="6%"><img src="../img/categoria/<?php if(!$dadcate->url){echo "off.jpg";}else{ print $dadcate->url;}?>" width="40"/></th>
                  <td><?php print $dadcate->nome;?></td>
                  <td><?php print $dadcate->posicao; ?></td>
				  <td align="left">
				  <form action="categoriaseditar.php" method="post">
	              <input type="hidden" name="codigoc" value="<?php print $dadcate->id;?>"/>
	              <button type="submit" class="btn btn-purple btn-sm"><i class="icon fa fa-pencil"></i></button>
	              </form>
				  </td>
                  <td align="left">
				  <form action="" method="post">
	              <input type="hidden" name="deletarcat" value="<?php print $dadcate->id;?>"/>
	              <button type="submit" class="btn btn-danger btn-sm"><i class="icon fa fa-times"></i></button>
	              </form>
				  </td>
                

<!-- Adicione mais um <th> no <thead> se quiser -->

<!-- ... -->
<!-- Dentro do while da listagem -->
<td align="left">
  <a href="exibirdiascat.php?idcat=<?php print $dadcate->id;?>">
    <button class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top" title="Dias de Exibição da Categoria">
      <i class="fa fa-calendar"></i>
    </button>
  </a>
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
