<?php
require_once "topo.php";

// Obtém o ID do cliente da URL
if (!isset($_GET['id_cliente']) || !is_numeric($_GET['id_cliente'])) {
    header("Location: clientes.php?erro");
    exit();
}
$id_cliente = $_GET['id_cliente'];

// Busca o nome do cliente para o título da página
$sql_cliente = "SELECT nome FROM clientes WHERE id = :id_cliente";
$stmt_cliente = $connect->prepare($sql_cliente);
$stmt_cliente->bindParam(':id_cliente', $id_cliente, PDO::PARAM_INT);
$stmt_cliente->execute();
$dados_cliente = $stmt_cliente->fetch(PDO::FETCH_OBJ);
$nome_cliente = $dados_cliente ? $dados_cliente->nome : "Não Encontrado";

// Consulta para buscar todos os itens, agrupados por pedido e data
// Adicionei a coluna 'data' e 'vtotal' da tabela pedidos
$sql_pedidos = "SELECT 
                    p.idpedido, 
                    p.data,
                    p.vtotal,
                    so.nome AS nome_produto, 
                    so.valor AS valor_produto
                FROM 
                    pedidos p
                JOIN 
                    store s ON p.idpedido = s.idsecao
                JOIN 
                    store_o so ON s.id = so.idp
                WHERE 
                    p.id_cliente = :id_cliente
                ORDER BY 
                    p.idpedido DESC";

$stmt_pedidos = $connect->prepare($sql_pedidos);
$stmt_pedidos->bindParam(':id_cliente', $id_cliente, PDO::PARAM_INT);
$stmt_pedidos->execute();
?>
<div class="slim-mainpanel">
    <div class="container">
        <div class="section-wrapper">
            <label class="section-title">
                <i class="fa fa-list-alt" aria-hidden="true"></i> Pedidos de: **<?php echo htmlspecialchars($nome_cliente); ?>**
            </label>
            <hr>
            <a href="clientes.php" class="btn btn-secondary mg-b-20"><i class="fa fa-arrow-left"></i> Voltar para Clientes</a>

            <?php
            $current_pedido_id = null;
            while ($dados_pedido = $stmt_pedidos->fetch(PDO::FETCH_OBJ)) {
                // Se o ID do pedido for diferente do anterior, inicia uma nova seção
                if ($dados_pedido->idpedido != $current_pedido_id) {
                    if ($current_pedido_id !== null) {
                        // Fecha a tabela anterior (se não for a primeira iteração)
                        echo "</tbody></table></div></div>";
                    }

                    // Inicia a nova seção do pedido
                    $current_pedido_id = $dados_pedido->idpedido;
                    $data_pedido = date('d/m/Y H:i', strtotime($dados_pedido->data));
                    $total_pedido = "R$ " . number_format($dados_pedido->vtotal, 2, ',', '.');
                    
                    echo '<div class="card mg-b-20">';
                    echo '<div class="card-header bg-primary text-white">';
                    echo 'Pedido **#'.$current_pedido_id.'** | Data: '.$data_pedido.' | Valor Total: '.$total_pedido;
                    echo '</div>';
                    echo '<div class="card-body">';
                    echo '<table class="table table-striped">';
                    echo '<thead><tr><th>Produto</th><th>Valor</th></tr></thead><tbody>';
                }
                
                // Exibe o item do pedido
                $valor_produto_formatado = "R$ " . number_format($dados_pedido->valor_produto, 2, ',', '.');
                echo '<tr><td>'.htmlspecialchars($dados_pedido->nome_produto).'</td><td>'.$valor_produto_formatado.'</td></tr>';
            }

            // Fecha a última tabela após o loop
            if ($current_pedido_id !== null) {
                echo "</tbody></table></div></div>";
            }
            ?>
        </div>
    </div>
</div>

<script src="../lib/jquery/js/jquery.js"></script>
<script src="../js/slim.js"></script>
</body>
</html>