<?php
header('Content-Type: text/html; charset=UTF-8');
include('header.php');
date_default_timezone_set( ''.$dadosempresa->fuso.'' );

// Passo 1: Captura o ID da sessão para usar no JavaScript
$id_carrinho_temp = session_id();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>

	<meta property="og:url" content="<?=$site;?>">
	<meta property="og:title" content="<?php print $dadosempresa->nomeempresa; ?>">
	<meta property="og:description" content="Nosso Cardápio Digital na palma de sua mão.">

	<meta property="og:image" content="<?=$site;?>img/logomarca/<?php print $dadoslogo->foto; ?>">
	<meta property="og:image:secure_url" content="<?=$site;?>img/logomarca/<?php print $dadoslogo->foto; ?>">
	<meta property="og:image:type" content="image/jpg">
	<meta property="og:image:width" content="1200">
	<meta property="og:image:height" content="600">

	<link rel="shortcut icon" type="image/png" href="img/logomarca/<?php print $dadoslogo->foto; ?>" />
	<title><?php print $dadosempresa->nomeempresa; ?> - Cardápio de pedidos Online via Whatsapp</title>
	<link href="lib/font-awesome/css/font-awesome.css" rel="stylesheet">
	<link href="lib/select2/css/select2.min.css" rel="stylesheet">
	<link rel="stylesheet" href="css/slim.css">
</head>
<body style="background-color:<?php print $dadosempresa->corfundo; ?>">
	<div class="slim-navbar" style="height:320px; background-image:url(img/fundo_banner/<?php print $dadosfundo->foto; ?>); background-attachment:fixed; height: 100%; background-position: center; background-repeat: no-repeat; background-size: cover;">
		<div class="container">
			<div class="row mg-t-20">
				

				<div class="col-md-4" align="center">
					<div class="mg-b-10"><img src="img/logomarca/<?php print $dadoslogo->foto; ?>" width="180" height="180" class="bd bd-3 rounded-20"/></div>
						<?php if(isset($_GET["up"])){ echo unlink("".$_GET["up"].""); } ?>
				</div>


				<div class="col-md-8" align="center">
				     
						<h2 class="mg-b-10"><span style="color:#FFFFFF; text-shadow: 2px 2px black;"><?php print $dadosempresa->nomeempresa; ?></span></h2>
						<?php if(isset($_COOKIE['nomecli'])){?>
							<h6 class="mg-b-10"><span style="color:#FFFFFF; text-shadow: 2px 2px black;">OLÁ <?php print $_COOKIE['nomecli']; ?></span></h6>
						<?php } ?>
						
						<?php if($aberto && $dadosempresa->funcionamento == 1 ) { ?>
							<button class="btn btn-success btn-oblong btn-sm"><i class="fa fa-thumbs-o-up mg-r-5" aria-hidden="true"></i> ABERTO</button>
						<?php } else { ?>
							<button class="btn btn-danger btn-oblong btn-sm"><i class="fa fa-window-close mg-r-5" aria-hidden="true"></i> FECHADO</button>
						<?php } ?>

						<h6 class="mg-t-10">
						<a href="#" class="view_local" id="<?php print $idu; ?>">
							<span style="color:#FFFFFF; text-shadow: 2px 2px black;">
								<i class="fa fa-map-marker tx-20"></i>
							</span>
						</a>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<a href="https://api.whatsapp.com/send?phone=55<?=$dadosempresa->celular;?>&text=Olá gostaria de falar com um atendente." target='_blanck'>	
							<span style="color:#FFFFFF; text-shadow: 2px 2px black;">
								<i class="fa fa-whatsapp tx-30"></i>
							</span>
						</a>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<a href="#" class="view_hora" id="<?php print $idu; ?>">
							<span style="color:#FFFFFF; text-shadow: 2px 2px black;">
								<i class="fa fa-history tx-20"></i>
							</span>
						</a>
							
							
						</h6>

				</div>


		</div>
	</div>
</div>
		<?php 
		if(file_exists('include/'.$Url[0] . '.php')):
			require_once 'include/'.$Url[0] . '.php';
		else:
			require_once 'include/home.php';
		endif; 
		?>
	</div> 
</div>
<a href="#top" style="color:#999999"><i class="fa fa-chevron-circle-up" aria-hidden="true"></i></a>

<div id="visulLocalModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h6 class="modal-title" id="visulLocalModalLabel">NOSSO ENDEREÇO</h6>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<span id="visul_local"></span>
			</div>
		</div>
	</div>
</div>

<div id="visulHoraModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h6 class="modal-title" id="visulHoraModalLabel">HORÁRIOS DE FUNCIONAMENTO</h6>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<span id="visul_hora"></span>
			</div>
		</div>
	</div>
</div>

<div id="visulPedidoModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h6 class="modal-title" id="visulPedidoModalLabel"><i class="fa fa-cutlery mg-r-10"></i> SEUS PEDIDOS</h6>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<span id="visul_pedido"></span>
			</div>
		</div>
	</div>
</div>

<?php require 'include/fundo.php'; ?> 
<script src="lib/jquery/js/jquery.js"></script>
<script src="lib/bootstrap/js/bootstrap.js"></script>
<script src="lib/jquery.cookie/js/jquery.cookie.js"></script>
<script src="lib/jquery.maskedinput/js/jquery.maskedinput.js"></script>
<script src="lib/select2/js/select2.full.min.js"></script>
<script src="js/moeda.js"></script>
<script>
	$(function(){
		'use strict';
		$('#cel').mask('(99)99999-9999');  
		$('#numb').mask('9999');	
	});
</script>
<script>
	function verifica(value){
		var input = document.getElementById("troco");

		if(value == 'DINHEIRO'){
			input.disabled = false;
		}else if(value == 'CARTAO'){
			input.disabled = true;
		}
	};
</script> 
<script>
	$(document).on('click', '.number-spinner button', function () {    
		var btn = $(this),
		oldValue = btn.closest('.number-spinner').find('input').val().trim(),
		newVal = 0;

		if (btn.attr('data-dir') == 'up') {
			newVal = parseInt(oldValue) + 1;
		} else {
			if (oldValue > 1) {
				newVal = parseInt(oldValue) - 1;
			} else {
				newVal = 1;
			}
		}
		btn.closest('.number-spinner').find('input').val(newVal);
	});
</script>
<script language="JavaScript">
	window.onload = function() {
		document.addEventListener("contextmenu", function(e){
			e.preventDefault();
		}, false);
		document.addEventListener("keydown", function(e) {
            //document.onkeydown = function(e) {
              // "I" key
              if (e.ctrlKey && e.shiftKey && e.keyCode == 73) {
              	disabledEvent(e);
              }
              // "J" key
              if (e.ctrlKey && e.shiftKey && e.keyCode == 74) {
              	disabledEvent(e);
              }
              // "S" key + macOS
              if (e.keyCode == 83 && (navigator.platform.match("Mac") ? e.metaKey : e.ctrlKey)) {
              	disabledEvent(e);
              }
              // "U" key
              if (e.ctrlKey && e.keyCode == 85) {
              	disabledEvent(e);
              }
              // "F12" key
              if (event.keyCode == 123) {
              	disabledEvent(e);
              }
          }, false);
		function disabledEvent(e){
			if (e.stopPropagation){
				e.stopPropagation();
			} else if (window.event){
				window.event.cancelBubble = true;
			}
			e.preventDefault();
			return false;
		}
	};
</script>
<script>
	$(document).ready(function(){
		$(window).scroll(function(){
			if ($(this).scrollTop() > 100) {
				$('a[href="#top"]').fadeIn();
			} else {
				$('a[href="#top"]').fadeOut();
			}
		});

		$('a[href="#top"]').click(function(){
			$('html, body').animate({scrollTop : 0},800);
			return false;
		});
	});
</script>
<script>

	// AQUI ESTÁ A CORREÇÃO
	// Passo 2: A função view_pedido precisa enviar o ID da sessão
	$(document).ready(function(){
		$(document).on('click','.view_data', function(){
			var user_id = $(this).attr("id");
					//alert(user_id);
					//Verificar se há valor na variável "user_id".
					if(user_id !== ''){
						var dados = {
							user_id: user_id
						};
						$.post('ajax/produtom.php', dados, function(retorna){
							//Carregar o conteúdo para o usuário
							$("#visul_usuario").html(retorna);
							$('#visulUsuarioModal').modal('show'); 
						});
					}
				});
	});
	
	$(document).ready(function(){
		$(document).on('click','.view_local', function(){
			var user_idx = $(this).attr("id");
					if(user_idx !== ''){
						var dados = {
							user_idx: user_idx
						};
						$.post('ajax/local.php', dados, function(retorna){
							//Carregar o conteúdo para o usuário
							$("#visul_local").html(retorna);
							$('#visulLocalModal').modal('show'); 
						});
					}
				});
	});
	
	$(document).ready(function(){
		$(document).on('click','.view_hora', function(){
			var user_idx = $(this).attr("id");
					if(user_idx !== ''){
						var dados = {
							user_idx: user_idx
						};
						$.post('ajax/horario.php', dados, function(retorna){
							//Carregar o conteúdo para o usuário
							$("#visul_hora").html(retorna);
							$('#visulHoraModal').modal('show'); 
						});
					}
				});
	});
	
	$(document).ready(function(){
		$(document).on('click','.view_pedido', function(){
			var user_idx = $(this).attr("id");
					if(user_idx !== ''){
						var dados = {
							user_idx: user_idx,
							id_carrinho: '<?php echo $id_carrinho_temp; ?>' // Adicionamos o ID da sessão aqui
						};
						$.post('ajax/pedido.php', dados, function(retorna){
							//Carregar o conteúdo para o usuário
							$("#visul_pedido").html(retorna);
							$('#visulPedidoModal').modal('show'); 
						});
					}
				});
	});
	

</script>
<script>
	$('.dinheiro').mask('#.##0,00', {reverse: true});
</script>
<script>
	$('#select-taxa').change(function() {
		window.location = $(this).val();
	});
</script>
<script>
      $(function(){
        'use strict';

        $('.select2').select2({
          minimumResultsForSearch: Infinity
        });

        // Select2 by showing the search
        $('.select2-show-search').select2({
          minimumResultsForSearch: ''
        });

        // Colored Hover
        $('#select2').select2({
          dropdownCssClass: 'hover-success',
          minimumResultsForSearch: Infinity // disabling search
        });

        $('#select3').select2({
          dropdownCssClass: 'hover-danger',
          minimumResultsForSearch: Infinity // disabling search
        });

        // Outline Select
        $('#select4').select2({
          containerCssClass: 'select2-outline-success',
          dropdownCssClass: 'bd-success hover-success',
          minimumResultsForSearch: Infinity // disabling search
        });

        $('#select5').select2({
          containerCssClass: 'select2-outline-info',
          dropdownCssClass: 'bd-info hover-info',
          minimumResultsForSearch: Infinity // disabling search
        });

        // Full Colored Select Box
        $('#select6').select2({
          containerCssClass: 'select2-full-color select2-primary',
          minimumResultsForSearch: Infinity // disabling search
        });

        $('#select7').select2({
          containerCssClass: 'select2-full-color select2-danger',
          dropdownCssClass: 'hover-danger',
          minimumResultsForSearch: Infinity // disabling search
        });

        // Full Colored Dropdown
        $('#select8').select2({
          dropdownCssClass: 'select2-drop-color select2-drop-primary',
          minimumResultsForSearch: Infinity // disabling search
        });

        $('#select9').select2({
          dropdownCssClass: 'select2-drop-color select2-drop-indigo',
          minimumResultsForSearch: Infinity // disabling search
        });

        // Full colored for both box and dropdown
        $('#select10').select2({
          containerCssClass: 'select2-full-color select2-primary',
          dropdownCssClass: 'select2-drop-color select2-drop-primary',
          minimumResultsForSearch: Infinity // disabling search
        });

        $('#select11').select2({
          containerCssClass: 'select2-full-color select2-indigo',
          dropdownCssClass: 'select2-drop-color select2-drop-indigo',
          minimumResultsForSearch: Infinity // disabling search
        });
      });
    </script>
	<script>

        $(document).ready(function() {

            function limpa_formulário_cep() {
                // Limpa valores do formulário de cep.
                $("#rua").val("");
                $("#bairro").val("");
                $("#cidade").val("");
                $("#uf").val("");
                $("#ibge").val("");
            }
            
            //Quando o campo cep perde o foco.
            $("#cep").blur(function() {

                //Nova variável "cep" somente com dígitos.
                var cep = $(this).val().replace(/\D/g, '');

                //Verifica se campo cep possui valor informado.
                if (cep != "") {

                    //Expressão regular para validar o CEP.
                    var validacep = /^[0-9]{8}$/;

                    //Valida o formato do CEP.
                    if(validacep.test(cep)) {

                        //Preenche os campos com "..." enquanto consulta webservice.
                        $("#rua").val("...");
                        $("#bairro").val("...");
                        $("#cidade").val("...");
                        $("#uf").val("...");
                        $("#ibge").val("...");

                        //Consulta o webservice viacep.com.br/
                        $.getJSON("https://viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {

                            if (!("erro" in dados)) {
                                //Atualiza os campos com os valores da consulta.
                                $("#rua").val(dados.logradouro);
                                $("#bairro").val(dados.bairro);
                                $("#cidade").val(dados.localidade);
                                $("#uf").val(dados.uf);
                                $("#ibge").val(dados.ibge);
                            } //end if.
                            else {
                                //CEP pesquisado não foi encontrado.
                                limpa_formulário_cep();
                                alert("CEP não encontrado.");
                            }
                        });
                    } //end if.
                    else {
                        //cep é inválido.
                        limpa_formulário_cep();
                        alert("Formato de CEP inválido.");
                    }
                } //end if.
                else {
                    //cep sem valor, limpa formulário.
                    limpa_formulário_cep();
                }
            });
        });

    </script>
</body>
</html>
<?php
ob_end_flush();
?>