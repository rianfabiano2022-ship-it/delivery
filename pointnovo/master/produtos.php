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
          <label class="section-title"><i class="fa fa-check-square-o" aria-hidden="true"></i> CADASTRO DE PRODUTOS</label>
		  <hr>
		  <form action="" method="post" enctype="multipart/form-data">
		  <input type="hidden" name="cadpro" value="ok">
          <div class="form-layout">
            <div class="row mg-b-25">
              <div class="col-lg-4">
                <div class="form-group">
                  <label class="form-control-label">Nome: <span class="tx-danger">*</span></label>
                  <input type="text" class="form-control" name="cad_nome"required>
                </div>
              </div><!-- col-4 -->
			  <div class="col-lg-8">
                <div class="form-group">
                  <label class="form-control-label">Ingredientes:</label>
                  <input type="text" class="form-control" name="cad_ingrediente" value="N">
                  <p>Atenção: Deixe N se não tiver descrição.</p>
                </div>
              </div><!-- col-4 -->
			 </div> 
			  <div class="row mg-b-25"> 
              <div class="col-lg-3">
                <div class="form-group">
                  <label class="form-control-label">Categoria: <span class="tx-danger">*</span></label>
                    <select class="form-control" name="cad_cat" required>
					<option value="" disabled selected><b>Selecione...</b></option>
					<?php 
					$selcat = $connect->query("SELECT * FROM categorias WHERE idu = '$cod_id' ORDER BY posicao ASC");
					while ($dadossel = $selcat->fetch(PDO::FETCH_OBJ)) { 
					?>
					<option value="<?php print $idca = $dadossel->id;?>"><?php print $nomca = $dadossel->nome;?></option>
					<?php } ?>
					</select>
                </div>
              </div><!-- col-4 --> 
			  <div class="col-lg-2">
                <div class="form-group">
                  <label class="form-control-label">Valor: <span class="tx-danger">*</span></label>
                  <input type="text" class="dinheiro form-control" id="dinheiro" name="cad_valor" maxlength="10" value="0,00"required>
                </div>
              </div><!-- col-4 -->
			  <div class="col-lg-7">
                <div class="form-group">
                  <label class="form-control-label">Sua imagem será diminuida para 600x400px. <span class="tx-danger">*</span></label>
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
			  
		<div class="section-wrapper">
          <label class="section-title"><i class="fa fa-check-square-o" aria-hidden="true"></i> Lista</label>
		  <hr>
          <div class="table-wrapper">
            <table id="datatable1" class="table display responsive nowrap" width="100%">
              <thead>
                <tr>
				  <th>IMG</th>
                  <th>Categoria</th>
                  <th>Nome</th>
				  <th>Visível</th>
				  <th>Status</th>
				  <th></th>
				  <th></th>
				  <th></th>
				  <th></th>
				  <th></th>
				  <th></th>
                </tr>
              </thead>
              <tbody>
                
			    <?php
			  	while ($dadcate = $dadpro->fetch(PDO::FETCH_OBJ)) {
				$buscat = $connect->query("SELECT * FROM categorias WHERE id =  '$dadcate->categoria'");
				$buscat = $buscat->fetch(PDO::FETCH_OBJ);
				
				if($dadcate->visivel=="G"){$visi = "Todos os dias";}
				if($dadcate->visivel=="1"){$visi = "Segunda";}
				if($dadcate->visivel=="2"){$visi = "Terça";}
				if($dadcate->visivel=="3"){$visi = "Quarta";}
				if($dadcate->visivel=="4"){$visi = "Quinta";}
				if($dadcate->visivel=="5"){$visi = "Sexta";}
				if($dadcate->visivel=="6"){$visi = "Sábado";}
				if($dadcate->visivel=="0"){$visi = "Domingo";}
				
				if($dadcate->status=="1"){$stu = "Ativo";}
				if($dadcate->status=="2"){$stu = "Bloqueado";}
			  	?>
                <tr>
                  <th><img src="../img/fotos_produtos/<?php if(!$dadcate->foto){echo "off.jpg";}else{ print $dadcate->foto;}?>" width="40"/></th>
				  <td><?php print $buscat->nome;?></td>
                  <td><?php print $dadcate->nome;?></td>
				  <td><?php print $visi;?></td>
				  <td><?php print $stu;?></td>
				  <td><a href="exibirdias.php?idpp=<?php print $dadcate->id;?>"><button class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top" title="Dias de Exibição"><i class="fa fa-calendar"></i></button></a></td>
				  <td align="center">
				  <?php if($dadcate->status=="1"){ ?>
				  <a href="produtos.php?desativar=<?php print $dadcate->id;?>"><button class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Desativar Produto"><i class="fa fa-eye"></i></button></a>
				  <?php } else { ?>
				  <a href="produtos.php?ativarp=<?php print $dadcate->id;?>"><button class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top" title="Ativar Produto"><i class="fa fa-eye"></i></button></a>
				  <?php } ?>
				  </td>
				  <td align="center">
				  <a href="variacoes.php?idpp=<?php print $dadcate->id;?>"><button class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="top" title="Cadastrar Tamanhos"><i class="fa fa-braille" aria-hidden="true"></i></button></a>
				  </td>
				  <td align="center">
				  <a href="opgrupo.php?idpp=<?php print $dadcate->id;?>"><button class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="top" title="Cadastrar Opcionais"><i class="fa fa-plus-square"></i></button></a>
				  </td>
				  <td align="center">
				  <form action="editarprodutos.php" method="post">
	              <input type="hidden" name="codigoc" value="<?php print $dadcate->id;?>"/>
	              <button type="submit" class="btn btn-purple btn-sm" data-toggle="tooltip" data-placement="top" title="Editar Produto"><i class="icon fa fa-pencil"></i></button>
	              </form>
				  </td>
				  <td align="center">
				  <form action="" method="post">
	              <input type="hidden" name="deletarproduto" value="<?php print $dadcate->id;?>"/>
	              <button type="submit" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Excluir Produto"><i class="icon fa fa-times"></i></button>
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
	<script src="../js/moeda.js"></script>
	<script>
	$('.dinheiro').mask('#.##0,00', {reverse: true});
	</script>
	<script src="../js/slim.js"></script>
  </body>
</html>
