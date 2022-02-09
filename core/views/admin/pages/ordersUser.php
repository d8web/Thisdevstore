<div class="container-fluid p-0 m-0"></div>
    <div class="row">

        <div class="col-md-2">
            <?php include(__DIR__ . "/../partials/aside.php") ?>
        </div>

        <div class="col-md-10 pe-4">

            <h4 class="mb-4 mt-4">
                Lista de compras do usuário
            </h4>

            <hr>
            <div class="row">
                <div class="col">
                    <span class="fw-bold">Nome: <span class="fw-normal"><?= $user->name ?></span></span>
                </div>
                <div class="col">
                    <span class="fw-bold">Email: <span class="fw-normal"><?= $user->email ?></span></span>
                </div>
                <div class="col">
                    <span class="fw-bold">Telefone: <span class="fw-normal"><?= $user->phone ?></span></span>
                </div>
            </div>
            <hr>

            <?php if (count($ordersUser) == 0) : ?>

                <p>Este usuário ainda não fez compras.</p>

            <?php else : ?>

                <div class="table-responsive pe-3 mt-4">
                    <table class="table table-sm table-bordered pt-3" id="list-sales">
                        <thead class="border-bottom">
                            <tr>
                                <th>Data</th>
                                <th>Endereço</th>
                                <th>Cidade</th>
                                <th>Email</th>
                                <th>Telefone</th>
                                <th>Código</th>
                                <th>Status</th>
                                <th>Mensagem</th>
                                <th class="text-end">Atualizado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($ordersUser as $item) : ?>
                                <tr class="border-bottom m-2">
                                    <td><?= date("d/m/Y", strtotime($item->date)) ?></td>
                                    <td><?= $item->address ?></td>
                                    <td><?= $item->city ?></td>
                                    <td><?= $item->email ?></td>
                                    <td><?= $item->phone != "" ? $item->phone : "Sem telefone" ?></td>
                                    <td><?= $item->code_order ?></td>
                                    <td>
                                        <?php
                                            switch($item->status) {
                                                case "PENDING":
                                                    echo "Pendente";
                                                break;
                                                case "PROCESSING":
                                                    echo "Processando";
                                                break;
                                                case "CANCELED":
                                                    echo "Cancelada";
                                                break;
                                                case "SEND":
                                                    echo "Enviada";
                                                break;
                                                case "CONCLUDED":
                                                    echo "Concluída";
                                                break;
                                            }
                                        ?>
                                    </td>
                                    <td><?= $item->message ?></td>
                                    <td class="text-end">
                                        <?= date("d/m/Y", strtotime($item->updated_at)) ?>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>

            <?php endif; ?>

        </div>
    </div>
</div>

<script>

$(document).ready(function () {
        $('#list-sales').DataTable({

            /*
            language: {
                lengthMenu: "Apresenta _MENU_ vendas por página",
                zeroRecords: "Não foi encontrado nenhuma venda!",
                info: "Página _PAGE_ de _PAGES_",
                infoEmpty: "Não existem vendas disponíveis",
                infoFiltered: "(Filtrando um total de _MAX_ vendas)"
            }
            */

            language: {
                "decimal": "",
                "emptyTable": "No data available in table",
                "info": "Mostrando _START_ de _TOTAL_ vendas",
                "infoEmpty": "Não existem vendas disponíveis",
                "infoFiltered": "(Filtrando um total de _MAX_ vendas)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Mostrar _MENU_ vendas por página",
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

    const defineFilter = () => {
        let filter = document.getElementById("combo-status").value
        
        // Reload na página com determinado filtro
        window.location.href = window.location.pathname +"?"+$.param({ 'a':'ordersList','filter':filter });
    }

</script>