<?php use core\classes\Store; ?>
<div class="container-fluid">
    <div class="row mt-3">

        <div class="col-md-2">
            <?php include(__DIR__ . "/../partials/aside.php") ?>
        </div>

        <div class="col-md-10 mt-4">
            <div class="row">
                <div class="col">
                    <h3 class="mb-4 fw-bold">Detalhes do usuário <?=$detailsClient->name?></h3>
        
                    <div class="d-flex mb-2">
                        <div class="me-3 fw-bold">Nome:</div>
                        <div><?=$detailsClient->name?></div>
                    </div>
        
                    <div class="d-flex mb-2">
                        <div class="me-3 fw-bold">Endereço:</div>
                        <div><?=$detailsClient->address?></div>
                    </div>
        
                    <div class="d-flex mb-2">
                        <div class="me-3 fw-bold">Cidade:</div>
                        <div><?=$detailsClient->city?></div>
                    </div>
        
                    <div class="d-flex mb-2">
                        <div class="me-3 fw-bold">Telefone:</div>
                        <div>
                            <?=($detailsClient->phone) == '' ? 'Este cliente não cadastrou seu telefone.' : $detailsClient->phone?>
                        </div>
                    </div>
        
                    <div class="d-flex mb-2">
                        <div class="me-3 fw-bold">Email:</div>
                        <div>
                            <a href="mailto:<?=$detailsClient->email?>">
                                <?=$detailsClient->email?>
                            </a>
                        </div>
                    </div>
        
                    <div class="d-flex mb-2">
                        <div class="me-3 fw-bold">Status:</div>
                        <div>
                            <?php if($detailsClient->active == 0): ?>
                                <span class="text-danger">Inativo</span>
                            <?php else: ?>
                                <span class="text-success">Ativo</span>
                            <?php endif ?>
                        </div>
                    </div>
        
                    <div class="d-flex mb-2">
                        <div class="me-3 fw-bold">Data da criação:</div>
                        <div>
                            <?=date("d/m/Y", strtotime($detailsClient->created_at));?>
                        </div>
                    </div>
                </div>
                
                <div class="col">
                    <h3 class="fw-bold mb-4">Compras do usuário</h3>
                    <?php if($totalOrdersClient == 0): ?>
                        <span>Este usuário não fez nenhuma compra!</span>
                    <?php else : ?>
                        <span class="d-block mb-3">O usuário <?=$detailsClient->name?> já fez <?=$totalOrdersClient?> compras.</span>
                        <a
                            href="?a=userHistoryOrder&user=<?=Store::aesEncrypt($detailsClient->id_client)?>"
                            class="btn btn-primary"
                        >
                            Ver histório de compras do usuário
                        </a>
                    <?php endif ?>
                </div>

            </div>

        </div>

    </div>

</div>