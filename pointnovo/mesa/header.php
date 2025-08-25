<?php
ob_start();
if(isset($_COOKIE['pedidomesa'])){
$id_mesa = $_COOKIE['pedidomesa'];
} else {
$cookie_cel = 'pedidomesa';
$cookie_value2 = rand(100000, 999999);
setcookie($cookie_cel, $cookie_value2, time() + (3500 * 5));
$id_mesa = $_COOKIE['pedidomesa'];
}
if(!isset($id_mesa)) { header('location: finalizado.php'); exit; }
include('../../funcoes/Conexao.php');
include('../../funcoes/Key.php');
include('../db/base.php');
require('../db/Mobile_Detect.php');
$detect = new Mobile_Detect;
$xurl = 'pointdapizza';
$site = HOME;
include('FuncoesM.php');
