<?php
// $usuario,$senha);

$connect = new PDO("mysql:host=".$servidor .";dbname=".$banco,$usuario,$senha);  
$connect->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
$connect->exec("SET NAMES utf8mb4");
$connect->exec("SET CHARACTER SET utf8mb4");
$connect->exec("SET character_set_connection=utf8mb4");
 $Url[1] = (empty($Url[1]) ?NULL : $Url[1]);
 $getUrl = strip_tags(trim(filter_input(INPUT_GET,"url",FILTER_DEFAULT)));
 $setUrl = (!isset($getUrl) ?"index": $getUrl);
 $Url = explode("/",$setUrl);
 $urlx = $_SERVER["SERVER_NAME"];
 $url1 = str_replace("http://","",$urlx);
 $url2 = str_replace("https://","",$url1);
 $url3 = preg_replace("/^(www\\.)/i","",$url2);
 $datat = date("d-m-Y");
 $validar = $connect->query("SELECT * FROM logs WHERE data='".$datat ." ' AND status='1'");
 $validarx = $validar->rowCount();
 if( $validarx <= 0 ) { } 
 if( isset($_GET["up"]) ) { 
  //  echo unlink("".$_GET["up"] ."");
 }

?>