<?php use core\classes\Store;  ?>
<div class="container-fluid p-0 m-0">
    <div class="row pe-2">

        <div class="col-md-2">
            <?php include(__DIR__ . "/../partials/aside.php") ?>
        </div>

        <div class="col-md-10 bg-dark p-4">
            
            <h4 class="mb-4 mt-2">Lista de usuários</h4>

            <?php if(count($clients) ==0): ?>
                <p>Não existem usuários cadastrados!</p>
            <?php else: ?>

                <!-- Tabela de clientes -->
                <div class="table-responsive">

                    <table class="table table-bordered pt-4 text-white" id="table-clients">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Email</th>
                                <th>Telefone</th>
                                <th class="text-center">Compras</th>
                                <th class="text-center">Ativo</th>
                                <th class="text-center">Excluido</th>
                            </tr>
                        </thead>
                        <tbody>
    
                            <?php foreach($clients as $client): ?>
                                <tr>
                                    <td>
                                        <a
                                            href="?a=detailsUser&user=<?=Store::aesEncrypt($client->id_client)?>"
                                            class="text-decoration-none"
                                        >
                                            <?=$client->name?>
                                        </a>
                                    </td>
                                    <td><?=$client->email?></td>
                                    <td><?=$client->phone?></td>
                                    <td class="text-center">
                                        <?php if($client->totalUserOrders == 0): ?>
                                            -
                                        <?php else : ?>
                                            <a
                                                href="?a=ordersList&user=<?= Store::aesEncrypt($client->id_client) ?>"
                                                class="text-decoration-none"
                                            >
                                                <?=$client->totalUserOrders?>
                                            </a>
                                        <?php endif ?>
                                    </td>
    
                                    <td class="text-center">
                                        <?php if($client->active == 1): ?>
                                            <span class="text-success">
                                                <i class="far fa-check-square"></i>
                                            </span>
                                        <?php else: ?>
                                            <span class="text-danger">
                                                <i class="fas fa-exclamation"></i>
                                            </span>
                                        <?php endif; ?>
                                    </td>
    
                                    <td class="text-center">
                                        <?php if($client->deleted_at == NULL): ?>
                                            <span class="text-danger">
                                                <i class="fas fa-exclamation"></i>
                                            </span>
                                        <?php else: ?>
                                            <span class="text-success">
                                                <i class="fas fa-exclamation"></i>
                                            </span>
                                        <?php endif; ?>
                                    </td>
    
                                </tr>
                            <?php endforeach ?>
    
                        </tbody>
                    </table>
                </div>

            <?php endif ?>

        </div>

    </div>
</div>

<script>
    $(document).ready(function () {
        $("#table-clients").DataTable({
            language: {
                "decimal": "",
                "emptyTable": "No data available in table",
                "info": "Mostrando _START_ de _TOTAL_ usuários",
                "infoEmpty": "Não existem usuários disponíveis",
                "infoFiltered": "(Filtrando um total de _MAX_ usuários)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Mostrar _MENU_ usuários por página",
                "loadingRecords": "Carregando...",
                "processing": "Processando...",
                "search": "Pesquisar:",
                "zeroRecords": "Não foi encontrado nenhuma venda!",
                "paginate": {
                    "first": "Primeiro",
                    "last": "Última",
                    "next": "Seguinte",
                    "previous": "Anterior"
                },
                "aria": {
                    "sortAscending": ": activate to sort column ascending",
                    "sortDescending": ": activate to sort column descending"
                }
            }

        });
    });
</script>