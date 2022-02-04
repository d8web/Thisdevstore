<div class="container mt-5">
    <div class="row">
        <div class="col">
            <h3 class="my-3">Meus pedidos</h3>
            <hr>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col">

            <?php if ($cart == null) : ?>


                <p>Não existem produtos no carrinho.</p>

                <a href="?a=loja" class="btn btn-primary">Ir para a loja</a>


            <?php else : ?>

                <div class="space-bottom">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Imagem</th>
                                <th>Nome</th>
                                <th class="text-center">Quantidade</th>
                                <th class="text-end">Valor total</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                                $index = 0;
                                $totalRows = count($cart);
                            ?>
                            <?php foreach ($cart as $product) : ?>
                                <?php if ($index < $totalRows - 1) : ?>

                                    <!-- Lista dos produtos -->
                                    <tr class="align-middle">
                                        <td>
                                            <img src="assets/images/products/<?= $product['image'] ?>" class="img-fluid" width="60px" />
                                        </td>
                                        <td>
                                            <h6 class="fw-normal"><?= $product['title'] ?></h6>
                                        </td>
                                        <td class="text-center">
                                            <h6 class="fw-normal"><?= $product['quantity'] ?></h6>
                                        </td>
                                        <td class="text-end">
                                            <h6 class="fw-normal">
                                                <?= number_format($product['price'], 2, ',', '.') . "$" ?>
                                            </h6>
                                        </td>
                                        <td class="text-center">
                                            <a
                                                href="?a=deleteProductCart&idproduct=<?= $product['idProduct'] ?>"
                                                class="btn btn-danger btn-sm">
                                                <i class="fas fa-times"></i>
                                            </a>
                                        </td>
                                    </tr>

                                <?php else : ?>

                                    <!-- Total -->
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td class="text-end">
                                            <h5 class="fw-normal">Total</h5>
                                        </td>
                                        <td class="text-end">
                                            <h5 class="fw-normal"><?= number_format($product, 2, ',', '.') . "$" ?></h5>
                                        </td>
                                        <td></td>
                                    </tr>

                                <?php endif ?>
                                <?php $index++ ?>
                            <?php endforeach ?>

                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col">
                            <!-- <a href="?a=clearcart" class="btn btn-sm btn-primary">Limpar Carrinho</a> -->
                            <button class="btn btn-sm btn-primary me-2" onclick="clearCart()">Limpar Carrinho</button>
                            <span id="confirm-clear-cart" style="display: none;">
                                Tem certeza?
                                <button class="btn btn-sm btn-primary" onclick="clearCartOff()">NÃO</button>
                                <a href="?a=clearcart" class="btn btn-sm btn-warning">SIM</a>
                            </span>
                        </div>
                        <div class="col text-end">
                            <a href="?a=loja" class="btn btn-sm btn-primary">Continuar comprando</a>
                            <a href="?a=checkout" class="btn btn-sm btn-success">Finalizar compra</a>
                        </div>
                    </div>
                </div>

            <?php endif ?>

        </div>
    </div>
</div>