<?php
require_once "topo.php";
require_once __DIR__ . "/../../funcoes/Conexao.php";

// Pega o ID do cliente logado na sessão (ajuste o nome da variável conforme seu sistema)
if (!isset($_SESSION['cod_id'])) {
    // Cliente não logado, redireciona para login ou mostra erro
    header('Location: ./login.php');
    exit();
}

$clienteId = $_SESSION['cod_id'];

// Busca os dados do cliente logado no banco
$stmt = $pdo->prepare("SELECT id, status, expiracao FROM config WHERE id = :id");
$stmt->execute(['id' => $clienteId]);
$configadmin = $stmt->fetch(PDO::FETCH_OBJ);

if (!$configadmin) {
    die("Cliente não encontrado.");
}

// Cria item para pagamento
$item = new MercadoPago\Item();
$item->title = "Renovação de plano - 30 dias";
$item->quantity = 1;
$item->unit_price = 50.00; // Valor desejado

// Cria preferência com external_reference igual ao ID do cliente logado
$preference = new MercadoPago\Preference();
$preference->items = array($item);
$preference->external_reference = $configadmin->id;
$preference->save();
$link = $preference->init_point;

// Calcula prazo para exibir na tela
$dataHoje = new DateTime();
$dataExpiracao = new DateTime($configadmin->expiracao);
$prazo = $dataHoje->diff($dataExpiracao)->days;
if ($dataHoje > $dataExpiracao) $prazo = 0;
?>
<div class="slim-mainpanel">
    <div class="container">
      <div class="row row-sm mg-t-20">
            <div class="col-lg-12">
                <div class="card card-info">
                    <div class="card-body pd-40">
                        <div class="row">
                            <div class="col-md-3">
                                <img src="../img/fim.png" alt="" class="img-thumbnail"/>
                            </div>
                            <div class="col-md-9" align="justify">
                                <br>
                                <?php if($prazo <= 5 && $prazo >= 1){?> 
                                <span style="font-size:18px">
                                    OLÁ AMIGO CLIENTE. SEU PLANO VENCE EM 
                                    <span style="color:#FF0033; font-size:28px"><?= $prazo;?></span> DIAS.
                                </span><br><br>
                                <?php } ?> 
                                <?php if($prazo <= 0){?> 
                                <span style="font-size:18px">
                                    OLÁ AMIGO CLIENTE. SEU PLANO ESTÁ 
                                    <span style="color:#FF0033;">EXPIRADO</span>
                                </span><br><br>
                                <?php } ?> 
                                <span>
                                    Clique no botão abaixo para renovar seu plano por mais <b>30 dias</b>.
                                    Você será redirecionado para uma tela de pagamento seguro.
                                </span><br><br>
                                <center>
                                    <a href="<?= htmlspecialchars($link) ?>" target="_blank" class="btn btn-primary">Pagar agora</a>
                                </center><br><br>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
      </div>
    </div>
</div>
<script src="../lib/jquery/js/jquery.js"></script>
</body>
</html>
<?php ob_end_flush(); ?>
