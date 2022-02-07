<div class="container">
    <div class="row">
        <div class="col">
            <h3 class="my-5">Detalhes da compra</h3>

            <!-- Dados da encomenda -->
            <div class="row">
                <div class="col">
                    <div class="d-flex flex-column my-3">
                        <strong>Data</strong>
                        <span><?=  date("d/m/Y", strtotime($detailOrder->date)) ?></span>
                    </div>
                    <div class="d-flex flex-column my-3">
                        <strong>Endereço</strong>
                        <span><?= $detailOrder->address ?></span>
                    </div>
                    <div class="d-flex flex-column my-3">
                        <strong>Cidade</strong>
                        <span><?= $detailOrder->city ?></span>
                    </div>
                </div>
                <div class="col">
                    <div class="d-flex flex-column my-3">
                        <strong>Email</strong>
                        <span><?= $detailOrder->email ?></span>
                    </div>
                    <div class="d-flex flex-column my-3">
                        <strong>Telefone</strong>
                        <span><?= !empty($detailOrder->phone) ? $detailOrder->phone : "Sem telefone" ?></span>
                    </div>
                    <div class="d-flex flex-column my-3">
                        <strong>Código</strong>
                        <span><?= $detailOrder->code_order ?></span>
                    </div>
                </div>
                <div class="col bg-primary bg-gradient text-light p-3 d-flex flex-column justify-content-center rounded">
                    <div class="mb-1 fs-5 text-center">
                        Status da compra
                    </div>
                    <div class="text-center fs-6">
                        <?php
                            switch($detailOrder->status) {
                                case "PENDING":
                                    echo "Pendente";
                                break;
                                case "PROCESSING":
                                    echo "Processando...";
                                break;
                            }
                        ?>
                    </div>
                </div>
            </div>

            <!-- Lista de dados dos produtos -->
            <div class="row mt-5">
                <div class="col">

                    <table class="table table-hover shadow-sm">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th class="text-center">Preço / Uni</th>
                                <th class="text-center">Quantidade</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php foreach($productsOrder as $product): ?>
                                <tr>
                                    <td><?=$product->name?></td>
                                    <td class="text-center">
                                        R$ <?=number_format($product->price_unit, 2, ',', '.')?>
                                    </td>
                                    <td class="text-center"><?=$product->quantity?></td>
                                </tr>
                            <?php endforeach ?>
                            
                            <tr>
                                <td>
                                    <strong>Total: </strong>
                                    <span>
                                        R$ <?=number_format($totalPurchase, 2, ',', '.')?>
                                    </span>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                            
                </div>
            </div>

            <div class="row my-5">
                <div class="col">
                    <a href="?a=historyUserOrders" class="btn btn-warning">Voltar</a>
                </div>
            </div>

        </div>
    </div>
</div>