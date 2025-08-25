<?php
ob_start();
session_start();

// Usa o ID da sessão como o ID temporário do carrinho
$id_carrinho_temp = session_id();

include_once('../../funcoes/Conexao.php');
include_once('../../funcoes/Key.php');

if(isset($_POST["produto"])){

    $iduser     = $_POST["iduser"];
    $idcat      = $_POST["idcat"];
    $produto    = $_POST["produto"];
    $valor      = $_POST["valor"];
    $quantidade = $_POST["quantidade"];
    $obser      = $_POST["observacoes"];

    $id_do_item_principal = null;

    if(isset($_POST['tamanho'])){
        $taman = $_POST['tamanho'];
        $array = explode(',',$taman);

        $inserpro = $connect->prepare("INSERT INTO store (idu, idsecao, produto_id, data, valor, quantidade, tamanho, obs) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $inserpro->execute([$iduser, $id_carrinho_temp, $produto, date("d-m-Y"), $array[1], $quantidade, $array[0], $obser]);

        // Captura o ID do item principal que acabou de ser inserido
        $id_do_item_principal = $connect->lastInsertId();

    } else {
        $inserpro = $connect->prepare("INSERT INTO store (idu, idsecao, produto_id, data, valor, quantidade, obs) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $inserpro->execute([$iduser, $id_carrinho_temp, $produto, date("d-m-Y"), $valor, $quantidade, $obser]);
        
        // Captura o ID do item principal que acabou de ser inserido
        $id_do_item_principal = $connect->lastInsertId();
    }
    
    // Agora que temos o ID do item principal, podemos inserir os adicionais
    if(isset($_POST['meioameios'])){
        foreach($_POST['meioameios'] as $valueo){
            $text = $valueo;    
            $array = explode(',',$text);
            $inserpro = $connect->prepare("INSERT INTO store_o (idu, ids, idp, nome, valor, quantidade, meioameio) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $inserpro->execute([$iduser, $id_carrinho_temp, $id_do_item_principal, $array[0], $array[1], $quantidade, '1']);
        }
        $pegarmaiorvalor = $connect->prepare("SELECT MAX(valor) AS valor FROM store_o WHERE ids=? AND meioameio='1'");
        $pegarmaiorvalor->execute([$id_carrinho_temp]);
        $pegarmaiorvalorx = $pegarmaiorvalor->fetch(PDO::FETCH_OBJ);
        $idlXd = $pegarmaiorvalorx->valor;

        $alteravalor = $connect->prepare("UPDATE store SET valor=? WHERE idsecao=?");
        $alteravalor->execute([$idlXd, $id_carrinho_temp]);
    }

    if(isset($_POST['opcionais'])){
        foreach ($_POST['opcionais'] as $Id => $valueo){
            $text = $valueo;    
            $array = explode(',',$text);
            $inserpro = $connect->prepare("INSERT INTO store_o (idu, ids, idp, nome, valor, quantidade, meioameio) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $inserpro->execute([$iduser, $id_carrinho_temp, $id_do_item_principal, $array[0], $array[1], $quantidade, '0']);
        }
    }

    header("location: ../?ok=");    
    exit;
}

if(isset($_GET["up"])){ echo unlink("".$_GET["up"].""); }

ob_end_flush();
?>