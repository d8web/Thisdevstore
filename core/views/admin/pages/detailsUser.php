<div class="container-fluid">
    <div class="row mt-3">

        <div class="col-md-2">
            <?php include(__DIR__ . "/../partials/aside.php") ?>
        </div>

        <div class="col-md-10">
            <h3 class="mb-4">Detalhes do usuário <?=$detailsClient->name?></h3>

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

    </div>
</div>