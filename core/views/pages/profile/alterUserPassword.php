<div class="container mt-5">
    <div class="row">

        <div class="col-8">
            
            <h3>Alterar senha</h3>
            <form action="?a=alterUserPasswordSubmit" method="POST" class="mt-3">
    
                <!-- Old password input -->
                <div class="form-outline mb-4">
                    <label class="form-label" for="oldPassword">Senha Atual</label>
                    <input type="password" name="oldPassword" id="oldPassword" placeholder="Digite a senha atual" class="form-control" required />
                </div>

                <!-- New password input -->
                <div class="form-outline mb-4">
                    <label class="form-label" for="newPassword">Nova senha</label>
                    <input type="password" name="newPassword" id="newPassword" placeholder="Digite a nova senha" class="form-control" required />
                </div>

                <!-- New password confirm -->
                <div class="form-outline mb-4">
                    <label class="form-label" for="newPasswordConfirm">Confirmar nova senha</label>
                    <input type="password" name="newPasswordConfirm" id="newPasswordConfirm" placeholder="Repita a nova senha" class="form-control" required />
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