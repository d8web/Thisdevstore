<div class="container mt-5">
    <div class="row">
        <div class="col mb-4">
            <h3 class="my-3 fw-bold">Resumo da compra</h3>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col">

            <div class="space-bottom">
                <table class="table table-borderless p-0 border-bottom border-end border-top border-start mb-5">
                    <thead>
                        <tr class="border-bottom">
                            <th>Produto</th>
                            <th class="text-center">Quantidade</th>
                            <th class="text-end">Valor total</th>
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
                                <tr class="border-bottom">
                                    <td><?= $product['title'] ?></td>
                                    <td class="text-center"><?= $product['quantity'] ?></td>
                                    <td class="text-end">R$ <?= number_format($product['price'], 2, ',', '.') ?></td>
                                </tr>

                            <?php else : ?>

                                <!-- Total -->
                                <tr class="m-0 p-0 d-flex align-items-center">
                                    <td class="flex-grow-1 m-0 d-flex align-items-center">
                                        <h6 class="m-0 p-0 fw-regular">Total</h6>
                                    </td>
                                    <td class="flex-grow-1 m-0 d-flex align-items-center">
                                        <h6 class="m-0 p-0 fw-bold">
                                            R$ <?= number_format($product, 2, ',', '.')?>
                                        </h6>
                                    </td>
                                </tr>

                            <?php endif ?>
                            <?php $index++ ?>
                        <?php endforeach ?>

                    </tbody>
                </table>
                <hr>

                <!-- Dados do cliente -->
                <h3 class="my-4 fw-bold">Dados do cliente</h3>
                <div class="row mt-4">

                    <div class="col">
                        <p class="fw-bold">Nome: <span class="fw-normal"><?= $client->name ?></span></p>
                        <p class="fw-bold">Endereço: <span class="fw-normal"><?= $client->address ?></span></p>
                        <p class="fw-bold">Cidade: <span class="fw-normal"><?= $client->city ?></span></p>
                    </div>
                    <div class="col">
                        <p class="fw-bold">Email: <span class="fw-normal"><?= $client->email ?></span></p>
                        <p class="fw-bold">
                            Telefone: <span class="fw-normal">
                                <?= $client->phone == "" ? "Sem telefone" : $client->phone ?>
                            </span>
                        </p>
                    </div>

                </div>
                <hr>

                <!-- Dados de pagamento -->
                <h3 class="my-4 fw-bold">Dados da compra</h3>
                <div class="row mt-4">
                    <div class="col">
                        <p class="fw-bold">
                            Conta Bancária: <span class="fw-normal">1234567890</span>
                        </p>
                        <p class="fw-bold">
                            Código da compra: <span class="fw-normal"><?= $_SESSION['codeOrder'] ?></span>
                        </p>
                        <p class="fw-bold">
                            Total: <span class="fw-normal">
                                R$ <?= number_format($product, 2, ',', '.') ?>
                            </span>
                        </p>
                    </div>
                </div>
                <hr>

                <!-- Input check -->
                <h3 class="my-4 fw-bold">Endereço Alternativo</h3>
                <div class="form-check form-switch mt-2">
                    <input class="form-check-input" onchange="showAddress()" type="checkbox" value="" id="checkAddressAlternative">
                    <label class="form-check-label" for="checkAddressAlternative">
                        Definir outro endereço
                    </label>
                </div>

                <!-- Mudar endereço/dados -->
                <div id="endereco_alternativo" class="mt-4" style="display: none;">
                    
                    <div class="row">
                        <div class="col-md-6">
                            <!-- Endereço -->
                            <div class="mb-3">
                                <label class="form-label">Endereço:</label>
                                <input type="text" name="addressAlternative" class="form-control" id="addressAlternative" placeholder="Digite o novo endereço" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <!-- Cidade -->
                            <div class="mb-3">
                                <label class="form-label">Cidade:</label>
                                <input type="text" name="cityAlternative" class="form-control" id="cityAlternative" placeholder="Digite o novo endereço" />
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <!-- Email -->
                            <div class="mb-3">
                                <label class="form-label">Email:</label>
                                <input type="email" name="emailAlternative" class="form-control" id="emailAlternative" placeholder="Digite o seu email" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <!-- Telefone -->
                            <div class="mb-3">
                                <label class="form-label">Telefone:</label>
                                <input type="text" name="phoneAlternative" class="form-control" id="phoneAlternative" placeholder="Digite o seu telefone(opcional)" />
                            </div>
                        </div>
                    </div>

                </div>

                <div class="row mt-5">
                    <div class="col">
                        <a href="?a=cart" class="btn btn-sm btn-danger">Cancelar</a>
                    </div>
                    <div class="col text-end">
                        <a href="?a=confirmOrder" class="btn btn-sm btn-success" onclick="addressAlternative()">
                            Confirmar Pedido
                        </a>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>