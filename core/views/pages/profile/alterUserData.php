<div class="container mt-5">
    <div class="row">

        <div class="col-8">
            
            <h3>Alterar dados</h3>
            <form action="?a=alterUserDataSubmit" method="POST" class="mt-3">
                <!-- 2 column grid layout with text inputs for the first and last names -->
                <div class="row">
                    <div class="col-md-6">
                        <!-- Nome input -->
                        <div class="form-outline mb-4">
                            <label class="form-label" for="name">Nome</label>
                            <input type="text" name="name" id="name" value="<?= $user->name ?>" placeholder="Digite seu nome" class="form-control" required />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <!-- Email input -->
                        <div class="form-outline mb-4">
                            <label class="form-label" for="email">Email</label>
                            <input type="email" name="email" id="email" value="<?= $user->email ?>" placeholder="Digite seu email" class="form-control" required />
                        </div>
                    </div>
                </div>
    
                <!-- Address input -->
                <div class="form-outline mb-4">
                    <label class="form-label" for="address">Endereço</label>
                    <input type="text" name="address" id="address" value="<?= $user->address ?>" placeholder="Digite seu endereço" class="form-control" required />
                </div>
    
                <!-- City input -->
                <div class="form-outline mb-4">
                    <label class="form-label" for="city">Cidade</label>
                    <input type="text" name="city" id="city" value="<?= $user->city ?>" placeholder="Digite sua cidade" class="form-control" required />
                </div>
    
                <!-- Phone input -->
                <div class="form-outline mb-4">
                    <label class="form-label" for="phone">Telefone</label>
                    <input type="text" name="phone" id="phone" value="<?= $user->phone ?>" placeholder="Digite seu telefone" class="form-control" />
                </div>
    
                <!-- Cancel button -->
                <a href="?a=myaccount" class="btn btn-danger btn-block my-3">Cancelar</a>
    
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