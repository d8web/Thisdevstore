<div class="container space-bottom">

    <div class="row my-5">

        <div class="mb-5">
            <a href="?a=loja&c=todos" class="btn btn-light border-bottom shadow-sm">Todas</a>
            <?php foreach ($categories as $category) : ?>
                <a href="?a=loja&c=<?= $category ?>" class="btn btn-light border-bottom shadow-sm">
                    <?= ucfirst(preg_replace("/\_/", " ", $category)) ?>
                </a>
            <?php endforeach ?>
        </div>

        <div class="col-12">

            <!-- Apresentação dos produtos -->
            <div class="row">

                <?php if (count($products) == 0) : ?>

                    <div class="my-4">
                        <h3>Não existem produtos disponíveis!</h3>
                    </div>

                <?php else : ?>
                    <?php foreach ($products as $product) : ?>

                        <!-- Apresentação do produto -->
                        <div class="col-lg-4 col-md-6 col-sm-12 p-3 my-cursor">
                            <div class="card border-0 my-product-card">
                                <?php if ($product->bestseller == 1) : ?>
                                    <span></span>
                                <?php endif ?>
                                <div class="p-3 text-center">
                                    <img src="assets/images/products/<?= $product->image ?>" class="img-fluid" />
                                    <h5 class="my-2"><?= $product->name ?></h5>
                                    <h6 class="fw-normal">
                                        R$ <?= number_format($product->price, 2, ',', '.') ?>
                                    </h6>
                                    <div>

                                        <?php if ($product->stock > 0) : ?>

                                            <button class="btn btn-primary btn-sm my-2" onclick="addToCart(<?= $product->id_product ?>)">
                                                <i class="fas fa-shopping-cart me-2"></i>
                                                Adicionar ao carrinho
                                            </button>

                                        <?php else : ?>

                                            <button class="btn btn-danger btn-sm my-2" disabled>
                                                <i class="fas fa-shopping-cart me-2"></i>
                                                Em falta!
                                            </button>

                                        <?php endif ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach ?>
                <?php endif ?>

            </div>

        </div>
    </div>

</div>