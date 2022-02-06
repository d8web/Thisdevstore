<div class="container-fluid">
    <div class="row my-5">
        <div class="col-sm-8 offset-sm-2">
            <h3 class="fw-bold">Encomenda confirmada com sucesso!</h3>
            <p>Obrigado por comprar com a gente!</p>

            <div class="my-5">
                <h3 class="fw-bold mb-4">Dados de pagamento</h4>
                <p>Conta bancária : 123456789</p>
                <p>Código da encomenda : <strong><?=$codeOrder?></strong></p>
                <p class="fw-bold">
                    Total da encomenda : <span class="fw-normal">
                        R$ <?=number_format($totalSale, 2, ',', '.')?>
                    </span>
                </p>
            </div>

            <p class="m-0">Você recebeu um email com a confirmação do sua encomenda juntamente com os dados de pagamento.</p>
            <p>Sua encomenda só será processado após a confirmação do pagamento.</p>
            <p>
                <span>
                    Verifique se o email aparece na sua conta ou se foi para a pasta de spam.
                </span>
            </p>
            <div class="my-5">
                <a class="btn btn-primary" href="?a=home">Voltar</a>
            </div>
        </div>
    </div>
</div>