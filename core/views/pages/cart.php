<div class="container mt-5">
    <div class="row">
        <div class="col">
            <h3 class="my-3 pb-4">Meus pedidos</h3>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col">

            <?php if ($cart == null) : ?>


                <p>Não existem produtos no carrinho.</p>

                <a href="?a=loja" class="btn bg-button">Ir para a loja</a>


            <?php else : ?>

                <div class="space-bottom">
                    <div class="table-responsive-md">

                        <table class="table table-borderless border-end border-start">
                            <thead class="border-bottom border-top pb-2">
                                <tr>
                                    <th>Imagem</th>
                                    <th>Nome</th>
                                    <th>Quantidade</th>
                                    <th>Preço</th>
                                    <th class="text-end">Ações</th>
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
                                        <tr class="align-middle border-bottom">
                                            <td>
                                                <img src="assets/images/products/<?= $product['image'] ?>" class="img-fluid" width="60px" />
                                            </td>
                                            <td>
                                                <h6 class="fw-normal"><?= $product['title'] ?></h6>
                                            </td>
                                            <td>
                                                <h6 class="fw-normal"><?= $product['quantity'] ?></h6>
                                            </td>
                                            <td>
                                                <h6 class="fw-normal">
                                                    <?= number_format($product['price'], 2, ',', '.') ?>
                                                </h6>
                                            </td>
                                            <td class="text-end">
                                                <a
                                                    href="?a=removeProductCart&idProduct=<?= $product['idProduct'] ?>"
                                                    class="btn btn-danger btn-sm">
                                                    <i class="fas fa-times"></i>
                                                </a>
                                            </td>
                                        </tr>
    
                                    <?php else : ?>
    
                                        <!-- Total -->
                                        <tr class="border-top border-bottom">
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td class="text-end pt-3">
                                                <h5 class="fw-regular fs-6">Total</h5>
                                            </td>
                                            <td class="text-end pt-3">
                                                <h5 class="fw-bold fs-6">
                                                    R$ <?= number_format($product, 2, ',', '.') ?>
                                                </h5>
                                            </td>
                                        </tr>
    
                                    <?php endif ?>
                                    <?php $index++ ?>
                                <?php endforeach ?>
    
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col">
                            <!-- <a href="?a=clearCart" class="btn btn-sm btn-primary">Limpar Carrinho</a> -->
                            <button class="btn btn-sm bg-button me-2" onclick="clearCart()">Limpar Carrinho</button>
                            <span id="confirm-clear-cart" style="display: none;">
                                Tem certeza?
                                <button class="btn btn-sm btn-primary" onclick="clearCartOff()">NÃO</button>
                                <a href="?a=clearCart" class="btn btn-sm btn-danger">SIM</a>
                            </span>
                        </div>
                        <div class="col text-end">
                            <a href="?a=loja" class="btn btn-sm bg-button">Continuar comprando</a>
                            <a href="?a=checkout" class="btn btn-sm btn-success">Finalizar compra</a>
                        </div>
                    </div>
                </div>

            <?php endif ?>

        </div>
    </div>
</div>