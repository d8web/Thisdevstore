<?php use core\classes\Store; ?>

<div class="container mt-4">
    <div class="row">
        <div class="col">
            <h2 class="mt-3">
                Histórico de compras
            </h2>

            <?php if(count($historyOrders) == 0): ?>

                <figure class="mt-5">
                    <blockquote class="blockquote">
                        <p>Parece que você ainda não fez nenhuma compra.</p>
                    </blockquote>
                    <figcaption class="blockquote-footer">
                        Faça uma nova compra <cite title="Source Title">e ela vai aparecer aqui.</cite>
                    </figcaption>
                </figure>

            <?php else: ?>

                <table class="table table-hover table-light mt-5">
                   <thead class="table-info">
                        <tr>
                            <th>Data</th>
                            <th>Código</th>
                            <th>Status</th>
                            <th class="text-end">Opções</th>
                        </tr>
                   </thead>
                   <tbody>

                        <?php foreach($historyOrders as $historyOrder): ?>
                            <tr>
                                <td><?= date("d/m/Y", strtotime($historyOrder->date)) ?></td>
                                <td><?=$historyOrder->code_order?></td>
                                <td>
                                    <?php
                                        switch($historyOrder->status) {
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
                                <td class="text-end">
                                    <a
                                        class="text-decoration-none text-dark"
                                        href="?a=detailsOrder&id=<?= Store::aesEncrypt($historyOrder->id_order) ?>"
                                    >
                                        Detalhes
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach ?>

                   </tbody>
                </table>

                <div class="text-end fs-6 mt-4">
                    Total de produtos: <strong><?=count($historyOrders)?></strong>
                </div>

            <?php endif ?>

        </div>
    </div>
</div>