<?php use core\classes\Store;  ?>
<div class="container-fluid p-0 m-0 pb-5">
    <div class="row">

        <div class="col-md-2">
            <?php include(__DIR__ . "/../partials/aside.php") ?>
        </div>

        <div class="col-md-10 pe-4">
            
            <div class="row mb-4">
                <div class="col-md-6">
                    <h4 class="mb-4 mt-4">Lista de Produtos</h4>
                </div>
                <div class="col-md-6 d-flex align-items-center justify-content-end">
                    <a href="?a=newProduct" class="btn btn-primary">Adicionar Produto</a>
                </div>
            </div>

            <?php if(isset($_SESSION["success"]) && !empty($_SESSION["success"])): ?>
                <div class="alert alert-success">
                    <?= $_SESSION["success"] ?>
                    <?php unset($_SESSION["success"]) ?>
                </div>
            <?php endif ?>

            <?php if(count($productsList) ==0): ?>
                <p>Não existem usuários cadastrados!</p>
            <?php else: ?>

                <!-- Tabela de clientes -->
                <div class="table-responsive">

                    <table class="table table-bordered pt-4" id="table-clients">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Categoria</th>
                                <th class="text-center">Preço</th>
                                <th class="text-center">Visivel</th>
                                <th class="text-center">Estoque</th>
                                <th class="text-center">Mais vendido</th>
                                <th class="text-end">Criado</th>
                                <th class="text-end">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
    
                            <?php foreach($productsList as $item): ?>
                                <tr>
                                    <td>
                                        <a
                                            href="?a=editProduct&product=<?=Store::aesEncrypt($item->id_product)?>"
                                            class="text-decoration-none"
                                        >
                                            <?=$item->name?>
                                        </a>
                                    </td>
                                    <td><?=$item->category?></td>
                                    <td class="text-center">R$ <?= number_format($item->price, 2, ',', '.') ?></td>
                                    <td class="text-center">
                                        <?php if($item->visible == 1): ?>
                                            <span class="text-success">
                                                <i class="fas fa-check"></i>
                                            </span>
                                        <?php else: ?>
                                            <span class="text-danger">
                                                <i class="fas fa-ban"></i>
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center"><?=$item->stock?></td>
                                    <td class="text-center">
                                        <?php if($item->bestseller == 1): ?>
                                            <span class="text-success">
                                                <i class="fas fa-check"></i>
                                            </span>
                                        <?php else: ?>
                                            <span class="text-danger">
                                                <i class="fas fa-ban"></i>
                                            </span>
                                        <?php endif; ?>
                                    </td>
    
                                    <td class="text-end">
                                        <?= date("d/m/Y", strtotime($item->created_at))?>
                                    </td>

                                    <td class="text-end">
                                        <a href="?a=deleteProduct&product=<?=Store::aesEncrypt($item->id_product)?>">
                                            <i class="fas fa-trash text-danger"></i>
                                        </a>
                                    </td>
    
                                </tr>
                            <?php endforeach ?>
    
                        </tbody>
                    </table>
                </div>

            <?php endif ?>

        </div>

    </div>
</div>

<script>
    $(document).ready(function () {
        $("#table-clients").DataTable({
            language: {
                "decimal": "",
                "emptyTable": "No data available in table",
                "info": "Mostrando _START_ de _TOTAL_ usuários",
                "infoEmpty": "Não existem usuários disponíveis",
                "infoFiltered": "(Filtrando um total de _MAX_ usuários)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Mostrar _MENU_ usuários por página",
                "loadingRecords": "Carregando...",
                "processing": "Processando...",
                "search": "Pesquisar:",
                "zeroRecords": "Não foi encontrado nenhuma venda!",
                "paginate": {
                    "first": "Primeiro",
                    "last": "Última",
                    "next": "Seguinte",
                    "previous": "Anterior"
                },
                "aria": {
                    "sortAscending": ": activate to sort column ascending",
                    "sortDescending": ": activate to sort column descending"
                }
            }

        });
    });
</script>