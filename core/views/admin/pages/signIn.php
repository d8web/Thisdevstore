<div class="container mt-5">
    <div class="row my-5">

        <div class="col-sm-4 offset-sm-4 bg-dark p-4 pe-5">
            <h3>Login Admin</h3>

            <form action="?a=signInAdminAction" method="post" class="mt-4">

                <!-- Email input -->
                <div class="form-outline">
                    <label class="form-label" for="email">Email</label>
                    <input
                        type="email"
                        id="email"
                        name="user"
                        placeholder="Digite o seu email"
                        class="form-control"
                        required
                    />
                </div>

                <!-- Password input -->
                <div class="form-outline mt-3">
                    <label class="form-label" for="password">Password</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Digite sua senha"
                        class="form-control"
                        required
                    />
                </div>

                <!-- Submit button -->
                <button
                    type="submit"
                    class="btn btn-primary mt-4"
                >Login</button>

                <?php if(isset($_SESSION["error"])): ?>
                    <div class="alert alert-danger mt-4 text-center">
                        <span><?=$_SESSION["error"]?></span>
                        <?php unset($_SESSION["error"]) ?>
                    </div>
                <?php endif ?>

            </form>

        </div>
    </div>
</div>