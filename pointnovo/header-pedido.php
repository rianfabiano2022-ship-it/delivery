<?php
// Ativa o buffering de saída.
ob_start();

// Configurações de segurança para a sessão
ini_set('session.cookie_httponly', 1);
if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
    ini_set('session.cookie_secure', 1);
}

// Inicia a sessão.
session_start();

// 1. Inclui os arquivos de conexão e base PRIMEIRO
// A pasta 'funcoes' está um nível acima da pasta 'pointnovo'.
include('../funcoes/Conexao.php');
include('../funcoes/Key.php');
include('db/base.php'); // <-- Inclua base.php aqui para definir a constante HOME

// 2. Agora, a constante HOME já está definida e você pode usá-la.
$xurl = 'pointnovo';
$site = HOME;

// 3. Inclua os outros arquivos de função que podem depender de HOME ou de outras variáveis
include('db/Funcoes.php');

// Tratamento seguro para a variável $Url
$Url[1] = isset($Url[1]) && !empty($Url[1]) ? htmlspecialchars($Url[1], ENT_QUOTES, 'UTF-8') : null;

?>