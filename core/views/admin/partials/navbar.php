<?php use core\classes\Store; ?>

<header class="my-bg container-fluid ps-4 pe-4">
    <nav class="navbar navbar-expand-lg">
        <a class="navbar-brand text-light" href="?a=home">
            <?= "ADMIN | " . APP_NAME ?>
        </a>

        <!-- Toggler/collapsibe Button -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar links -->
        <div class="collapse navbar-collapse" id="collapsibleNavbar">
            <ul class="navbar-nav ms-auto">
                <?php if (Store::LoggedAdmin()) : ?>
                    <li class="me-4">
                        <span href="" class="text-decoration-none">
                            <span><?= $_SESSION["userAdmin"]; ?></span>
                        </span>
                    </li>
                    <li>
                        <a href="?a=logoutAdmin" class="text-decoration-none">
                            <i class="fas fa-sign-out-alt text-light"></i>
                        </a>
                    </li>
                <?php endif ?>
            </ul>
        </div>
    </nav>
</header>