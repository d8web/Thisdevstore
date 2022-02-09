<div class="container-fluid p-0 m-0"></div>
    <div class="row">

        <div class="col-md-2">
            <?php include(__DIR__ . "/../partials/aside.php") ?>
        </div>

        <div class="col-md-10 pe-4">

            <h4 class="mt-4">Vendas</h4>

            <div class="row mt-4">
                <div class="col-md-4">
                    <?php if ($totalPendingOrders == 0) : ?>
                        <div class="card p-3">
                            <div class="card-body">
                                <h5 class="card-title">Vendas Pendentes</h5>
                                <p class="card-text">Não existem vendas pendentes no sistema.</p>
                            </div>
                        </div>
                    <?php else : ?>
                        <div class="card p-3">
                            <div class="card-body">
                                <h5 class="card-title">Vendas Pendentes</h5>
                                <p class="card-text">
                                    Existe<?=$totalPendingOrders == 1 ? "" : "m"?> <?=$totalPendingOrders?> venda<?=$totalPendingOrders == 1 ? "" : "s"?> pendentes no sistema.
                                </p>
                                <a href="?a=ordersList&filter=pending" class="btn btn-primary">Ver vendas</a>
                            </div>
                        </div>
                    <?php endif ?>
                </div>
                <div class="col-md-4">
                    <?php if ($totalProcessingOrders == 0) : ?>
                        <div class="card p-3">
                            <div class="card-body">
                                <h5 class="card-title">Vendas em processamento</h5>
                                <p class="card-text">Não existem vendas em processamento no sistema.</p>
                            </div>
                        </div>
                    <?php else : ?>
                        <div class="card p-3">
                            <div class="card-body">
                                <h5 class="card-title">Vendas em processamento</h5>
                                <p class="card-text">
                                    Existe<?=$totalProcessingOrders == 1 ? "" : "m"?> <?=$totalProcessingOrders?> venda<?=$totalProcessingOrders == 1 ? "" : "s"?> em processamento no sistema.
                                </p>
                                <a href="?a=ordersList&filter=processing" class="btn btn-primary">Ver vendas</a>
                            </div>
                        </div>
                    <?php endif ?>
                </div>
            </div>

        </div>
    </div>
</div>