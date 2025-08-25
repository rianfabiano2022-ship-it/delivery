<?php
require_once "topo.php";

// Atualiza visibilidade se receber parâmetro na URL
if (isset($_GET['exediascat']) && isset($_GET['idcat'])) {
    $dias = $_GET['exediascat'];
    $idcat = $_GET['idcat'];
    $editardias = $connect->query("UPDATE categorias SET visivel='$dias' WHERE id='$idcat' AND idu='$cod_id'");
    if ($editardias) {
        header("Location: exibirdiascat.php?idcat=$idcat&ok=ok");
        exit;
    } else {
        header("Location: exibirdiascat.php?idcat=$idcat&erro=erro");
        exit;
    }
}

$codigoc = $_GET['idcat'];
$editarcat = $connect->query("SELECT * FROM categorias WHERE id='$codigoc' AND idu='$cod_id'");
$dadoscat = $editarcat->fetch(PDO::FETCH_OBJ);

$visi = "Desconhecido";
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
            <i class="fa fa-asterisk" aria-hidden="true"></i> Erro ao salvar.
        </div>
        <?php }?>
        <?php if(isset($_GET["ok"])){?>
        <div class="alert alert-success" role="alert">
            <i class="fa fa-thumbs-o-up" aria-hidden="true"></i> Salvo com sucesso.
        </div>
        <?php }?>

        <div class="section-wrapper mg-b-20">
            <label class="section-title"><i class="fa fa-check-square-o" aria-hidden="true"></i> DIAS DE EXIBIÇÃO DA CATEGORIA</label>
            <hr>
            <form action="" method="post">
                <div class="form-layout">
                    <div class="row mg-b-25">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-control-label">Categoria: <span class="tx-danger">*</span></label>
                                <input type="text" class="form-control" value="<?php print $dadoscat->nome; ?>" disabled>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label class="form-control-label">Dias de Exibição: <span class="tx-danger">*</span></label>
                                <select id="select-dias" class="form-control" required>
                                    <option value=""><?php print $visi;?></option>
                                    <option value="./exibirdiascat.php?exediascat=G&idcat=<?php print $dadoscat->id;?>">Todos os Dias</option>
                                    <option value="./exibirdiascat.php?exediascat=1&idcat=<?php print $dadoscat->id;?>">Segunda</option>
                                    <option value="./exibirdiascat.php?exediascat=2&idcat=<?php print $dadoscat->id;?>">Terça</option>
                                    <option value="./exibirdiascat.php?exediascat=3&idcat=<?php print $dadoscat->id;?>">Quarta</option>
                                    <option value="./exibirdiascat.php?exediascat=4&idcat=<?php print $dadoscat->id;?>">Quinta</option>
                                    <option value="./exibirdiascat.php?exediascat=5&idcat=<?php print $dadoscat->id;?>">Sexta</option>
                                    <option value="./exibirdiascat.php?exediascat=6&idcat=<?php print $dadoscat->id;?>">Sábado</option>
                                    <option value="./exibirdiascat.php?exediascat=0&idcat=<?php print $dadoscat->id;?>">Domingo</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row mg-b-25">
                        <div class="col-lg-10" style="text-align:right;">
                            <a href="categorias.php" class="btn btn-secondary">
                                <i class="fa fa-arrow-left"></i> Voltar
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="../lib/jquery/js/jquery.js"></script>
<script src="../js/slim.js"></script>
<script>
$('#select-dias').change(function() {
    window.location = $(this).val();
});
</script>
</body>
</html>