<?php use core\classes\Store; ?>

<div class="container-fluid">
    <div class="row">

        <div class="col-md-2">
            <?php include(__DIR__ . "/../partials/aside.php") ?>
        </div>

        <div class="col-md-10 bg-dark p-4 pe-5">

            <div class="row mb-2">
                <div class="col">
                    <div class="mb-4">
                        <h3 class="fw-bold m-0">Detalhes da venda</h3>
                        <small><?= $order->code_order ?></small>
                    </div>
                </div>
                <div class="col text-end">
                    <button type="button" class="btn btn-primary" onclick="showModal()">
                        <?php
                            switch($order->status) {
                                case "PENDING":
                                    echo "Pendente";
                                break;
                                case "PROCESSING":
                                    echo "Processando";
                                break;
                                case "CANCELED":
                                    echo "Cancelada";
                                break;
                                case "SEND":
                                    echo "Enviada";
                                break;
                                case "CONCLUDED":
                                    echo "Concluída";
                                break;
                            }
                        ?>
                    </button>
                    <?php if($order->status == "PROCESSING"): ?>
                        <a
                            href="?a=createOrderPDF&order=<?= Store::aesEncrypt($order->id_order) ?>"
                            class="btn btn-warning"
                        >Ver PDF</a>
                        <a
                            href="?a=sendOrderPDF&order=<?= Store::aesEncrypt($order->id_order) ?>"
                            class="btn btn-warning"
                        >Enviar PDF</a>
                    <?php endif ?>
                </div>
            </div>

            <div class="row mb-5">

                <div class="col">

                    <div class="d-flex mb-2">
                        <div class="me-3 fw-bold">Nome:</div>
                        <div><?= $order->name ?></div>
                    </div>

                    <div class="d-flex mb-2">
                        <div class="me-3 fw-bold">Email:</div>
                        <div>
                            <a href="mailto:<?= $order->email ?>">
                                <?= $order->email ?>
                            </a>
                        </div>
                    </div>

                </div>

                <div class="col">

                    <div class="d-flex mb-2">
                        <div class="me-3 fw-bold">Cidade:</div>
                        <div><?= $order->city ?></div>
                    </div>

                    <div class="d-flex mb-2">
                        <div class="me-3 fw-bold">Endereço:</div>
                        <div><?= $order->address ?></div>
                    </div>

                </div>

                <div class="col">

                    <div class="d-flex mb-2">
                        <div class="me-3 fw-bold">Telefone:</div>
                        <div>
                            <?= ($order->phone) == "" ? "Sem telefone." : $order->phone ?>
                        </div>
                    </div>

                    <div class="d-flex mb-2">
                        <div class="me-3 fw-bold">Criado:</div>
                        <div>
                            <?= date("d/m/Y", strtotime($order->created_at)) ?>
                        </div>
                    </div>

                </div>

            </div>

            <hr>

            <table class="table table-borderless mt-5 mb-4 bg-transparent text-white">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th class="text-end">Preço / Uni</th>
                        <th class="text-center">Quantidade</th>
                    </tr>
                </thead>
                <tbody>

                    <?php foreach ($orderProducts as $item) : ?>
                        <tr>
                            <td><?= $item->name ?></td>
                            <td class="text-end">
                                R$ <?= number_format($item->price_unit, 2, ',', '.') ?>
                            </td>
                            <td class="text-center"><?= $item->quantity ?></td>
                        </tr>
                    <?php endforeach ?>

                </tbody>
            </table>

            <?php if (isset($_SESSION["success"])) : ?>
                <div class="alert alert-success text-center p-2 my-4" role="alert">
                    <?= $_SESSION["success"] ?>
                    <?php unset($_SESSION["success"]) ?>
                </div>
            <?php endif ?>

        </div>

    </div>

</div>

<!-- Modal -->
<div class="modal fade bg-transparent" id="modalStatus" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark">
            <div class="modal-header border-0">
                <h5 class="modal-title fs-4" id="exampleModalLabel">Alterar status da compra</h5>
                <button type="button" class="btn-close bg-light" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                
                <ul class="list-unstyled">
                    <?php foreach (STATUS as $item): ?>
                        <li class="fs-5 mb-2">
                            <?php if($order->status == $item): ?>
                                <?php
                                    switch($item) {
                                        case "PENDING":
                                            echo "Pendente";
                                        break;
                                        case "PROCESSING":
                                            echo "Processando";
                                        break;
                                        case "CANCELED":
                                            echo "Cancelada";
                                        break;
                                        case "SEND":
                                            echo "Enviada";
                                        break;
                                        case "CONCLUDED":
                                            echo "Concluída";
                                        break;
                                    }
                                ?>
                            <?php else: ?>
                                <a
                                    href="?a=alterStatusOrder&idOrder=<?= core\classes\Store::aesEncrypt($order->id_order) ?>&status=<?=$item?>"
                                    class="text-decoration-none fs-5"
                                >
                                    <?php
                                        switch($item) {
                                            case "PENDING":
                                                echo "Pendente";
                                            break;
                                            case "PROCESSING":
                                                echo "Processando";
                                            break;
                                            case "CANCELED":
                                                echo "Cancelada";
                                            break;
                                            case "SEND":
                                                echo "Enviada";
                                            break;
                                            case "CONCLUDED":
                                                echo "Concluída";
                                            break;
                                        }
                                    ?>
                                </a>
                            <?php endif; ?>
                        </li>
                    <?php endforeach ?>
                </ul>

            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<script>
    const showModal = () => {
        let modalStatus = new bootstrap.Modal(document.getElementById("modalStatus"))
        modalStatus.show()
    }
</script>