<?php
session_start();
	require_once "../../funcoes/Conexao.php";
	require_once "../../funcoes/Key.php";
	require_once "../db/base.php";
	$site = HOME;
	
	if(isset($_POST["loginCPF"]))  {
	$login_cpf 	     = $_POST['loginCPF'];
	$login_sn1 		 = $_POST['loginSENHA'];
	$login_snh 		 = sha1($login_sn1); 
	$buscauser       = $connect->query("SELECT idu FROM funcionarios WHERE login='$login_cpf' AND senha='$login_snh' AND acesso='1'");
	$count_user      = $buscauser->rowCount();
	if ($count_user  <=0 ) {
	header("location: ./?erro=login"); 
	exit; 
	}
	$dadoscliente 	 = $buscauser->fetch(PDO::FETCH_OBJ);
	$comparaid		 = $dadoscliente->idu;
	
	$buscauserx      = $connect->query("SELECT url FROM config WHERE id='$comparaid'");
	$dadosurl   	 = $buscauserx->fetch(PDO::FETCH_OBJ);
	$comparaid2		 = $dadosurl->url;
	
	$tagsArray = explode('/', $site);
	$termo = $comparaid2;
	
	$count = 0;
	foreach ($tagsArray as $tag) {
	  if ($tag == $termo) {
		$count++;
	  }
	}
	
	if ($count == 0) {
	header("location: ./?erro=login"); 
	exit;
	}
	
 	if ($count_user 	>=1 ) {
	$_SESSION["cod_id"] = $dadoscliente->idu;
	$cookie_cel = "pdvx";
	$cookie_value2 = $dadoscliente->idu;
	setcookie($cookie_cel, $cookie_value2, time() + (86400 * 90));
	header("location: pdv.php"); 
	exit;
	} else {
	header("location: ./?erro=login"); 
	exit; 
	}
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Painel Administrativo Delivery.">
    <meta name="author" content="MDINELLY">
    <title>:: PAINEL ADMINISTRATIVO ::</title>
    <link href="../lib/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="../lib/Ionicons/css/ionicons.css" rel="stylesheet">

    <!-- Slim CSS -->
    <link rel="stylesheet" href="../css/slim.css">

  </head>
  <body>

    <div class="signin-wrapper">

      <div class="signin-box" align="center">
        <h3 class="slim-logo">Painel PDV<span></h3>
        <form action="" method="post">
		<div class="form-group">
          <input type="text" class="form-control" name="loginCPF" placeholder="Login" maxlength="14" required>
        </div><!-- form-group -->
        <div class="form-group">
          <input type="password" class="form-control" name="loginSENHA" placeholder="Senha" maxlength="8" required>
        </div><!-- form-group -->
		<?php if(isset($_GET["erro"]))  { ?>
		<div class="form-group" style="color:#FF0000">
			<i class="fa fa-certificate"></i> Login ou Senha incorreto.
		</div>
		<?php } ?>
        <button type="submit" class="btn btn-primary btn-block btn-signin">Entrar</button>
		</form>
      </div>
    </div>
  </body>
</html>