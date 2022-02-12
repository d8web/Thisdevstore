<?php use core\classes\Store; ?>
<div class="container-fluid p-0 m-0"></div>
    <div class="row pe-1">

        <div class="col-md-2">
            <?php include(__DIR__ . "/../partials/aside.php") ?>
        </div>

        <div class="col-md-10 bg-dark p-4">

            <h4 class="mb-4 mt-2">
                Lista de Vendas <?= $filter != "" ? $filter : "" ?>
            </h4>

            <div class="d-flex mb-4 justify-content-between pe-2">
                <div class="flex-grow-1">
                    <a href="?a=ordersList" class="btn btn-primary">Todas as vendas</a>
                </div>
                <div class="d-flex justify-content-end align-items-center flex-grow-1">
                    <span class="me-4 d-flex w-50 justify-content-end">
                        Escolha um status
                    </span>

                    <?php
                        $f = "";
                        if (isset($_GET["filter"])) {
                            $f = $_GET["filter"];
                        }
                    ?>

                    <select class="form-select w-25 bg-transparent text-white" id="combo-status" onchange="defineFilter()">
                        <option class="text-dark" value="" <?= $f == "" ? "selected" : ""; ?>>
                            Todas
                        </option>
                        <option class="text-dark" value="pending" <?= $f == "pending" ? "selected" : ""; ?>>
                            Pendentes
                        </option>
                        <option class="text-dark" value="processing" <?= $f == "processing" ? "selected" : ""; ?>>
                            Em processamento
                        </option>
                        <option class="text-dark" value="send" <?= $f == "send" ? "selected" : ""; ?>>
                            Enviadas
                        </option>
                        <option class="text-dark" value="canceled" <?= $f == "canceled" ? "selected" : ""; ?>>
                            Canceladas
                        </option>
                        <option class="text-dark" value="concluded" <?= $f == "concluded" ? "selected" : ""; ?>>
                            Concluídas
                        </option>
                    </select>
                </div>
            </div>

            <?php if (count($listSales) == 0) : ?>

                <p>Nenhuma venda foi realizada!</p>

            <?php else : ?>

                <div class="table-responsive pe-2 mt-4">
                    <table class="table table-sm table-bordered pt-3 text-white" id="list-sales">
                        <thead class="border-bottom">
                            <tr>
                                <th>Data</th>
                                <th>Código</th>
                                <th>Cliente</th>
                                <th>Telefone</th>
                                <th>Status</th>
                                <th class="text-end">Atualizado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($listSales as $sale) : ?>
                                <tr class="border-bottom m-2">
                                    <td><?= date("d/m/Y", strtotime($sale->date)) ?></td>
                                    <td><?= $sale->code_order ?></td>
                                    <td><?= $sale->name ?></td>
                                    <td><?= $sale->phone != "" ? $sale->phone : "Sem telefone" ?></td>
                                    <td>
                                        <a
                                            href="?a=detailsOrder&order=<?= Store::aesEncrypt($sale->id_order) ?>"
                                            class="text-decoration-none"
                                        >
                                            <?php
                                                switch($sale->status) {
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
                                        </a>
                                    </td>
                                    <td class="text-end">
                                        <?= date("d/m/Y", strtotime($sale->updated_at)) ?>
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