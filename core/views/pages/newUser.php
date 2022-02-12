<div class="container mt-5">
    <div class="row">
        <div class="col-12">

            <h2>Novo usuário</h2>

            <form action="?a=signupAction" method="POST" class="mt-5">
                <!-- 2 column grid layout with text inputs for the first and last names -->
                <div class="row">
                    <div class="col-md-6">
                        <!-- Nome input -->
                        <div class="form-outline mb-3">
                            <label class="form-label" for="name">Nome</label>
                            <input type="text" name="name" id="name" placeholder="Digite seu nome" class="form-control" required />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <!-- Email input -->
                        <div class="form-outline mb-3">
                            <label class="form-label" for="email">Email</label>
                            <input type="email" name="email" id="email" placeholder="Digite seu email" class="form-control" required />
                        </div>
                    </div>
                </div>

                <!-- Password input -->
                <div class="form-outline mb-3">
                    <label class="form-label" for="password">Senha</label>
                    <input type="password" name="password" id="password" placeholder="Digite sua senha" class="form-control" required />
                </div>
                <!-- Password confirm input -->
                <div class="form-outline mb-3">
                    <label class="form-label" for="password_confirm">Confirmar senha</label>
                    <input type="password" name="password_confirm" id="password_confirm" placeholder="Repita a senha" class="form-control" required />
                </div>

                <!-- Address input -->
                <div class="form-outline mb-3">
                    <label class="form-label" for="address">Endereço</label>
                    <input type="text" name="address" id="address" class="form-control" placeholder="Digite o seu endereço" required />
                </div>

                <!-- Address input -->
                <div class="form-outline mb-3">
                    <label class="form-label" for="city">Cidade</label>
                    <input type="text" name="city" id="city" class="form-control" placeholder="Digite o nome da sua cidade" required />
                </div>

                <!-- Phone input -->
                <div class="form-outline mb-3">
                    <label class="form-label" for="phone">Telefone</label>
                    <input type="text" name="phone" id="phone" class="form-control" placeholder="Digite seu telefone" />
                </div>

                <!-- Submit button -->
                <button type="submit" class="btn bg-button btn-block my-4">Cadastrar</button>

                <?php if (isset($_SESSION["error"])) : ?>
                    <div class="alert alert-danger text-center p-2" role="alert">
                        <?= $_SESSION["error"] ?>
                        <?php unset($_SESSION["error"]) ?>
                    </div>
                <?php endif ?>

            </form>

        </div>
    </div>
</div>