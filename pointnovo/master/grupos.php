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
          <label class="section-title"><i class="fa fa-check-square-o" aria-hidden="true"></i> GRUPOS DE OPCIONAIS</label>
		  <hr>
		  <form action="" method="post">
		  <input type="hidden" name="cadgrupo" value="ok">
          <div class="form-layout">
		  
            <div class="row mg-b-25">
			
              <div class="col-lg-6">
                <div class="form-group">
                  <label class="form-control-label">Nome Interno: <span class="tx-danger">*</span></label>
                  <input type="text" class="form-control" name="cad_nomex" maxlength="30" required>
				  <p>Apenas para controle administrativo.</p>
                </div>
              </div><!-- col-4 -->
              <div class="col-lg-6">
                <div class="form-group">
                  <label class="form-control-label">Nome Externo: <span class="tx-danger">*</span></label>
                  <input type="text" class="form-control" name="cad_nome" required>
				  <p>Será exibido para seu cliente.</p>
                </div>
              </div><!-- col-4 --> 
			              
            </div><!-- row -->
			
			<div class="row mg-b-25">
			
              <div class="col-lg-2">
                <div class="form-group">
                  <label class="form-control-label">Posição: <span class="tx-danger">*</span></label>
                  <input type="number" class="form-control" name="cad_posicao" maxlength="1" required>
                </div>
              </div><!-- col-4 -->
			  <input type="hidden" name="cad_minopcoes" value="0" >
			   
			  
			  <div class="col-lg-2">
                <div class="form-group">
                  <label class="form-control-label">Máximo de Seleção: <span class="tx-danger">*</span></label>
                  <input type="number" class="form-control" name="cad_mopcoes" maxlength="2" value="0" required>
                </div>
              </div><!-- col-4 -->
			  
              <div class="col-lg-6">
                <div class="form-group">
                  <label class="form-control-label">Opçoes do Grupo: <span class="tx-danger">*</span></label>
					<select class="form-control" name="cad_obri" required>
					<option value="" disabled selected><b>Selecione...</b></option>
					<option value="1">Seleção do item obrigatória (Uma opção)</option>
					<option value="2">Seleção do item por quantidade máxima</option>
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
	  
		<div class="section-wrapper">
          <label class="section-title"><i class="fa fa-check-square-o" aria-hidden="true"></i> Lista</label>
		  <hr>
          <div class="table-wrapper">
            <table id="datatable1" class="table display responsive nowrap" width="100%">
              <thead>
                <tr>
				  <th>ID</th>
          <th>N. Interno</th>
          <th>N. Externo</th>
				  <th>Máx</th>
				  <th>Opções</th>
          <th>Posição</th>
				  <th>Status</th>
				  <th></th>
				  <th></th>
                  <th></th>
				  <th></th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                
			    <?php
			  	while ($dadcate = $grupop->fetch(PDO::FETCH_OBJ)) {
				if($dadcate->obrigatorio == 1) { $obri = "Obrigatório"; }
				if($dadcate->obrigatorio == 2) { $obri = "Máximo de Seleção"; }
				if($dadcate->obrigatorio == 3) { $obri = "Sabores / Meio a Meio"; }
				if($dadcate->status == 1) { $stt = "Ativo"; }
				if($dadcate->status == 2) { $stt = "Desativado"; }
				 
			  	?>
                <tr>
				  <td width="5%"><?php print $dadcate->Id;?></td>
				  <td><?php print $dadcate->nomeinterno;?></td>
          <td><?php print $dadcate->nomegrupo;?></td>
				  <td><?php print $dadcate->quantidade;?></td>
				  <td><?php print $obri; ?></td>
          <td><?php print $dadcate->posicao; ?></td>
				  <td><?php print $stt; ?></td>
				  <td align="center">
				  <?php if($dadcate->status=="1"){ ?>
				  <a href="grupos.php?desativarg=<?php print $dadcate->Id;?>"><button class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Desativar Grupo"><i class="fa fa-eye"></i></button></a>
				  <?php } else { ?>
				  <a href="grupos.php?ativarpg=<?php print $dadcate->Id;?>"><button class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top" title="Ativar Grupo"><i class="fa fa-eye"></i></button></a>
				  <?php } ?>
				  </td>
				   <td align="center">
				  <a href="opcionais.php?idpp=<?php print $dadcate->Id;?>"><button class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="top" title="Cadastrar Opcionais"><i class="fa fa-object-group"></i></button></a>
				  </td>
				  <td align="center">
				  <form action="gruposeditar.php" method="post">
	              <input type="hidden" name="codgrupo" value="<?php print $dadcate->Id;?>"/>
	              <button type="submit" class="btn btn-purple btn-sm" data-toggle="tooltip" data-placement="top" title="Editar Grupo"><i class="icon fa fa-pencil"></i></button>
	              </form>
				  </td>
				  <td align="center">
				  <form action="" method="post">
	              <input type="hidden" name="duplicargrupo" value="<?php print $dadcate->Id;?>"/>
	              <button type="submit" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="top" title="Duplicar Grupo"><i class="icon fa fa-cubes"></i></button>
	              </form>
				  </td>
                  <td align="center">
				  <form action="" method="post">
	              <input type="hidden" name="deletargrupo" value="<?php print $dadcate->Id;?>"/>
	              <button type="submit" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Excluir Grupo"><i class="icon fa fa-times"></i></button>
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
  </body>
</html>
