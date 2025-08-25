<?php
session_start();
    require_once "../../funcoes/Conexao.php";
	require_once "../../funcoes/Key.php";
	if(isset($_POST["loginCPF"]))  {
	$login_cpf 	    = $_POST['loginCPF'];
	$emaillogin 	= $_POST['loginEMAIL'];
	$celularlogin 	= $_POST['loginCEL'];
	$login_snh 		= sha1("123mudar"); 
	$buscauser       = $connect->query("SELECT * FROM config WHERE cpf='$login_cpf' AND email='$emaillogin' AND celular='$celularlogin'");
	$count_user      = $buscauser->rowCount();
 	if ($count_user  >=1 ) {
	$update = $connect->query("UPDATE config SET senha='$login_snh' WHERE cpf='$login_cpf'");
	header("location: ./recuperar.php?senhaok=ok"); 
	exit;
	} else {
	header("location: ./recuperar.php?senhaerro=ok"); 
	exit; 
	}
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Premium Quality and Responsive UI for Dashboard.">
    <meta name="author" content="ThemePixels">
    <title>:: PAINEL ADMINISTRATIVO ::</title>
    <link href="../lib/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="../lib/Ionicons/css/ionicons.css" rel="stylesheet">

    <!-- Slim CSS -->
    <link rel="stylesheet" href="../css/slim.css">

  </head>
  <body>

    <div class="signin-wrapper">

      <div class="signin-box" align="center">
        <h3 class="slim-logo">Painel do Cliente<span></h3>
        <form action="" method="post">
		<div class="form-group">
          <input type="text" class="form-control" name="loginCPF" placeholder="CPF/CNPJ" maxlength="14" required>
        </div><!-- form-group -->
		<div class="form-group">
          <input type="email" class="form-control" name="loginEMAIL" placeholder="E-mail" maxlength="60" required>
        </div><!-- form-group -->
        <div class="form-group">
          <input type="text" class="form-control" name="loginCEL" placeholder="Celular" maxlength="11" required>
        </div><!-- form-group -->
		<?php if(isset($_GET["senhaerro"]))  { ?>
		<div class="form-group" style="color:#FF0000">
			<i class="fa fa-certificate"></i> Dados Incorretos.
		</div>
		<?php } ?>
		<?php if(isset($_GET["senhaok"]))  { ?>
		<div class="form-group" style="color:#009900">
			<i class="fa fa-certificate"></i> Sua nova senha é 123mudar.
		</div>
		<?php } ?>
        <button type="submit" class="btn btn-primary btn-block btn-signin">Recuperar Senha</button>
		</form>
        <p class="mg-b-0">Fazer Login? <a href="./">Clique aqui...</a></p>
      </div>
    </div>
  </body>
</html>