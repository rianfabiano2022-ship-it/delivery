<?php  
require_once "topo.php";
$codigoc = $_GET['idpp'];
$editarcat = $connect->query("SELECT * FROM produtos WHERE id='$codigoc' AND idu='$cod_id'"); 
$dadoscat		= $editarcat->fetch(PDO::FETCH_OBJ);
if($dadoscat->visivel=="G"){$visi = "Todos os dias";}
if($dadoscat->visivel=="1"){$visi = "Segunda";}
if($dadoscat->visivel=="2"){$visi = "Terça";}
if($dadoscat->visivel=="3"){$visi = "Quarta";}
if($dadoscat->visivel=="4"){$visi = "Quinta";}
if($dadoscat->visivel=="5"){$visi = "Sexta";}
if($dadoscat->visivel=="6"){$visi = "Sábado";}
if($dadoscat->visivel=="0"){$visi = "Domingo";}

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
          <label class="section-title"><i class="fa fa-check-square-o" aria-hidden="true"></i> DIAS DE EXIBIÇÃO DO PRODUTO</label>
		  <hr>
		  <form action="" method="post">
		  <input type="hidden" name="cadbairro" value="ok">
          <div class="form-layout">
            <div class="row mg-b-25">
              
			  <div class="col-lg-6">
                <div class="form-group">
                  <label class="form-control-label">Produto: <span class="tx-danger">*</span></label>
                  <input type="text" class="form-control" value="<?php print $dadoscat->nome; ?>" disabled>
                </div>
              </div><!-- col-4 -->
			  
			  
              <div class="col-lg-4">
                <div class="form-group">
                  <label class="form-control-label">Dias de Exibição: <span class="tx-danger">*</span></label>
                  <select id="select-dias" class="form-control" required> 
				        <option value="<?php print $dadoscat->visivel;?>"><?php print $visi;?></option>           
						<option value="./exibirdias.php?exedias=G&idpp=<?php print $dadoscat->id;?>">Todos os Dias</option>
						<option value="./exibirdias.php?exedias=1&idpp=<?php print $dadoscat->id;?>">Segunda</option> 
						<option value="./exibirdias.php?exedias=2&idpp=<?php print $dadoscat->id;?>">Terça</option> 
						<option value="./exibirdias.php?exedias=3&idpp=<?php print $dadoscat->id;?>">Quarta</option> 
						<option value="./exibirdias.php?exedias=4&idpp=<?php print $dadoscat->id;?>">Quinta</option> 
						<option value="./exibirdias.php?exedias=5&idpp=<?php print $dadoscat->id;?>">Sexta</option> 
						<option value="./exibirdias.php?exedias=6&idpp=<?php print $dadoscat->id;?>">Sábado</option> 
						<option value="./exibirdias.php?exedias=0&idpp=<?php print $dadoscat->id;?>">Domingo</option> 						
				</select>
                </div>
              </div><!-- col-4 -->               
            </div><!-- row -->

             
          </div><!-- form-layout -->
        </div><!-- section-wrapper -->
	    
	  
      </div><!-- container -->
    </div><!-- slim-mainpanel -->
    <script src="../lib/jquery/js/jquery.js"></script>
    <script src="../js/slim.js"></script>
	<script>
	$('#select-dias').change(function() {
		window.location = $(this).val();
	});
	</script>
  </body>
</html>
