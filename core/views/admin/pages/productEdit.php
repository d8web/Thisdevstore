<?php use core\classes\Store;  ?>
<div class="container-fluid p-0 m-0">
    <div class="row pe-3">

        <div class="col-md-2">
            <?php include(__DIR__ . "/../partials/aside.php") ?>
        </div>

        <div class="col-md-10 bg-dark p-4">
            <h4 class="mb-4 mt-2">Editar Produto</h4>

            <form action="?a=editProductSubmit" method="POST"  enctype="multipart/form-data" class="mt-3 pb-5">
                <!-- 2 column grid layout with text inputs for the first and last names -->
                <div class="row">
                    <div class="col-lg-4">
                        <!-- Nome input -->
                        <div class="form-outline mb-4">
                            <label class="form-label" for="name">Nome</label>
                            <input
                                type="text"
                                name="name"
                                id="name"
                                value="<?= $product->name ?>"
                                placeholder="Digite o nome do produto"
                                class="form-control bg-transparent text-white"
                                required
                            />
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <!-- Category input -->
                        <div class="form-outline mb-4">
                            <label class="form-label" for="category">Categoria</label>
                            <input
                                type="text"
                                name="category"
                                id="category"
                                value="<?= $product->category ?>"
                                placeholder="Digite a categoria"
                                class="form-control bg-transparent text-white"
                                required
                            />
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <!-- Price input -->
                        <div class="form-outline mb-4">
                            <label class="form-label" for="price">Preço</label>
                            <input
                                type="text"
                                name="price"
                                id="price"
                                value="<?= $product->price ?>"
                                placeholder="Digite o preço"
                                class="form-control bg-transparent text-white"
                                required
                            />
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-4">
                        <!-- Stock input -->
                        <div class="form-outline mb-4">
                            <label class="form-label" for="stock">Estoque</label>
                            <input
                                type="number"
                                name="stock"
                                id="stock"
                                value="<?= $product->stock ?>"
                                placeholder="Digite a quantidade em estoque"
                                class="form-control bg-transparent text-white"
                                required
                            />
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <!-- Visible input -->
                        <div class="form-outline mb-4">
                            <label class="form-label" for="visible">Visivel</label>
                            <select class="form-select bg-transparent text-white" name="visible">
                                <option class="text-dark"value="0" <?= $product->visible == 0 ? "selected" : ""?>>Não</option>
                                <option class="text-dark"value="1" <?= $product->visible == 1 ? "selected" : ""?>>Sim</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <!-- Bestseller input -->
                        <div class="form-outline mb-4">
                            <label class="form-label" for="bestseller">Mais vendido</label>
                            <select class="form-select bg-transparent text-white" name="bestseller">
                                <option class="text-dark"value="0" <?= $product->bestseller == 0 ? "selected" : ""?>>Não</option>
                                <option class="text-dark"value="1" <?= $product->bestseller == 1 ? "selected" : ""?>>Sim</option>
                            </select>
                        </div>
                    </div>
                </div>
                        
                <!-- Old image -->
                <div class="form-outline mb-4">
                    <label class="form-label d-block" for="city">Imagem</label>
                    <img src="<?= BASE_URL. "/assets/images/products/".$product->image ?>" class="img-fluid" width="180px" />
                </div>

                <!-- Image input -->
                <div class="form-outline mb-4">
                    <label for="image" class="form-label">Escolha uma imagem para seu produto</label>
                    <input
                        class="form-control bg-transparent text-white"
                        name="image"
                        type="file"
                        id="image"
                        accept="image/png, image/jpeg, image/jpg"
                    />
                </div>

                <!-- Description input -->
                <div class="form-outline mb-4">
                    <label class="form-label" for="description">Descrição</label>
                    <textarea
                        name="description"
                        id="description"
                        placeholder="Digite a descrição do produto"
                        class="form-control bg-transparent text-white"
                        style="height: 200px;"
                        required><?= $product->description ?></textarea>
                </div>

                <input type="hidden" name="id" value="<?= Store::aesEncrypt( $product->id_product ) ?>"/>
                <input type="hidden" name="oldImage" value="<?=  Store::aesEncrypt($product->image) ?>"/>

                <!-- Cancel button -->
                <a href="?a=productsList" class="btn btn-danger btn-block my-4">Cancelar</a>
    
                <!-- Submit button -->
                <button type="submit" class="btn btn-primary btn-block my-4">Salvar</button>
    
                <?php if (isset($_SESSION["error"])) : ?>
                    <div class="alert alert-danger text-center p-2 mt-4" role="alert">
                        <?= $_SESSION["error"] ?>
                        <?php unset($_SESSION["error"]) ?>
                    </div>
                <?php endif ?>
    
            </form>

        </div>

    </div>
</div>