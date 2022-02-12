<div class="container mt-5">
    <div class="row">
        <div class="col-4 m-auto p-2">
            <h2>Login</h2>
            <form method="POST" action="?a=signinAction" class="mt-4">

                <!-- Email input -->
                <div class="form-outline">
                    <label class="form-label" for="email">Email</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
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
                    class="btn bg-button mt-4"
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