<div class="container-fluid p-0 m-0"></div>
    <div class="row me-4">

        <div class="col-md-2">
            <?php include(__DIR__ . "/../partials/aside.php") ?>
        </div>

        <div class="col-md-10 bg-dark p-4 pe-5 rounded">

            <h4 class="mb-4 mt-2">Vendas</h4>

            <div class="row mt-4">
                <div class="col-md-4">
                    <?php if ($totalPendingOrders == 0) : ?>
                        <div class="p-4 border border-light rounded">
                            <h4 class="card-title">Vendas Pendentes</h4>
                            <p class="card-text">Não existem vendas pendentes no sistema.</p>
                        </div>
                    <?php else : ?>
                        <div class="p-4 border border-light rounded">
                            <h4 class="card-title">Vendas Pendentes</h4>
                            <p class="card-text">
                                Existe<?=$totalPendingOrders == 1 ? "" : "m"?> <?=$totalPendingOrders?> venda<?=$totalPendingOrders == 1 ? "" : "s"?> pendentes no sistema.
                            </p>
                            <a href="?a=ordersList&filter=pending" class="btn btn-primary">Ver vendas</a>
                        </div>
                    <?php endif ?>
                </div>
                <div class="col-md-4">
                    <?php if ($totalProcessingOrders == 0) : ?>
                        <div class="p-4 border border-light rounded">
                            <h4 class="card-title">Vendas em processamento</h4>
                            <p class="card-text">Não existem vendas em processamento no sistema.</p>
                        </div>
                    <?php else : ?>
                        <div class="p-4 border border-light rounded">
                            <h4 class="card-title">Vendas em processamento</h4>
                            <p class="card-text">
                                Existe<?=$totalProcessingOrders == 1 ? "" : "m"?> <?=$totalProcessingOrders?> venda<?=$totalProcessingOrders == 1 ? "" : "s"?> em processamento no sistema.
                            </p>
                            <a href="?a=ordersList&filter=processing" class="btn btn-primary">Ver vendas</a>
                        </div>
                    <?php endif ?>
                </div>
            </div>

        </div>
    </div>
</div>