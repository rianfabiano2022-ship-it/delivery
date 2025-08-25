<?php
require_once "topo.php";

// A consulta SQL foi atualizada para somar apenas os pedidos com status '5'
$sql_clientes = "SELECT 
                    c.id, 
                    c.nome, 
                    c.telefone,
                    SUM(CASE WHEN p.status = '5' THEN p.vtotal ELSE 0 END) AS total_gasto
                FROM 
                    clientes c
                LEFT JOIN 
                    pedidos p ON c.id = p.id_cliente
                GROUP BY 
                    c.id
                ORDER BY 
                    c.nome ASC";

$dadclis = $connect->query($sql_clientes);
?>
<div class="slim-mainpanel">
    <div class="container">
        <?php if(isset($_GET["erro"])){?>
        <div class="alert alert-warning" role="alert">
            <i class="fa fa-asterisk" aria-hidden="true"></i> Erro.
        </div>
        <?php }?>
        <?php if(isset($_GET["ok"])){?>
        <div class="alert alert-success" role="alert">
            <i class="fa fa-thumbs-o-up" aria-hidden="true"></i> Sucesso.
        </div>
        <?php }?>

        <div class="section-wrapper">
            <label class="section-title"><i class="fa fa-users" aria-hidden="true"></i> LISTA DE CLIENTES</label>
            <hr>
            <div class="table-wrapper">
                <table id="datatable1" class="table display responsive nowrap" width="100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Telefone</th>
                            <th>Total Gasto</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Itera sobre o resultado da busca no banco de dados
                        while ($dadoscli = $dadclis->fetch(PDO::FETCH_OBJ)) {
                            // Formata o valor total gasto para a moeda brasileira
                            $total_gasto = "R$ " . number_format($dadoscli->total_gasto, 2, ',', '.');
                        ?>
                        <tr>
                            <td><?php print $dadoscli->id;?></td>
                            <td><?php print $dadoscli->nome;?></td>
                            <td><?php print $dadoscli->telefone;?></td>
                            <td><?php print $total_gasto;?></td>
                            <td align="center">
                                <a href="pedidos_cliente.php?id_cliente=<?php print $dadoscli->id;?>">
                                    <button class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Ver Pedidos">
                                        <i class="fa fa-list-alt"></i>
                                    </button>
                                </a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script src="../lib/jquery/js/jquery.js"></script>
<script src="../lib/datatables/js/jquery.dataTables.js"></script>
<script src="../lib/datatables-responsive/js/dataTables.responsive.js"></script>
<script src="../lib/select2/js/select2.min.js"></script>

<script>
    $(function(){
        'use strict';
        $('#datatable1').DataTable({
            responsive: true,
            language: {
                searchPlaceholder: 'Buscar...',
                sSearch: '',
                lengthMenu: '_MENU_ ítens',
            }
        });
        $('.dataTables_length select').select2({ minimumResultsForSearch: Infinity });
    });
</script>
<script src="../js/slim.js"></script>
</body>
</html>