<div class="container-fluid p-0 m-0">
    <div class="row me-4">

        <div class="col-md-2">
            <?php include(__DIR__ . "/../partials/aside.php") ?>
        </div>

        <div class="col-md-10 bg-dark p-4 rounded">
            <h4 class="mb-4 mt-2">Novo produto</h4>

            <form action="?a=newProductSubmit" method="POST"  enctype="multipart/form-data" class="mt-3 pb-5">
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
                                <option class="text-dark"value="0">Não</option>
                                <option class="text-dark"value="1">Sim</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <!-- Bestseller input -->
                        <div class="form-outline mb-4">
                            <label class="form-label" for="bestseller">Mais vendido</label>
                            <select class="form-select bg-transparent text-white" name="bestseller">
                                <option class="text-dark" value="0">Não</option>
                                <option class="text-dark" value="1">Sim</option>
                            </select>
                        </div>
                    </div>
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
                        required
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
                        style="height: 220px;"
                        required
                        ></textarea>
                </div>

                <!-- Cancel button -->
                <a href="?a=productsList" class="btn btn-danger btn-block my-3">Cancelar</a>
    
                <!-- Submit button -->
                <button type="submit" class="btn btn-primary btn-block my-3">Salvar</button>
    
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